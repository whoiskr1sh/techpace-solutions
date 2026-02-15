<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaInvoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pi_number',
        'sales_order_id',
        'customer_name',
        'issue_date',
        'total_amount',
        'notes',
        'status',
        'created_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
