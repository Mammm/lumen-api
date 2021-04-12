<?php


namespace App\Providers;


use App\Services\Contract\AccountService;
use App\Services\WechatAccountService;
use Closure;
use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(AccountService::class, WechatAccountService::class);
    }
}
