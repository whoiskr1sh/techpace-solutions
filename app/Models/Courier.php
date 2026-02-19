<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'courier_name',
        'tracking_number',
        'date',
        'type',
        'invoice_id',
        'sales_order_id',
        'recipient_name',
        'remarks',
        'status',
        'shipped_at',
        'delivered_at',
        'created_by',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
