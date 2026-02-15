<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>table{width:100%;border-collapse:collapse}td,th{border:1px solid #ccc;padding:6px;font-size:12px}</style>
    <title>Quotations</title>
</head>
<body>
    <h3>Quotations</h3>
    <table>
        <thead>
            <tr>
                <th>Quotation#</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Total</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $it)
            <tr>
                <td>{{ $it->quotation_number }}</td>
                <td>{{ $it->customer_name }}</td>
                <td>{{ $it->customer_email }}</td>
                <td>{{ number_format($it->total_amount,2) }}</td>
                <td>{{ $it->status }}</td>
                <td>{{ $it->creator?->name }}</td>
                <td>{{ $it->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
