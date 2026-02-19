<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'make',
        'model_no',
        'unit_price',
        'discount',
        'unit_discounted_price',
        'quantity',
        'total_price',
        'delivery_time',
        'remarks',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
