<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\CustomerCash;
use Illuminate\Http\Request;
use DB;

class CustomerPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customersCash= CustomerPay::width('payMethods')->paginate(10);
        return  json_encode($customersCash);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pays = array();
        $pays['is_pay'] = $request->is_pay;
        $pays['paid_value'] = $request->pay;
        $pays['pay_method'] = $request->pay_method;
        $pays['user_id'] = $request->user_id;
        $pays['paid_date'] = now();
        $pays['cust_id'] = $request->customer['cust_id'];
        $cust = DB::table('customers')->where('cust_id', $request->customer['cust_id'])->first();;
        $pays['cust_balance_before'] = $cust->cust_balance;
        $customer = DB::table('customers')
            ->where('cust_id', $request->customer['cust_id']);
        if ($pays['is_pay']) {
            $customer->update(['cust_balance' => DB::raw('cust_balance -' . $request->pay)]);
            $pays['note']="توريد نقدية";
        }else{
            $customer->update(['cust_balance' => DB::raw('cust_balance +' . $request->pay)]);
            $pays['note']="صرف نقدية";
        }
        $cust = DB::table('customers')->where('cust_id', $request->customer['cust_id'])->first();
        $pays['cust_after_after'] = $cust->cust_balance;

        $pays_no = DB::table('customer_pay')->insert($pays);
        return response($pays_no);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
