<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Contracts\Repositories;

use App\Repositories\Models\User;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 */
interface UserRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * 手机号查询用户
     * @param string $telephoneNumber
     * @return User|null
     */
    function getByTelephoneNumber(string $telephoneNumber): ?User;

    /**
     * 新建用户
     * @param array $attr
     * @param string $operator
     * @return User
     */
    function insertUser(array $attr, string $operator): User;

    /**
     * 更新用户金额记录
     * @param int $userId 用户id
     * @param int $gold 金额
     * @param int $version 版本号
     * @return bool
     */
    function updateGoldByVersion(int $userId, int $gold, int $version): bool;

    /**
     * 自增长签到天数
     * @param int $userId
     * @param int $version
     * @return bool
     */
    function incrementCheckinByVersion(int $userId, int $version): bool;

    /**
     * 更新用户的海报
     * @param int $userId
     * @param array $poster
     * @return bool
     */
    function storePoster(int $userId, array $poster): bool;
}
