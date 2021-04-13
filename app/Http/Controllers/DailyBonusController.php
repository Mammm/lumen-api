<?php


namespace App\Http\Controllers;


use App\Services\DailyBonusService;
use Illuminate\Support\Facades\Auth;
use Jiannei\Response\Laravel\Support\Facades\Response;

class DailyBonusController extends Controller
{
    private DailyBonusService $dailyBonusService;

    public function __construct(DailyBonusService $dailyBonusService)
    {
        $this->dailyBonusService = $dailyBonusService;
    }

    public function checkIn()
    {
        $this->dailyBonusService->checkInToday(Auth::user()->id);
        return Response::success();
    }

    public function share()
    {
        $this->dailyBonusService->share(Auth::user()->id);
        return Response::success();
    }
}
