<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\GoldHistoryRepository;
use App\Repositories\Models\GoldHistory;

/**
 * Class GoldLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class GoldHistoryRepositoryEloquent extends BaseRepository implements GoldHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GoldHistory::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
