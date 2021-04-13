<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\CheckHistoryRepository;
use App\Repositories\Models\CheckHistory;

/**
 * Class DailySignInLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class CheckHistoryRepositoryEloquent extends BaseRepository implements CheckHistoryRepository
{
    public function model()
    {
        return CheckHistory::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param int $userId
     * @param string $date
     * @return Model|null
     */
    public function getByDateOfCheck(int $userId, string $date): ?CheckHistory
    {
        return $this->model->newQuery()
            ->where("user_id", $userId)
            ->where("date_of_check", $date)
            ->first();
    }

    /**
     * 新建签到记录
     * @param int $userId
     * @return Model
     */
    public function insertLog(int $userId): Model
    {
        $this->model->user_id = $userId;
        $this->model->date_of_check = date("Y-m-d");
        $this->model->gmt_created = date("Y-m-d H:i:s");
        try {
            $this->model->saveOrFail();
        } catch (\Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "签到日志记录失败");
        }
        return $this->model;
    }
}
