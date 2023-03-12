<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Window extends Model
{
    use HasFactory;
    use LogsActivity;
  
    protected $fillable=[
        'guest_id',
        'window_number',
        'window_name',
        'invoice_number',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "Window  has been {$eventName}");
    }
    public function guest(){
        return $this->hasMany(Guests::class,'id','guest_id');
    }
}
