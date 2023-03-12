<?php
namespace App\Repository\profiles\guestProfile;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Guests;
use App\Models\RoomType;
use App\Models\OordService;
use App\Models\guest_profile;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GuestProfileRequest;
use App\Repositoryinterface\Profiles\GuestProfile\RepositoryGuestInhouseInterface;

class DBrepositoryGuestInhouse implements RepositoryGuestInhouseInterface {
    private $guestInhouseModel; 
    private $roomModel; 
    private $roomTypeModel; 
    private $OordServices; 
    public function __construct(Guests $guestInhouseModel,Room $roomModel,RoomType $roomTypeModel, OordService $OordServices)
    {
        $this->guestInhouseModel = $guestInhouseModel;
        $this->roomModel = $roomModel;
        $this->roomTypeModel = $roomTypeModel;
        $this->OordServices = $OordServices;
    }

public function index()
{
    $guestInhouse = $this->guestInhouseModel->with(
        'profile',
     //   'company',
        'room',
        'roomTybe',
        'rateCode',
        'marketSegment',
        'sourceBusiness',
        'meal',
        'createdBy',
        )->get();
    return $guestInhouse;
}
public function inhousPagination()
{
    $guestInhouse = $this->guestInhouseModel->with(
        'profile',
     //   'company',
        'room',
        'roomTybe',
        'rateCode',
        'marketSegment',
        'sourceBusiness',
        'meal',
        'createdBy',
        )->paginate(request()->segment(count(request()->segments())));
    return $guestInhouse;
}
public function store($request)
{
    $this->guestInhouseModel::create(
        [
            'folio_no' =>$request->folio_no,
            'in_date' =>$request->in_date,
            'out_date' =>$request->out_date,
            'original_out_date' =>$request->original_out_date,
            'no_of_nights' =>$request->no_of_nights,
            'rm_rate' =>$request->rm_rate,
            'taxes' =>$request->taxes,
            'no_of_pax' =>$request->no_of_pax,
            'hotel_note' =>$request->hotel_note,
            'client_note' =>$request->client_note,
            'way_of_payment' =>$request->way_of_payment,
            'profile_id' =>$request->profile_id,
            'company_id' =>$request->company_id,
            'room_id' =>$request->room_id,
            'room_type_id' =>$request->room_type_id,
            'rate_code_id' =>$request->rate_code_id,
            'market_segment_id' =>$request->market_segment_id,
            'source_of_business_id' =>$request->source_of_business_id,
            'meal_id' =>$request->meal_id,
            'created_by' =>auth()->id(),
            'created_inhousGuest_at' =>$request->created_inhousGuest_at,
            'checked_out' =>$request->checked_out,
            'checkout_by' =>$request->checkout_by,
            'checkout_at' =>$request->checkout_at,
            'is_reservation' =>$request->is_reservation,
            'res_status' =>$request->res_status,
            'is_group' =>$request->is_group,
            'group_code' =>$request->group_code,
            'is_dummy' =>$request->is_dummy,
            'Is_PM' =>$request->Is_PM,
        ]
    );
    $guestInhouse =  $this->guestInhouseModel::where('folio_no',$request->folio_no)->with('profile',
    //   'company',
       'room',
       'roomTybe',
       'rateCode',
       'marketSegment',
       'sourceBusiness',
       'meal',
       'createdBy'
       )->get();
    return  $guestInhouse;


}
public function show($id)
{
   
    $room = $this->guestInhouseModel::where('id', $id)->with( 'profile',
    //   'company',
       'room',
       'roomTybe',
       'rateCode',
       'marketSegment',
       'sourceBusiness',
       'meal',
       'createdBy',)->first();
    return $room;
}
public function update($request, $id)
{
    $guestInhouse = $this->guestInhouseModel::where('id', $id)->first();
    if($guestInhouse){
        $this->guestInhouseModel::where('id',$id)->Update([
            'folio_no'  => (!empty($request['folio_no'])) ? $request['folio_no'] :  $guestInhouse->folio_no,
            'in_date'  => (!empty($request['in_date'])) ? $request['in_date'] :  $guestInhouse->rm_name_loc,
            'out_date'  => (!empty($request['out_date'])) ? $request['out_date'] :  $guestInhouse->rm_max_pax,
            'original_out_date'  => (!empty($request['original_out_date'])) ? $request['original_out_date'] :  $guestInhouse->rm_phone_no,
            'rm_rate'  => (!empty($request['rm_rate'])) ? $request['rm_rate'] :  $guestInhouse->rm_rate,
            'taxes'  => (!empty($request['taxes'])) ? $request['taxes'] :  $guestInhouse->taxes,
            'no_of_pax'  => (!empty($request['no_of_pax'])) ? $request['no_of_pax'] :  $guestInhouse->no_of_pax,
            'hotel_note'  => (!empty($request['hotel_note'])) ? $request['hotel_note'] :  $guestInhouse->hotel_note,
            'client_note'  => (!empty($request['client_note'])) ? $request['client_note'] :  $guestInhouse->client_note,
            'way_of_payment'  => (!empty($request['way_of_payment'])) ? $request['way_of_payment'] :  $guestInhouse->way_of_payment,
            'profile_id'  => (!empty($request['profile_id'])) ? $request['profile_id'] :  $guestInhouse->profile_id,
            'company_id'  => (!empty($request['company_id'])) ? $request['company_id'] :  $guestInhouse->company_id,
            'room_type_id'  => (!empty($request['room_type_id'])) ? $request['room_type_id'] :  $guestInhouse->room_type_id,
            'rate_code_id'  => (!empty($request['room_id'])) ? $request['room_id'] :  $guestInhouse->room_id,
            'market_segment_id'  => (!empty($request['market_segment_id'])) ? $request['market_segment_id'] :  $guestInhouse->market_segment_id,
            'source_of_business_id'  => (!empty($request['source_of_business_id'])) ? $request['source_of_business_id'] :  $guestInhouse->source_of_business_id,
            'meal_id'  => (!empty($request['meal_id'])) ? $request['meal_id'] :  $guestInhouse->meal_id,
            'created_inhousGuest_at'  => (!empty($request['created_inhousGuest_at'])) ? $request['created_inhousGuest_at'] :  $guestInhouse->created_inhousGuest_at,
            'checked_out'  => (!empty($request['checked_out'])) ? $request['checked_out'] :  $guestInhouse->checked_out,
            'checkout_by'  => (!empty($request['checkout_by'])) ? $request['checkout_by'] :  $guestInhouse->checkout_by,
            'checkout_at'  => (!empty($request['checkout_at'])) ? $request['checkout_at'] :  $guestInhouse->checkout_at,
            'is_reservation'  => (!empty($request['is_reservation'])) ? $request['is_reservation'] :  $guestInhouse->is_reservation,
            'res_status'  => (!empty($request['res_status'])) ? $request['res_status'] :  $guestInhouse->res_status,
            'is_group'  => (!empty($request['is_group'])) ? $request['is_group'] :  $guestInhouse->is_group,
            'group_code'  => (!empty($request['group_code'])) ? $request['group_code'] :  $guestInhouse->group_code,
            'is_dummy'  => (!empty($request['is_dummy'])) ? $request['is_dummy'] :  $guestInhouse->is_dummy,
            'room_id'  => (!empty($request['room_id'])) ? $request['room_id'] :  $guestInhouse->room_id,
            'Is_PM'  => (!empty($request['Is_PM'])) ? $request['Is_PM'] :  $guestInhouse->Is_PM,
               
        ]);
        $guestInhouse = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $guestInhouse;
    }else{
        return null;
    }       
}
public function isGroupUpdate($request,$id)
{
    $isGroub = $this->guestInhouseModel::where('id', $id)->first();
    if($isGroub){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'is_group'  => $request['is_group'],
            
        ]);
        $isGroub = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $isGroub;
    }else{
        return null;
    }       
}
public function isDummy($request,$id)
{
    $isDummy = $this->guestInhouseModel::where('id', $id)->first();
    if($isDummy){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'is_dummy'  => $request['is_dummy'],
        ]);
        $isDummy = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $isDummy;
    }else{
        return null;
    }       
}
public function IsPM($request,$id)
{
    $IsPM = $this->guestInhouseModel::where('id', $id)->first();
    if($IsPM){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'Is_PM'  => $request['Is_PM'],
           
        ]);
        $IsPM = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $IsPM;
    }else{
        return null;
    }       
}
public function isCancel($id)
{
    $isCancel = $this->guestInhouseModel::where('id', $id)->first();
    if($isCancel){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'is_cancel'  => true,
            'res_status' => 'CNC'
        ]);
        $isCancel = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $isCancel;
    }else{
        return null;
    }       
}
public function isCheckedIn($id)
{
    $isCheckedIn = $this->guestInhouseModel::where('id', $id)->first();
    if($isCheckedIn){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'is_reservation' => false,
            'res_status' => 'CHK',
            'is_checked_in' => true
        ]);
        $isCheckedIn = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $isCheckedIn;
    }else{
        return null;
    }       
}
public function isOnline($request,$id)
{
    $isOnline = $this->guestInhouseModel::where('id', $id)->first();
    if($isOnline){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'is_online'  => $request['is_online'],
               
        ]);
        $isOnline = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $isOnline;
    }else{
        return null;
    }       
}
public function reInstate($id)
{
    $reservision = $this->guestInhouseModel::where('id', $id)->first();
    if($reservision){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'is_cancel' =>false,
            'res_status' => 'CNF'               
        ]);
        $reservision = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $reservision;
    }else{
        return null;
    }       
}
public function reservisionUpdate($request,$id)
{
    $reservision = $this->guestInhouseModel::where('id', $id)->first();
    if($reservision){ 
        $this->guestInhouseModel::where('id',$id)->Update([
            
            'is_reservation'  => $request['is_reservation'],
               
        ]);
        $reservision = $this->guestInhouseModel::where('id',$id)->with( 
            'profile',
        //   'company',
           'room',
           'roomTybe',
           'rateCode',
           'marketSegment',
           'sourceBusiness',
           'meal',
           'createdBy',)->get();
        return  $reservision;
    }else{
        return null;
    }       
}

