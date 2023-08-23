<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    public function schedules()
    {
        return $this->hasMany(BusSchedule::class, 'route_id');
    }
    protected $hidden = [
        
        'created_at',
        'updated_at'
    ];
}
