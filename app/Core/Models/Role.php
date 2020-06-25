<?php
namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

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
}
