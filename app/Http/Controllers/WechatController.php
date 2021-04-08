<?php


namespace App\Http\Controllers;

use App\Services\Contract\AccountService;
use App\Services\Impl\WechatAccountServiceImpl;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    private $account;

    public function __construct(WechatAccountServiceImpl $account)
    {
        $this->account = $account;
    }

    public function serve() {
        Log::info("接收到微信消息");

        $officialAccount = app("wechat.official_account");
        $officialAccount->server->push(function ($message) {
            return "欢迎关注公众号";
        });

        return $officialAccount->server->server();
    }
}
