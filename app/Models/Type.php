<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['type_id', 'type_name_ar',
        'type_name_en',
        'type_icon',
        'type_location',
        'type_purchases_pre',
        'type_count',
        'type_has_vat',
        'type_vat_value',
        'type_vat_percent',
        'type_note',
        'type_sill_price',
        'type_discount_value',
        'type_discount_percent',
        'total_type_cost',
        'type_barcode',
        'type_exp_date',
        'sell_unit',

        'is_deleted',
        'minimum_sill_price',
        'type_code',
        'prevent_use',
        'main_type',
        'types_no',
        'sill_without_stock',
        'has_offer',
        'type_return_count',
        'calc_count'];
    public $timestamps=false;
    public function typeStock(){
        return $this -> hasOne('App\Models\MixinsTypeStock','type_stock_id','type_id');
    }
    public function units(){
        return $this -> hasMany('App\Models\TypeUnits','type_id','type_id')->with('unit');
    }
    public function billType(){
        return $this -> hasMany('App\Models\BillTypes','type_id','type_id')->with(['bill']);
    }
}
