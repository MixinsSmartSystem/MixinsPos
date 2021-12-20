<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        //
        $users = User::where('is_user', 1)->paginate(10);
        return json_encode($users);
    }

    public function roles($id) {

        $user = User::with(["roles"])->where("id", $id)->first();
        return ["user" => $user];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(UersRequest $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['is_admin'] = $request->is_admin;
        $data['is_user'] = 1;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
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
    public function update(UersRequest $request, $id)
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
