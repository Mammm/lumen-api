<?php


namespace App\Services\OutApi;


use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Http;

class HttpUtils
{
    const TIMEOUT = 3;

    const HOST = "https://passport.fiveplus.com/";

    const METHOD = "GET";

    public static function send(string $uri, string $data): array
    {
        $url = self::HOST.$uri;
        $appCode = AESUtils::CODE;
        $data = AESUtils::encrypt($data);

        try {
            $response = Http::timeout(self::TIMEOUT)->get($url, compact("appCode", "data"));
        } catch (ConnectException $connectException) {
            stop("请求超时");
        }

        $data = $response->json();
        $data["content"] = AESUtils::decrypt($data["content"]);
        return $data;
    }
}
