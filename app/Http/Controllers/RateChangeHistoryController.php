<?php

namespace App\Http\Controllers;

use App\Models\Guests;
use App\Models\RateCode;
use App\Models\Ratechange;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RateChangeHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Ratechange::all());
    }
    public function rateChangPagination()
    {
        return response()->json(Ratechange::paginate(request()->segment(count(request()->segments()))));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'hotel_date'                      => 'required|after_or_equal:.date(Y-m-d H:i:s)',
    //             'guest_id'                        => 'required|integer',
    //             'from_rate_code_id'               => 'required|integer',
    //             'to_rate_code_id'                 => 'required|integer',
    //             'from_rm_rate'                    => 'required|numeric',
    //             'to_rm_rate'                      => 'required|numeric',
    //             'room_id'                         => 'required|integer',
    //             'raeson'                          => 'string|required',
    //             'created_by'                      => 'required|integer',
    //             'meal_id'                         => 'required|integer',

    //         ]);
    //         $ratechange = new Ratechange();
    //         $ratechange->hotel_date                = $request->hotel_date;
    //         $ratechange->guest_id                  = $request->guest_id;
    //         $ratechange->from_rate_code_id         = $request->from_rate_code_id;
    //         $ratechange->to_rate_code_id           = $request->to_rate_code_id;
    //         $ratechange->from_rm_rate              = $request->from_rm_rate;
    //         $ratechange->to_rm_rate                = $request->to_rm_rate;
    //         $ratechange->room_id                   = $request->guest_id;
    //         $ratechange->raeson                    = $request->raeson;
    //         $ratechange->created_by                = $request->created_by;
    //         $ratechange->meal_id                   = $request->meal_id;

    //         $ratechange->save();

    //         return response()->json([
    //             'message'  => 'Rate-Change Created Successfully',
    //             'data'     =>   $ratechange,
    //         ], 201);
    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'message' => 'Validation Error',
    //             'errors'  => $e->errors(),
    //         ], 400);
    //     }
    // }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'hotel_date'                      => 'required|after_or_equal:.date(Y-m-d H:i:s)',
                'guest_id'                        => 'required|integer',
                'from_rate_code_id'               => 'required|integer',
                'to_rate_code_id'                 => 'required|integer',
                'from_rm_rate'                    => 'required|numeric',
                'to_rm_rate'                      => 'required|numeric',
                'room_id'                         => 'required|integer',
                'raeson'                          => 'string|required',
                'created_by'                      => 'required|integer',
                'meal_id'                         => 'required|integer',

            ]);
            $ratechange = new Ratechange();
            $ratechange->hotel_date                = $request->hotel_date;
            $ratechange->guest_id                  = $request->guest_id;
            $ratechange->from_rate_code_id         = $request->from_rate_code_id;
            $ratechange->to_rate_code_id           = $request->to_rate_code_id;
            $ratechange->from_rm_rate              = $request->from_rm_rate;
            $ratechange->to_rm_rate                = $request->to_rm_rate;
            $ratechange->room_id                   = $request->guest_id;
            $ratechange->raeson                    = $request->raeson;
            $ratechange->created_by                = $request->created_by;
            $ratechange->meal_id                   = $request->meal_id;

            $ratechange->save();
           // $ratechange= Ratechange::find($request->id);
            $guest = Guests::find($request->guest_id);
            if($guest->is_checked_in == 1){
                
        
                $guest->update([
                'rate_code_id'  => $request->to_rate_code_id,
                'meal_id'       => $request->meal_id,
                'rm_rate'       => $request->to_rm_rate
            ]);
           // dd('ss');
        }else{
            return response(["message" =>("not found")]); 
        };

            return response()->json([
                'message'  => 'Rate-Change Created Successfully',
                'data'     =>   $ratechange,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors'  => $e->errors(),
            ], 400);
        }
    }


    public function storeNew(Request $request)
    {
       // dd('ss');
        try {
            $request->validate([
                'hotel_date'                      => 'required|after_or_equal:.date(Y-m-d H:i:s)',
                'guest_id'                        => 'required|integer',
                'from_rate_code_id'               => 'required|integer',
                'to_rate_code_id'                 => 'required|integer',
                'from_rm_rate'                    => 'required|numeric',
                'to_rm_rate'                      => 'required|numeric',
                'room_id'                         => 'required|integer',
                'raeson'                          => 'string|required',
                'created_by'                      => 'required|integer',
                'meal_id'                         => 'required|integer',

            ]);
            $ratechange = new Ratechange();
            $ratechange->hotel_date                = $request->hotel_date;
            $ratechange->guest_id                  = $request->guest_id;
            $ratechange->from_rate_code_id         = $request->from_rate_code_id;
            $ratechange->to_rate_code_id           = $request->to_rate_code_id;
            $ratechange->from_rm_rate              = $request->from_rm_rate;
            $ratechange->to_rm_rate                = $request->to_rm_rate;
            $ratechange->room_id                   = $request->guest_id;
            $ratechange->raeson                    = $request->raeson;
            $ratechange->created_by                = $request->created_by;
            $ratechange->meal_id                   = $request->meal_id;

            $ratechange->save();
           
            $guest = Guests::find($request->guest_id);
           $rate = Ratechange::with('guest')->get();
            //dd($rate);

            if($guest->is_checked_in == 1){
               // $guest_update=Guests::find( $ratechange->guest_id);
                $guest->update([
                'rate_code_id'  => $request->to_rate_code_id,
                'meal_id'       => $request->meal_id,
                'rm_rate'       => $request->to_rm_rate
            ]);
        }else{
            return response(["message" =>("not found")]); 
        };

            return response()->json([
                'message'  => 'Rate-Change Created Successfully',
                'data'     =>   $ratechange,
            ], 201);
        } catch (ValidationException $e) {
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
        $ratechange=Ratechange::find($id);
        return response()->json($ratechange);

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
    // public function destroy($id)
    // {
    //     $ratechange  =Ratechange::where('id',$id)->delete();
    //     return response()->json([
    //         'status'     => true,
    //         'message'    => 'Rate-change  Deleted Successfully',
    //     ],201);
    // }
}
