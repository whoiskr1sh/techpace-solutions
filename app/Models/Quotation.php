<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'source_of_inquiry_id',
        'notes',
        'total_amount',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function source()
    {
        return $this->belongsTo(SourceOfInquiry::class, 'source_of_inquiry_id');
    }
}
