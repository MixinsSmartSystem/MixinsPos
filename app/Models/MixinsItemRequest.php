<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixinsItemRequest extends Model
{
    use HasFactory;
    protected $table="mixins_item_request";
    protected $fillable=['mixins_item_request_id','add_to_request','type_request','added_request_date'];
    public function type(){
        return $this -> hasOne('App\Models\Type','type_id','type_request');
    }
}
