<?php
/**
 * Created by PhpStorm.
 * User: wxj
 * Date: 2018/10/27
 * Time: 17:12
 */
namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}