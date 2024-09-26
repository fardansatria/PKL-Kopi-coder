<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background: linear-gradient(90deg, #ff6b6b, #ff4757);
            color: white;
            padding: 15px 0;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container {
            width: 80%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            flex: 1;
        }

        .header-title h1 {
            margin: 0;
            padding: 0;
            margin-right: 250px;
            text-decoration: underline #ccc 3px;
            font-size: 25px;
            font-weight: 500;
        }

        .center-nav {
           display: inline-block;
        }

        .center-nav a {
            color: white;
            text-decoration: none;
            padding: 7px 5px;
            margin: 0 5px;
            font-size: 16px;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .center-nav a:hover {
            color: white;
            text-decoration: none;
        }

        .center-nav a::after {
            content: '';
            position: absolute;
            height: 2px;
            width: 0;
            bottom: 0;
            left: 60%;
            transform: translateX(-60%);
            background-color: #fff;
            transition: all .2s ease;
        }

        .center-nav a:hover::after {
            width: 70%;
        }

        .profile-dropdown {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
            justify-content: flex-end;
        }

        .dropdown-menu {
            background-color: #fff;
            border: none;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            color: #333;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .cart {
            color: white;
            font-size: 18px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .cart:hover {
            color: #ff4757;
            transform: scale(1.1);
        }

        .cart-container {
            color: white;
            text-decoration: none;
            position: relative;
        }

        .cart-container:hover .cart {
            color: #ff4757;
            transform: scale(1.1);
        }

        .cart-container:hover .cart-count {
            background-color: #fff;
            color: black;
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #333;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-title">
                <h1>Coder Store</h1>
            </div>

            <div class="center-nav">
                <a href="{{route('dashboard')}}">Home</a>
            </div>
            <div class="center-nav">
                <a href="{{route('dashboard')}}">Home</a>
            </div>
            <div class="center-nav">
                <a href="{{route('dashboard')}}">Home</a>
            </div>
            <div class="center-nav">
                <a href="{{route('dashboard')}}">Home</a>
            </div>

            <div class="profile-dropdown">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('mycart') }}" class="cart-container">
                    <i class="fa fa-shopping-bag" aria-hidden="true" class="cart"></i>
                    <span class="cart-count">{{ $count }}</span>
                </a>
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-none d-md-block dropdown-toggle ps-2"> {{Auth::user()->name}} </span>
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route('user.profile.edit')}}">
                            <i class="bi bi-person"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('user.order') }}">
                            <i class="bi bi-gear"></i> Orders
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                @endif
                @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>