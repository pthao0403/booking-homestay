<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'checkin_date',
        'checkout_date',
        'total_guests',
        'total_price',
        'status'
    ];

    /**
     * Cast attributes to native types or Carbon instances.
     */
    protected $casts = [
        'checkin_date' => 'date',
        'checkout_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the room associated with the booking.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the user who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias check_in to checkin_date
     */
    protected function checkIn(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->checkin_date,
            set: fn ($value) => ['checkin_date' => $value],
        );
    }

    /**
     * Alias check_out to checkout_date
     */
    protected function checkOut(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->checkout_date,
            set: fn ($value) => ['checkout_date' => $value],
        );
    }

    /**
     * Alias guests to total_guests
     */
    protected function guests(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_guests,
            set: fn ($value) => ['total_guests' => $value],
        );
    }
}
