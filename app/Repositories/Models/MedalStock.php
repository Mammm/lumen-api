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
class MedalStock extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "medal_stock";

    protected $guarded = [];
}
