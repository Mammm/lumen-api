<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\DailyShareLogRepository;
use App\Repositories\Models\ShareHistory;

/**
 * Class DailyShareLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class DailyShareLogRepositoryEloquent extends BaseRepository implements DailyShareLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShareHistory::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
