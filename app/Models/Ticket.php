<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quota_per_day',
        'is_active',
    ];

    public function items()
    {
        return $this->hasMany(TicketOrderItem::class);
    }
}