<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class MedalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "medal" => [
                "name" => $this->resource->name,
                "code" => $this->resource->code,
                "imageUrl" => $this->resource->image_url
            ]
        ];
    }
}
