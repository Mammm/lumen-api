<?php


namespace App\Providers;


use App\Services\Contract\AccountService;
use App\Services\Impl\WechatAccountServiceImpl;
use Closure;
use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(AccountService::class, WechatAccountServiceImpl::class);
    }
}
