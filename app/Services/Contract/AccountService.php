<?php


namespace App\Services\Contract;


use App\Repositories\Models\User;

interface AccountService
{
    /**
     * 尝试登陆，如果没有账号就创建
     * @param array $credentials
     * @return User|null
     */
    public function loginOrRegister(array $credentials): ?User;
}
