<?php


namespace App\Repositories\Presenters;


use App\Repositories\Transformers\Top100Transformer;

class Top100Presenter extends Presenter
{

    public function getTransformer()
    {
        return new Top100Transformer();
    }
}
