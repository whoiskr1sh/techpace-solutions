<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_of_item',
        'group_of_item',
        'item_name',
        'item_description',
        'primary_unit',
        'is_freez',
        'gst_percent',
        'igst_percent',
        'is_machine',
        'hsn_code',
        'account_group',
        'photo',
    ];

    protected $casts = [
        'is_freez' => 'boolean',
        'is_machine' => 'boolean',
        'gst_percent' => 'decimal:2',
        'igst_percent' => 'decimal:2',
    ];
}
