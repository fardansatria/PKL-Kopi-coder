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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        nav {
            float: right;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 7px 15px;
            display: inline-block;
        }

        nav a:hover {
            background-color: #575757;
        }

        .header-title {
            float: left;
        }

        .header-title h1 {
            margin: 0;
            padding: 0;
        }

        .header-title h2 {
            margin: 0;
            padding: 0;
            font-size: 14px;
            color: #d3d3d3;
        }

        form {
            display: inline;
        }

        form input[type="submit"] {
            background-color: #ff2d20;
            color: white;
            border: none;
            padding: 7px 15px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #e0261b;
        }

        .profile {
            float: right;
            margin-left: 15px;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-title">
                <h1>Halaman User</h1>
                <h2>Kamu bisa melihat-lihat disini</h2>
            </div>

            @if (Route::has('login'))
            <nav>
                @auth
                <a href="{{ url('mycart') }}">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    {{ $count }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" value="Logout">
                </form>
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-none d-md-block dropdown-toggle ps-2"> {{Auth::user()->name}} </span>
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route('user.profile.show')}}">
                            <i class="bi bi-person"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
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
            </nav>
            @endif
        </div>
    </header>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
