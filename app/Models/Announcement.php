<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
       'uuid',
        'title',
        'description',
        'image_path',
        'status',
        'city',
        'price',
        'phone_number'
    ];

    public function vehicle(): HasOne
    {
       return $this->hasOne(Vehicle::class);
    }
}
