<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'opensans', sans-serif;
            background: linear-gradient(to bottom, #001355, #0029BB);
            overflow-x: hidden;
            max-width: 100%;
        }

        .product-detail-container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            color: #fff;
        }

        .product-image-large {
            max-width: 370px;
            width: 100%;
            height: 75%;
            flex: 0 0 100px;
            border-radius: 10px;
            margin-right: 20px;
            margin-top: 35px;
        }

        .product-details {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            color: #fff;
        }

        .product-details .product-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #fff;
        }

        .product-details .product-price {
            color: #2596be;
            font-size: 1.9rem;
            font-weight: 400;
            margin-bottom: 20px;
        }

        .product-availability {
            font-size: 16px;
            color: #fff;
            margin-bottom: 20px;
        }

        .product-rating {
            margin-bottom: 20px;
        }

        .stars {
            color: #ffd700;
        }

        .quantity {
            display: flex;
            align-items: center;
            gap: 0px;
        }

        .quantity label {
            margin-right: 18px;
        }

        .quantity button {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            background-color: white;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
        }

        .quantity input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .buttons button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            z-index: 1;
            position: relative;
        }

        .add-to-cart {
            border: 1px solid #2977ff;
            border: none;
            background-color: #fff;
            color: #2977ff;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: 0.4s ease;
        }

        .add-to-cart:hover {
            border: 1px solid #fff;
            border: none;
            background-color: #2977ff;
            color: #fff;
        }

        .buy-now {
            background-color: #2977ff;
            color: white;
            border: none;
            transition: 0.3s ease;
        }

        .buy-now:hover {
            background-color: #2264d6;
        }

        .image {
            width: 100%;
            max-width: 600px;
            height: 75%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .additional-images {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .additional-images img {
            width: 60px;
            height: 60px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .additional-images img:hover {
            transform: scale(1.1);
            border: 1px solid #000;
        }

        .description {
            margin-top: 50px;
            width: 100%;
            margin-left: 120px;
            color: #fff;
        }

        .h-description {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: left;
            margin-bottom: 10px;
            color: #fff;
        }

        .product-description {
            font-size: 16px;
            margin: 10px 100px;
            white-space: pre-line;
            max-width: 50%;
            overflow-wrap: break-word;
            line-height: 1.9;
            line-spacing: 1.4;
            font-size: 0.85rem;
        }

        /* style other product */
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin: 0 auto;
            max-width: 100%;
            padding: 0 15px;
            margin-bottom: 100px;
        }

        .title {
            width: 100%;
            color: #fff;
            text-align: start;
            font-size: 1.4rem;
            font-weight: 500;
            margin-bottom: 2px;
            margin-left: 80px;
            margin-top: 10px;
        }

        .strip {
            height: 1px;
            width: 100%;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .product-card {
            position: relative;
            width: calc(17% - 25px);
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
            font-size: 0.900rem;
            text-align: left;
            margin: 10px 0;
        }

        .product-price {
            color: #2596be;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 10px 0;
        }


        .btn-cart-form-other {
            position: absolute;
            bottom: -45px;
            left: 50%;
            transform: translateX(-50%);
            transition: bottom 0.3s;
        }

        .product-card:hover .btn-cart-form-other {
            bottom: 10px;
        }

        .btn-cart-other {
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

        .btn-cart-other:hover {
            background-color: #ff4757;
            transform: scale(1.1);
        }

        .btn-cart-other i {
            margin: 0;
        }

        .product-rating-other {
            margin-top: -15px;
            margin-bottom: 10px;
            padding-left: 10px;
            font-size: 0.85rem;
            color: #000;
        }

        .stars-other {
            color: #ffd700;
        }
    </style>
</head>

<body>
    @include('user.header-test')
    <div class="product-detail-container">
        <div class="image">
            <!-- Gambar Utama -->
            <img id="main-image" src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->name }}" class="product-image-large">

            <!-- Gambar Tambahan -->
            <div class="additional-images">
                <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->name }}"
                    onmouseover="changeMainImage('{{ asset('/storage/products/' . $product->image) }}')">
                @foreach($product->ProductImages as $image)
                <img src="{{ asset('/storage/products/' . $image->image) }}" alt="Additional Image"
                    onmouseover="changeMainImage('{{ asset('/storage/products/' . $image->image) }}')">
                @endforeach
            </div>
        </div>

        <div class="product-details">
            <div class="product-title">{{ $product->title }}</div>
            <div class="product-price">Rp{{ number_format( $product->price, 0, ',', '.' )}}</div>
            <div class="product-rating">
                <span class="stars">★★★★☆</span> <!-- Example rating, you can use dynamic content here -->
                <span>(120 reviews)</span>
            </div>
            @if ($product->stock > 0)
            <div class="product-availability">Stock : {{ $product->stock }}</div>
            @else
            <span class="text-danger fs-5 fw-bold">Stok Habis</span>
            @endif

            <div class="quantity">
                <label for="quantity">Kuantitas</label>
                <button>-</button>
                <input type="number" id="qty-input" name="qty" min="1" value="1">
                <button>+</button>
            </div>
            <div class="buttons">
                <form id="add-cart-form" action="{{ url('add_cart', $product->id) }}" method="POST" class="btn-cart-form">
                    @csrf
                    <button type="submit" class="add-to-cart" onclick="setQtyToAddCart()">
                        <i class="fas fa-shopping-cart"></i> Masukkan Keranjang
                    </button>
                    <div class="wave"></div>
                </form>

                <form id="checkout-form" action="{{ route('checkout.product', ['product_id' => $product->id]) }}" method="GET">
                    <button type="submit" class="buy-now" onclick="setQtyToCheackout()">Beli Sekarang</button>
                </form>
            </div>

        </div>
    </div>

    <div class="description">
        <div class="h-description">
            <p>Deskripsi Produk</p>
        </div>
        <div class="product-description">{{ $product->description }}</div>
    </div>
    </div>
    <!-- other product -->
    <div class="product-container">
        <div class="strip"></div>
        <h1 class="title">Produk Lainnya</h1>
        @foreach($otherProducts as $product)
        <div class="product-card">
            <a href="{{ url('product_detail', $product->id) }}">
                <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                <div class="product-info">
                    <div class="product-title">{{ Str::limit($product->title, 20) }}</div>

                    <div class="product-price">RP {{ number_format( $product->price, 0, ',', '.' )}}</div>
                </div>
                <div class="product-rating-other">
                    <span class="stars-other">★ </span> <!-- Example rating, you can use dynamic content here -->
                    <span>4,5 | </span>
                    <span>1 Terjual</span>
                </div>
            </a>
            <form action="{{ url('add_cart', $product->id) }}" method="POST" class="btn-cart-form-other">
                @csrf
                <button type="submit" class="btn-cart-other">
                    <i class="fa fa-shopping-cart"></i>
                </button>
            </form>
        </div>
        @endforeach
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Mengubah gambar utama dengan gambar tambahan yang di-hover
    function changeMainImage(imageUrl) {
        document.getElementById('main-image').src = imageUrl;
    }

    // Pesan dengan Sweetalert
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


    function setQtyToAddCart() {
        const qty = document.getElementById('qty-input').value;
        const addCartForm = document.getElementById('add-cart-form');
        const qtyInput = document.createElement('input');
        qtyInput.type = 'hidden';
        qtyInput.name = 'qty';
        qtyInput.value = qty;
        addCartForm.appendChild(qtyInput);
    }

    function setQtyToAddCart() {
        const qty = document.getElementById('qty-input').value;
        const addCartForm = document.getElementById('checkout-form');
        const qtyInput = document.createElement('input');
        qtyInput.type = 'hidden';
        qtyInput.name = 'qty';
        qtyInput.value = qty;
        addCartForm.appendChild(qtyInput);
    }
</script>

</html>