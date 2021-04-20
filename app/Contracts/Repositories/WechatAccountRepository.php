<?php

namespace App\Contracts\Repositories;

use App\Repositories\Models\Account\WechatAccount;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Throwable;

/**
 * Interface UserWechatAccountRepository.
 *
 * @package namespace App\Contracts\Repositories;
 */
interface WechatAccountRepository extends RepositoryInterface, RepositoryCriteriaInterface
{

    /**
     * 通过userId获取
     * @param int $userId
     * @return WechatAccount|null
     */
    function getByUserId(int $userId): ?WechatAccount;

    /**
     * 通过openId查找账户
     * @param $openId
     * @return Model|null
     */
    function getByOpenId($openId): ?WechatAccount;

    /**
     * 通过unionId查找账户
     * @param $unionId
     * @return Model|null
     */
    function getByUnionId($unionId): ?WechatAccount;

    /**
     * 新建账号数据
     * @param array $attr
     * @param string $operator
     * @return Model
     */
    function insertAccount(array $attr, string $operator): Model;

    /**
     * 更新微信账号userId
     * @param int $id
     * @param int $userId
     * @return bool
     */
    function updateUserId(int $id, int $userId): bool;
}
