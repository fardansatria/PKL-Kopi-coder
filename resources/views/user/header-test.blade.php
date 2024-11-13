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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'opensans', sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }

        header {
            background: transparent;
            color: white;
            height: 200px;
            padding: 20px 0;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Search Bar */
        .search-bar {
            margin: 20px auto;
            width: 600px;
            text-align: center;
            border: none;
            position: relative;
        }

        .search-bar input[type="text"] {
            width: 100%;
            padding: 5px;
            border: none;
        }

        .search-bar button {
            padding: 40px;
            border: none;
            background-color: #00b0ff;
            color: white;
        }

        .container-header {
            width: 90%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Coder Store */
        .header-title h1 {
            margin: 0;
            padding: 0;
            font-size: 2rem;
            font-weight: 300;
            color: white;
            left: 30px;
            font: serif;
        }

        /* Mengatur Garis */
        .horizontal-line {
            border: none;
            height: 4px;
            background-color: white;
            margin: 20px 10px;
            position: relative;
            top: 10px;
        }

        /* Product & Flash Sale */
        .center-nav {
            display: inline-block;
        }

        .center-nav a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 7px 5px;
            margin: 0 5px;
            font-size: 1.5rem;
            position: relative;
            transition: background-color 0.3s ease;
            right: -280px;
            position: relative;
            top: 1px;
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
            left: 50%;
            transform: translateX(-50%);
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

        .login {
            color: #f4f4f4;
            font-size: 1.2rem;
        }

        .login:hover {
            color: #f4f4f4;
            text-underline-offset: 8px;
        }

        .register {
            color: #f4f4f4;
            font-size: 1.2rem;
        }

        .register:hover {
            color: #f4f4f4;
            text-underline-offset: 8px;
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
        <div class="container-header">
            <div class="header-title">
                <h1>Coder Store</h1>
            </div>
            <form action="{{ url('user/search') }}" method="GET">
                <div class="search-bar">
                    <input type="text" name="query" id="search" value="{{ request('query') }}" placeholder="cari produk">
                </div>
            </form>

            <div class="profile-dropdown">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('mycart') }}" class="cart-container">
                    <i class="fa fa-shopping-bag cart" aria-hidden="true"></i>
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
                        <a class="dropdown-item" href="{{route('user.order')}}">
                            <i class="bi bi-person"></i>Orders
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i> Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                @else
                <a href="{{ route('login') }}" class="login">Log in</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="register">Register</a>
                @endif
                @endauth
                @endif
            </div>
        </div>
        <div class="horizontal-line"></div>
        <div class="center-nav">
            <a href="{{url('/')}}#product">Product</a>
        </div>
        <div class="center-nav">
            <a href="{{url('/')}}#merek" class="scroll-to-products">Merek</a>
        </div>
        <div class="center-nav">
            <a href="{{url('/')}}#product-baru" class="scroll-to-products">Produk Baru</a>
        </div>
    </header>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const hash = window.location.hash;
        if (hash) {
            const target = document.querySelector(hash);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
</script>

</html>