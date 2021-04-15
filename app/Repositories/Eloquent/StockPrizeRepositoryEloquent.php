<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\StockPrizeRepository;
use App\Repositories\Models\StockPrize;

/**
 * Class PrizeStockRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class StockPrizeRepositoryEloquent extends BaseRepository implements StockPrizeRepository
{
    public function model()
    {
        return StockPrize::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function listByUserIdAndStatus(int $userId, int $status)
    {
        $this->model->where("user_id", $userId)
            ->where("notify_shipping", $status)
            ->get();
    }

    public function listByUserIdAndPrizeId(int $userId, int $prizeId)
    {
        $this->model->newQuery()
            ->where("user_id", $userId)
            ->where("prize_id", $prizeId)
            ->get();
    }

    public function insertStockPrize($attr): Model
    {
        $this->model->user_id = $attr["userId"];
        $this->model->prize_id = $attr["prizeId"];
        $this->model->gmt_created = date("Y-m-d H:i:s");
        try {
            $this->model->saveOrFail();
        } catch (\Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "创建奖励领取信息失败");
        }
        return $this->model;
    }

    public function receiveCoupon(int $stockPrizeId)
    {
        $updateLine = $this->model->newQuery()
            ->where("id", $stockPrizeId)
            ->where("notify_shipping", 0)
            ->update(["notify_shipping" => 1]);

        return $updateLine > 0;
    }

    public function notifyShipping(int $stockPrizeId, string $realName, string $phoneNumber, string $address)
    {
        $updateLine = $this->model->newQuery()
            ->where("id", $stockPrizeId)
            ->where("notify_shipping", 0)
            ->update([
                "notify_shipping" => 1,
                "real_name" => $realName,
                "phone_number" => $phoneNumber,
                "address" => $address
            ]);

        return $updateLine > 0;
    }
}
