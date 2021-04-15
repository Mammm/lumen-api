<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\StockMedalHistoryRepository;
use App\Repositories\Models\StockMedalHistory;

/**
 * Class MedalStockLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class StockMedalHistoryRepositoryEloquent extends BaseRepository implements StockMedalHistoryRepository
{
    public function model()
    {
        return StockMedalHistory::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function insertLog(array $attr): Model
    {
        $this->model->user_id = $attr["userId"];
        $this->model->medal_id = $attr["medalId"];
        $this->model->medal_code = $attr["medalCode"];
        $this->model->before_number = $attr["before"];
        $this->model->number = $attr["adjust"];
        $this->model->after_number = $attr["after"];
        $this->model->version = $attr["version"];
        $this->model->description = $attr["description"];
        $this->model->gmt_created = date("Y-m-d H:i:s");
        try {
            $this->model->saveOrFail();
        } catch (\Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "创建勋章变动流水表失败");
        }
        return $this->model;
    }
}
