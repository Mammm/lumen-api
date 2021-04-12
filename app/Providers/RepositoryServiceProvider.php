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

use App\Contracts\Repositories\ShareHistoryRepository;
use App\Contracts\Repositories\CheckHistoryRepository;
use App\Contracts\Repositories\GoldHistoryRepository;
use App\Contracts\Repositories\MedalRepository;
use App\Contracts\Repositories\StockMedalHistoryRepository;
use App\Contracts\Repositories\StockMedalRepository;
use App\Contracts\Repositories\PrizeRepository;
use App\Contracts\Repositories\StockPrizeRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\WechatAccountRepository;
use App\Repositories\Eloquent\ShareHistoryRepositoryEloquent;
use App\Repositories\Eloquent\CheckHistoryRepositoryEloquent;
use App\Repositories\Eloquent\GoldHistoryRepositoryEloquent;
use App\Repositories\Eloquent\MedalRepositoryEloquent;
use App\Repositories\Eloquent\StockMedalHistoryRepositoryEloquent;
use App\Repositories\Eloquent\StockMedalRepositoryEloquent;
use App\Repositories\Eloquent\PrizeRepositoryEloquent;
use App\Repositories\Eloquent\StockPrizeRepositoryEloquent;
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
        $this->app->bind(ShareHistoryRepository::class, ShareHistoryRepositoryEloquent::class);
        $this->app->bind(CheckHistoryRepository::class, CheckHistoryRepositoryEloquent::class);
        $this->app->bind(GoldHistoryRepository::class, GoldHistoryRepositoryEloquent::class);
        $this->app->bind(MedalRepository::class, MedalRepositoryEloquent::class);
        $this->app->bind(StockMedalRepository::class, StockMedalRepositoryEloquent::class);
        $this->app->bind(StockMedalHistoryRepository::class, StockMedalHistoryRepositoryEloquent::class);
        $this->app->bind(PrizeRepository::class, PrizeRepositoryEloquent::class);
        $this->app->bind(StockPrizeRepository::class, StockPrizeRepositoryEloquent::class);
    }
}
