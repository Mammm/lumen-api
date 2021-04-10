<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Prize.
 *
 * @package namespace App\Repositories\Models;
 */
class Prize extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "prize";

    protected $guarded = [];
}
