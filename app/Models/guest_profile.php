<?php

namespace App\Models;

use App\Models\Country;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class guest_profile extends Model

{
    
    use HasFactory, SoftDeletes,LogsActivity;
   
    
    protected $fillable =[
        'Profile_no',
        'first_name',
        'last_name',
        'id_no',
        'mobile',
        'phone',
        'email',
        'address',
        'country_id',
        'city',
        'language',
        'date_of_birth',
        'gender',
        'created_by',
        'deleted_at',
        'deleted_at',
    ];


    public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logAll()
        ->setDescriptionForEvent(fn(string $eventName) => "guest_profile has been {$eventName}");
}
    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }


}
