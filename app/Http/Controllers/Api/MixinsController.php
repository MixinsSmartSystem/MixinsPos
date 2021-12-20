<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ImagesTrait;
use Illuminate\Http\Request;
use DB;

class MixinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;
    public function index()
    {
        $mixins= DB::table('mixins_info')->limit(5)->get();
        return  json_encode($mixins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $mixins= DB::table('mixins_info')->where('id',$id)->first();
        return  json_encode($mixins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $mixins=array();
        $mixins['contruct_no']= $request->contruct_no;

                $mixins['bill_type']= $request->bill_type;
                $mixins['item_request_qty']= $request->item_request_qty;
                $mixins['logo_height']= $request->logo_height;
                $mixins['logo_width']= $request->logo_width;
                $mixins['mixins_adress']= $request->mixins_adress;
                $mixins['mixins_mobile']= $request->mixins_mobile;
                $mixins['mixins_name']= $request->mixins_name;
                $mixins['mixins_note']= $request->mixins_note;
                $mixins['mixins_price_include_vat']= $request->mixins_price_include_vat;
                if( $request->mixins_new_logo){
                    $mixins_logo=$this->UploadImage($request->mixins_new_logo, 'backend/mixins/');
                    $mixins['mixins_logo']=$mixins_logo;
                    DB::table('mixins_info')->where('id', $id)->update($mixins);
                }else{
                   DB::table('mixins_info')->where('id', $id)->update($request->all());

                }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
