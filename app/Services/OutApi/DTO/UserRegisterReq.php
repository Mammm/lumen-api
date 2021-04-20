<?php


namespace App\Services\OutApi\DTO;


use App\Services\OutApi\OutApiService;

class UserRegisterReq
{
    const DEFAULT_PASSWORD = "123456";
    const FROM_ONLINE = 1;
    const SOURCE_WEIXIN = "weixin";
    const AUTH_WEIXIN = 24;

    public string $userLoginPhone;

    public string $userPwd = self::DEFAULT_PASSWORD;

    public int $userFrom = self::FROM_ONLINE;

    public string $regSource = self::SOURCE_WEIXIN;

    public int $storeId = OutApiService::STORE_ID;

    public string $phoneAuthCode;

    public string $userNickName;

    public int $userGender;

    //openid
    public string $outerUserId;

    public int $authType = self::AUTH_WEIXIN;

    public string $outerNickName;

    public string $unionId;
}
