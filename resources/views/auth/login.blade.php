<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tajawal">
        <!-- Styles -->
        <style>
             body , h1, h2, h3, h4, h5, h6, p, label {
    font-family: 'Tajawal', sans-serif;
}

input[type=button], button {
    font-family: 'Tajawal', sans-serif !important;
    font-size:12px !important;
}
</style>

<x-guest-layout>


<div class="flex justify-center">
                    <img src="{{ asset('assets\admin\images\logo.png')}}" width="100px">
                    
                </div>
                <center>
                    <p style="font-size:30px;color: brown;">منصة حساباتي</p>
                    <p style="color: white;">متابعة الحسابات</p>
                    <br>
                    
                </center>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
        <label for="password" style="float:right;"> البريد الالكتروني</label>
            <x-text-input id="email" style="text-align:right;" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')"  class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
           <label for="password" style="float:right;">كلمة المرور</label>

            <x-text-input id="password" class="block mt-1 w-full" style="text-align:right;"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
           <!-- <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>-->
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
              <!--  <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>-->
            @endif

            <x-primary-button class="ml-3" style="background-color: #1a95bb;">
                تسجيل الدخول
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>


