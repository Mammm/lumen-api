<?php


namespace App\Services;


use App\Contracts\Repositories\PrizeRepository;
use App\Repositories\Presenters\PrizePresenter;

class PrizeService
{
    private PrizeRepository $prizeRepository;

    public function __construct(PrizeRepository $prizeRepository)
    {
        $this->prizeRepository = $prizeRepository;
    }

    public function handleAll()
    {
        $this->prizeRepository->setPresenter(PrizePresenter::class);
        return $this->prizeRepository->all();
    }
}
