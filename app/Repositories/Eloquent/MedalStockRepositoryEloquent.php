<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\MedalStockRepository;
use App\Repositories\Models\MedalStock;
use App\Repositories\Validators\MedalStockValidator;

/**
 * Class MedalStockRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class MedalStockRepositoryEloquent extends BaseRepository implements MedalStockRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MedalStock::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
