@extends('admin.layouts.master')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                        <h1>مرحباً</h1>
                        {{-- <p>مــــــدير كافيــة الركنـــة</p> --}}
                        <p>( أ . موكشا ) مدير كافيهات الركنـــة</p>
                    </div>
                    <div>
                        <!--<a href="" class="btn btn-link btn-soft-light">
                                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.8251 15.2171H12.1748C14.0987 15.2171 15.731 13.985 16.3054 12.2764C16.3887 12.0276 16.1979 11.7713 15.9334 11.7713H14.8562C14.5133 11.7713 14.2362 11.4977 14.2362 11.16C14.2362 10.8213 14.5133 10.5467 14.8562 10.5467H15.9005C16.2463 10.5467 16.5263 10.2703 16.5263 9.92875C16.5263 9.58722 16.2463 9.31075 15.9005 9.31075H14.8562C14.5133 9.31075 14.2362 9.03619 14.2362 8.69849C14.2362 8.35984 14.5133 8.08528 14.8562 8.08528H15.9005C16.2463 8.08528 16.5263 7.8088 16.5263 7.46728C16.5263 7.12575 16.2463 6.84928 15.9005 6.84928H14.8562C14.5133 6.84928 14.2362 6.57472 14.2362 6.23606C14.2362 5.89837 14.5133 5.62381 14.8562 5.62381H15.9886C16.2483 5.62381 16.4343 5.3789 16.3645 5.13113C15.8501 3.32401 14.1694 2 12.1748 2H11.8251C9.42172 2 7.47363 3.92287 7.47363 6.29729V10.9198C7.47363 13.2933 9.42172 15.2171 11.8251 15.2171Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M19.5313 9.82568C18.9966 9.82568 18.5626 10.2533 18.5626 10.7823C18.5626 14.3554 15.6186 17.2627 12.0005 17.2627C8.38136 17.2627 5.43743 14.3554 5.43743 10.7823C5.43743 10.2533 5.00345 9.82568 4.46872 9.82568C3.93398 9.82568 3.5 10.2533 3.5 10.7823C3.5 15.0873 6.79945 18.6413 11.0318 19.1186V21.0434C11.0318 21.5715 11.4648 22.0001 12.0005 22.0001C12.5352 22.0001 12.9692 21.5715 12.9692 21.0434V19.1186C17.2006 18.6413 20.5 15.0873 20.5 10.7823C20.5 10.2533 20.066 9.82568 19.5313 9.82568Z"
                                            fill="currentColor"></path>
                                    </svg>
                                    Announcements
                                </a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iq-header-img">
        <img src="{{ url('assets/admin/images/dashboard/top-header.png') }}" alt="header"
            class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ url('assets/admin/images/dashboard/top-header1.png') }}" alt="header"
            class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ url('assets/admin/images/dashboard/top-header2.png') }}" alt="header"
            class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ url('assets/admin/images/dashboard/top-header3.png') }}" alt="header"
            class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ url('assets/admin/images/dashboard/top-header4.png') }}" alt="header"
            class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ url('assets/admin/images/dashboard/top-header5.png') }}" alt="header"
            class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
    </div>
</div>
<!-- Nav Header Component End -->
<!--Nav End-->
</div>

<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
                <div class="overflow-hidden d-slider1 ">
                    <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-01"
                                        class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                        data-min-value="0" data-max-value="100" data-value="90" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" height="24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">عـــدد المستخدمين </p>
                                        <h4 class="counter">{{ $users }}</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-02"
                                        class="text-center circle-progress-01 circle-progress circle-progress-info"
                                        data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2"> عدد العملاء</p>
                                        <h4 class="counter">{{ $clints }}</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-03"
                                        class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                        data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                                        <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">المنتجـات</p>
                                        <h4 class="counter">{{ $products }}</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-04"
                                        class="text-center circle-progress-01 circle-progress circle-progress-info"
                                        data-min-value="0" data-max-value="100" data-value="60" data-type="percent">
                                        <svg class="card-slie-arrow " width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">الأوردرات</p>
                                        <h4 class="counter">{{ $orders }}</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div id="circle-progress-05"
                                        class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                        data-min-value="0" data-max-value="100" data-value="50" data-type="percent">
                                        <svg class="card-slie-arrow " width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                        </svg>
                                    </div>
                                    <div class="progress-detail">
                                        <p class="mb-2">الأصناف</p>
                                        <h4 class="counter">{{ $categories }}</h4>
                                    </div>
                                </div>
                            </div>
                        </li>



                    </ul>
                   

                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="conatiner">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <center>

                    <img src="{{ asset('assets\admin\images\logo.png')}}" width="220px">
                    <h1>
                        منصـة حســاباتي
                        <br>
                        نظــــــــــــــــــــام متكامــــــــــــل لمتابعــــــــــة الحسابات
                    </h1>
                </center>
                {{-- <hr /><br> --}}
            </div>
            {{-- <div class="col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart1" style="width:100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart2" style="width:100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart3" style="width:100%;"></canvas>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
</div>








<script>
var xValues = ["", "يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
var yValues = [0, 2000, 1400, 1600, 1500, 1800, 2000, 1200, 1400, 1800, 1500, 1200, 1900];
var barColors = ["", "#3a57e8", "#3a57e8","#3a57e8","#3a57e8","#3a57e8", "#3a57e8", "#3a57e8","#3a57e8","#3a57e8","#3a57e8", "#3a57e8", "#3a57e8"];

new Chart("myChart1", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "الصف الاول الثانوي - تقرير الارباح الشهرية"
    }
  }
});

//=================================================================================================
var xValues2 = ["", "يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
var yValues2 = [0, 2000, 1400, 1600, 1500, 1800, 2000, 1200, 1400, 1800, 1500, 1200, 1900];
var barColors2 = ["", "#3a57e8", "#3a57e8","#3a57e8","#3a57e8","#3a57e8", "#3a57e8", "#3a57e8","#3a57e8","#3a57e8","#3a57e8", "#3a57e8", "#3a57e8"];

new Chart("myChart2", {
  type: "bar",
  data: {
    labels: xValues2,
    datasets: [{
      backgroundColor: barColors2,
      data: yValues2
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "تقرير الارباح الشهرية - الصف الثاني الثانوي"
    }
  }
});

//=================================================================================================
var xValues3 = ["", "يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
var yValues3 = [0, 2000, 1400, 1600, 1500, 1800, 2000, 1200, 1400, 1800, 1500, 1200, 1900];
var barColors3 = ["", "#3a57e8", "#3a57e8","#3a57e8","#3a57e8","#3a57e8", "#3a57e8", "#3a57e8","#3a57e8","#3a57e8","#3a57e8", "#3a57e8", "#3a57e8"];

new Chart("myChart3", {
  type: "bar",
  data: {
    labels: xValues3,
    datasets: [{
      backgroundColor: barColors3,
      data: yValues3
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "تقرير الارباح الشهرية - الصف الثالث الثانوي"
    }
  }
});
</script>
@endsection