<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\StockMedal;
use League\Fractal\TransformerAbstract;

class Top100Transformer extends TransformerAbstract
{
    public function transform(StockMedal $stockMedal)
    {
        return [
            "id" => $stockMedal->user->id,
            "name" => $stockMedal->user->nickname,
            "avatarUrl" => $stockMedal->user->avatar_url,
            "medal" => $stockMedal->number
        ];
    }
}
