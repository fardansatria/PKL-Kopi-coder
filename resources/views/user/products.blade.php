<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            font-size: 2rem;
            color: #333;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin: 0 auto;
            max-width: 1200px;
            padding: 0 15px;
        }

        .product-card {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 250px;
            background-color: #fff;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .product-price {
            color: #28a745;
            font-size: 1rem;
            margin: 10px 0;
        }

        .product-description {
            font-size: 0.875rem;
            color: #555;
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
    </style>
</head>

<body>
    <h1>Our Products</h1>
    <div class="product-container">
        @foreach($products as $product)
        <div class="product-card">
            <a href="{{ url('product_detail', $product->id) }}">
                <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                <div class="product-info">
                    <div class="product-title">{{ $product->title }}</div>
                    <div class="product-price">RP {{ number_format( $product->price, 0, ',', '.' )}}</div>
                    <div class="product-description">{{ Str::limit($product->description, 50) }}</div>
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
