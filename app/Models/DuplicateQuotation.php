<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicateQuotation extends Model
{
    use HasFactory;

    protected $table = 'duplicate_quotations';

    protected $fillable = [
        'original_quotation_id',
        'new_quotation_id',
        'reason',
        'created_by',
    ];

    public function original()
    {
        return $this->belongsTo(Quotation::class, 'original_quotation_id');
    }

    public function duplicate()
    {
        return $this->belongsTo(Quotation::class, 'new_quotation_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
