<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="hero_area">
        @include('user.header')
        @if(session('status'))
        <div class="alert alert-success" id="status-alert">
            {{ session('status') }}
        </div>
        @endif
    </div>
    @include('user.slider')

    @include('user.products')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
           
            setTimeout(function() {
                var statusAlert = document.getElementById('status-alert');
                if (statusAlert) {
                    statusAlert.style.display = 'none';
                }
            }, 5000); 
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>