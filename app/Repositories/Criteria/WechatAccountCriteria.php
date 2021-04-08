<?php


namespace App\Repositories\Criteria;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WechatAccountCriteria extends Criteria
{
    public function __construct(Request $request)
    {

    }

    protected function condition(Builder $query): void
    {
        if ($this->request->has("openId")) {
            $query->where("open_id", $this->request->get("openId"))
                ->where("app_id", "111");
        }
    }
}
