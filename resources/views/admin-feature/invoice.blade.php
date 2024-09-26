<!-- resources/views/admin-feature/invoice.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $data->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details h1 {
            font-size: 24px;
            margin: 0;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .order-items th, .order-items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .order-items th {
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 20px;
            text-align: right;
        }
        .total p {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('/storage/web_image/coder.jpg') }}" alt="Coder Store">
        <h2>Coder Store</h2>
    </div>

    <div class="invoice-details">
        <h1>Pesanan ID: {{ $data->id }}</h1>
        <p><strong>Nama:</strong> {{ $data->user->name }}</p>
        <p><strong>Alamat:</strong> {{ $data->addres }}</p>
        <p><strong>No.Telepon:</strong> {{ $data->phone }}</p>
    </div>

    <table class="order-items">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->items as $item)
            <tr>
                <td>{{ $item->product->title }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp {{ number_format($item->price, 0) }}</td>
                <td>Rp {{ number_format($item->qty * $item->price, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total Belanja: Rp {{ number_format($data->total, 2) }}</p>
    </div>

    <div class="footer">
        <p>Terimakasih Sudah Berbelanja</p>
    </div>
</body>
</html>
