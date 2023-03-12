<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;
    use LogsActivity;
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "Transaction has been {$eventName}");
    }
    public function ledger()
    {
        return $this->hasOne(Ledger::class,'id','ledger_id');
    }
    public function created_by()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
    public function updated_by()
    {
        return $this->hasOne(User::class,'id','updated_by');
    }
    public function taxes()
    {
        return $this->belongsToMany(Tax::class,'transactions_taxes','transaction_id','tax_id')
            ->withPivot('amount', 'name', 'name_loc','inc')
            ->withTimestamps();
    }
}
