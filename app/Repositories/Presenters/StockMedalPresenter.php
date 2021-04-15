<?php


namespace App\Repositories\Presenters;


use App\Repositories\Transformers\StockMedalTransformer;

class StockMedalPresenter extends Presenter
{

    public function getTransformer()
    {
        return new StockMedalTransformer();
    }
}
