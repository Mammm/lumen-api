<?php


namespace App\Services\OutApi;

use App\Services\OutApi\DTO\UserRegisterReq;
use Illuminate\Support\Facades\Http;

class OutApiService
{
    const STORE_ID = 2;

    public static function accessToken()
    {
        $response = Http::get(API::ACCESS_TOKEN);
        if ($response["code"] != 1) {
            stop("获取access_token失败");
        }

        return $response["content"]["token"];
    }

    public static function UserRegister(UserRegisterReq $req)
    {
        $response = HttpUtils::send(API::USER_REG_ADD_NEW, json_encode($req));
        if ($response["code"] != 1) {
            stop("注册失败 - {$response["message"]}");
        }

        return $response["content"];
    }


    public static function sendRegisterVerifyCode(string $phoneNumber)
    {
        $req = ["storeId" => self::STORE_ID, "userLoginPhone" => $phoneNumber];
        $response = HttpUtils::send(API::USER_VERIFY_CODE_SEND, json_encode($req));
        if ($response["code"] != 1) {
            stop("发送验证码失败 - {$response["message"]}");
        }

        return $response["content"];
    }

    public static function queryUser(string $phoneNumber): ?string
    {
        $req = ["storeId" => self::STORE_ID, "userLoginPhone" => $phoneNumber];
        $response = HttpUtils::send(API::USER_PROFILE_QUERY, json_encode($req));
        if ($response["code"] == 0) {
            stop("查询用户失败  - {$response["message"]}");
        }
        if ($response["code"] != 1) {
            return null;
        }

        return $response["content"];
    }
}
