<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MedalStockLogRepository.
 *
 * @package namespace App\Contracts\Repositories;
 */
interface StockMedalHistoryRepository extends RepositoryInterface
{
    /**
     * 新建流水
     * @param array $attr
     * @return Model
     */
    function insertLog(array $attr): Model;
}
