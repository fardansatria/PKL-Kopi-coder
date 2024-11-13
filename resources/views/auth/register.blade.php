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
        min-height: 120vh;
        background: linear-gradient(45deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 27%, rgba(0, 212, 255, 1) 100%);
        overflow: hidden;
    }

    .form-box {
        background-color: #e5e7eb;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 15px 15px 25px 4px rgba(0, 0, 0, 0.87);
        webkit-box-shadow: 15px 15px 25px 4px rgba(0, 0, 0, 0.87);
        moz-box-shadow: 15px 15px 25px 4px rgba(0, 0, 0, 0.87);
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
    }

    .form-header h2 {
        font-size: 1.25rem;
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

    .back-home {
        display: flex;
        align-items: center;
        margin-top: 16px;
    }
    .note {
        display: flex;
        align-items: center;
        margin-top: 1px;
    }

    .back-home a {
        text-decoration: none;
        color: #2563eb;
    }

    .back-home a:hover {
        text-decoration: underline;
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
        top: 65%;
        left: 865px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 20px;
        color: #6b7280;
    }
</style>

<div class="container">
    <div class="form-box">
        <div class="form-header">
            <div>
                <h1>Coder Store</h1>
                <h2>Register</h2>
                <p>Continue to Coder Store</p>
            </div>
            <img src="{{ asset('/storage/web_image/coder.jpg') }}" alt="Coder Store" style="height: 80px; width: 80px; object-fit: contain;">
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="('username')" />
                <x-text-input id="name" class="form-input" type="name" name="name" :value="old('name')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 " />
            </div>

            <div>
                <x-input-label for="email" :value="('email')" />
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

            <div class="form-group">
                <x-input-label for="password-confirmation" :value="('Confirm Password')" />
                <x-text-input id="password_confirmation" class="form-input" type="password" name="password_confirmation"
                    required autocomplete="new-password" />
                <!-- <span class="material-icons toggle-password" onclick="togglePasswordVisibility()">visibility</span> -->
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Back Home -->
            <div class="back-home">
                <a href="{{url('/')}}">Back Home</a>
            </div>
            <div class="note">
                <p>Note: Verifikasi email akan di kirimkan ke email yang diisi</p>
            </div>

            <div class="form-footer">
                <a class="link" href="{{ route('login') }}">
                    {{ __('Sudah punya akun?') }}
                </a>

                <button class="btn" type="submit">
                    {{ __('Register') }}
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
            toggleIcon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = 'visibility';
        }
    }
</script>