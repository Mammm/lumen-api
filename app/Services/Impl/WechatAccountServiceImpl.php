<?php


namespace App\Services\Impl;

use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\WechatAccountRepository;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Repositories\Eloquent\WechatAccountRepositoryEloquent;
use App\Repositories\Enums\ResponseCodeEnum;
use App\Repositories\Models\User;
use App\Services\Contract\AccountService;
use EasyWeChat\OfficialAccount\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WechatAccountServiceImpl implements AccountService
{
    private Application $officialAccountApp;
    private WechatAccountRepository $accountRepository;
    private UserRepository $userRepository;

    /**
     * WechatAccountServiceImpl constructor.
     * @param Application $officialAccountApp
     * @param WechatAccountRepositoryEloquent $accountRepository
     * @param UserRepositoryEloquent $userRepository
     */
    public function __construct(Application $officialAccountApp,
                                WechatAccountRepository $accountRepository,
                                UserRepository $userRepository)
    {
        $this->officialAccountApp = $officialAccountApp;
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
    }

    public function loginOrRegister(array $credentials): ?User
    {
        if (!$user = $this->login($credentials)) {
            if (!$user = $this->register($credentials)) {
                abort(ResponseCodeEnum::SERVICE_LOGIN_ERROR);
            }
        }
        return $user;
    }

    /**
     * 查询账号获取用户信息
     * @param array $credentials
     * @return User|null
     */
    private function login(array $credentials): ?User
    {
        if (!isset($credentials["name"], $credentials["type"])) {
            abort(ResponseCodeEnum::CLIENT_PARAMETER_ERROR);
        }
        $account = $this->accountRepository->getByOpenId($credentials["name"]);
        if (is_null($account)) {
            return null;
        }
        return $account->user;
    }

    /**
     * 注册账号数据
     * @param array $credentials
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     * @throws \Throwable
     */
    private function register(array $credentials)
    {
        if (!isset($credentials["name"], $credentials["type"])) {
            abort(ResponseCodeEnum::CLIENT_PARAMETER_ERROR);
        }

        try {
            $wechatUser = $this->officialAccountApp->user->get($credentials["name"]);
        } catch (\Exception $e) {
            Log::error("调用微信用户信息接口失败，错误信息：{$e->getMessage()}");
            abort(ResponseCodeEnum::SERVICE_LOGIN_ERROR);
        }

        if (isset($wechatUser["unionid"])) {
            $user = $this->accountRepository->getByUnionId($wechatUser["unionid"]);
            if (!is_null($user)) {
                $attr = [
                    "userId" => $user->id,
                    "openId" => $wechatUser["openid"],
                    "unionId" => $wechatUser["unionid"],
                    "appId" => $this->officialAccountApp->config->get("app_id"),
                    "type" => "officialAccount"
                ];
                try {
                    $this->accountRepository->insertAccount($attr, "system");
                } catch (\Exception $e) {
                    Log::error("微信账号创建失败", $e->getTrace());
                    abort(ResponseCodeEnum::SERVICE_REGISTER_ERROR, "微信账号注册失败");
                }
                return $user;
            }
        }

        DB::beginTransaction();
        $userAttr = [
            "nickname" => $wechatUser["nickname"],
            "gender" => $wechatUser["sex"],
            "avatarUrl" => $wechatUser["headimgurl"]
        ];
        $user = $this->userRepository->insertUser($userAttr, "system");
        $accountAttr = [
            "userId" => $user->id,
            "openId" => $wechatUser["openid"],
            "unionId" => $wechatUser["unionid"],
            "appId" => $this->officialAccountApp->config->get("app_id"),
            "type" => "officialAccount"
        ];
        $account = $this->accountRepository->insertAccount($accountAttr, "system");
        DB::commit();

        return $user;
    }
}
