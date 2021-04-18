<?php


namespace App\Http\Controllers;


use App\Services\PrizeService;
use Jiannei\Response\Laravel\Support\Facades\Response;

class PrizeController extends Controller
{
    private PrizeService $prizeService;

    public function __construct(PrizeService $prizeService)
    {
        $this->prizeService = $prizeService;
        $this->middleware('auth:api');
    }

    public function all()
    {
        $prizeList = $this->prizeService->handleAll();
        return Response::success($prizeList);
    }
}
