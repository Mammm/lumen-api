<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Models;

use Database\Factories\UserFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable, HasFactory;

    protected $table = "user";

    protected $guarded = [];

    public $timestamps = false;
    public function checkHistory(): HasMany
    {
        return $this->hasMany(CheckHistory::class, "user_id");
    }

    public function shareHistory(): HasMany
    {
        return $this->hasMany(ShareHistory::class, "user_id");
    }

    public function goldHistory(): HasMany
    {
        return $this->hasMany(GoldHistory::class, "user_id");
    }

    public function stockMedal(): HasMany
    {
        return $this->hasMany(StockMedal::class, "user_id");
    }

    public function stockMedalHistory(): HasMany
    {
        return $this->hasMany(StockMedalHistory::class, "user_id");
    }

    public function stockPrize(): HasMany
    {
        return $this->hasMany(StockPrize::class, "user_id");
    }

    /**
     * 兼容 Laravel 8 的 Factory.
     *
     * @return UserFactory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * JWT - 返回数据唯一标识符
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT - token中自定义的信息字段
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
