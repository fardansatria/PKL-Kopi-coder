<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
        }



        .cart-section {
            margin-top: 30px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .cart-table th,
        .cart-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cart-table th {
            background-color: #007bff;
            color: white;
            font-weight: 500;
        }

        .cart-table img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .cart-table img:hover {
            transform: scale(1.1);
        }

        .cart-table button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .cart-table button:hover {
            background-color: #c82333;
        }

        .cart-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-summary p {
            font-size: 1.4em;
            margin: 0;
        }

        .cart-summary .btn {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .cart-summary .btn:hover {
            background-color: #218838;
        }

        .empty-cart {
            text-align: center;
            padding: 60px;
            font-size: 1.4em;
            color: #6c757d;
        }

        .cart-value {
            text-align: center;
            margin-bottom: 40px;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-value h3 {
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .order {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 40px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .order div {
            margin-bottom: 15px;
        }

        .order label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
        }

        .order input,
        .order textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .order input.btn {
            width: auto;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .order input.btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    @include('user.header')

    <div class="container">
        <div class="header">
            <h1>Keranjang Belanja Anda</h1>
        </div>

        <div class="cart-section">
        <?php $value = 0; ?>
            @if($cart->isEmpty())
            <div class="empty-cart">
                <p>Keranjang belanja Anda kosong.</p>
            </div>
            @else
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($cart as $cart)
                    <tr>
                        <td><img src="{{ asset('storage/products/' . $cart->product->image) }}" alt="{{ $cart->product->title }}"></td>
                        <td>{{ $cart->product->title }}</td>
                        <td>{{ number_format($cart->product->price, 2, ',', '.') }}</td>
                        <td>{{ $cart->qty }}</td>
                        <td>{{ number_format($cart->product->price * $cart->qty, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ url('cart_delete', $cart->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                        </td>
                    </tr>
                    <?php $value += $cart->product->price * $cart->qty; ?>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>


    <div class="cart-value">
        <h3>Total: Rp {{ number_format($value, 2, ',', '.') }}</h3>
        <div>
            <a class="btn btn-primary" href="{{ route('checkout.index') }}">Bayar</a>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Message with Sweetalert
    @if(session('success'))
    Swal.fire({
        icon: "success",
        title: "BERHASIL",
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2000
    });
    @elseif(session('error'))
    Swal.fire({
        icon: "error",
        title: "GAGAL!",
        text: "{{ session('error') }}",
        showConfirmButton: false,
        timer: 2000
    });
    @endif
</script>

</html>