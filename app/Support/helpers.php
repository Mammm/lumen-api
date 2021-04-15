<?php

use Jiannei\Response\Laravel\Response;

if (!function_exists('public_path')) {
    function public_path($path = ''): string
    {
        return app()->storagePath('app' . DIRECTORY_SEPARATOR . "public" .
            ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}
if (!function_exists('new_tmp_path')) {
    function new_tmp_path(): string
    {
        $tmpPath = public_path(date("Ymd"));
        if (!is_dir($tmpPath)) {
            if (!mkdir($tmpPath)) {
                return false;
            }
        }

        return $tmpPath;
    }
}
if (!function_exists("new_tmp_file")) {
    function new_tmp_file(string $ext)
    {
        if (!$tmpPath = new_tmp_path()) {
            return false;
        }
        return $tmpPath . DIRECTORY_SEPARATOR . date('His') . mt_rand(100, 999) . '.' . $ext;
    }
}
if (!function_exists("storage_url")) {
    function storage_url(string $path): string
    {
        $path = str_replace(public_path(), DIRECTORY_SEPARATOR . "storage", $path);
        return url($path);
    }
}
if (!function_exists("stop")) {
    function stop(string $message = "")
    {
        app(Response::class)->fail($message, \App\Repositories\Enums\ResponseCodeEnum::SERVICE_ERROR);
    }
}
