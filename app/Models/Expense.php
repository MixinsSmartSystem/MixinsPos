<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable=['id','expense_title','expense_cost','expense_icon','expense_date','user_id'];
    public function user(){
        return $this -> hasOne('App\Models\User','id','user_id');
    }
}
