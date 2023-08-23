<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    use HasFactory;

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    // Define the many-to-one relationship with Bus model
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
    protected $hidden = [
        
        'created_at',
        'updated_at'
    ];
}
