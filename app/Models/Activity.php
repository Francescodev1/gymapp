<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'schedule', 'max_participants'];
    protected $dates = ['schedule'];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function setScheduleAttribute($value)
{
    // Aggiorna il formato qui per corrispondere a quello generato dalla factory
    $this->attributes['schedule'] = Carbon::createFromFormat('Y-m-d H:i:s', $value);
}

}
