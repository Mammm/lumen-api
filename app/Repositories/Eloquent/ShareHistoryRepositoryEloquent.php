<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\ShareHistoryRepository;
use App\Repositories\Models\ShareHistory;

/**
 * Class DailyShareLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ShareHistoryRepositoryEloquent extends BaseRepository implements ShareHistoryRepository
{
    public function model()
    {
        return ShareHistory::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 根据分享日期获得分享记录
     * @param int $userId
     * @param string $date
     * @return Model|null
     */
    public function getByDateOfCheck(int $userId, string $date): ?ShareHistory
    {
        return $this->model->newQuery()
            ->where("user_id", $userId)
            ->where("date_of_share", $date)
            ->first();
    }

    /**
     * 新建日志
     * @param int $userId
     * @return Model
     */
    public function insertLog(int $userId): Model
    {
        $this->model->user_id = $userId;
        $this->model->date_of_share = date("Y-m-d");
        $this->model->gmt_created = date("Y-m-d H:i:s");
        try {
            $this->model->saveOrFail();
        } catch (\Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "创建分享日志失败");
        }
        return $this->model;
    }
}
