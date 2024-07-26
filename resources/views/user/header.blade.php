<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" value="Logout">
                </form>
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
</body>

</html>