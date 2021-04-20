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
use App\Services\OutApi\API;
use App\Services\OutApi\DTO\UserRegisterReq;
use App\Services\OutApi\OutApiService;
use App\Support\Aliyun\ApiGateway\Constant\ContentType;
use App\Support\Aliyun\ApiGateway\Constant\HttpHeader;
use App\Support\Aliyun\ApiGateway\Constant\HttpMethod;
use App\Support\Aliyun\ApiGateway\Constant\SystemHeader;
use App\Support\Aliyun\ApiGateway\Http\HttpClient;
use App\Support\Aliyun\ApiGateway\Http\HttpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jiannei\Response\Laravel\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        return QrCode::format("png")
            ->size(100)
            ->generate("test");
    }
}
