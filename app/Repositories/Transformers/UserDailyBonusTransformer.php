<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\User;
use League\Fractal\TransformerAbstract;

class UserDailyBonusTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $data = [
            "toDay" => $user->checkin,
            "taken" => $user->checkHistory->contains("date_of_check", date("Y-m-d"))
        ];

        return $data;
    }
}
