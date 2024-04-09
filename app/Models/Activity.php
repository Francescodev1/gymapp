<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'date', 'time', 'max_participants'];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Opzionale: Mutators per 'date' e/o 'time' se necessario
    public function setDateAttribute($value)
    {
        // Esempio di conversione per 'date', se necessario
        $this->attributes['date'] = $value; // Adattalo secondo le tue necessità
    }

    public function setTimeAttribute($value)
    {
        // Esempio di conversione per 'time', se necessario
        $this->attributes['time'] = $value; // Adattalo secondo le tue necessità
    }
}
