<!DOCTYPE html>
<html>
<head>
    <title>Halaman Utama</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            max-height: 410px; 
            width: 100%; 
            margin: 0 auto; 
            margin-top: 0px;
            border-radius: 0px;
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
    <div class="slide">
    <a class="carousel-control-prev visibility-hidden" href="#headerCarousel" role="button" data-slide="prev">
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next  visibility-hidden" href="#headerCarousel" role="button" data-slide="next">
        <span class="sr-only">Next</span>
    </a>
    </div>
</div>

<div id="eventCarousel" class="carousel slide mt-5" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($eventSliders as $index => $slider)
            <div class="carousel-item @if($index == 0) active @endif">
                <img class="d-block" src="{{ asset('images/' . $slider->image) }}" alt="{{ $slider->title }}">
            </div>
        @endforeach
    </div>
    <div class="slide">
    <a class="carousel-control-prev  visibility-hidden d-none" href="#eventCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next  visibility-hidden d-none" href="#eventCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    </div>
</div>


    <!-- Sertakan jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
