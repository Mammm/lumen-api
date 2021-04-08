<?php

namespace App\Providers;

use App\Repositories\Enums\PermissionEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
//      关闭授权代码
//      Gate::before(PermissionEnum::gateBeforeCallback());

        $this->app['auth']->provider('custom', function ($app, array $config) {
            return new EloquentUserProvider($app['hash'], $config['model']);
        });
    }
}
