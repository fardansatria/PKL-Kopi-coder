<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Cards</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: left;
            font-size: 2rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 20px;
        }

        

        .container-product-terbaru {
            justify-content: center; 
            align-items: center;
            margin: 0 auto;
            max-width: 1200px;
            padding: 0 15px;
        }

        .product-card-baru {
            padding: 30px;
            margin: 10px;
            position: relative;
            width: calc(20% - 25px);
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

        .product-card-baru:hover {
            transform: scale(1.03);
            border: 1px solid #000;
            backdrop-filter: none;
        }

        .product-card-baru a{
            text-decoration: none;
        }
        .product-image-baru {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .product-info-baru {
            padding: 10px;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 500;
            margin: 0;
            color: #333;
        }

        .product-price {
            color: #2596be;
            font-size: 1rem;
            font-weight: 600;
            margin: 10px 0;
        }

        .btn-cart-form-baru {
            position: absolute;
            bottom: -45px;
            left: 50%;
            transform: translateX(-50%);
            transition: bottom 0.3s;
        }

        .product-card-baru:hover .btn-cart-form-baru {
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

        .product-rating-baru {
            margin-top: 5px;
            font-size: 0.9rem;
            color: #333;
        }

        .stars {
            color: #ffd700;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <h1 id="product-baru">Produk Terbaru</h1>
    <div class="product-baru">
    <div class="container-product-terbaru">
        <div class="slider-products">
            @foreach($latestProducts as $product)
            <div class="product-card-baru">
                <a href="{{ url('product_detail', $product->id) }}">
                    <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="product-image-baru">
                    <div class="product-info-baru">
                        <div class="product-title">{{ Str::limit($product->title, 20) }}</div>
                        <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="product-rating-baru">
                        <span class="stars">★</span>
                        <span>4,5 | 1 Terjual</span>
                    </div>
                </a>
                <form action="{{ url('add_cart', $product->id) }}" method="POST" class="btn-cart-form-baru">
                    @csrf
                    <button type="submit" class="btn-cart">
                        <i class="fa fa-shopping-cart"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $('.slider-products').slick({
            slidesToShow: 4, // Tampilkan 4 produk dalam satu baris
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            swipeToSlide: true,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    </script>
</body>

</html>
