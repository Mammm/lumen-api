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

use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\WechatAccountRepository;
use App\Repositories\Enums\ResponseCodeEnum;
use App\Repositories\Presenters\UserPresenter;
use App\Support\Constant;
use EasyWeChat\OfficialAccount\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserService
{
    private Application $officialAccountApp;
    private UserRepository $userRepository;
    private WechatAccountRepository $wechatAccountRepository;

    public function __construct(Application $officialAccountApp,
                                UserRepository $userRepository,
                                WechatAccountRepository $wechatAccountRepository)
    {
        $this->officialAccountApp = $officialAccountApp;
        $this->userRepository = $userRepository;
        $this->wechatAccountRepository = $wechatAccountRepository;
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
            $outUser = [];// TODO:查找甲方系统中用户的数据
            if (is_null($outUser)) {
                try {
                    $outUser = []; //TODO:甲方系统中没有用户数据，注册
                } catch (\Exception $e) {
                    Log::error("远端服务器调用注册接口失败,错误信息{$e->getMessage()}", $e->getTrace());
                    abort(ResponseCodeEnum::SERVICE_REGISTER_ERROR, "注册超时，请稍后重试");
                }
            }
            $userAttr = [
                "out_id" => $outUser["id"],
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
        $this->wechatAccountRepository->insertAccount($wechatAccountAttr, Constant::OPERATOR);
    }
}
