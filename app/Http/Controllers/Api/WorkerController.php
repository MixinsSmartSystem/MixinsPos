<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $workers = User::where('is_user', 0)->paginate(10);
        return json_encode($workers);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['is_user'] = 0;
        $data['mobile'] = $request->mobile;
        $data['hour_price'] = $request->hour_price;
        $data['work_hour_count'] = $request->work_hour_count;
        $data['jop_title'] = $request->jop_title;
        $data['salary'] = $request->salary;
        DB::table('users')->insert($data);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user)
            $user = DB::table('users')->where('name', $id)->first();
        if (!$user)
            $user = DB::table('users')->where('mobile', $id)->first();
        return response()->json($user);
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
        DB::table('users')->where('id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->first();

        DB::table('users')->where('id', $id)->delete();
    }
}
