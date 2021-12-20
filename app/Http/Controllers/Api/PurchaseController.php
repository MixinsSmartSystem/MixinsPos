<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MixinsPurchaseBills;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\Array_;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bills=MixinsPurchaseBills::with('billType','supplier','user')->get();
        return json_encode($bills);
    }

    public function purchasesBillReport( $period,$from,$to)
    {
        if ($period)
            if ($period == "daily") {
                $bills = MixinsPurchaseBills::with(['billType','user','supplier','payMethods'])

                    ->whereDate('bill_date', Carbon::today())->get();
            } else if ($period == "monthly") {
                $bills = MixinsPurchaseBills::with(['billType','user','supplier','payMethods'])

                    ->whereMonth('bill_date', date('m'))->get();

            } else {
                if ($from &&$to)
                    $bills = MixinsPurchaseBills::with(['billType','user','supplier','payMethods'])
                        ->whereDate('bill_date', '<=', $to)
                        ->whereDate('bill_date', '>=', $from)->get();
            }
        return response()->json($bills);


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
//        Main Bill Data
        $bill = array();
        $bill['bill_sum'] = $request->sum;
        $bill['bill_vat_val'] = $request->vat ?? 0.0;
        $bill['bill_discount'] = $request->descount ?? 0.0;
        $bill['bill_total'] = $request->total;
        $bill['bill_remain_val'] = $request->remain ?? 0.0;
        $bill['bill_paid_val'] = $request->paid ?? 0.0;
        $bill['bill_notes'] = $request->note;
        $bill['user_id'] = $request->user_id;
        $bill['bill_paid_type'] = $request->pay;
        $bill['bill_date'] = Carbon::now()->toDateTimeString();
        $bill['supplier_name'] = $request->supplier['supplier_id'];
        $bill_no = DB::table('mixins_purchase_bills')->insertGetId($bill);

        //Insert Cart Data
        $contents = $request->cart;
        $billdetails = array();
        foreach ($contents as $content) {
            $billdetails['purchase_bills'] = $bill_no;
            $billdetails['type_id'] = $content['type_id'];
            $billdetails['type_count'] = $content['type_count'];
            $billdetails['type_purchase_price'] = $content['type_price'];
            $billdetails['type_sill_price'] = $content['type_sill_price'];
            $billdetails['total_purchase_price'] = $content['total_purchase_price'];
//           Update Type Stock
            DB::table('purchase_bill_types')->insert($billdetails);
            $type=DB::table('mixins_type_stock')
                ->where('type_stock_id',$content['type_id'])->first();
            if($type) {

                if($content['calc_count']){
                    DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => $content['calc_count']]);

                }else{
                    DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['type_count'])]);

                }
            }else {
//                insert Type If not Has Stock
                $type = array();
                $type['type_stock_id'] = $content['type_id'];
                $type['mixins_type_stock'] = $content['calc_count'];
                DB::table('mixins_type_stock')->insert($type);
            }
//            Delete Type From Item Request
            $typeStock = DB::table('mixins_item_request')->where('type_request', $content['type_id'])->first();
            if ($typeStock) {
                DB::table('mixins_item_request')->where('type_request', $content['type_id'])->delete();

            }
        }

//        Calc Supplier Info
        DB::table('mixins_suppliers')
            ->where('supplier_id',$request->supplier['supplier_id'])
            ->update(['supplier_total_paid' => DB::raw('supplier_total_paid +' . $request->paid)]);
        DB::table('mixins_suppliers')
            ->where('supplier_id',$request->supplier['supplier_id'])
            ->update(['supplier_total_withdrawals' => DB::raw('supplier_total_withdrawals +' . $request->total)]);
        DB::table('mixins_suppliers')
            ->where('supplier_id',$request->supplier['supplier_id']) ->update(['supplier_total_remain' => DB::raw('supplier_total_remain +' . $request->remain)]);
//        End Calc Supplier

        return response($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $bill=MixinsPurchaseBills::with('billType')->where('purchase_bill_no', $id)->first();
        return response()->json($bill);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
