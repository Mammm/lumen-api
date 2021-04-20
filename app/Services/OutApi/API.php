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

    /**
     * 阿里云api接入地址
     */
    const ALIYUN_API_HOST = "http://9da0bd02ef1c41b6a4e1c87b81002b7c-cn-shenzhen.alicloudapi.com";

    /**
     * 阿里云api: 用户领取优惠券
     */
    const ALIYUN_API_USER_GET_COUPON = "/marketing/coupon/userGetCoupon";
}
