<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>table{width:100%;border-collapse:collapse}td,th{border:1px solid #ccc;padding:6px;font-size:12px}</style>
    <title>Invoices</title>
</head>
<body>
    <h3>Invoices</h3>
    <table>
        <thead>
            <tr>
                <th>Invoice#</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Issue Date</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $it)
            <tr>
                <td>{{ $it->invoice_number }}</td>
                <td>{{ $it->customer_name }}</td>
                <td>{{ number_format($it->total_amount,2) }}</td>
                <td>{{ $it->status }}</td>
                <td>{{ $it->creator?->name }}</td>
                <td>{{ optional($it->issue_date)->toDateString() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
