<?php


namespace App\Repositories\Presenters;


use App\Repositories\Transformers\WechatAccountTransformer;

class WechatAccountPresenter extends Presenter
{

    public function getTransformer()
    {
        return new WechatAccountTransformer();
    }
}
