<?php

namespace App\Models;

use App\Models\Floor;
use App\Models\Guests;
use App\Models\RoomType;

use App\Models\OordService;

use App\Models\RoomStatus;
use App\Models\guest_profile;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "Room has been {$eventName}");
    }
    protected $fillable = [
        'rm_name_en',
        'rm_name_loc',
        'rm_max_pax',
        'rm_phone_no',
        'rm_phone_ext',
        'rm_key_code',
        'rm_key_options',
        'rm_connection',
        'fo_status',
        'hk_stauts',
        'rm_active',
        'sort_order',
        'room_type_id',
        'floor_id',
    ];

    public function room_type()
    {
        return $this->hasOne(RoomType::class, 'id', 'room_type_id');
    }
    public function floors()
    {
        return $this->hasOne(Floor::class,'id','floor_id');
    }



    public function guests()
    {
        return $this->hasOne(Guests::class);
    }
        public function guest_profile()
        {
            return $this->hasOne(guest_profile::class);
        }
    
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class,'room_id','id');
    }
    public function room_status()

    {
        return $this->hasOne(OordService::class);
    }
}
