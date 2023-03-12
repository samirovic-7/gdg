<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;
    use LogsActivity;



    protected $guarded = [];
    public function getActivitylogOptions(): LogOptions
   {
    return LogOptions::defaults()
     ->logAll()
     ->setDescriptionForEvent(fn(string $eventName) => "Tenant has been {$eventName}");
    }

    protected $hidden = [
        'password',
        'remember_token',
        'language_id',
    ];

   

}
