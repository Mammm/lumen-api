<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PrizeStock.
 *
 * @package namespace App\Repositories\Models;
 */
class StockPrize extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "stock_prize";

    protected $guarded = [];

    public function prize()
    {
        return $this->belongsTo(Prize::class, "prize_id");
    }
}
