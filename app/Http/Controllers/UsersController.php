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

use App\Services\StockMedalService;
use App\Services\StockPrizeService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiannei\Response\Laravel\Support\Facades\Response;

class UsersController extends Controller
{
    private UserService $userService;
    private StockPrizeService $stockPrizeService;
    private StockMedalService $stockMedalService;

    public function __construct(UserService $userService,
                                StockPrizeService $stockPrizeService,
                                StockMedalService $stockMedalService)
    {
        $this->userService = $userService;
        $this->stockPrizeService = $stockPrizeService;
        $this->stockMedalService = $stockMedalService;
        $this->middleware('auth:api', ['except' => ['store', 'sendRegisterVerifyCode']]);
    }

    public function sendRegisterVerifyCode(Request $request)
    {
        $this->validate($request, [
            "phone" => ["required"],
        ]);
        $this->userService->sendRegisterVerifyCode($request);
        return Response::success();
    }

    public function notifyShipping(Request $request)
    {
        $this->stockPrizeService->notifyShipping($request);
        return Response::success();
    }

    public function receiveCoupon(Request $request)
    {
        $this->stockPrizeService->receiveCoupon($request->userPrizeId);
        return Response::success();
    }

    public function medalList(Request $request)
    {
        $data = $this->stockMedalService->all($request);
        return Response::success($data);
    }

    public function prizeList(Request $request)
    {
        $data = $this->stockPrizeService->all($request);
        return Response::success($data);
    }

    public function getPrize(Request $request)
    {
        $this->userService->cashPrize(Auth::id(), $request->input("prizeId"));
        return Response::success();
    }

    public function gameStart()
    {
        $this->userService->gameStart();
        return Response::success();
    }

    public function rank()
    {
        $data = $this->userService->top100();
        return Response::success($data);
    }

    public function poster()
    {
        $data = $this->userService->randomGetPoster(Auth::user()->id);
        return Response::success($data);
    }

    public function show()
    {
        $user = $this->userService->handleSearchItem(Auth::user()->id);
        return Response::success($user);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "openid" => ["required", "string"],
            "phone" => ["required"],
            "verifyCode" => ["required"],
        ]);
        $this->userService->register($request);
        return Response::success();
    }
}
