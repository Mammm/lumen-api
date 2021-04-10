<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Medal.
 *
 * @package namespace App\Repositories\Models;
 */
class Medal extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "medal";

    protected $guarded = [];
}
