<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\CustomerPay;
use App\Models\MixinsItemRequest;
use App\Models\MixinsMainTypes;
use App\Models\Offer;
use App\Models\Type;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;

class ActionController extends Controller
{
    public function getAllCategories()
    {
        $mainTypes = MixinsMainTypes::with('products')->get();
        return json_encode($mainTypes);
    }
    public function findCustomers()
    {
        $customers= Customer::get()->all();
        return  response()->json($customers);
    }
    public function addToSoldWithoutStock($id, $count)
    {
        $typeStock = DB::table('types_sold_without_balance')->where('type_id', $id);
        if ($typeStock) {
            $typeStock->update(['qty' => DB::raw('qty +' . $count)]);
        } else {
            $typeStock = array();
            $typeStock['type_id'] = $id;
            $typeStock['qty'] = $count;
            DB::table('types_sold_without_balance')->insert($typeStock);
        }

    }

    public function checkIfTypeAddedToItemRequestToday($id)
    {

        $typeStock = DB::table('mixins_item_request')->where('type_request', $id)->whereDate('added_request_date', Carbon::today())->first();
        if ($typeStock)
            return response()->json(true);
        return response()->json(false);


    }

    public function addToExitStock($id)
    {
        $typeStock = DB::table('mixins_item_request')->where('type_request', $id)->first();
        if ($typeStock) {
            DB::table('mixins_item_request')->where('type_request', $id)->update(['added_request_date' => now()]);
        } else {
            $typeStock = array();
            $typeStock['type_request'] = $id;
            $typeStock['added_request_date'] = now();
            DB::table('mixins_item_request')->insert($typeStock);
        }

    }

    public function findTypeByCodeOrId($id)
    {
        $type =Type::where('type_id', $id)->with('units','typeStock')->first();
        if (!$type)
            $type =Type::where('type_code', $id)->with('units','typeStock')->first();

        return response()->json($type);
    }
    public function findTypeByLike($name)
    {
        $type =Type::with('units','typeStock')->where('type_name_ar','like', $name.'%')->limit(50)->get()->all();
        if (!$type)
            $type =Type::with('units','typeStock')->where('type_name_en','like','%'. $name.'%')->limit(50)->get()->all();

        return response()->json($type);
    }

    public function supplierPay($id, $pay)
    {
        DB::table('mixins_suppliers')
            ->where('supplier_id', $id)
            ->update(['supplier_total_paid' => DB::raw('supplier_total_paid +' . $pay)]);
        DB::table('mixins_suppliers')
            ->where('supplier_id', $id)->update(['supplier_total_remain' => DB::raw('supplier_total_remain -' . $pay)]);

    }

    public function allRequests($from, $to, $status)
    {

        if ($from && $to)
            $requetsts = MixinsItemRequest::with(['type'=>function($q){
                $q->select('type_id','type_name_ar');

    }])->where('add_to_request', $status)->whereDate('added_request_date', '<=', $to)
                ->whereDate('added_request_date', '>=', $from)->get();

        return response()->json($requetsts);


    }
    function PaidDetails($type){
        $customersCash= CustomerPay::with(['customer'=>function($q){
            $q->select('cust_id','cust_name');
        },'user'=>function($q){
            $q->select('id','name');
        },'payMethods'])->where('is_pay',$type)->whereDate('paid_date', Carbon::today())->get();
        return  json_encode($customersCash);

    }

    public function getOfferType($id)
    {
        $offers = Offer::with(['mainOfferType','offerType'])->where('main_type',$id)->get()->all();

        return  json_encode($offers);
    }
    public function findBillById($id)
    {
        $bill = Bill::with(['billType', 'customer', 'user', 'payMethods','returns'])->where('bill_no', $id)->get()->all();
        return response()->json($bill);
    }
    public function  findBillWithTypeId($id){
        $type =Type::with('billType')->where('type_barcode', $id)->first();
        return response()->json($type);
}
}
