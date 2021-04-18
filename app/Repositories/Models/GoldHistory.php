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
class GoldHistory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "gold_history";

    protected $guarded = [];

    public $timestamps = false;
}
