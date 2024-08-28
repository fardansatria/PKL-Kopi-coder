<!DOCTYPE html>
<html>
<head>
    <title>Halaman Utama</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            max-height: 300px; /* Atur tinggi maksimum gambar */
            width: 75%; /* Atur lebar otomatis */
            margin: 0 auto; /* Tengah-tengahkan gambar */
            margin-top: 28px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
<div id="headerCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($headerSliders as $index => $slider)
            <div class="carousel-item @if($index == 0) active @endif">
                <img class="d-block" src="{{ asset('images/' . $slider->image) }}" alt="{{ $slider->title }}">
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#headerCarousel" role="button" data-slide="prev">
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#headerCarousel" role="button" data-slide="next">
        <span class="sr-only">Next</span>
    </a>
</div>

<div id="eventCarousel" class="carousel slide mt-5" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($eventSliders as $index => $slider)
            <div class="carousel-item @if($index == 0) active @endif">
                <img class="d-block" src="{{ asset('images/' . $slider->image) }}" alt="{{ $slider->title }}">
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#eventCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#eventCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


    <!-- Sertakan jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
