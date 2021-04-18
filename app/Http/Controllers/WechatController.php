<?php


namespace App\Http\Controllers;

use App\Services\WechatAccountService;
use EasyWeChat\OfficialAccount\Application as OfficialAccountService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class WechatController extends Controller
{
    private OfficialAccountService $service;
    private WechatAccountService $account;

    public function __construct(OfficialAccountService $service,
                                WechatAccountService $account)
    {
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

    public function test(Request $request)
    {
        $this->service->oauth->userFromCode($request->input("code"));
    }
}
