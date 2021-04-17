<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers;
use EasyWeChat\Kernel\Support\AES;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('enum:false');
        $this->middleware('throttle:10,1', ['only' => ['configurations']]);
    }

    public function configurations(Request $request)
    {
        $data = '{"clerkNumber":"2000005094","brandId":1}';
        $key = 'abcd1234abcd1234';

        $secret = Crypt::encrypt($data, false);
        dd($secret);
    }
}
