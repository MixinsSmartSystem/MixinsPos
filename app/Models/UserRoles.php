<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;
    protected $table="user_roles";
    protected $fillable=['user_role_id','mixins_role','user_id'];
    public function user(){
        return $this -> hasOne('App\Models\User','id','user_id');
    }
    public function role(){
        return $this -> hasOne('App\Models\MixinsRoles','role_id','mixins_role');
    }
}
