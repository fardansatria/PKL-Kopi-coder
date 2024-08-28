<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Checkout</h2>

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $profile->phone ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="addres">Alamat Pengiriman</label>
                <textarea name="addres" class="form-control" id="addres" rows="3" required>{{ old('addres', $profile->addres ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="payment_method">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="cod">Cash on Delivery (COD)</option>
                    <option value="bank-transfer">Transfer Bank</option>
                </select>
            </div>

            <h4>Rincian Pesanan:</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>Rp {{ number_format($item->product->price, 2, ',', '.') }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->product->price * $item->qty, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Proses Checkout</button>
        </form>
    </div>
</body>

</html>