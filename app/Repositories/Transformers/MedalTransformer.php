<?php


namespace App\Repositories\Transformers;


use App\Repositories\Models\Medal;
use League\Fractal\TransformerAbstract;

class MedalTransformer extends TransformerAbstract
{
    public function transform(Medal $medal)
    {
        return [
            "id" => $medal->id,
            "name" => $medal->name,
            "code" => $medal->code,
            "imageUrl" => $medal->image_url,
        ];
    }
}
