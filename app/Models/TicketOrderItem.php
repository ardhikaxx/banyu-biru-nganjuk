<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_order_id',
        'ticket_id',
        'ticket_code',
        'qr_code_path',
        'qty',
        'price',
        'is_used',
        'used_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(TicketOrder::class, 'ticket_order_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}