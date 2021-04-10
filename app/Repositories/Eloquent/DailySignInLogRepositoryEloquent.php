<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\DailySignInLogRepository;
use App\Repositories\Models\DailySignInLog;
use App\Repositories\Validators\DailySignInLogValidator;

/**
 * Class DailySignInLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class DailySignInLogRepositoryEloquent extends BaseRepository implements DailySignInLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DailySignInLog::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}