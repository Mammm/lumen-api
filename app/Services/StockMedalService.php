<?php


namespace App\Services;


use App\Contracts\Repositories\StockMedalHistoryRepository;
use App\Contracts\Repositories\StockMedalRepository;
use App\Repositories\Criteria\StockMedalCriteria;
use App\Repositories\Models\Medal;
use App\Repositories\Models\StockMedal;
use App\Repositories\Models\User;
use App\Repositories\Presenters\StockMedalPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Exceptions\RepositoryException;

class StockMedalService
{
    private StockMedalRepository $stockMedalRepository;
    private StockMedalHistoryRepository $stockMedalHistoryRepository;

    public function __construct(StockMedalRepository $stockMedalRepository,
                                StockMedalHistoryRepository $stockMedalHistoryRepository)
    {
        $this->stockMedalRepository = $stockMedalRepository;
        $this->stockMedalHistoryRepository = $stockMedalHistoryRepository;
    }

    /**
     * 获得用户所有的勋章数据
     * @param Request $request
     * @return mixed
     * @throws RepositoryException
     */
    public function all(Request $request)
    {
        $this->stockMedalRepository->pushCriteria(new StockMedalCriteria($request));
        $this->stockMedalRepository->setPresenter(StockMedalPresenter::class);
        return $this->stockMedalRepository->with("medal")->all();
    }

    /**
     * 减少用户勋章数量
     * @param StockMedal $stockMedal
     * @param string $description
     */
    public function decrementInventory(StockMedal $stockMedal, string $description)
    {
        $nowInventory = $stockMedal->number;
        $updatedInventory = $stockMedal->number - 1;
        $version = $stockMedal->version;

        DB::beginTransaction();
        $result = $this->stockMedalRepository->decrementStock($stockMedal->id, $version);
        if (!$result) {
            stop("扣减勋章数量失败");
        }
        $attr = [
            "userId" => $stockMedal->user_id,
            "medalId" => $stockMedal->medal_id,
            "medalCode" => $stockMedal->medal_code,
            "before" => $nowInventory,
            "adjust" => -1,
            "after" => $updatedInventory,
            "version" => $version,
            "description" => $description
        ];
        $this->stockMedalHistoryRepository->insertLog($attr);
        DB::commit();
    }

    /**
     * 增加勋章数量
     * @param User $user
     * @param Medal $medal
     * @param string $description
     */
    public function incrementInventory(User $user, Medal $medal, string $description)
    {
        $stockMedal = $this->stockMedalRepository->getByUserIdAndMedalId($user->id, $medal->id);
        if (is_null($stockMedal)) {
            $stockMedal = $this->addStockMedal($user, $medal);
        }

        $nowInventory = $stockMedal->number;
        $updatedInventory = $stockMedal->number + 1;
        $version = $stockMedal->version;

        DB::beginTransaction();
        $result = $this->stockMedalRepository->incrementStock($stockMedal->id, $version);
        if (!$result) {
            stop("增加勋章数量失败");
        }
        $attr = [
            "userId" => $stockMedal->user_id,
            "medalId" => $stockMedal->medal_id,
            "medalCode" => $stockMedal->medal_code,
            "before" => $nowInventory,
            "adjust" => 1,
            "after" => $updatedInventory,
            "version" => $version,
            "description" => $description
        ];
        $this->stockMedalHistoryRepository->insertLog($attr);
        DB::commit();
    }

    /**
     * 新建数据
     * @param User $user
     * @param Medal $medal
     * @return Model|mixed
     */
    public function addStockMedal(User $user, Medal $medal)
    {
        $attr = [
            "userId" => $user->id,
            "medalId" => $medal->id,
            "medalCode" => $medal->code
        ];
        return $this->stockMedalRepository->insertStockMedal($attr);
    }

    /**
     * 查询兑换奖品所需的勋章
     * @param User $user
     * @param array $cashPrizeMedalCode
     * @return Collection|mixed
     */
    public function listCashPrizeMedal(User $user, array $cashPrizeMedalCode)
    {
        if (count($cashPrizeMedalCode) == 1 && $cashPrizeMedalCode[0] == "*") {
            $stockMedal = $this->stockMedalRepository->getByUserIdAndDescMedalId($user->id);
            return $stockMedal ? collect([$stockMedal]) : collect();
        }
        return $this->stockMedalRepository->listByUserIdAndMedalCodes($user->id, $cashPrizeMedalCode);
    }
}
