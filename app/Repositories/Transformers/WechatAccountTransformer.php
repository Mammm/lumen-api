<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\Account\WechatAccount;
use League\Fractal\TransformerAbstract;

class WechatAccountTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
//        'user',
    ];

    public function transform(WechatAccount $account)
    {
        return [
            "userId" => $account->user_id,
            "appType" => $account->app_type,
            "openId" => $account->open_id,
            "unionId" => $account->union_id
        ];
    }

    public function includeUser(WechatAccount $account) {
        dd($account->user);
        return $this->item($account->user, new UserTransformer());
    }
}
