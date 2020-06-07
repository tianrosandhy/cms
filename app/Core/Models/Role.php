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
}
