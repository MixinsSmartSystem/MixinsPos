<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mixins extends Model
{
    use HasFactory;
    protected $table="mixins_info";
    protected  $fillable=['id','mixins_name','mixins_adress','mixins_mobile','mixins_vat_val','mixins_price_include_vat','mixins_note','main_mixins_store','closure_hour','mixins_logo','mixins_mac_serial','image_path','render_bills','render_new_bill','render_bill_reports','render_purchase_bills','render_purchase_bills_reports','render_withdraw_cash','render_cash','end_support_date','mixins_font_size','mixins_font_color','default_lang','bill_with_main_type','mixins_theme','render_en_names','bill_type','item_request_qty','mixins_main_payment_method','bill_column_num','render_bill_img','main_type_column_num','use_type_uints','render_bill_note','render_types_note','render_bill_footer_note','partition_folder','contruct_no','render_cash_point','logo_width','logo_height','type_discount','bill_discount','show_reset_btn','master_ip','master_log_file','master_log_pos','incremented','main_sill_type','active_type_offer'];
}
