<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\User;
use League\Fractal\TransformerAbstract;

class Top100Transformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            "id" => $user->id,
            "name" => $user->nickname,
            "avatarUrl" => $user->avatar_url,
            "medal" => $user->medal
        ];
    }
}
