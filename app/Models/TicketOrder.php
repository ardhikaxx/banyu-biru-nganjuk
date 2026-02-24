<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'visit_date',
        'total_qty',
        'total_price',
        'payment_proof',
        'status',
        'confirmed_at',
        'confirmed_by',
        'rejection_note',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'confirmed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TicketOrderItem::class);
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}