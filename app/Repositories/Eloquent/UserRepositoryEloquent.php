<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\UserRepository;
use App\Repositories\Criteria\RequestCriteria;
use App\Repositories\Enums\ResponseCodeEnum;
use App\Repositories\Models\User;
use App\Repositories\Validators\UserValidator;
use App\Support\Constant;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function model()
    {
        return User::class;
    }

    public function validator()
    {
        return UserValidator::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 手机号查找用户
     * @param string $telephoneNumber
     * @return Model|null
     */
    public function getByTelephoneNumber(string $telephoneNumber): ?User
    {
        return $this->model->newQuery()->where("mobile_phone", $telephoneNumber)->first();
    }

    /**
     * 新建用户数据
     * @param array $attr
     * @param string $operator
     * @return User
     * @throws Throwable
     */
    public function insertUser(array $attr, string $operator): User
    {
        $now = date("Y-m-d H:i:s");

        $this->model->out_id = $attr["out_id"];
        $this->model->nickname = $attr["nickname"];
        $this->model->gender = $attr["gender"];
        $this->model->avatar_url = $attr["avatar_url"];
        $this->model->register_time = $now;
        $this->model->mobile_phone = $attr["mobile_phone"];
        $this->model->freeze = 0;
        $this->model->referrer = $attr["referrer"];
        $this->model->gold = 0;
        $this->model->version = 1;
        $this->model->gmt_created = $now;
        $this->model->gmt_modified = $now;

        try {
            $this->model->saveOrFail();
        } catch (Exception $e) {
            Log::error("创建用户失败", $e->getTrace());
            abort(ResponseCodeEnum::SYSTEM_ERROR, "创建用户失败");
        }

        return $this->model;
    }
}
