<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'address',
        'description',
        'thumbnail_url',
        'status',
        'capacity',
        'type',
        'is_featured',
    ];

    /**
     * Alias location to address
     */
    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->address,
            set: fn ($value) => ['address' => $value],
        );
    }

    /**
     * Alias price_per_night to price
     */
    protected function pricePerNight(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->price,
            set: fn ($value) => ['price' => $value],
        );
    }

    /**
     * Get images for the room
     */
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }




    /**
     * Get bookings for the room
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
