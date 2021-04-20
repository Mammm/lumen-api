<?php


namespace App\Services\OutApi\DTO;


use App\Services\OutApi\OutApiService;

class UserRegisterReq
{
    const DEFAULT_PASSWORD = "123456";
    const FROM_ONLINE = 1;
    const SOURCE_WEIXIN = "weixin";
    const AUTH_WEIXIN = 24;

    private string $userLoginPhone;

    private string $userPwd = self::DEFAULT_PASSWORD;

    private int $userFrom = self::FROM_ONLINE;

    private string $regSource = self::SOURCE_WEIXIN;

    private int $storeId = OutApiService::STORE_ID;

    private string $phoneAuthCode;

    private string $userNickName;

    private int $userGender;

    //openid
    private string $outerUserId;

    private int $authType = self::AUTH_WEIXIN;

    private string $outerNickName;

    private string $unionId;

    /**
     * @return string
     */
    public function getUserLoginPhone(): string
    {
        return $this->userLoginPhone;
    }

    /**
     * @param string $userLoginPhone
     */
    public function setUserLoginPhone(string $userLoginPhone): void
    {
        $this->userLoginPhone = $userLoginPhone;
    }

    /**
     * @return string
     */
    public function getPhoneAuthCode(): string
    {
        return $this->phoneAuthCode;
    }

    /**
     * @param string $phoneAuthCode
     */
    public function setPhoneAuthCode(string $phoneAuthCode): void
    {
        $this->phoneAuthCode = $phoneAuthCode;
    }

    /**
     * @return string
     */
    public function getUserNickName(): string
    {
        return $this->userNickName;
    }

    /**
     * @param string $userNickName
     */
    public function setUserNickName(string $userNickName): void
    {
        $this->userNickName = $userNickName;
    }

    /**
     * @return int
     */
    public function getUserGender(): int
    {
        return $this->userGender;
    }

    /**
     * @param int $userGender
     */
    public function setUserGender(int $userGender): void
    {
        $this->userGender = $userGender;
    }

    /**
     * @return string
     */
    public function getOuterUserId(): string
    {
        return $this->outerUserId;
    }

    /**
     * @param string $outerUserId
     */
    public function setOuterUserId(string $outerUserId): void
    {
        $this->outerUserId = $outerUserId;
    }

    /**
     * @return string
     */
    public function getOuterNickName(): string
    {
        return $this->outerNickName;
    }

    /**
     * @param string $outerNickName
     */
    public function setOuterNickName(string $outerNickName): void
    {
        $this->outerNickName = $outerNickName;
    }

    /**
     * @return string
     */
    public function getUnionId(): string
    {
        return $this->unionId;
    }

    /**
     * @param string $unionId
     */
    public function setUnionId(string $unionId): void
    {
        $this->unionId = $unionId;
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
