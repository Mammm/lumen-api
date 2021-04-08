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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class UserRepositoryEloquent.
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'email', // Default Condition "="
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
        return UserValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 新建用户数据
     * @param array $attr
     * @param string $operator
     * @return Model
     * @throws \Throwable
     */
    public function insertUser(array $attr, string $operator): Model
    {
        $this->model->nickname = $attr["nickname"];
        $this->model->gender = $attr["gender"];
        $this->model->avatar_url = $attr["avatarUrl"];
        $this->model->register_time = date("Y-m-d H:i:s");
        $this->model->created_by = $operator;
        $this->model->gmt_created = date("Y-m-d H:i:s");
        $this->model->modified_by = $operator;
        $this->model->gmt_modified = date("Y-m-d H:i:s");

        try {
            $this->model->saveOrFail();
        } catch (\Exception $e) {
            Log::error("创建用户失败", $e->getTrace());
            abort(ResponseCodeEnum::SYSTEM_ERROR, "创建用户失败");
        }

        return $this->model;
    }
}
