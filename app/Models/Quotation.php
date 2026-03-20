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
        'currency',
        'status',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function source()
    {
        return $this->belongsTo(SourceOfInquiry::class, 'source_of_inquiry_id');
    }

    public static function amountInWords($num)
    {
        $ones = [
            0 => "ZERO", 1 => "ONE", 2 => "TWO", 3 => "THREE", 4 => "FOUR", 5 => "FIVE", 6 => "SIX", 7 => "SEVEN", 8 => "EIGHT", 9 => "NINE", 10 => "TEN",
            11 => "ELEVEN", 12 => "TWELVE", 13 => "THIRTEEN", 14 => "FOURTEEN", 15 => "FIFTEEN", 16 => "SIXTEEN", 17 => "SEVENTEEN", 18 => "EIGHTEEN", 19 => "NINETEEN"
        ];
        $tens = [
            0 => "ZERO", 1 => "TEN", 2 => "TWENTY", 3 => "THIRTY", 4 => "FORTY", 5 => "FIFTY", 6 => "SIXTY", 7 => "SEVENTY", 8 => "EIGHTY", 9 => "NINETY"
        ];
        $hundreds = ["HUNDRED", "THOUSAND", "MILLION", "BILLION", "TRILLION", "QUADRILLION"];

        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr);
        $rettxt = "";
        
        if ((int)$wholenum == 0) {
            $rettxt = "ZERO";
        } else {
            foreach ($whole_arr as $key => $i) {
                while (substr($i, 0, 1) == "0") $i = substr($i, 1, 5);
                if ($i == "") continue;
                if ($i < 20) {
                    if (isset($ones[$i])) $rettxt .= $ones[$i];
                } elseif ($i < 100) {
                    $rettxt .= $tens[substr($i, 0, 1)];
                    if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
                } else {
                    $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                    if (substr($i, 1, 1) != "0" || substr($i, 2, 1) != "0") {
                        $rettxt .= " ";
                        if (substr($i, 1, 2) < 20) {
                            $rettxt .= $ones[(int)substr($i, 1, 2)];
                        } else {
                            $rettxt .= $tens[substr($i, 1, 1)];
                            if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
                        }
                    }
                }
                if ($key > 0) $rettxt .= " " . $hundreds[$key] . " ";
            }
        }

        if ($decnum > 0) {
            $rettxt .= " AND ";
            if ($decnum < 20) {
                $rettxt .= $ones[(int)$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                if (substr($decnum, 1, 1) != "0") $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
            $rettxt .= " PAISE";
        }
        return ucwords(strtolower(trim($rettxt)));
    }
}
