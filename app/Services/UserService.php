<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services;

use App\Contracts\Repositories\MedalRepository;
use App\Contracts\Repositories\PrizeRepository;
use App\Contracts\Repositories\StockMedalRepository;
use App\Contracts\Repositories\StockPrizeRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\WechatAccountRepository;
use App\Repositories\Enums\ResponseCodeEnum;
use App\Repositories\Presenters\Top100Presenter;
use App\Repositories\Presenters\UserPresenter;
use App\Services\OutApi\DTO\UserRegisterReq;
use App\Services\OutApi\OutApiService;
use App\Support\Constant;
use EasyWeChat\OfficialAccount\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    const GAME_GOLD = 3;
    const INVITE_GOLD = 3;
    const USER_INVITE_URL = "https://localhost";
    private array $posterBackgroundImgs = [
        "",
        "",
        ""
    ];

    private Application $officialAccountApp;
    private UserRepository $userRepository;
    private WechatAccountRepository $wechatAccountRepository;
    private PosterService $posterService;
    private PrizeRepository $prizeRepository;
    private MedalRepository $medalRepository;
    private StockMedalRepository $stockMedalRepository;
    private StockMedalService $stockMedalService;
    private StockPrizeRepository $stockPrizeRepository;
    private StockPrizeService $stockPrizeService;
    private GoldService $goldService;
    private MedalService $medalService;

    public function __construct(Application $officialAccountApp,
                                UserRepository $userRepository,
                                WechatAccountRepository $wechatAccountRepository,
                                PosterService $posterService,
                                PrizeRepository $prizeRepository,
                                MedalRepository $medalRepository,
                                StockMedalRepository $stockMedalRepository,
                                StockMedalService $stockMedalService,
                                StockPrizeRepository $stockPrizeRepository,
                                StockPrizeService $stockPrizeService,
                                GoldService $goldService,
                                MedalService $medalService)
    {
        $this->officialAccountApp = $officialAccountApp;
        $this->userRepository = $userRepository;
        $this->wechatAccountRepository = $wechatAccountRepository;
        $this->posterService = $posterService;
        $this->prizeRepository = $prizeRepository;
        $this->medalRepository = $medalRepository;
        $this->stockMedalRepository = $stockMedalRepository;
        $this->stockMedalService = $stockMedalService;
        $this->stockPrizeRepository = $stockPrizeRepository;
        $this->stockPrizeService = $stockPrizeService;
        $this->goldService = $goldService;
        $this->medalService = $medalService;
    }

    public function sendRegisterVerifyCode(Request $request)
    {
        OutApiService::sendRegisterVerifyCode($request->input("phone"));
    }

    public function top100()
    {
        $this->userRepository->setPresenter(Top100Presenter::class);
        $hundred = $this->userRepository->top100();

        $user = $this->userRepository->find(Auth::user()->id);
        $ranking = $this->userRepository->ranking($user)->count();

        $data = [
            "hundred" => $hundred,
            "self" => [
                "id" => $user->id,
                "name" => $user->name,
                "avatarUrl" => $user->avatar_url,
                "top" => $ranking,
                "medal" => $user->medal
            ]
        ];

        return $data;
    }

    public function gameStart()
    {
        $user = $this->userRepository->find(Auth::id());
        if ($user->gold < self::GAME_GOLD) {
            stop("金币不足");
        }

        DB::beginTransaction();
        try {
            $this->goldService->adjustGold($user, -self::GAME_GOLD, "游戏消费");
            $medal = $this->medalService->luckDraw();
            $this->stockMedalService->addStockMedal($user, $medal);
            $this->userRepository->incrementMedal($user->id);
        } catch (\Throwable $e) {
            stop("游戏发生错误 - {$e->getMessage()}");
        }
        DB::commit();

        return $medal;
    }

    public function cashPrize(int $id, int $prizeId)
    {
        $user = $this->userRepository->find($id);
        $prize = $this->prizeRepository->find($prizeId);

        if ($prize->type == 0) {
            if ($this->stockPrizeService->checkHasBeenGetCouponPrize($user, $prize)) {
                stop("优惠券奖励{$prize->name}只能领取一次");
            }
        }
        $cashMedalCodeList = explode(",", $prizeId->exchange_rule);

        $stockList = $this->stockMedalService->listCashPrizeMedal($user, $cashMedalCodeList);
        if (count($stockList) != count($cashMedalCodeList)) {
            stop("勋章数量不足兑换奖品");
        }
        $missInventory = $stockList->filter(function ($key, $value) {
            return $value->number <= 0;
        })->all();
        if (count($missInventory) > 0) {
            stop("勋章数量不足兑换奖品");
        }

        DB::beginTransaction();
        try {
            $stockList->each(function ($item, $key) use ($prize) {
                $this->stockMedalService->decrementInventory($item, "兑换奖励{$prize->name}");
            });
            $attr = [
                "userId" => $user->id,
                "prizeId" => $prize->id
            ];
            $this->stockPrizeRepository->insertStockPrize($attr);
        } catch (\Throwable $e) {
            stop("领取奖励失败，请稍后再次尝试领取 - {$e->getMessage()}");
        }
        DB::commit();
    }

    public function randomGetPoster(int $id): array
    {
        $user = $this->userRepository->find($id);

        $poster = null;
        if (strlen($user->poster) > 0) {
            $poster = explode(",", $user->poster);
        } else {
            $poster = $this->newUserPoster($user->id);
            $this->userRepository->storePoster($user->id, $poster);
        }

        return ["posterUrl" => $poster[mt_rand(0, 2)]];
    }

    private function newUserPoster(int $id): array
    {
        $url = self::USER_INVITE_URL . "?inviteBy={$id}";
        $qrCodePath = $this->posterService->makeQrCodeImage($url);

        $poster = [];
        foreach ($this->posterBackgroundImgs as $posterBackgroundImg) {
            $posterPath = $this->posterService->makePosterImage($posterBackgroundImg, $qrCodePath);
            $poster[] = storage_url($posterPath);
        }

        return $poster;
    }

    public function handleSearchItem($id)
    {
        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->find($id);
    }

    public function register(Request $request): void
    {
        //获取微信用户信息
        $wechatUser = null;
        try {
            $wechatUser = $this->officialAccountApp->user->get($request->input("openid"));
        } catch (\Exception $e) {
            abort(ResponseCodeEnum::SERVICE_REGISTER_ERROR, "获取用户信息失败");
        }

        //用户数据处理
        $user = $this->userRepository->getByTelephoneNumber($request->input("phone"));
        if (!is_null($user)) {
            $outUser = OutApiService::queryUser($request->input("phone"));
            if (is_null($outUser)) {
                try {
                    $registerReq = new UserRegisterReq();
                    $registerReq->setUserLoginPhone($request->input("phone"));
                    $registerReq->setUserPwd("");
                    $registerReq->setUserFrom(1);
                    $registerReq->setRegSource("weixin");
                    $registerReq->setPhoneAuthCode($request->input("verifyCode"));
                    $registerReq->setUserNickName($wechatUser["nickname"]);
                    $registerReq->setUserGender($wechatUser["sex"]);
                    $registerReq->setShopNumber("test");
                    $registerReq->setClerkNumber("test");
                    $registerReq->setBrandId(0);
                    $registerReq->setOuterUserId($wechatUser["openid"]);
                    $registerReq->setAuthType("24");
                    $registerReq->setOuterNickName($wechatUser["nickname"]);
                    $registerReq->setUnionId($wechatUser["unionid"]);
                    $outUser = OutApiService::sendRegisterVerifyCode($registerReq);
                } catch (\Exception $e) {
                    Log::error("远端服务器调用注册接口失败,错误信息{$e->getMessage()}", $e->getTrace());
                    abort(ResponseCodeEnum::SERVICE_REGISTER_ERROR, "注册超时，请稍后重试");
                }
            }
            $userAttr = [
                "out_id" => $outUser["userId"],
                "nickname" => $wechatUser["nickname"],
                "gender" => $wechatUser["sex"],
                "avatar_url" => $wechatUser["headimgurl"],
                "mobile_phone" => $outUser["mobile_phone"],
                "referrer" => $request->input("inviteBy", 0)
            ];
            $user = $this->userRepository->insertUser($userAttr, Constant::OPERATOR);
        }

        //微信账号数据处理
        $wechatAccount = $this->wechatAccountRepository->getByOpenId($request->input("openid"));
        if (!is_null($wechatAccount)) {
            if ($wechatAccount["user_id"] != $user["id"]) {
                abort(ResponseCodeEnum::SERVICE_REGISTER_ERROR, "手机账号已被{$wechatAccount["nickname"]}绑定");
            }
            return;
        }
        $wechatAccountAttr = [
            "user_id" => $user["id"],
            "app_type" => "officialAccount",
            "open_id" => $wechatUser["openid"],
            "app_id" => $this->officialAccountApp->config->get("app_id"),
            "union_id" => $wechatUser["unionid"] ?? "",
            "nickname" => $wechatUser["nickname"],
            "avatar_url" => $wechatUser["headimgurl"],
            "gender" => $wechatUser["sex"],
            "city" => $wechatUser["city"],
            "province" => $wechatUser["province"],
            "country" => $wechatUser["country"],
            "subscribe_time" => $wechatUser["subscribe_time"],
            "subscribe_scene" => $wechatUser["subscribe_scene"],
        ];
        $newAccount = $this->wechatAccountRepository->insertAccount($wechatAccountAttr, Constant::OPERATOR);

        if ($request->has("inviteBy")) {
            $inviteUser = $this->userRepository->find($request->input("inviteBy"));
            $this->goldService->adjustGold($inviteUser, self::INVITE_GOLD, "邀请{$newAccount->nickname}注册奖励");
        }
    }
}
