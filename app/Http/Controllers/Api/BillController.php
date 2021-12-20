<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BillTypes;
use App\Models\Bill;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bills = Bill::with('billType', 'customer', 'user', 'payMethods')->get();
        return json_encode($bills);
    }

    public function billsReport($period, $from, $to)
    {
        if ($period)
            if ($period == "daily") {
                $bills = Bill::with(['billType', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods', 'returns'])
                    ->whereDate('bill_date', Carbon::today())->get();
            } else if ($period == "monthly") {
                $bills = Bill::with(['billType', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods', 'returns'])
                    ->whereMonth('bill_date', date('m'))->get();

            } else {
                if ($from && $to)
                    $bills = Bill::with(['billType', 'user' => function ($q) {
                        $q->select('id', 'name');
                    }, 'customer' => function ($q) {
                        $q->select('cust_id', 'cust_name');
                    }, 'payMethods', 'returns'])
                        ->whereDate('bill_date', '<=', $to)
                        ->whereDate('bill_date', '>=', $from)->get();
            }
        return response()->json($bills);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
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
        $bill['bill_date'] = now();
        $bill['cust_id'] = $request->customer['cust_id'] ?? null;
        $bill_no = DB::table('bills')->insertGetId($bill);
        if ($bill['cust_id'] != null) {
            $cust = DB::table('customers')->where('cust_id', $bill['cust_id'])->first();;
            $pays = array();
            $pays['cust_balance_before'] = $cust->cust_balance;
            $pays['is_pay'] = 1;
            $pays['paid_value'] = $request->paid;
            $pays['pay_method'] = 1;
            $pays['user_id'] = $request->user_id;
            $pays['paid_date'] = now();
            $pays['cust_id'] = $request->customer['cust_id'];
            $customer = DB::table('customers')->where('cust_id', $bill['cust_id']);
            $customer->update(['cust_balance' => DB::raw('cust_balance +' . $request->remain)]);
            $cust = DB::table('customers')->where('cust_id', $bill['cust_id'])->first();
            $pays['cust_after_after'] = $cust->cust_balance;
            $pays['note'] = 'فاتورة رقم ' . $bill_no;
            DB::table('customer_pay')->insert($pays);

        }
        $contents = $request->cart;
        $billdetails = array();
        foreach ($contents as $content) {
            $billdetails['bill_no'] = $bill_no;
            $billdetails['type_id'] = $content['type_id'];
            $billdetails['type_count'] = $content['type_count'];
            $billdetails['sell_unit'] = $content['sell_unit'];
            $billdetails['type_price'] = $content['type_sill_price'];
            $billdetails['type_total_price'] = $content['total_type_cost'];
            $billdetails['type_note'] = $content['type_note'];
            DB::table('bill_types')->insert($billdetails);
            $type = DB::table('mixins_type_stock')
                ->where('type_stock_id', $content['type_id'])->first();
            if ($type) {

                if($content['calc_count']){
                    DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => $content['calc_count']]);

                }else{
                    DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock -' . $content['type_count'])]);

                }

                $type = DB::table('mixins_type_stock')
                    ->where('type_stock_id', $content['type_id'])->first();
                if ($type->mixins_type_stock <= 0) {
                    DB::table('mixins_type_stock')->where('mixins_type_stock_id', $type->mixins_type_stock_id)->delete();
                }
            } else {
                $typeStock = DB::table('types_sold_without_balance')->where('type_id', $content['type_id'])->first();
                if ($typeStock) {
                    DB::table('types_sold_without_balance')->where('type_id', $content['type_id'])->
                    update(['qty' => DB::raw('qty +' . $content['type_count'])]);
                } else {
                    $typeStock = array();
                    $typeStock['type_id'] = $content['type_id'];
                    $typeStock['qty'] = $content['type_count'];
                    DB::table('types_sold_without_balance')->insert($typeStock);
                }

            }

        }
        shell_exec('php artisan database:backup');

        return response($bill_no);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $bill = Bill::with(['billType', 'customer', 'user', 'payMethods', 'returns'])->where('bill_no', $id)->first();
        return response()->json($bill);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        $currentBill = Bill::with(['billType', 'customer', 'user', 'payMethods', 'returns'])->where('bill_no', $id)->first();

        $bill = array();
        $bill['bill_sum'] = $currentBill->bill_sum - $request->sum;
        $bill['bill_vat_val'] = $currentBill->bill_vat_val - $request->vat ?? 0.0;
        $bill['bill_total'] = $currentBill->bill_total - $request->total;
        $updated_bill = DB::table('bills')->where('bill_no', $id)->update($bill);

        $returns = array();
        $returns['sum'] = $request->sum;

        $returns['vat'] = $request->vat ?? 0.0;
        $returns['total'] = $request->total;
        $returns['bill_no'] = $id;
        $return_no = DB::table('returns')->insertGetId($returns);
        $contents = $request->cart;
        $billdetails = array();
        foreach ($contents as $content) {
            if ($content['returned_qty'] > 0 &&($content['type_count'] - $content['returned_qty']) >0 )  {
                $billdetails['return_id'] = $return_no;
                $billdetails['type_id'] = $content['type_id'];
                $billdetails['returned_qty'] = $content['returned_qty'];
                $billdetails['type_cost'] = $content['type_cost'];
                $billdetails['returned_total'] = $content['returned_total'];
                $billdetails['type_total_price'] = $content['type_price'] * $content['returned_qty'];
                $billdetails['type_count'] = $content['returned_qty'];
                if($billdetails['type_count']!=$content['type_count']){
                    DB::table('return_types')->insert($billdetails);
                }
                $type = DB::table('mixins_type_stock')
                    ->where('type_stock_id', $content['type_id'])->first();
                if ($type) {
                    if($content['calc_count']){
                        DB::table('mixins_type_stock')
                            ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => $content['calc_count']]);
                    }else{
                        DB::table('mixins_type_stock')
                            ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['returned_qty'])]);

                    }
                    $type = DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->first();

                }else{
//                insert Type If not Has Stock
                    $type = array();
                    $type['type_stock_id'] = $content['type_id'];
                    $type['mixins_type_stock'] = $content['type_count'];
                    DB::table('mixins_type_stock')->insert($type);
                }
            }else {
                $type = DB::table('mixins_type_stock')
                    ->where('type_stock_id', $content['type_id'])->first();
                if ($type) {
                    if ($content['calc_count']) {
                        DB::table('mixins_type_stock')
                            ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => $content['calc_count']]);
                    } else {
                        DB::table('mixins_type_stock')
                            ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['returned_qty'])]);

                    }
                }
            }
        }
        $prevTypes = $request->prevtype;
        $billPrevTypes = array();
        foreach ($prevTypes as $content) {
            if ($content['returned_qty'] > 0){
                $billPrevTypes['type_count'] = $content['type_count'] - $content['returned_qty'];
            $billPrevTypes['type_total_price'] = $content['type_price'] * $billPrevTypes['type_count'];
            if ($billPrevTypes['type_count'] != 0) {
                DB::table('bill_types')->where('bill_type_id', $content['bill_type_id'])->update($billPrevTypes);
            } else {
                $billPrevTypes['returned'] = 1;
                $billPrevTypes['type_count'] = $content['returned_qty'];
                $billPrevTypes['returned_qty'] = $content['returned_qty'];
                $billPrevTypes['returned_total'] = $content['type_price'] * $billPrevTypes['returned_qty'];;
                $billPrevTypes['type_total_price'] = $content['type_price'] * $billPrevTypes['returned_qty'];
                DB::table('bill_types')->where('bill_type_id', $content['bill_type_id'])->update($billPrevTypes);

            }
        }
        }
        return response($currentBill);
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
