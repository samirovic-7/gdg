<?php

namespace App\Http\Controllers;

use App\Models\Guests;
use App\Models\ExtendStay;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExtendStayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ExtendStay::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd('ss');
      
         try{

            $request->validate([
                'guest_id'                     =>'required|string|max:254',
                'out_date_from'                =>'required|after_or_equal:.date(Y-m-d H:i:s)',
                'out_date_to'                  =>'required|after_or_equal:.date(Y-m-d H:i:s)',
                'done_by'                      =>'required|string|max:254',

            ]);
           // dd($request);

        $Extend_Stay= new ExtendStay();
       
           // $saveExtend=
        $Extend_Stay->guest_id                 =$request->guest_id;
        $Extend_Stay->out_date_from            =$request->out_date_from;
        $Extend_Stay->out_date_to              =$request->out_date_to;
        $Extend_Stay->done_by                  =$request->done_by;

       $Extend_Stay->save();

       $guest = Guests::find($request->guest_id);
      // dd($guest);
       if($guest->checked_out == 0){

          $guest->update([

            'out_date'  => $request->out_date_to,
        ]);
       // return response(["message" =>("The operation was completed successfully")]);

       }else{

        return response(["message" =>("not found")]); 
       };



       
       return response()->json([
        'message'  => 'Extend_Stay Created Successfully',
        'data'     => $Extend_Stay,
    ], 201);

       }catch(ValidationException $e) {
    return response()->json([
        'message' => 'Validation Error',
        'errors'  => $e->errors(),
    ], 400);
    
    }
        
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
        //
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
