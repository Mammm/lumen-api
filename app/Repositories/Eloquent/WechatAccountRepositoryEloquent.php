<?php


namespace App\Repositories\Eloquent;


use App\Contracts\Repositories\WechatAccountRepository;
use App\Repositories\Criteria\RequestCriteria;
use App\Repositories\Enums\ResponseCodeEnum;
use App\Repositories\Models\Account\WechatAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Throwable;

class WechatAccountRepositoryEloquent extends BaseRepository implements WechatAccountRepository
{

    public function model()
    {
        return WechatAccount::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 通过openId查找账户
     * @param $openId
     * @return Model|null
     */
    public function getByOpenId($openId): ?WechatAccount
    {
        return $this->model->newQuery()->where("open_id", $openId)->first();
    }

    /**
     * 通过unionId查找账户
     * @param $unionId
     * @return Model|null
     */
    public function getByUnionId($unionId): ?WechatAccount
    {
        return $this->model->newQuery()->where("union_id", $unionId)->first();
    }

    /**
     * 新建账号数据
     * @param array $attr 账号数据
     * @param string $operator 操作人
     * @return Model
     * @throws Throwable
     */
    public function insertAccount(array $attr, string $operator): Model
    {
        $now = date("Y-m-d H:i:s");
        $this->model->user_id = $attr["user_id"];
        $this->model->app_type = $attr["app_type"];
        $this->model->open_id = $attr["open_id"];
        $this->model->app_id = $attr["app_id"];
        $this->model->union_id = $attr["union_id"];
        $this->model->nickname = $attr["nickname"];
        $this->model->avatar_url = $attr["avatar_url"];
        $this->model->gender = $attr["gender"];
        $this->model->city = $attr["city"];
        $this->model->province = $attr["province"];
        $this->model->country = $attr["country"];
        $this->model->subscribe_time = $attr["subscribe_time"];
        $this->model->subscribe_scene = $attr["subscribe_scene"];
        $this->model->created_by = $operator;
        $this->model->gmt_created = $now;
        $this->model->modified_by = $operator;
        $this->model->gmt_modified = $now;
        try {
            $this->model->saveOrFail();
        } catch (\Exception $e) {
            Log::error("微信账号新建失败,错误信息{$e->getMessage()}", $e->getTrace());
            abort(ResponseCodeEnum::SERVICE_REGISTER_ERROR);
        }
        return $this->model;
    }
}
