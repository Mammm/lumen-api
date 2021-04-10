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
class MedalStockLog extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "medal_stock_log";

    protected $guarded = [];
}
