<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .header {
            padding: 10px 0;
            background-color: #343a40;
            color: white;
            text-align: center;
        }

        .cart-section {
            margin-top: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        }

        .cart-table img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
        }

        .cart-table button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        .cart-table button:hover {
            background-color: #c82333;
        }

        .cart-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-summary p {
            font-size: 1.2em;
            margin: 0;
        }

        .cart-summary .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1em;
        }

        .cart-summary .btn:hover {
            background-color: #0056b3;
        }

        .empty-cart {
            text-align: center;
            padding: 50px;
            font-size: 1.2em;
            color: #6c757d;
        }

        .cart-value {
            text-align: center;
            margin-bottom: 70px;
            padding: 18px;
        }

        .order {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .order label{
            display: inline-block;
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        @include('user.header')
    </div>

    <div class="container">
        <div class="header">
            <h1>Keranjang Belanja Anda</h1>
        </div>

        <div class="cart-section">
            @if($cart->isEmpty())
            <div class="empty-cart">
                <p>Keranjang belanja Anda kosong.</p>
            </div>
            @else

            <div class="order">
                <form action="{{url('confirm_order')}}" method="POST">
                    <div>
                        <label for="">name</label>
                        <input type="text" name="name" value="{{Auth::user()->name}}">
                    </div>
                    <div>
                        <label for="">email</label>
                        <input type="text" name="email" value="{{Auth::user()->email}}">
                    </div>
                    <div>
                        <label for="">addres</label>
                      <textarea name="addres" id=""></textarea>
                    </div>
                    <div>
                        <label for="">phone</label>
                        <input type="text" name="phone" id="">
                    </div>
                    <div>
                        <input class="btn btn-danger" type="submit" value="place order">
                    </div>
                </form>
            </div>

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $value = 0;
                ?>

                <tbody>
                    @foreach($cart as $cart)
                    <tr>
                        <td><img src="{{ asset('storage/products/' . $cart->product->image) }}" alt="{{ $cart->product->title }}"></td>
                        <td>{{ $cart->product->title }}</td>
                        <td>{{ number_format($cart->product->price, 2, ',', '.') }}</td>
                        <td>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{url('delete_cart', $cart->id)}}">Hapus</a>
                        </td>
                    </tr>

                    <?php
                    $value = $value + $cart->product->price;
                    ?>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <div class="cart-value">
        <h3>total : {{ number_format($value, 2, ',', '.')}}</h3>
        <div>
            <a class="btn btn-danger" href="">Bayar</a>
        </div>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>