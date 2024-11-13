<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(to bottom, #001355, #0029BB);
        }

        .merek-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            max-width: 100%;
            background: #0029BB;
            overflow-x: hidden;
            padding: 20px 0;
            box-shadow: 0px 6px 9px rgba(0, 0, 0, 0.87);
        }

        .merek {
            text-align: start;
            margin: 0px 15px;
            font-size: 2rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
            margin-left: 100px;
        }

        .merek-card {
            flex: 0 0 auto;
            margin: 5px 5px;
        }

        .merek-card img {
            width: 100%;
            max-width: 200px;
            height: 100px;
            object-fit: cover;
        }

        .line {
            background-color: #fff;
            width: 100%;
            height: 20px;
            
        }

        .slick-prev,
        .slick-next {
            color: #000;
        }

        .slick-prev:hover,
        .slick-next:hover {
            color: #ff4757;
        }

        .slick-dots li button:before {
            color: #333;
        }

        .slick-dots li.slick-active button:before {
            color: #ff4757;
        }

       

       
    </style>
</head>

<body>
    <div class="hero_area">
        @include('user.header-test')
    </div>
    @include('user.slider')
    @include('user.products')
    @include('user.product-terbaru')

    

    <!-- Merek Slider Section -->
    <h1 class="merek">Merek</h1>
    <div class="merek-container slider-merek" id="merek">
        @foreach($mereks as $merek)
        <div class="merek-card">
            <a href="{{ route('products.filterByBrand', $merek->slug) }}">
                <img src="{{ asset('/storage/mereks/'.$merek->image) }}" class="img-fluid rounded">
            </a>
        </div>
        @endforeach
    </div>
    <div class="line"></div>

    {{ $mereks->links() }}

    @include('user.footer')

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Slick Slider JS -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        // Initialize Slick Slider for Merek
        $('.slider-merek').slick({
            slidesToShow: 6, // Tampilkan 6 merek dalam satu baris
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            swipeToSlide: true,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4, // 4 merek untuk layar medium
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3, // 3 merek untuk layar tablet
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2, // 2 merek untuk layar ponsel
                        slidesToScroll: 1
                    }
                }
            ]
        });

        // Sweetalert message
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
            title: "GAGAL",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @endif
    </script>
</body>

</html>
