<!doctype html>
<html lang="en" dir="rtl">
    <!-- ======= sidebar content ======= -->
    @include('admin.layouts.head')

    <body class="  ">
        <!-- loader Start -->
         <!-- <div id="loading">
            <div class="loader simple-loader">
                <div class="loader-body"></div>
            </div>
         </div>  -->
        <!-- loader END -->
        <!-- ======= sidebar content ======= -->
        @include('admin.layouts.sidebar')

        <main class="main-content">
            <div class="position-relative iq-banner">
                <!--Nav Start-->
                <!-- ======= settings content ======= -->
                @include('admin.layouts.navbar')
                @include('admin.layouts.toaster')
                <!-- ======= main content ======= -->
                <!-- ======= main content ======= -->
                @yield('content')
                <!-- ======= settings content ======= -->
                @include('admin.layouts.footer')
        </main>
        <!-- ======= settings content ======= -->
        @include('admin.layouts.settings')
        <!-- ======= scripts content ======= -->
        @include('admin.layouts.scripts')
    </body>

</html>