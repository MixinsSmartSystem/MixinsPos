<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table="bills";
    protected  $fillable=['bill_no','cust_id','bill_sum','bill_discount','bill_total','bill_date','bill_is_paid','bill_extra','bill_remain_val','bill_paid_val','delete_date','bill_notes','is_deleted','user_id','bill_vat_val','bill_paid_type','cust_balance_after','cust_balance_before','mixins_store','hold_bill','total_returned','all_returned_val','bill_discount_percent','bill_sill_type','bill_id','table_id'];
    public $timestamps=false;
    public function billType(){
        return $this -> hasMany('App\Models\BillTypes','bill_no','bill_no')->with(['type','units']);
    }
    public function user(){
        return $this -> hasOne('App\Models\User','id','user_id');
    }
    public function customer(){
        return $this -> hasOne('App\Models\Customer','cust_id','cust_id');
    }
    public function payMethods(){
        return $this -> hasOne('App\Models\PayMethods','id','bill_paid_type');
    }
    public function returns(){
        return $this -> hasMany('App\Models\Returns','bill_no','bill_no')->with('returnTypes');
    }
}
