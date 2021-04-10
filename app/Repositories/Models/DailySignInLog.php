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
class DailySignInLog extends Model implements Transformable
{
    use TransformableTrait;


    protected $table = "daily_sign_in_log";

    protected $guarded = [];

}
