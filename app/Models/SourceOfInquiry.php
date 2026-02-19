<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourceOfInquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'source',
    ];

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
