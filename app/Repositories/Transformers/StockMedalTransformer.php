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
            "code" => $stockMedal->medal->code,
            "imageUrl" => $stockMedal->medal->image_url,
            "inventory" => $stockMedal->number
        ];
    }
}
