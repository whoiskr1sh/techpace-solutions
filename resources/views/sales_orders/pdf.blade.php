<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sales Order</title>

<style>
body{ font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; }
.page{ width:900px; margin:auto; background:white; padding:30px; }
.header{ display:flex; justify-content:space-between; align-items:flex-start; }
.logo img{ height:50px; }
.subhead{ font-size:14px; }
.rightbox{ text-align:right; }
.so{ background:#333; color:white; padding:5px 10px; font-size:13px; display:inline-block; }
.address{ margin-top:15px; font-size:13px; }
table{ width:100%; border-collapse:collapse; font-size:13px; }
td,th{ border:1px solid black; padding:6px; }
.center{ text-align:center; }
.right{ text-align:right; }
.summary{ display:flex; margin-top:10px; gap:10px; }
.summary table{ width:50%; }
.amountbox{ width:40%; margin-left:auto; }
.terms{ margin-top:10px; }
.footer{ margin-top:40px; font-size:12px; }
.signature{ text-align:right; margin-top:40px; }
.bottom-address{ text-align:center; margin-top:40px; font-size:12px; }
.footer-fixed{ position:fixed; bottom:10px; left:0; width:100%; text-align:center; font-size:12px; }
</style>
</head>
<body>
<div class="page">
<div class="header">
<div>
<div class="logo">
<img src="data:image/webp;base64,UklGRsYDAABXRUJQVlA4ILoDAABwFACdASpaABsAPkkei0QioaEWqzW0KASEoAuU/WqJha9XD1AcpX6j/MB5TPqA3hv0APLb/Zn4N/3J/Yz2yaYc9d/JHkOMbvu3CDKi5YPJT+Vf6P7O+cDuL/87xg0b3+v9KP+98t30d/3fcH/lP9V/4vYgYEiTHJLF2DAkcPZA0wn+8PuvN474GXXqf3FHXS58fMO1BNRcHcdMxpBFH/g0MNySJ5IUMp3/7zKgAP7//lokX4VfsVB6xNiJ0qdW2hGrtkOsH03vAflPk+hZyUraM0SsRGHpmcXTBhgsRGzxgT+6EXZlsAI9Zcv014CxHPCjYnSexIHmKIJsDDqyIQODW82Wh/nUsN3MDhpOD8ggytH4JVWZz+7CnSIxou7AdveOkWq8A+onjBVCp4PCGpzrDwChvVF8hXB2vfhyUlB9XkJV5k0xsiM9yyXBA/4p5577Ai05dxFsDvgVil/pkJ9GDwBO4nlItgaUhQm4HmFq7RVWXDXT26vM8xvXbPdWbkA5yOdq3PisCOfq5zaxJZTF1HeUgHtsU37jBhM+N501IQh0lPR1QL6+J5vjSSpgxrtLBq0zSFFE6B829T43sGalmwQD+CbJPT8kUU/Q6GJ0pCuNHlgtzWYB6eNVCIoB68emyAgaRuvu1/+H/4JQ1QYr1LrsL+Rbo1p6ZctCMcI8laSZCXjqN79an3hp8DEaBkscpL7gHkUrk78MwBCZiKnCsvrbaPMEtvwcx/HNtOBmRaW4QRzq8/pJlyo8BdLtON7o1zsK/M9PIpLGViWIf79lo2b99BP8EQ9ovc/8Go2zOva4dJ6EnAP6piz4CxzObvd2xuV8/xrXGv9SzoEb/f1lg6GuOIKpcrfAmd8T4sKn1dD/apK48XBFETxLLjQ3iTbD7MfrUPP8Oln7yrg8nWS49QcHs//bOGRNKn8Q1X+5WwaUYAkaRjYWjCK4e/75sg98+Xkfh/VpO35OsdO+T0m3XMgV116xj/E5jzibtRiKzNSrAviPytaP+hFfmM2xOWubp8BiY0bKKrbXHaH44+I8F1WpkFuDha+nOYtXHJEaBwBEfLPMiRYj06v08hgxYB4fw70PU3xVQCbA1w3sYYoev8zyS5Sz8U5R3DYpeseIaM+8MkGlLuVnx5/fcr1MZie/D9zGiAkTQ/qxMBf+2Tw9UNF6X2gG89YEN6e+9Mg3Stl+fXgJi8c8sIuWOJ5scsGIR9CbBro++ZjM/g90Ffg4VR6bAba188WXteZ2F3zyQqES+Fb3xXVIAAA=">
</div>
<div class="subhead">
Products and System Solutions<br>
Industrial Automation & Instrumentation
</div>
<br>
<b>Millenium Techno Solutions</b>
</div>

<div class="rightbox">
<div class="so">S/O No. : {{ $salesOrder->so_number }} &nbsp;&nbsp; Date : {{ $salesOrder->created_at->format('d-m-Y') }}</div>
<br><br>
<b>BUYER GSTIN :</b> 08ABHPB6914C1Z2
</div>
</div>

<div class="address">
<b>Ship To</b><br>
S-1-112, R.C VYAS COLONY, BHILWARA , RAJASTHAN - 311001
</div>

<div class="address">
<b>Bill To</b><br>
S-1-112, R.C VYAS COLONY, BHILWARA , RAJASTHAN - 311001
</div>

<br>

<table>
<tr>
<th>Sr. No.</th>
<th>PRODUCT</th>
<th>DISPATCH SCHEDULE</th>
<th>QTY</th>
<th>UNIT PRICE</th>
<th>IGST</th>
<th>AMOUNT</th>
</tr>

@if($salesOrder->quotation && $salesOrder->quotation->items)
@foreach($salesOrder->quotation->items as $index => $item)
<tr>
<td class="center">{{ $index + 1 }}</td>
<td>
{{ $item->make ?? $item->name }} {{ $item->model_no ? "({$item->model_no})" : "" }}<br>
{{ $item->remarks }}
</td>
<td class="center">{{ $item->delivery_time ?? 'N/A' }}</td>
<td class="center">{{ $item->quantity ?? $item->qty }} {{ $item->unit ?? 'Nos' }}</td>
<td class="right">{{ number_format($item->unit_price ?? $item->rate, 2) }}</td>
<td class="center">{{ $item->gst_percent ?? '18.00' }}</td>
<td class="right">{{ number_format($item->total_price ?? ($item->quantity * ($item->unit_price ?? $item->rate)), 2) }}</td>
</tr>
@endforeach
@endif
</table>

<div class="summary">
<table>
<tr><th colspan="5">Item Rate Wise Tax Summary</th></tr>
<tr><th>GST</th><th>Amount (INR)</th><th>CGST</th><th>SGST</th><th>IGST</th></tr>
<tr>
<td class="center">18.000</td>
<td class="right">{{ number_format($salesOrder->total_amount, 2) }}</td>
<td class="right">0.00</td>
<td class="right">0.00</td>
<td class="right">{{ number_format($salesOrder->total_amount * 0.18, 2) }}</td>
</tr>
<tr>
<td><b>Total</b></td>
<td class="right"><b>{{ number_format($salesOrder->total_amount, 2) }}</b></td>
<td class="right"><b>0.00</b></td>
<td class="right"><b>0.00</b></td>
<td class="right"><b>{{ number_format($salesOrder->total_amount * 0.18, 2) }}</b></td>
</tr>
</table>

<table class="amountbox">
<tr>
<td class="center">Amount ( ₹ )</td>
<td class="right">{{ number_format($salesOrder->total_amount, 2) }}</td>
</tr>
<tr>
<td class="center">IGST ( ₹ )</td>
<td class="right">{{ number_format($salesOrder->total_amount * 0.18, 2) }}</td>
</tr>
<tr>
<td class="center"><b>Net Amount ( ₹ )</b></td>
<td class="right"><b>{{ number_format($salesOrder->total_amount * 1.18, 2) }}</b></td>
</tr>
<tr>
<td colspan="2">
<b>Amount In Word:</b>
{{ ucwords(\App\Models\Quotation::amountInWords($salesOrder->total_amount * 1.18)) }} Rupees Only
</td>
</tr>
</table>
</div>

<table class="terms">
<tr><th colspan="2">TERMS & CONDITIONS</th></tr>
<tr><td>1</td><td>Price : Ex-Works Vadodara</td></tr>
<tr><td>2</td><td>P&F Charges & Freight : Included</td></tr>
<tr><td>3</td><td>Warranty : 1 Year from Date of Invoice in mfg fault only if applicable</td></tr>
<tr><td>4</td><td>Insurance : On Buyer Scope If Applicable</td></tr>
<tr><td>5</td><td>Payment : 30 Day Credit</td></tr>
<tr><td>6</td><td>Delivery Time :::</td></tr>
</table>

<div class="signature">
For, TECHPACE SOLUTIONS
<br><br><br>
Authorized Signatory<br>
<b>(KEYUR R PARAMAR)</b>
</div>

<div class="bottom-address">
FF-53, SIDDESHWAR HALLMARK, OPP. SHREE HARI TOWNSHIP,  
SAYAJI PARK AJWA ROAD, VADODARA - 390019
</div>
</div>
</body>
</html>
