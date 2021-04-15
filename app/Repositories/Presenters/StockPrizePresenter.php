<?php


namespace App\Repositories\Presenters;


use App\Repositories\Transformers\StockPrizeTransformer;

class StockPrizePresenter extends Presenter
{

    public function getTransformer()
    {
        return new StockPrizeTransformer();
    }
}
