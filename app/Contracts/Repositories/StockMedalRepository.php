<?php

namespace App\Contracts\Repositories;

use App\Repositories\Models\StockMedal;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface StockMedalRepository extends RepositoryInterface
{
    /**
     * 获得用户下所有的勋章数据
     * @param int $userId
     * @return mixed
     */
    function listByUserId(int $userId);

    /**
     * 获得用户下特定code的勋章数据
     * @param int $userId
     * @param array $codes
     * @return mixed
     */
    function listByUserIdAndMedalCodes(int $userId, array $codes);

    /**
     * 减少勋章库存
     * @param $id
     * @param $version
     * @return bool
     */
    function decrementStock($id, $version): bool;

    /**
     * 增加勋章库存
     * @param $id
     * @param $version
     * @return bool
     */
    function incrementStock($id, $version): bool;

    /**
     * 通过userId和勋章id获得用户库存数据
     * @param int $userId
     * @param int $medalId
     * @return mixed
     */
    function getByUserIdAndMedalId(int $userId, int $medalId);

    /**
     * 创建勋章表
     * @param $attr
     * @return mixed
     */
    function insertStockMedal($attr): Model;

    /**
     * 查询用户所拥有的勋章中权重最低的那个
     * @param int $userId
     * @return StockMedal|null
     */
    function getByUserIdAndDescMedalId(int $userId);
}
