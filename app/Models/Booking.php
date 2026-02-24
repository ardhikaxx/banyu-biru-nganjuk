<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'place_id',
        'booking_code',
        'booking_date',
        'visitor_name',
        'visitor_phone',
        'visitor_address',
        'num_persons',
        'total_price',
        'payment_proof',
        'status',
        'confirmed_at',
        'confirmed_by',
        'rejection_note',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'confirmed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}