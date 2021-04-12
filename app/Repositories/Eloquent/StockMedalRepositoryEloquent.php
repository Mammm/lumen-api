<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\StockMedalRepository;
use App\Repositories\Models\StockMedal;

/**
 * Class MedalStockRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class StockMedalRepositoryEloquent extends BaseRepository implements StockMedalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StockMedal::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
