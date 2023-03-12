<?php

namespace App\Http\Controllers\Api\v1\Profiles\GuestProfile;

use App\helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralCollection;
use App\Http\Requests\AvailabilityRequest;
use App\Http\Requests\GuestInhouseRequest;
use App\Http\Resources\GuestInhouseResource;
use App\Repositoryinterface\Profiles\GuestProfile\RepositoryGuestInhouseInterface;

class ReservationController extends Controller
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
    public function reservationPagination()
    {
        $guestInhouse = $this->guestInhouseInterface->reservationPagination();
        if($guestInhouse->first()){
            return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);

        }else
        return $this->apiResponse(["message" => __("not found")],404); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuestInhouseRequest $request)
    {
        $request->is_reservation = 1;
        $guestInhouse = $this->guestInhouseInterface->store($request);
        return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),201);
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
            return $this->apiResponse(['data' =>collect(new GuestInhouseResource($guestInhouse))],200);
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
        $request->is_reservation = 1;

        $guestInhouse = $this->guestInhouseInterface->update($request,$id);
        if($guestInhouse){
            
            return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);
        }else{
            return $this->apiResponse(["message" => __("not found")],404);
        }

    }

    public function checkIn($id)
    {
        $request =['is_reservation' => false,'res_status' => 'CHK','is_checked_in' => true];       
        $guestInhouse = $this->guestInhouseInterface->update($request,$id);
        $guestInhouse = $this->guestInhouseInterface->reservisionUpdate($request,$id);
        $guestInhouse = $this->guestInhouseInterface->isCheckedIn($request,$id);
        if($guestInhouse){
            
            return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);
        }else{
            return $this->apiResponse(["message" => __("not found")],404);
        }

    } 
    public function cancel($id)
    {
        $guestInhouse = $this->guestInhouseInterface->isCancel($id);
        if($guestInhouse){
            
            return $this->apiResponse(new GeneralCollection($guestInhouse,GuestInhouseResource::class),200);
        }else{
            return $this->apiResponse(["message" => __("not found")],404);
        }

    } 
    public function reInstate($id)
    {
        $guestInhouse = $this->guestInhouseInterface->reInstate($id);
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

     public function availability(AvailabilityRequest $request)
     {
        $avelableGuestreservition = $this->guestInhouseInterface->availability($request);
 
        return $this->apiResponse(['data' =>[$avelableGuestreservition]],200);
 
     }
    public function destroy($id)
    {
        //
    }
}
