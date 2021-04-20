<?php


namespace App\Http\Controllers;

use App\Services\OutApi\OutApiService;
use App\Services\WechatAccountService;
use EasyWeChat\OfficialAccount\Application as OfficialAccountService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Jiannei\Response\Laravel\Support\Facades\Response;

class WechatController extends Controller
{
    const JS_SDK_URL = "http://xingyu.fiveplus.com/#/";

    private OfficialAccountService $service;
    private WechatAccountService $account;

    public function __construct(OfficialAccountService $service,
                                WechatAccountService $account)
    {
        $this->service = $service;
        $this->account = $account;
    }

    public function serve()
    {
        Log::info("接收到微信消息");
        $officialAccount = app("wechat.official_account");
        $officialAccount->server->push(function ($message) {
            return "欢迎关注公众号";
        });
        return $officialAccount->server->server();
    }

    public function getJsSDKConfig()
    {
        $this->service->access_token->setToken(OutApiService::accessToken());
        $config = $this->service->jssdk->getConfigArray([], false, false, [], self::JS_SDK_URL);
        return Response::success($config);
    }

    public function userFromCode(Request $request)
    {
        $token = $this->service->oauth->tokenFromCode($request->input("code"));
        if ($account = $this->account->getByOpenId($token["openid"])) {
            return Response::success(["openid" => $token["openid"]]);
        }
        //未写入
        $user = $this->service->oauth->userFromToken($token["access_token"]);
        $this->account->addAccount($user);
        return Response::success(["openid" => $token["openid"]]);
    }
}
