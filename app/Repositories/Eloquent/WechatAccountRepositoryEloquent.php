<?php


namespace App\Repositories\Eloquent;


use App\Contracts\Repositories\WechatAccountRepository;
use App\Repositories\Criteria\RequestCriteria;
use App\Repositories\Models\Account\WechatAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByOpenId($openId)
    {
        return $this->getModel()->newQuery()->where("open_id", $openId)->first();
    }

    /**
     * 通过unionId查找账户
     * @param $unionId
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByUnionId($unionId)
    {
        return $this->getModel()->newQuery()->where("union_id", $unionId)->first();
    }

    /**
     * 新建账号数据
     * @param array $attr 账号数据
     * @param string $opeartor 操作人
     * @throws \Throwable
     */
    public function insertAccount(array $attr, string $opeartor): Model
    {
        $this->getModel()->user_id = $attr["userId"];
        $this->getModel()->app_type = $attr["openId"];
        $this->getModel()->open_id = $attr["appType"];
        $this->getModel()->app_id = $attr["appId"];
        $this->getModel()->union_id = $attr["unionId"];
        $this->getModel()->create_by = $opeartor;
        $this->getModel()->gmt_created = date("Y-m-d H:i:s");
        $this->getModel()->modified_by = $opeartor;
        $this->getModel()->gmt_modified = date("Y-m-d H:i:s");
        $this->getModel()->saveOrFail();

        return $this->getModel();
    }
}
