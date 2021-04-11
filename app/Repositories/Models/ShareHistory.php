<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DailyShareLog.
 *
 * @package namespace App\Repositories\Models;
 */
class ShareHistory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "share_history";

    protected $guarded = [];
}
