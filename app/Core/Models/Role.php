<?php
namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Role extends Model
{
    //
    protected $fillable = [
    	'name',
        'role_owner',
        'is_sa',
    	'priviledge_list'
    ];

    public function owner(){
    	return $this->belongsTo('App\Core\Models\Role', 'role_owner');
    }
    
    public function children(){
    	return $this->hasMany('App\Core\Models\Role', 'role_owner');
    }
    
    public function getByName($role_name=''){
        return $this->where('name', $role_name)->first();
    }

    public function getPermissionList(){
        $data = json_decode($this->priviledge_list, true);
        if($data){
            return $data;
        }
        return [];
    }

    public function getPermissionListCount(){
        return count($this->getPermissionList());
    }

    public function owners(){
        $out = [];
        if($this->owner){
            $out = $this->recOwner($this->owner);
        }
        return $out;
    }

    protected function recOwner($instance, $arr=[]){
        if(!in_array($instance->id, $arr)){
            $arr[] = $instance->id;
        }
        if($instance->owner){
            return $this->recOwner($instance->owner, $arr);
        }
        return $arr;
    }

    // will return all roles data in cached format
    public function allCached(){
        $cache_name = config('cms.cache_key.role', 'APP-CMS-ALLROLE');
        if(Cache::has($cache_name)){
            return Cache::get($cache_name);
        }

        $data = $this->with('owner', 'children')->get();
        Cache::set($cache_name, $data, 86400);
        return $data;
    }
}
