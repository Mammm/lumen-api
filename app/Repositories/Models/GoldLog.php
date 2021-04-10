<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GoldLog.
 *
 * @package namespace App\Repositories\Models;
 */
class GoldLog extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "gold_log";

    protected $guarded = [];
}
