<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixinsMainTypes extends Model
{
    use HasFactory;
    protected $table='mixins_main_types';
    protected  $fillable=['main_type_id','main_type_title_ar','main_type_title_en','mixins_main_types_no'];
    public $timestamps=false;
    public function products(){
        return $this -> hasMany('App\Models\Type','main_type','main_type_id')->with('units','typeStock');
    }
}
