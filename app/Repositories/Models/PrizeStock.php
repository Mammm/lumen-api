<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PrizeStock.
 *
 * @package namespace App\Repositories\Models;
 */
class PrizeStock extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "prize_stock";

    protected $guarded = [];
}
