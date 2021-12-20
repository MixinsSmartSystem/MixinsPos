<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MixinsMainTypes;
use Illuminate\Http\Request;
use DB;

class MainTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainTypes= MixinsMainTypes::with('products')->get();
        return  json_encode($mainTypes);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MixinsMainTypes::insert($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mainTypes = DB::table('mixins_main_types')->where('main_type_id',$id)->first();
        if(!$mainTypes)
            $mainTypes = DB::table('mixins_main_types')->where('main_type_id',$id)->first();
        if(!$mainTypes)
            $mainTypes = DB::table('mixins_main_types')->where('main_type_id',$id)->first();
        return response()->json($mainTypes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('mixins_main_types')->where('main_type_id',$id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('mixins_main_types')->where('main_type_id', $id)->first();

        DB::table('mixins_main_types')->where('main_type_id', $id)->delete();
    }
}
