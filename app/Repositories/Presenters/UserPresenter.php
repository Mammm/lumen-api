<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\UserTransformer;

class UserPresenter extends Presenter
{
    public function getTransformer()
    {
        return new UserTransformer();
    }
}
