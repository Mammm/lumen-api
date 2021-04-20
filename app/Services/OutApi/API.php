<?php


namespace App\Services\OutApi;


class API
{
    /**
     * 发送验证码
     */
    const USER_VERIFY_CODE_SEND = "/m/UserVerifyCodeSend.action";

    /**
     * 查询用户
     */
    const USER_PROFILE_QUERY = "/m/UserProfileQuery.action";

    /**
     * 用户注册接口
     */
    const USER_REG_ADD_NEW = "/m/UserRegAddNew.action";

    /**
     * 微信access_token接口
     */
    const ACCESS_TOKEN = "https://act.fiveplus.com/m/getToken.action";
}
