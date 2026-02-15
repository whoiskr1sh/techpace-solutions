<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HsnCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hsn_codes';

    protected $fillable = [
        'code',
        'description',
        'gst_rate',
        'created_by',
    ];

    protected $casts = [
        'gst_rate' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
