<?php


namespace App\Services;


use App\Contracts\Repositories\GoldHistoryRepository;
use App\Contracts\Repositories\UserRepository;
use App\Repositories\Enums\ResponseCodeEnum;
use App\Repositories\Models\User;
use Illuminate\Support\Facades\DB;

class GoldService
{
    private UserRepository $userRepository;
    private GoldHistoryRepository $goldHistoryRepository;

    public function __construct(UserRepository $userRepository, GoldHistoryRepository $goldHistoryRepository)
    {
        $this->userRepository = $userRepository;
        $this->goldHistoryRepository = $goldHistoryRepository;
    }

    /**
     * 调整金币
     * @param User $user 用户
     * @param int $adjustNum 调整数量
     * @param string $description 描述
     */
    public function adjustGold(User $user, int $adjustNum, string $description): void
    {
        $nowGold = $user->gold;
        $updatedGold = $user->gold + $adjustNum;
        $version = $user->version;

        DB::beginTransaction();
        $result = $this->userRepository->updateGoldByVersion($user->id, $updatedGold, $version);
        if (!$result) {
            abort(ResponseCodeEnum::SYSTEM_ERROR, "更新金币失败");
        }
        $attr = [
            "userId" => $user->id,
            "before" => $nowGold,
            "adjust" => $adjustNum,
            "after" => $updatedGold,
            "version" => $version,
            "description" => $description
        ];
        $this->goldHistoryRepository->insertLog($attr);
        DB::commit();
    }
}
