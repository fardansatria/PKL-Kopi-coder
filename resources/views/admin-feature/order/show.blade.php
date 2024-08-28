<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Detail Order</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Detail Order #{{ $orders->id }}</h2>

        @if($orders)
            <div class="card">
                <div class="card-body">
                    <h4>Informasi Pesanan</h4>
                    <p><strong>Nama Pengguna:</strong> {{ $orders->user->name }}</p>
                    <p><strong>Nomor HP:</strong> {{ $orders->phone }}</p>
                    <p><strong>Alamat:</strong> {{ $orders->addres }}</p>
                    <p><strong>Status:</strong> {{ $orders->status }}</p>
                    <p><strong>Total:</strong> {{ number_format( $orders->total, 0, ',', '.' ) }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ $orders->payment_method }}</p>

                    <h4>Item Pesanan</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Foto Produk</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders->items as $item)
                                <tr>
                                    <td><img src="{{ asset('/storage/products/' . $item->product->image) }}" alt="{{ $item->product->title }}" style="width: 50px; height: 50px;"></td>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ $item->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>Order tidak ditemukan.</p>
        @endif
    </div>
</body>
</html>
