<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Providers;

use App\Repositories\Enums\CacheEnum;
use App\Services\Contract\AccountService;
use Illuminate\Auth\EloquentUserProvider as BaseEloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Cache;

class EloquentUserProvider extends BaseEloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $cacheKey = CacheEnum::getCacheKey(CacheEnum::AUTHORIZATION_USER, $identifier);
        $cacheExpireTime = CacheEnum::getCacheExpireTime(CacheEnum::AUTHORIZATION_USER);

        return Cache::remember($cacheKey, $cacheExpireTime, function () use ($identifier) {
            $model = $this->createModel();

            return $this->newModelQuery($model)
                ->where($model->getAuthIdentifierName(), $identifier)
                ->first();
        });
    }

    /**
     * 登陆验证
     * @param array $credentials
     * @return \App\Repositories\Models\User|UserContract|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return app(AccountService::class)->loginOrRegister($credentials);
    }

    /**
     * 验证密码 - 默认为true
     * @param UserContract $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return true;
    }
}
