<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;
    protected $table="returns";
    protected $fillable=['return_id','bill_no','vat','sum','total'];
    public function returnTypes(){
        return $this -> hasMany('App\Models\ReturnTypes','return_id','return_id')->with('type');
    }

}
