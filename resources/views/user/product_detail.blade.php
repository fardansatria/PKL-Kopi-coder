<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .product-detail-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product-image-large {
            max-width: 600px;
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-right: 20px;
        }

        .product-details {
            flex: 1;
            padding: 20px;
        }

        .product-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-price {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 16px;
            color: #000;
            margin-top: 20px;
        }

        .product-availability {
            font-size: 16px;
            color: #888;
            margin-bottom: 20px;
        }

        .product-rating {
            margin-bottom: 20px;
        }

        .stars {
            color: #ffd700;
        }

        .add-to-cart-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    @include('user.header')
    <div class="product-detail-container">
        <img src="{{ asset('/storage/products/' . $data->image) }}" alt="{{ $data->name }}" class="product-image-large">

        <div class="product-details">
            <div class="product-title">{{ $data->title }}</div>
            <div class="product-price">RP {{ number_format( $data->price, 0, ',', '.' )}}</div>
            <div class="product-rating">
                <span class="stars">★★★★☆</span> <!-- Example rating, you can use dynamic content here -->
                <span>(120 reviews)</span>
            </div>
            <div class="product-availability">Stock : {{ $data->stock }}</div>

            <div class="btn-cart">
                <form action="{{ url('add_cart', $data->id) }}" method="POST" class="btn-cart-form">
                    @csrf
                    <input type="number" name="qty" min="1" value="1">
                    <button type="submit" class="add-to-cart-btn">Add To cart</button>
                    </button>
                </form>

                <form action="{{ route('checkout.product', ['product_id' => $data->id]) }}" method="GET">
                    <button type="submit" class="add-to-cart-btn">Bayar</button>
                </form>
                <div class="product-description">{{ $data->description }}</div>
            </div>
        </div>
    </div>
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