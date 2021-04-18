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

use App\Services\OutApi\AESUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jiannei\Response\Laravel\Support\Facades\Response;

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
        $url = "https://passport.fiveplus.com/m/UserProfileQuery.action";
        $appCode = "AES";
        $data = AESUtils::encrypt('{"storeId":2,"userLoginPhone":15107691336}');
        $response = Http::get($url, compact('appCode', 'data'));

        dd($response->json());
    }
}
