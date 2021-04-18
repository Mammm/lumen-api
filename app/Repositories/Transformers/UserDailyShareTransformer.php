<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\User;
use League\Fractal\TransformerAbstract;

class UserDailyShareTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $data = $user->shareHistory->contains("date_of_share", date("Y-m-d"));
        return ["taken" => $data];
    }
}
