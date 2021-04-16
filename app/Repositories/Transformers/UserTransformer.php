<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Transformers;

use App\Repositories\Models\User;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        "dailyBonus", "dailyShare"
    ];

    public function transform(User $user)
    {
        $data = [
            "id" => $user->id,
            "nickname" => $user->nickname,
            "avatarUrl" => $user->avatarUrl,
            "gold" => $user->gold,
            "medal" => $user->stockMedal->sum("number")
        ];

        return $data;
    }

    public function includeDailyBonus(User $user): Item
    {
        $user->checkHistory;
        return $this->item($user, new UserDailyBonusTransformer());
    }

    public function includeDailyShare(User $user): Item
    {
        $user->shareHistory;
        return $this->item($user, new UserDailyShareTransformer());
    }
}
