<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\StockMedalRepository;
use App\Repositories\Models\StockMedal;

/**
 * Class MedalStockRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class StockMedalRepositoryEloquent extends BaseRepository implements StockMedalRepository
{
    public function model()
    {
        return StockMedal::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function listByUserId(int $userId)
    {
        return $this->model->newQuery()->where("user_id", $userId)->get();
    }

    public function listByUserIdAndMedalCodes(int $userId, array $codes)
    {
        return $this->model->newQuery()
            ->where("user_id", $userId)
            ->whereIn("medal_code", $codes)
            ->get();
    }

    public function decrementStock($id, $version): bool
    {
        $updateLine = $this->model->newQuery()
            ->where("id", $id)
            ->where("version", $version)
            ->where("number", ">", 0)
            ->decrement("number", ["version" => $version + 1]);

        return $updateLine > 0;
    }

    public function incrementStock($id, $version): bool
    {
        $updateLine = $this->model->newQuery()
            ->where("id", $id)
            ->where("version", $version)
            ->increment("number", ["version" => $version + 1]);

        return $updateLine > 0;
    }

    public function getByUserIdAndMedalId(int $userId, int $medalId)
    {
        return $this->model->newQuery()
            ->where("user_id", $userId)
            ->where("medal_id", $medalId)
            ->first();
    }

    public function insertStockMedal($attr): Model
    {
        $this->model->user_id = $attr["userId"];
        $this->model->medal_id = $attr["medalId"];
        $this->model->medal_code = $attr["medalCode"];
        $this->model->number = 0;
        $this->model->version = 1;
        $this->model->gmt_created = date("Y-m-d H:i:s");
        try {
            $this->model->saveOrFail();
        } catch (\Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "创建勋章库存数据失败");
        }
        return $this->model;
    }

    public function getByUserIdAndDescMedalId(int $userId)
    {
        return $this->model->newQuery()
            ->where("user_id", $userId)
            ->where("number", ">", 0)
            ->orderBy("medal_id", "desc")
            ->first();
    }
}
