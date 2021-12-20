<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillTypes extends Model
{
    use HasFactory;
    protected $table ='bill_types';
    protected $fillable=['bill_type_id','bill_no','type_id','type_name',
        'type_count','type_price','type_total_price','type_discount','type_vat',
        'type_exp_date','sell_unit','returned','returned_qty','type_cost','type_note',
        'type_discount_perecent','returned_total','without_stock','calc_count'];
    public $timestamps=false;
    public function bill(){
        return $this -> belongsTo('App\Models\Bill','bill_no','bill_no')->with('payMethods','billType');
    }
    public function type(){
        return $this -> hasOne('App\Models\Type','type_id','type_id')->with('typeStock');
    }
    public function units(){
        return $this -> hasOne('App\Models\TypeUnits','type_unit_id','sell_unit')->with('unit');
    }
}
