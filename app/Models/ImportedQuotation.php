<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_name',
        'country',
        'make',
        'model_no',
        'description',
        'price_in_usd',
        'delivery_time',
    ];
}
