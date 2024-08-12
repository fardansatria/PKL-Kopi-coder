<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 200px;
            margin: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            width: 100%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .product-info {
            padding: 10px;
        }

        .product-title {
            font-size: 18px;
            font-weight: bold;
        }

        .product-price {
            color: #28a745;
            font-size: 16px;
        }
        .product-description {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .btn {
            background-color: #333;
            width: 60px;
            height: 30px;
            margin-left: 35%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn a {
            text-decoration: none;
            color: #fff;
        }

    </style>
</head>

<body>
    <h1>Our Products</h1>
    <div class="product-container">
        <div class="product-card">
            <img src="{{ asset('/storage/products/' . $data->image) }}" alt="{{ $data->name }}" class="product-image">
            <div class="product-info">
                <div class="product-title">{{ $data->name }}</div>
                <div class="product-price">RP {{ $data->price }}</div>
                <div class="product-description">{{ Str::limit($data->description) }}</div>  
            </div>
        </div>
    </div>
</body>

</html>