<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'opensnas', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: start;
            margin: 0px 20px;
            font-size: 2rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
            margin-left: 100px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin: 0 auto;
            max-width: 1300px;
            padding: 0 15px;
            margin-bottom: 35px;
        }

        .product-card {
            position: relative;
            border: 1px solid #ddd;
            width: calc(17% - 25px);
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: start;
            height: auto;
        }

        .product-card a {
            text-decoration: none;
        }

        .product-card:hover {
            transform: scale(1.03);
            border: 1px solid #000;
        }

        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            color: #333;
        }

        .product-price {
            color: #2596be;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 10px 0;
        }


        .btn-cart-form {
            position: absolute;
            bottom: -45px;
            left: 50%;
            transform: translateX(-50%);
            transition: bottom 0.3s;
        }

        .product-card:hover .btn-cart-form {
            bottom: 10px;
        }

        .btn-cart {
            background-color: #333;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-cart:hover {
            background-color: #ff4757;
            transform: scale(1.1);
        }

        .btn-cart i {
            margin: 0;
        }

        .product-rating {
            margin-top: -15px;
            margin-bottom: 10px;
            padding-left: 10px;
            font-size: 0.85rem;
            color: #000;
        }

        .stars {
            color: #ffd700;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <h1>Products</h1>
    <div class="product-container">
        @foreach($products as $product)
        <div class="product-card">
            <a href="{{ url('product_detail', $product->id) }}">
                <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                <div class="product-info">
                    <div class="product-title">{{ Str::limit($product->title, 20) }}</div>
                    <div class="product-price">Rp{{ number_format( $product->price, 0, ',', '.' )}}</div>
                </div>
                <div class="product-rating">
                    <span class="stars">★ </span> <!-- Example rating, you can use dynamic content here -->
                    <span>4,5 | </span>
                    <span>1 Terjual</span>
                </div>
            </a>
            <form action="{{ url('add_cart', $product->id) }}" method="POST" class="btn-cart-form">
                @csrf
                <button type="submit" class="btn-cart">
                    <i class="fa fa-shopping-cart"></i>
                </button>
            </form>
        </div>
        @endforeach
    </div>

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
</body>

</html>