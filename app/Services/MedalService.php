<?php


namespace App\Services;


use App\Contracts\Repositories\MedalRepository;
use App\Repositories\Presenters\MedalPresenter;

class MedalService
{
    private MedalRepository $medalRepository;

    public function __construct(MedalRepository $medalRepository)
    {
        $this->medalRepository = $medalRepository;
    }

    public function item(int $id)
    {
        $this->medalRepository->setPresenter(MedalPresenter::class);
        return $this->medalRepository->find($id);
    }

    /**
     * 抽奖根据几率获得勋章
     * @return mixed
     * @throws \Exception
     */
    public function luckDraw()
    {
        $medalList = $this->medalRepository->all();
        $max = $medalList->sum("odds");

        $luckNumber = mt_rand(0, $max);

        $flag = 0;
        foreach ($medalList as $item) {
            $flag += $item->odds;
            if ($flag >= $luckNumber) {
                return $item;
            }
        }
        throw new \Exception("未命中勋章");
    }
}