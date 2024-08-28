<section>
    <header class="mb-4">
        <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
            <div class="mt-1">
                <input id="name" name="name" type="text" class="block w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" :value="old('name', $name->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" class="block w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800">{{ __('Your email address is unverified.') }}</p>
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Click here to re-send the verification email.') }}</button>
                    </div>

                    @if (session('status') === 'Resend Verification Email')
                        <p class="mt-2 font-medium text-sm text-green-600">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>