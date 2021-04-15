<?php


namespace App\Repositories\Presenters;


use App\Repositories\Transformers\PrizeTransformer;

class PrizePresenter extends Presenter
{

    public function getTransformer()
    {
        return new PrizeTransformer();
    }
}
