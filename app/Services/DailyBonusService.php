<?php


namespace App\Services;


use App\Contracts\Repositories\CheckHistoryRepository;
use App\Contracts\Repositories\GoldHistoryRepository;
use App\Contracts\Repositories\ShareHistoryRepository;
use App\Contracts\Repositories\UserRepository;
use App\Repositories\Enums\ResponseCodeEnum;
use Illuminate\Support\Facades\DB;
use Throwable;

class DailyBonusService
{
    const DEFAULT_SHARE_GOLD = 2;
    const DEFAULT_CHECKIN_GOLD = 2;
    const MAX_CHECKIN_DAY = 7;
    const MAX_CHECKIN_DAY_GOLD = 11;

    private UserRepository $userRepository;
    private GoldHistoryRepository $goldHistoryRepository;
    private CheckHistoryRepository $checkHistoryRepository;
    private ShareHistoryRepository $shareHistoryRepository;

    private GoldService $goldService;

    public function __construct(UserRepository $userRepository,
                                GoldHistoryRepository $goldHistoryRepository,
                                CheckHistoryRepository $checkHistoryRepository,
                                ShareHistoryRepository $shareHistoryRepository,
                                GoldService $goldService)
    {
        $this->userRepository = $userRepository;
        $this->goldHistoryRepository = $goldHistoryRepository;
        $this->checkHistoryRepository = $checkHistoryRepository;
        $this->shareHistoryRepository = $shareHistoryRepository;

        $this->goldService = $goldService;
    }

    /**
     * 今日签到（暂不考虑签到回归问题）
     * @param $userId
     */
    public function checkInToday(int $userId): void
    {
        $user = $this->userRepository->find($userId);

        //今日已签到
        $history = $this->checkHistoryRepository->getByDateOfCheck($user->id, date("Y-m-d"));
        if (!is_null($history)) {
            return;
        }

        //获得多少金币？
        $goldNumber = self::DEFAULT_CHECKIN_GOLD;
        if ($user->checkin == self::MAX_CHECKIN_DAY) {
            $goldNumber = self::MAX_CHECKIN_DAY_GOLD;
        }

        DB::beginTransaction();
        try {
            //签到记录
            $this->userRepository->incrementCheckinByVersion($user->id, $user->version);
            $this->checkHistoryRepository->insertLog($user->id);
            //刷新数据
            $user->refresh();
            //增加金币
            $this->goldService->adjustGold($user, $goldNumber, "每日签到获得金币");
        } catch (Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "签到失败，请稍后再次尝试");
        }
        DB::commit();
    }

    /**
     * 今日分享
     * @param int $userId
     */
    public function share(int $userId): void
    {
        $user = $this->userRepository->find($userId);

        //今日已分享
        $history = $this->shareHistoryRepository->getByDateOfCheck($user->id, date("Y-m-d"));
        if (!is_null($history)) {
            return;
        }

        //分享逻辑
        DB::beginTransaction();
        try  {
            $this->shareHistoryRepository->insertLog($user->id);
            $this->goldService->adjustGold($user, self::DEFAULT_SHARE_GOLD, "每日分享获得金币");
        } catch (Throwable $e) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "分享失败，请稍后再次尝试");
        }
        DB::commit();
    }
}
