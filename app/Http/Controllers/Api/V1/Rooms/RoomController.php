<?php

namespace App\Http\Controllers\Api\V1\Rooms;

use App\helpers;
use App\Models\Room;
use App\Models\Guests;
use App\Models\RoomStatus;
use App\Models\OordService;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;

use App\Http\Resources\GeneralCollection;
use App\Http\Resources\Rooms\RoomResource;
use App\Repositoryinterface\Rooms\RepositoryRoomInterface;

use function PHPUnit\Framework\isEmpty;

class RoomController extends Controller
{
    use helpers;

    private $RepositoryRoomInterface;

    public function __construct(RepositoryRoomInterface $RepositoryRoomInterface)
    {
        $this->RepositoryRoomInterface =$RepositoryRoomInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = $this->RepositoryRoomInterface->index();
        if ($rooms->first()) {
            return $this->apiResponse(new GeneralCollection($rooms, RoomResource::class),200);
        } else
            return $this->apiResponse(["message" => __("not found")],404);
    }
    public function roomPagination()
    {
        $rooms = $this->RepositoryRoomInterface->roomPagination();
        if ($rooms->first()) {
            return $this->apiResponse(new GeneralCollection($rooms, RoomResource::class),200);
        } else
            return $this->apiResponse(["message" => __("not found")],404);
    }



    public function roomRack(Request $request)
    {
        $rooms = Room::with("guests.profile")->get();
       
       //dd($rooms);      
        $rack_arr =  [];
        
       
        

        foreach ($rooms as $room) {
    
            $guest_inHouse =[];
            $reservation   =[];
            $rack2=[];
            $color_status='';
            
            $foStatus = $room->fo_status;
            $hkStatus= $room->hk_status;
            $roomName       = $room->rm_name_en;
            $roomName_Loc   = $room->rm_name_loc;
          
            if($foStatus == "OO" || $foStatus == "OS" ) {
                $status         = $room->fo_status ;
            } else {
                $status         = $room->fo_status . $room->hk_stauts;
            }
            
           

            if($room->fo_status == "OC"){
            $guest_inHouse = $room->guests;

            } elseif ($room->fo_status == "BL"){

                //dd($room->guests);
                $reservation =  $room->guests;

            } elseif ($room->fo_status == "OO"){

            $order=OordService::where('room_id',$room->id)->where("is_return",0)->first();
           // dd($order);
                if($order) {
                $end_date  =$order->end_date;
                $notes     =$order->notes;
                
                $rack2 = [
                    'end_date '       => $end_date ,
                    'notes '          =>$notes ,
                ];
            }
            }
    
            $color_status=RoomStatus::where('status_code',$status)->first();
          
            $color = $color_status->color;
          
            
         
            $rack = [

                'roomName'       => $roomName,
                'roomName_Loc'   => $roomName_Loc,
                'status'         => $status,
                'guest_details'  => $guest_inHouse,
                'reservation'    => $reservation,
                'Ord_status'     => $rack2,
                'color_status'   =>$color
            ];
            array_push($rack_arr, $rack);       //////for room details


        }

        return response()->json([
            "message" => ' Details Of Our Rooms',
            'data' => $rack_arr
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {

        $rooms = $this->RepositoryRoomInterface->store($request);

        return $this->apiResponse(new GeneralCollection($rooms, RoomResource::class),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = $this->RepositoryRoomInterface->show($id);

        if ($room) {
            return $this->apiResponse(['data' => collect(new RoomResource($room))],200);
        } else {
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
    public function update(RoomRequest $request, $id)
    {
        $room = $this->RepositoryRoomInterface->update($request,$id);
        if($room){

            return $this->apiResponse(new GeneralCollection($room, RoomResource::class),200);
        } else {
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
        $room = $this->RepositoryRoomInterface->destroy($id);

        if ($room) {
            return $this->apiResponse(["message" => __("the Room Has Been Deleted")],200);
        } else {
            return $this->apiResponse(['message' => __("not found")], 404);
        }
    }

    public function geSoftDeletedData()
    {
        $roomsTrashed = $this->RepositoryRoomInterface->geSoftDeletedData();

        if ($roomsTrashed->first()) {
            return $this->apiResponse(new GeneralCollection($roomsTrashed, RoomResource::class),200);
        } else {
            return $this->apiResponse(["message" => __("not found")], 404);
        }
    }

    public function restorDataTrashed($id)
    {
        $roomRestore = $this->RepositoryRoomInterface->restorDataTrashed($id);

        if ($roomRestore->first()) {
            return $this->apiResponse(new GeneralCollection($roomRestore, RoomResource::class),200);
        } else {
            return $this->apiResponse(["message" => __("not found")], 404);
        }

    }

}
