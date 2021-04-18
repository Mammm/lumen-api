<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DailySignInLog.
 *
 * @package namespace App\Repositories\Models;
 */
class CheckHistory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "check_history";

    protected $guarded = [];

    public $timestamps = false;
}
