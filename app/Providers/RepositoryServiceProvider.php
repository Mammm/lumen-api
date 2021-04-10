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

use App\Contracts\Repositories\DailyShareLogRepository;
use App\Contracts\Repositories\DailySignInLogRepository;
use App\Contracts\Repositories\GoldLogRepository;
use App\Contracts\Repositories\MedalRepository;
use App\Contracts\Repositories\MedalStockLogRepository;
use App\Contracts\Repositories\MedalStockRepository;
use App\Contracts\Repositories\PrizeRepository;
use App\Contracts\Repositories\PrizeStockRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\WechatAccountRepository;
use App\Repositories\Eloquent\DailyShareLogRepositoryEloquent;
use App\Repositories\Eloquent\DailySignInLogRepositoryEloquent;
use App\Repositories\Eloquent\GoldLogRepositoryEloquent;
use App\Repositories\Eloquent\MedalRepositoryEloquent;
use App\Repositories\Eloquent\MedalStockLogRepositoryEloquent;
use App\Repositories\Eloquent\MedalStockRepositoryEloquent;
use App\Repositories\Eloquent\PrizeRepositoryEloquent;
use App\Repositories\Eloquent\PrizeStockRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Repositories\Eloquent\WechatAccountRepositoryEloquent;
use Prettus\Repository\Providers\LumenRepositoryServiceProvider;

class RepositoryServiceProvider extends LumenRepositoryServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(WechatAccountRepository::class, WechatAccountRepositoryEloquent::class);
        $this->app->bind(DailyShareLogRepository::class, DailyShareLogRepositoryEloquent::class);
        $this->app->bind(DailySignInLogRepository::class, DailySignInLogRepositoryEloquent::class);
        $this->app->bind(GoldLogRepository::class, GoldLogRepositoryEloquent::class);
        $this->app->bind(MedalRepository::class, MedalRepositoryEloquent::class);
        $this->app->bind(MedalStockRepository::class, MedalStockRepositoryEloquent::class);
        $this->app->bind(MedalStockLogRepository::class, MedalStockLogRepositoryEloquent::class);
        $this->app->bind(PrizeRepository::class, PrizeRepositoryEloquent::class);
        $this->app->bind(PrizeStockRepository::class, PrizeStockRepositoryEloquent::class);
    }
}
