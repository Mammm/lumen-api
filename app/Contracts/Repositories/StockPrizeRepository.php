<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PrizeStockRepository.
 *
 * @package namespace App\Contracts\Repositories;
 */
interface StockPrizeRepository extends RepositoryInterface
{
    /**
     * 通过用户id和状态查询
     * @param int $userId
     * @param int $status
     * @return mixed
     */
    function listByUserIdAndStatus(int $userId, int $status);

    /**
     * 查看用户某一个奖品获得了多少个？
     * @param int $userId
     * @param int $prizeId
     * @return mixed
     */
    function listByUserIdAndPrizeId(int $userId, int $prizeId);

    /**
     * 新建奖励的领取
     * @param $attr
     * @return Model
     */
    function insertStockPrize($attr): Model;

    /**
     * 领取优惠券奖励
     * @param int $stockPrizeId
     * @return mixed
     */
    function receiveCoupon(int $stockPrizeId);

    /**
     * 记录发货通知
     * @param int $stockPrizeId
     * @param string $realName
     * @param string $phoneNumber
     * @param string $address
     * @return mixed
     */
    function notifyShipping(int $stockPrizeId, string $realName, string $phoneNumber, string $address);
}
