<?php

namespace App\Models;

use App\Models\User;
use App\Models\companyProfile;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statement extends Model
{

   use SoftDeletes;
   use LogsActivity;
   use HasFactory;



    protected $guarded=[];


   public function getActivitylogOptions(): LogOptions
   {
    return LogOptions::defaults()
     ->logAll()
     ->setDescriptionForEvent(fn(string $eventName) => "Statement has been {$eventName}");
    }

   public function companyProfile()
   {
      return $this->hasOne(companyProfile::class, 'id', 'company_id');
   }


    public function users()
    {
       return $this->hasMany(User::class,'id','created_by');
    } 


}
