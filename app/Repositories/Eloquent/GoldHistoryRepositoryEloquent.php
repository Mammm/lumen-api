<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\GoldHistoryRepository;
use App\Repositories\Models\GoldHistory;

/**
 * Class GoldLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class GoldHistoryRepositoryEloquent extends BaseRepository implements GoldHistoryRepository
{
    public function model()
    {
        return GoldHistory::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 创建金额流水
     * @param array $attr
     * @return Model
     */
    public function insertLog(array $attr): Model
    {
        $this->model->user_id = $attr["userId"];
        $this->model->before_number = $attr["before"];
        $this->model->number = $attr["adjust"];
        $this->model->after_number = $attr["after"];
        $this->model->version = $attr["version"];
        $this->model->description = $attr["description"];
        $this->model->gmt_created = date("Y-m-d H:i:s");
        try {
            $this->model->saveOrFail();
        } catch (\Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "创建金币变动流水失败");
        }
        return $this->model;
    }
}
