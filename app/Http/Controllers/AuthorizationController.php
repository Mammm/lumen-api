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
use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Http\Request;
use Jiannei\Response\Laravel\Support\Facades\Response;

class AuthorizationController extends Controller
{
    /**
     * Create a new AuthController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    public function destroy()
    {
        auth()->logout();

        return Response::noContent();
    }

    public function show()
    {
        $user = auth()->userOrFail();

        return Response::success(new UserResource($user));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'type' => 'required'
        ]);

        $credentials = request(['name', 'password', 'type']);
        if (! $token = auth()->attempt($credentials)) {
            Response::errorUnauthorized();
        }

        return $this->respondWithToken($token);
    }

    public function update()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return Response::success(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ],
            '',
            ResponseCodeEnum::SERVICE_LOGIN_SUCCESS
        );
    }
}
