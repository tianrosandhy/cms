<?php
namespace App\Core\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    // will return all roles data in cached format
    public function allCached()
    {
        $cache_name = config('cms.cache_key.language', 'APP-CMS-ALLLANGUAGE');
        if (Cache::has($cache_name)) {
            return Cache::get($cache_name);
        }

        $data = $this->get();
        Cache::set($cache_name, $data, 86400);
        return $data;
    }
}
