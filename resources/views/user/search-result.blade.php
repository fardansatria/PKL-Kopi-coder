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
            display: flex;
            gap: 1px;
            max-width: 100%;
            margin: 0 auto;
            padding: 0 15px;
        }

        .query {
            display: none;
            visibility: hidden;
        }

        .filter {
            background-color: transparent;
            border-radius: 10px;
            padding: 15px;
            width: 200px;
            color: #fff;
            margin-left: -100px;
            height: 100%;
            position: fixed;
        }

        .filter h2 {
            margin-top: 0;
            font-size: 1.25rem;
            color: #fff;
        }

        .filter form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter label {
            font-size: 0.875rem;
            color: #fff;
        }

        .filter input[type="checkbox"] {
            margin-right: 10px;
        }

        .filter select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            color: #fff;
        }

        .filter button {
            border: none;
            color: #fff;
            background: black;
            padding: 7px;
            border-radius: 15px;
            width: 50%;
        }

        .filter button:hover {
            color: blue;
            background: #fff;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            justify-content: center;
            margin-top: 50px;
            margin-left: 100px;
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
            backdrop-filter: none;
        }

        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
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

        .product-description {
            font-size: 0.875rem;
            color: #555;
            text-align: left;
            margin: 10px 0;
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

        .btn-cart i {
            margin: 0;
        }
    </style>
</head>

<body>
    @include('user.header-test')
    <div class="container">
        <!-- Filter Section -->
        <div class="filter">
            <h2>Filter</h2>
            <form action="{{ url('user/search') }}" method="GET">
                <div class="query">
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="Cari produk...">
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="sort" value="price_asc" {{ request('sort') == 'price_asc' ? 'checked' : '' }}>
                        Harga Termurah
                    </label>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="sort" value="price_desc" {{ request('sort') == 'price_desc' ? 'checked' : '' }}>
                        Harga Termahal
                    </label>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="sort" value="best_selling" {{ request('sort') == 'best_selling' ? 'checked' : '' }}>
                        Barang Terlaris
                    </label>
                </div>
                <button type="submit">Filter</button>
            </form>
        </div>

        <!-- Product Section -->
        <div class="product-container">
    @foreach($products as $product)
    <div class="product-card">
        <a href="{{ url('product_detail', $product->id) }}">
            <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
            <div class="product-info">
                <div class="product-title">{{ Str::limit($product->title, 20) }}</div>
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
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