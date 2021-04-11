<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\MedalStockLogRepository;
use App\Repositories\Models\StockMedalHistory;

/**
 * Class MedalStockLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class MedalStockLogRepositoryEloquent extends BaseRepository implements MedalStockLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StockMedalHistory::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
