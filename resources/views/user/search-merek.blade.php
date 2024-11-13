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
            font-family: 'opensans', sans-serif;
            background: linear-gradient(to bottom, #001355, #0029BB);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1300px;
           
            display: flex;
            flex-direction: column;
        }

        .merek {
            text-align: center;
            margin-bottom: 4px;
        }

        .merek h1 {
            font-size: 2rem;
            color: #fff;
        }

        .merek p {
            color: #fff;
        }

        .merek img {
            margin-top: 20px;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .product {
            display: flex;
            justify-content: center;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(5 ,1fr);
            gap: 10px;
            justify-content: space-between;
            margin: 0 auto;
            max-width: 1300px;
            padding: 0 15px;
            margin-bottom: 35px;
        }

        .product-card {
            position: relative;
            background: rgba(255, 255, 255, 0.76);
            box-shadow: 0 4px 7px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10.4px);
            -webkit-backdrop-filter: blur(10.4px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: start;
            height: auto;
        }

        .product-card a {
            text-decoration: none;
        }

        .product-card:hover {
            transform: scale(1.03);
            border: 1px solid #fff;
            backdrop-filter: NONE;
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
    @include('user.header-test')

    <div class="container">
        <section class="merek">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h1 class="display-4">{{ $merek->name }}</h1>
                    <img src="{{ Storage::url('mereks/' . $merek->image) }}" alt="{{ $merek->name }}" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    <p class="lead mt-3">Temukan berbagai produk terbaik dari merek "{{ $merek->name }}" di sini!</p>
                </div>
            </div>
        </section>

        <!-- Product Section -->
        <section class="product">
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
        </section>
    </div>

    @include('user.footer')

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