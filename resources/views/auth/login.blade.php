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
                    <!-- <img src="{{ asset('assets\admin\images\logo.png')}}" width="100px"> -->
                    <img src="https://scontent.fcai19-3.fna.fbcdn.net/v/t39.30808-6/454449345_122132817914308884_7008900131491947585_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=peDVIzw0V4AQ7kNvwFMb8sU&_nc_oc=Adn2FM9GaqB95riTbRiDpACYhgEjFt2t0kRgZxPt3tVjtrq-f_BPGWG_td2VHGRzCf8&_nc_zt=23&_nc_ht=scontent.fcai19-3.fna&_nc_gid=uVVC5QGbpFzeFWaaf8H3Ww&oh=00_AfR7Ev4rFhTcAZqn02E3B6wJo7ziglbOvNHHf2cdYnRFUQ&oe=6891E85D" width="100px">
                    
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

            <x-primary-button class="ml-3" style="background-color: rgb(234, 124, 21);">
                تسجيل الدخول
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>


