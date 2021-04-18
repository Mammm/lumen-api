<?php


namespace App\Services\OutApi\DTO;


class UserRegisterReq
{
    private string $userLoginPhone;

    private string $userPwd;

    private int $userFrom;

    private string $regSource;

    private int $storeId;

    private string $phoneAuthCode;

    private string $userNickName;

    private int $userGender;

    private string $shopNumber;

    private string $clerkNumber;

    private int $brandId;

    //openid
    private string $outerUserId;

    private string $authType;

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
    public function getUserPwd(): string
    {
        return $this->userPwd;
    }

    /**
     * @param string $userPwd
     */
    public function setUserPwd(string $userPwd): void
    {
        $this->userPwd = $userPwd;
    }

    /**
     * @return int
     */
    public function getUserFrom(): int
    {
        return $this->userFrom;
    }

    /**
     * @param int $userFrom
     */
    public function setUserFrom(int $userFrom): void
    {
        $this->userFrom = $userFrom;
    }

    /**
     * @return string
     */
    public function getRegSource(): string
    {
        return $this->regSource;
    }

    /**
     * @param string $regSource
     */
    public function setRegSource(string $regSource): void
    {
        $this->regSource = $regSource;
    }

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->storeId;
    }

    /**
     * @param int $storeId
     */
    public function setStoreId(int $storeId): void
    {
        $this->storeId = $storeId;
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
    public function getShopNumber(): string
    {
        return $this->shopNumber;
    }

    /**
     * @param string $shopNumber
     */
    public function setShopNumber(string $shopNumber): void
    {
        $this->shopNumber = $shopNumber;
    }

    /**
     * @return string
     */
    public function getClerkNumber(): string
    {
        return $this->clerkNumber;
    }

    /**
     * @param string $clerkNumber
     */
    public function setClerkNumber(string $clerkNumber): void
    {
        $this->clerkNumber = $clerkNumber;
    }

    /**
     * @return int
     */
    public function getBrandId(): int
    {
        return $this->brandId;
    }

    /**
     * @param int $brandId
     */
    public function setBrandId(int $brandId): void
    {
        $this->brandId = $brandId;
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
    public function getAuthType(): string
    {
        return $this->authType;
    }

    /**
     * @param string $authType
     */
    public function setAuthType(string $authType): void
    {
        $this->authType = $authType;
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


}
