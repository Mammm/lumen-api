<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\CheckHistoryRepository;
use App\Repositories\Models\CheckHistory;

/**
 * Class DailySignInLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class CheckHistoryRepositoryEloquent extends BaseRepository implements CheckHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CheckHistory::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
