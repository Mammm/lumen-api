<?php

namespace App\Repositories\Models\Account;

use App\Repositories\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class WechatAccount extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "wechat_account";

    protected $guarded = [];

    protected $hidden = [
        "app_id"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
