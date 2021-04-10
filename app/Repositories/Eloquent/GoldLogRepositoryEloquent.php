<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\GoldLogRepository;
use App\Repositories\Models\GoldLog;
use App\Repositories\Validators\GoldLogValidator;

/**
 * Class GoldLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class GoldLogRepositoryEloquent extends BaseRepository implements GoldLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GoldLog::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
