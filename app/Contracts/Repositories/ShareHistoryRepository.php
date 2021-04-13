<?php

namespace App\Contracts\Repositories;

use App\Repositories\Models\ShareHistory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DailyShareLogRepository.
 *
 * @package namespace App\Contracts\Repositories;
 */
interface ShareHistoryRepository extends RepositoryInterface
{
    /**
     * 根据分享日期获得分享记录
     * @param int $userId
     * @param string $date
     * @return Model|null
     */
    function getByDateOfCheck(int $userId, string $date): ?ShareHistory;

    /**
     * 新建日志
     * @param int $userId
     * @return Model
     */
    function insertLog(int $userId): Model;
}
