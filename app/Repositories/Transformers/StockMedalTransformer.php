<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\StockMedal;
use League\Fractal\TransformerAbstract;

class StockMedalTransformer extends TransformerAbstract
{
    public function transform(StockMedal $stockMedal)
    {
        return [
            "id" => $stockMedal->medal_id,
            "name" => $stockMedal->medal->name,
            "inventory" => $stockMedal->number
        ];
    }
}
