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

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiannei\Response\Laravel\Support\Facades\Response;

class UsersController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api', ['except' => ['store']]);
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
