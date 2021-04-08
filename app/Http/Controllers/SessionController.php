<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SessionController extends Controller
{
    public function store(Request $request) {
        if (!$request->has(["account", "password", "type"])) {
            abort("登陆失败");
        }

        $account = $request->input("account");
        $password = $request->input("password");
        $type = $request->input("type");
    }
}
