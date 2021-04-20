<?php


namespace App\Services\OutApi;

use App\Services\OutApi\DTO\UserRegisterReq;
use App\Support\Aliyun\ApiGateway\Constant\ContentType;
use App\Support\Aliyun\ApiGateway\Constant\HttpHeader;
use App\Support\Aliyun\ApiGateway\Constant\HttpMethod;
use App\Support\Aliyun\ApiGateway\Constant\SystemHeader;
use App\Support\Aliyun\ApiGateway\Http\HttpClient;
use App\Support\Aliyun\ApiGateway\Http\HttpRequest;
use Illuminate\Support\Facades\Http;

class OutApiService
{
    const STORE_ID = 2;

    const ALIYUN_API_APP_KEY = "203928187";
    const ALIYUN_API_APP_SECRET = "kziRHJSXkqf5yo4tw7BU3yhZWQTFwJeG";

    public static function userGetCoupon(UserRegisterReq $req)
    {
        $request = new HttpRequest(API::ALIYUN_API_HOST, API::ALIYUN_API_USER_GET_COUPON, HttpMethod::POST, self::ALIYUN_API_APP_KEY, self::ALIYUN_API_APP_SECRET);

        $bodyContent = json_encode($req);

        $request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_TYPE, ContentType::CONTENT_TYPE_JSON);
        $request->setHeader(HttpHeader::HTTP_HEADER_ACCEPT, ContentType::CONTENT_TYPE_JSON);
        //注意：业务body部分，不能设置key值，只能有value
        if (0 < strlen($bodyContent)) {
            $request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_MD5, base64_encode(md5($bodyContent, true)));
            $request->setBodyString($bodyContent);
        }
        //指定参与签名的header
        $request->setSignHeader(SystemHeader::X_CA_TIMESTAMP);

        $response = HttpClient::execute($request);
        if (!$response->getSuccess()) {
            stop("优惠券发放失败 - {$response->getErrorMessage()}");
        }
    }

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
