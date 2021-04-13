<?php

namespace App\Contracts\Repositories;

use App\Repositories\Models\CheckHistory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DailySignInLogRepository.
 *
 * @package namespace App\Contracts\Repositories;
 */
interface CheckHistoryRepository extends RepositoryInterface
{
    /**
     * 获取用户签到记录
     * @param int $userId
     * @param string $date
     * @return CheckHistory|null
     */
    function getByDateOfCheck(int $userId, string $date): ?CheckHistory;

    /**
     * 新建签到记录
     * @param int $userId
     * @return Model
     */
    function insertLog(int $userId): Model;
}
