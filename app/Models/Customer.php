<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="customers";
    protected $fillable=['cust_id','cust_name','cust_mobile','cust_address','cust_balance','cust_discount_val','cust_discount_percent','active_customer','pay_method','max_balance','customers_no'];
public $timestamps=false;
    public function bills(){
        return $this -> hasMany('App\Models\Bill','bill_no','cust_id')->with(['billType','user','payMethods','returns']);
    }
    public function cashs(){
        return $this -> hasMany('App\Models\CustomerPay','cust_id','cust_id')->with(['user','payMethods']);
    }
}
