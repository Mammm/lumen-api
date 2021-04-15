<?php


namespace App\Repositories\Criteria;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StockMedalCriteria extends Criteria
{
    protected function condition(Builder $query): void
    {
        $query->where("user_id", Auth::user()->id);
    }
}
