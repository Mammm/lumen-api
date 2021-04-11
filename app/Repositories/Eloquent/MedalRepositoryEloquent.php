<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\MedalRepository;
use App\Repositories\Models\Medal;

/**
 * Class MedalRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class MedalRepositoryEloquent extends BaseRepository implements MedalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Medal::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
