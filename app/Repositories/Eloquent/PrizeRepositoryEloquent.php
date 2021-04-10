<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\PrizeRepository;
use App\Repositories\Models\Prize;
use App\Repositories\Validators\PrizeValidator;

/**
 * Class PrizeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PrizeRepositoryEloquent extends BaseRepository implements PrizeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Prize::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
