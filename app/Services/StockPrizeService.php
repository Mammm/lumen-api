<?php


namespace App\Services;


use App\Contracts\Repositories\StockPrizeRepository;
use App\Repositories\Criteria\StockPrizeCriteria;
use App\Repositories\Models\Prize;
use App\Repositories\Models\User;
use App\Repositories\Presenters\StockPrizePresenter;
use App\Services\OutApi\DTO\UserRegisterReq;
use App\Services\OutApi\OutApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;

class StockPrizeService
{
    private StockPrizeRepository $stockPrizeRepository;

    public function __construct(StockPrizeRepository $stockPrizeRepository)
    {
        $this->stockPrizeRepository = $stockPrizeRepository;
    }

    /**
     * 获得用户所有的奖励数据
     * @param Request $request
     * @return mixed
     * @throws RepositoryException
     */
    public function all(Request $request)
    {
        $this->stockPrizeRepository->pushCriteria(new StockPrizeCriteria($request));
        $this->stockPrizeRepository->setPresenter(StockPrizePresenter::class);
        return $this->stockPrizeRepository->with("prize")->all();
    }

    /**
     * 检查用户是否已经领取了优惠券奖励
     * @param User $user
     * @param Prize $couponPrize
     * @return bool
     */
    public function checkHasBeenGetCouponPrize(User $user, Prize $couponPrize): bool
    {
        if ($couponPrize->type != 0) {
            return false;
        }
        $couponPrizeList = $this->stockPrizeRepository->listByUserIdAndPrizeId($user->id, $couponPrize->id);
        return count($couponPrizeList) > 0;
    }

    public function receiveCoupon(int $stockPrizeId)
    {
        $stockPrize = $this->stockPrizeRepository->find($stockPrizeId);
        if (is_null($stockPrize)) {
            stop("不存在的奖励");
        }
        if ($stockPrize->prize->type != 0) {
            stop("奖励不属于优惠券，不可领取");
        }

        DB::beginTransaction();
        try {
            $result = $this->stockPrizeRepository->receiveCoupon($stockPrize->id);
            if (!$result) {
                stop();
            }

            $req = new UserRegisterReq();
            OutApiService::userGetCoupon($req);
        } catch (\Throwable $e) {
            stop("领取优惠券奖励失败，请稍后重试 - {$e->getMessage()}");
        }
        DB::commit();
    }

    public function notifyShipping(Request $request)
    {
        $stockPrizeIds = $request->input("userPrizeIds");

        $stockPrizeList = $this->stockPrizeRepository->with("prize")->findWhereIn("id", $stockPrizeIds);
        $couponPrize = $stockPrizeList->filter(function ($key, $item) {
            return $item->prize->type == 0;
        })->all();
        if (count($couponPrize) > 0) {
            stop("优惠券奖励不可以快递发货兑换");
        }

        DB::beginTransaction();
        try {
            $stockPrizeList->each(function ($item, $key) use ($request) {
               $result = $this->stockPrizeRepository->notifyShipping(
                    $item->id, $request->input("realName"), $request->input("phoneNumber"), $request->input("address")
                );
                if (!$result) {
                    stop();
                }
            });
            //TODO:调用远端接口领取优惠券
        } catch (\Throwable $e) {
            stop("领取优惠券奖励失败，请稍后重试 - {$e->getMessage()}");
        }
        DB::commit();
    }
}
