<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MedalStock.
 *
 * @package namespace App\Repositories\Models;
 */
class StockMedal extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "stock_medal";

    protected $guarded = [];

    public function medal()
    {
        return $this->belongsTo(Medal::class, "medal_id");
    }
}
