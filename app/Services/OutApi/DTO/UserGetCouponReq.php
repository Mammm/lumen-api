<?php


namespace App\Services\OutApi\DTO;


class UserGetCouponReq
{
    /**
     * @var string 券模板编号
     */
    public string $couponTemplateNo;

    /**
     * @var string 组织编码
     */
    public string $orgCode;

    /**
     * @var string|int 发放数量
     */
    public int $qtyIssue = 1;

    /**
     * @var string 应用id
     */
    public string $appId = "";

    /**
     * @var string 会员编号
     */
    public string $memberNos;
}