public function availability($request)
{
    $carbonStartDate = Carbon::parse($request->startDate);
    $carbonEndDate = Carbon::parse($request->endDate);
    $roomsTybe = $this->roomTypeModel::get(['id','no_of_rooms','rm_type_name']);
    $roomCount = [];
    $notAvailableRoom=[];
     //**start check by room id */
    if($request->room_id)
    {
        $rooms= $this->roomModel::where('id',$request->room_id)->with('room_type')->get();
                $roomTypeName = $rooms->first()->room_type->rm_type_name;
          //*******************check in out of order */
                $countRoomsOord =  $this->OordServices::
                where('room_id',$request->room_id)->
                whereBetween('start_date',[$carbonStartDate,$carbonEndDate])->
                where('is_return',0)->
                orWhereBetween('end_date',[$carbonStartDate,$carbonEndDate])->
                where('room_id',$request->room_id)->
                where('is_return',0)->
                count();
                if($countRoomsOord)
                {
                    return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => 'NotAvailable'];

                }
                    //******************check in guest reservission and inhous */
                else{
        $notAvelableGuest =  $this->guestInhouseModel::where('room_id',$request->room_id)->
        whereBetween('in_date',[$carbonStartDate,$carbonEndDate])->
        Where('is_reservation',1)->
        Where(function($query){
            $query-> Where('res_status','CNF' );
            $query->orWhere('res_status','NCF');
        })->
       Where('is_cancel',0)->
       Where('res_status','!=','CNC')->
        Where('checked_out',0)->
        
        orWhereBetween('out_date',[$carbonStartDate,$carbonEndDate])->
        where('room_id',$request->room_id)->
        Where('is_reservation',1)->
        Where(function($query){
            $query-> Where('res_status','CNF' );
            $query->orWhere('res_status','NCF');
        })->
         Where('is_cancel',0)->
         Where('res_status','!=','CNC')->
          Where('checked_out',0)->
          orWhere(function($query)use ($carbonStartDate,$carbonEndDate,$request){
            $query->whereBetween('in_date',[$carbonStartDate,$carbonEndDate]);
            $query->  where('room_id',$request->room_id);
            $query->where('is_checked_in',1);
            $query->where('is_reservation',0);
            $query->where('checked_out',0);  
            $query->whereBetween('out_date',[$carbonStartDate,$carbonEndDate]); 
            $query->where('room_id',$request->room_id); 
            $query->where('is_checked_in',1);
            $query->where('is_reservation',0);
            $query->where('checked_out',0);  
        })->
            with('roomTybe')->get();

            if(!empty($notAvelableGuest->first()))
             {
                
                return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => 'NotAvailable'];
             }else{
                $rooms= $this->roomModel::where('id',$request->room_id)->with('room_type')->get();
                $roomTypeName = $rooms->first()->room_type->rm_type_name;
                return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => 'available', 'roomData' => $rooms];
             }     
            }
    }
     //** start check by room type id */
        elseif($request->roomType_id)
        {
            $roomType= $this->roomTypeModel::where('id',$request->roomType_id)->withcount('roomTybe')->first();
            $rooms= $this->roomTypeModel::where('id',$request->roomType_id)->with('roomTybe')->first();
           // dd( $roomType);
                $roomTypeName =$roomType->rm_type_name;
            
               // dd( $roomTypeName);
             //*******************check in out of order */
                //dd($roomType->id);

                $countRoomsOord =  $this->OordServices::
                whereHas('room',function($q) use($request){
                   $q->where('room_type_id',$request->roomType_id);
                })->
                whereBetween('start_date',[$carbonStartDate,$carbonEndDate])->
                where('is_return',0)->
                orWhereBetween('end_date',[$carbonStartDate,$carbonEndDate])->
                whereHas('room',function($q) use($request){
                    $q->where('room_type_id',$request->roomType_id);
                 })->
                where('is_return',0)->
                get();
                foreach($countRoomsOord as $romNotAvailable)
                {
                    array_push($notAvailableRoom,$romNotAvailable->room_id);
                }
                //******************check in guest reservission and inhous */
                $notAvelableGuest =  $this->guestInhouseModel:: where('room_type_id',$request->roomType_id)->
            whereBetween('in_date',[$carbonStartDate,$carbonEndDate])->
                Where('is_reservation',1)->
                Where(function($query){
                    $query-> Where('res_status','CNF' );
                    $query->orWhere('res_status','NCF');
                })->
            Where('is_cancel',0)->
            Where('res_status','!=','CNC')->
                Where('checked_out',0)->
                
                orWhereBetween('out_date',[$carbonStartDate,$carbonEndDate])->
                where('room_type_id',$request->roomType_id)->
                Where('is_reservation',1)->
                Where(function($query){
                    $query-> Where('res_status','CNF' );
                    $query->orWhere('res_status','NCF');
                })->
                Where('is_cancel',0)->
                Where('res_status','!=','CNC')->
                Where('checked_out',0)->
                orWhere(function($query)use ($carbonStartDate,$carbonEndDate,$request){
                    $query->whereBetween('in_date',[$carbonStartDate,$carbonEndDate]);
                    $query->  where('room_type_id',$request->roomType_id);
                    $query->where('is_checked_in',1);
                    $query->where('is_reservation',0);
                    $query->where('checked_out',0);  
                    $query->whereBetween('out_date',[$carbonStartDate,$carbonEndDate]); 
                    $query->  where('room_type_id',$request->roomType_id); 
                    $query->where('is_checked_in',1);
                    $query->where('is_reservation',0);
                    $query->where('checked_out',0);  
                })->
                    with('roomTybe')->get();
                    foreach($notAvelableGuest as $romNotAvailable)
                    {
                        if(!in_array($romNotAvailable->room_id,$notAvailableRoom))
                        {
                            array_push($notAvailableRoom,$romNotAvailable->room_id);
                        }
                    }
                  
                    $availableRooms = $this->roomModel::
                    where('room_type_id',$request->roomType_id)->
                    whereNotIn('id',$notAvailableRoom)->get();
                    
                   // dd($availableRoom);
                   // dd($notAvailableRoom);
    //dd($notAvelableGuest);

                    if(!empty($notAvelableGuest->first()))
                    {
                    if($countRoomsOord){
                        $countAvailable =$notAvelableGuest->count() - $roomType->room_type_count - $countRoomsOord->count();
                    }else{
                        $countAvailable =$notAvelableGuest->count() - $roomType->room_type_count;

                    }
    
                        if($rooms->room_type_count <= 0 || $countAvailable <= 0)
                        {

                            return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => 'NotAvailable'];
                        }else{
                            if($countRoomsOord){
                            return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => $countAvailable -$countRoomsOord->count(),'roomAvailable' => $availableRooms];
                            }else{
                                
                                return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => $countAvailable,'roomAvailable' => $availableRooms];

                            }

                        }
                   
                    }else{
                       // dd($roomTypeName);
                       if($countRoomsOord){
                       // dd($countRoomsOord);
                    return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => $roomType->room_type_count - $countRoomsOord->count(),'roomAvailable' => $availableRooms];
                       }else{
                        return ['romeTypeName' => $roomTypeName , 'roomAvailableCount' => $roomType->room_type_count,'roomAvailable' => $availableRooms];

                       }
                    }     
            

        }       
        //** start check for all rooms type */
        else{
                foreach($roomsTybe as $roomType)
                {

                //*******************check in out of order */
               // dd($roomType->id);
               $rooms= $this->roomTypeModel::where('id',$request->roomType_id)->with('room_type')->first();
             
                $countRoomsOord =  $this->OordServices::
                whereHas('room',function($q) use($roomType){
                   $q->whereIn('room_type_id',array($roomType->id));
                })->
                whereBetween('start_date',[$carbonStartDate,$carbonEndDate])->
                where('is_return',0)->
                orWhereBetween('end_date',[$carbonStartDate,$carbonEndDate])->
                whereHas('room',function($q) use($roomType){
                    $q->whereIn('room_type_id',array($roomType->id));
                 })->
                where('is_return',0)->
                get();
                foreach($countRoomsOord as $romNotAvailable)
                {
                    array_push($notAvailableRoom,$romNotAvailable->room_id);
                }

                //******************check in guest reservission and inhous */
                $totCountRoomType  = $this->roomModel::where('room_type_id',$roomType->id)->count();
            
                $notAvelableGuest =  $this->guestInhouseModel:: where('room_type_id',$roomType->id)->
                whereBetween('in_date',[$carbonStartDate,$carbonEndDate])->
                Where('is_reservation',1)->
                Where(function($query){
                    $query-> Where('res_status','CNF' );
                    $query->orWhere('res_status','NCF');
                })->
                Where('is_cancel',0)->
                Where('res_status','!=','CNC')->
                Where('checked_out',0)->
               
                
                orWhereBetween('out_date',[$carbonStartDate,$carbonEndDate])->
                where('room_type_id',$roomType->id)->
                Where('is_reservation',1)->
                Where(function($query){
                    $query-> Where('res_status','CNF' );
                    $query->orWhere('res_status','NCF');
                })->
                Where('is_cancel',0)->
                Where('res_status','!=','CNC')->
                Where('checked_out',0)->
                orWhere(function($query)use ($carbonStartDate,$carbonEndDate,$roomType){
                    $query->whereBetween('in_date',[$carbonStartDate,$carbonEndDate]);
                    $query-> where('room_type_id',$roomType->id);
                    $query->where('is_checked_in',1);
                    $query->where('is_reservation',0);
                    $query->where('checked_out',0);  
                    $query->whereBetween('out_date',[$carbonStartDate,$carbonEndDate]); 
                    $query-> where('room_type_id',$roomType->id); 
                    $query->where('is_checked_in',1);
                    $query->where('is_reservation',0);
                    $query->where('checked_out',0);  
                })->
                    with('roomTybe')->get();
               //************************************************************************************************************************* */

                    foreach($notAvelableGuest as $romNotAvailable)
                    {
                        if(!in_array($romNotAvailable->room_id,$notAvailableRoom))
                        {
                            array_push($notAvailableRoom,$romNotAvailable->room_id);
                        }
                    }
                    $availableRooms = $this->roomModel::
                    where('room_type_id',$roomType->id)->
                    whereNotIn('id',$notAvailableRoom)->get();
            
            if($countRoomsOord){
                array_push( $roomCount,['nameOfType' => "$roomType->rm_type_name", 'countOfType' => (  $totCountRoomType - $notAvelableGuest->count() - $countRoomsOord->count()), 'roomAvailable' => $availableRooms])    ;

            }else{
                array_push( $roomCount,['nameOfType' => "$roomType->rm_type_name", 'countOfType' => (  $totCountRoomType - $notAvelableGuest->count()), 'roomAvailable' => $availableRooms ])    ;

            }
                    
                }
            }

             return $roomCount;
            
}


 }    
 
        




