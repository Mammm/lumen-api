<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\Prize;
use League\Fractal\TransformerAbstract;

class PrizeTransformer extends TransformerAbstract
{
    public function transform(Prize $prize)
    {
        return [
            "id" => $prize->id,
            "name" => $prize->name,
            "inventory" => $prize->quantity,
        ];
    }
}
