<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface GoldLogRepository.
 *
 * @package namespace App\Contracts\Repositories;
 */
interface GoldHistoryRepository extends RepositoryInterface
{
    /**
     * 创建金额流水
     * @param array $attr
     * @return Model
     */
    function insertLog(array $attr): Model;
}
