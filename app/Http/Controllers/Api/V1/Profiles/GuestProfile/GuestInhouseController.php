<?php

namespace App\Http\Controllers\Api\V1\Profiles\GuestProfile;

use App\helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralCollection;
use App\Http\Requests\GuestInhouseRequest;
use App\Http\Resources\GuestInhouseResource;
use App\Models\Guests;
use App\Repositoryinterface\Profiles\GuestProfile\RepositoryWindowInterface;
use App\Repositoryinterface\Profiles\GuestProfile\RepositoryGuestInhouseInterface;

class GuestInhouseController extends Controller
{
    use helpers;

    private $guestInhouseInterface; 

    public function __construct(RepositoryGuestInhouseInterface $guestInhouseInterface)
    {
        $this->guestInhouseInterface =$guestInhouseInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestInhouse = $this->guestInhouseInterface->index();
        if($guestInhouse->first()){
            return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);

        }else
        return $this->apiResponse(["message" => __("not found")],404);   
    }
    public function inhousPagination()
    {
        $guestInhouse = $this->guestInhouseInterface->inhousPagination();
        if($guestInhouse->first()){
            return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);

        }else
        return $this->apiResponse(["message" => __("not found")],404);   
    }

    public function GuestsFilter(Request $request){
       
     
       $Result=  Guests::with('profile')->where(function ($q) use ($request)
       {
        if ($request->has('InDate'))
        {
            $q->whereDate('in_date','>=', $request->input('start_date') )
                          ->whereDate('in_date','<=', $request->input('end_date'));
        }
        if ($request->has('OutDate')){
            $q->whereDate('out_date','>=', $request->input('start_date'))
            ->whereDate('out_date','<=', $request->input('end_date'));
        }
        if ($request->has('company_id')){
            $q->where('company_id', 'LIKE', $request->input('company_id') . '%');
        }
        if ($request->has('rate_code_id')){
            $q->where('rate_code_id', 'LIKE', $request->input('rate_code_id') . '%'); 
        }
        if ($request->has('is_reservation')){
            $q->where('is_reservation', 'LIKE', $request->input('is_reservation') . '%');
        }
        if ($request->has('checked_out')){
            $q->where('checked_out', 'LIKE', $request->input('checked_out') . '%');   
        }
        if ($request->has('market_segment_id')){
            $q->where('market_segment_id', 'LIKE', $request->input('market_segment_id') . '%');
        }
        if ($request->has('source_of_business_id')){
            $q->where('source_of_business_id', 'LIKE', $request->input('source_of_business_id') . '%');
                        
        }
        if ($request->has('room_type_id') ){
            $q->where('room_type_id', 'LIKE', $request->input('room_type_id') . '%');
        }
        if ($request->has('res_no')){
            $q->where('res_no', 'LIKE', $request->input('res_no') . '%');
        }
        if ($request->has('guest_name'))
        {
           $q->whereHas('profile',function ($q) use ($request)
            {
                 $q->where('first_name', 'LIKE', '%' . $request->input('guest_name') . '%')
                         ->orWhere('last_name', 'LIKE', '%' . $request->input('guest_name') . '%');
            });
        }

     }) ->get();
     
     return $Result;
    }
   
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuestInhouseRequest $request)
    {
        $guestInhouse = $this->guestInhouseInterface->store($request);

        return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guestInhouse = $this->guestInhouseInterface->show($id);
       
        if($guestInhouse){
            return $this->apiResponse(['data' =>collect(new GuestInhouseResource($guestInhouse)),200]);
        }else{
            return $this->apiResponse(["message" => __("not found")],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuestInhouseRequest $request, $id)
    {
        $guestInhouse = $this->guestInhouseInterface->update($request,$id);
        if($guestInhouse){
            
            return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);
        }else{
            return $this->apiResponse(["message" => __("not found")],404);
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
