<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Traits\ImagesTrait;
use DB;
use Illuminate\Support\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;

    public function index()
    {
        $expenses = Expense::get()->all();
        return json_encode($expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();
        if ($request->expense_icon) {
            $image_url = $this->UploadImage($request->expense_icon, 'backend/expense/');
        }else{
            $image_url= 'backend/expense/product.png';
        }
        $data['expense_title'] = $request->expense_title;
        $data['expense_cost'] = $request->expense_cost;
        $data['expense_date'] =$request->expense_date;;
        $data['expense_icon'] = $image_url ;
         DB::table('expenses')->insert($data);



    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense =Expense::where('id', $id)->first();
        return response()->json($expense);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        if ($request->newphoto) {
            $image_url = $this->UploadImage($request->newphoto, 'backend/expense/');
        }else{
            $image_url= 'backend/expense/product.png';
        }
        $data['expense_title'] = $request->expense_title;
        $data['expense_cost'] = $request->expense_cost;

        $data['expense_icon'] = $image_url ;

        $data = DB::table('expenses')->where('id', $id)->update($data);

    }
    public function expensesReport($period, $from, $to)
    {
        if ($period)
            if ($period == "daily") {
                $expenses = Expense::with([ 'user' => function ($q) {
                    $q->select('id', 'name');
                }])
                    ->whereDate('expense_date', Carbon::today())->get();
            } else if ($period == "monthly") {
                $expenses = Expense::with([ 'user' => function ($q) {
                    $q->select('id', 'name');
                }])
                    ->whereMonth('expense_date', date('m'))->get();

            } else {
                if ($from && $to)
                    $expenses = Expense::with(['user' => function ($q) {
                        $q->select('id', 'name');
                    }])
                        ->whereDate('expense_date', '<=', $to)
                        ->whereDate('expense_date', '>=', $from)->get();
            }
        return response()->json($expenses);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = DB::table('expenses')->where('id', $id)->first();
        $icon = $expense->expense_icon;
        if ($icon) {
            unlink($icon);
            DB::table('expenses')->where('id', $id)->delete();
        } else {
            DB::table('expenses')->where('id', $id)->delete();
        }
    }
}
