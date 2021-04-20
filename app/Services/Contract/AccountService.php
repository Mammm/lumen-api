<?php


namespace App\Services\Contract;


use App\Repositories\Models\Account\WechatAccount;
use App\Repositories\Models\User;

interface AccountService
{
    /**
     * 尝试登陆，如果没有账号就创建
     * @param array $credentials
     * @return User|null
     */
    function loginOrRegister(array $credentials): ?User;

    /**
     * 查找用户是否已经有了记录
     * @param string $openid
     * @return WechatAccount|null
     */
    function getByOpenId(string $openid): ?WechatAccount;

    /**
     * 新建账号
     * @param \Overtrue\Socialite\User $wechatUser
     * @return mixed
     */
    function addAccount(\Overtrue\Socialite\User $wechatUser);
}
