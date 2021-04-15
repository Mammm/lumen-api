<?php


namespace App\Repositories\Presenters;


use App\Repositories\Transformers\MedalTransformer;

class MedalPresenter extends Presenter
{

    public function getTransformer()
    {
        return new MedalTransformer();
    }
}
