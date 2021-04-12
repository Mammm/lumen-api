<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\StockPrizeRepository;
use App\Repositories\Models\StockPrize;

/**
 * Class PrizeStockRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class StockPrizeRepositoryEloquent extends BaseRepository implements StockPrizeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StockPrize::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
