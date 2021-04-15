<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Support\Traits;

trait Helpers
{
    public function newTmpPath(string $ext)
    {
        $day = date('Ymd');
        $path = public_path("uploads/{$day}");

        if (!is_dir($path) && !mkdir($path))
            throw new \Exception('add image path');

        return $path.DIRECTORY_SEPARATOR.date('His').mt_rand(100, 999).'.'.$ext;
    }
}
