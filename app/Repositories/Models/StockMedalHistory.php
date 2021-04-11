<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MedalStockLog.
 *
 * @package namespace App\Repositories\Models;
 */
class StockMedalHistory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "stock_medal_history";

    protected $guarded = [];
}
