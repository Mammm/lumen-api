<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\StockPrize;
use League\Fractal\TransformerAbstract;

class StockPrizeTransformer extends TransformerAbstract
{
    public function transform(StockPrize $stockPrize)
    {
        return [
            "id" => $stockPrize->id,
            "name" => $stockPrize->prize->name,
            "imageUrl" => $stockPrize->prize->image_url,
            "type" => $stockPrize->prize->type,
            "status" => $stockPrize->notify_shipping,
            "gmtCreated" => $stockPrize->gmt_created
        ];
    }
}
