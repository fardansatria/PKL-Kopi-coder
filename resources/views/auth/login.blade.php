<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<style>
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(45deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 27%, rgba(0, 212, 255, 1) 100%);
        overflow: hidden;
    }

    .form-box {
        background-color: #e5e7eb;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 15px 15px 25px 4px rgba(0,0,0,0.87);
        webkit-box-shadow: 15px 15px 25px 4px rgba(0,0,0,0.87);
        moz-box-shadow: 15px 15px 25px 4px rgba(0,0,0,0.87);
        width: 25rem;
        max-width: 90%;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .form-header h1 {
        font-size: 2rem;
        font-weight: bold;
        position: relative;
        top: -10px;
    }

    .form-header h2 {
        font-size: 1.55rem;
    }

    .form-header p {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .form-input {
        padding: 14px;
        margin-top: 8px;
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group {
        margin-top: 16px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-top: 15px;
    }

    .checkbox-group input {
        margin-right: 5px;
    }

    .link {
        font-size: 0.875rem;
        color: #2563eb;
        text-decoration: none;
    }

    .link:hover {
        text-decoration: underline;
    }

    .btn {
        padding: 12px 24px;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 16px;
    }

    .btn:hover {
        background-color: #1e40af;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
    }

    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 16px;
    }

    .toggle-password {
        position: absolute;
        top: 62%;
        left: 875px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 20px;
        color: #6b7280;
    }

    /* Mengatur Garis */
    .horizontal-line {
            border: none;
            height: 3px;
            background-color: black;
            margin: 0px -40px;
            right: -40px;
            position: relative;
            top: -50px;
    }


</style>

<div class="container">
    <div class="form-box">
        <div class="form-header">
            <div>
                <h1>Coder Store</h1>
                <div class="horizontal-garis"></div>
                <p>Continue to Coder Store</p>
                <div class="horizontal-line"></div>
            </div>
            <img src="{{ asset('/storage/web_image/coder.jpg') }}" alt="Coder Store" style="height: 120px; width: 120px; object-fit: contain; border-radius: 5px;">
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="('Email')" />
                <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 " />
            </div>

            <!-- Password -->
            <div class="form-group">
                <x-input-label for="password" :value="('Password')" />
                <x-text-input id="password" class="form-input" type="password" name="password"
                    required autocomplete="current-password" />
                    <!-- <span class="material-icons toggle-password" onclick="togglePasswordVisibility()">visibility</span> -->
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="checkbox-group">
                <label for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="form-footer">
                @if (Route::has('password.request'))
                <a class="link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
                <a class="link" href="{{ route('register') }}">
                    {{ __('Sign In') }}
                </a>

                <button class="btn" type="submit">
                    {{ __('Log in') }}
                </button>


            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = 'visibility_off'; // Ganti ikon menjadi mata tertutup
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = 'visibility'; // Ganti ikon menjadi mata terbuka
        }
    }
</script>