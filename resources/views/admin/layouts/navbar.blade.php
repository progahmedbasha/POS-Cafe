<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
    <div class="container-fluid navbar-inner">
        <a href="dashboard/index.html" class="navbar-brand">
            <!--Logo start-->
            <svg width="30" class="text-primary" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)"
                    fill="currentColor" />
                <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)"
                    fill="currentColor" />
                <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)"
                    fill="currentColor" />
                <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)"
                    fill="currentColor" />
            </svg>
            <!--logo End-->
            <h4 class="logo-title"></h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20px" height="20px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
            </i>
        </div>
        <!--<div class="input-group search-input">
                    <span class="input-group-text" id="search-input">
                        <svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></circle>
                            <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input type="search" class="form-control" placeholder="Search...">
                </div>-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="mt-2 navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ url('assets/admin/images/avatars/01.png') }}" alt="User-Profile"
                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ url('assets/admin/images/avatars/avtar_1.png') }}" alt="User-Profile"
                            class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ url('assets/admin/images/avatars/avtar_2.png') }}" alt="User-Profile"
                            class="theme-color-blue-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ url('assets/admin/images/avatars/avtar_4.png') }}" alt="User-Profile"
                            class="theme-color-green-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ url('assets/admin/images/avatars/avtar_5.png') }}" alt="User-Profile"
                            class="theme-color-yellow-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ url('assets/admin/images/avatars/avtar_3.png') }}" alt="User-Profile"
                            class="theme-color-pink-img img-fluid avatar avatar-50 avatar-rounded">
                        <div class="caption ms-3 d-none d-md-block ">
                            {{-- <h6 class="mb-0 caption-title">{{ Auth::user()->name }}</h6> --}}
                            {{-- <p class="mb-0 caption-sub-title">{{ Auth::user()->userType->type}}</p> --}}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">البيانات الشخصية</a></li>
                        <!--<li><a class="dropdown-item" href="dashboard/app/user-privacy-setting.html">Privacy
                                        Setting</a>
                                </li>-->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="icon">
                                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4"
                                            d="M2 6.447C2 3.996 4.03024 2 6.52453 2H11.4856C13.9748 2 16 3.99 16 6.437V17.553C16 20.005 13.9698 22 11.4744 22H6.51537C4.02515 22 2 20.01 2 17.563V16.623V6.447Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M21.7787 11.4548L18.9329 8.5458C18.6388 8.2458 18.1655 8.2458 17.8723 8.5478C17.5802 8.8498 17.5811 9.3368 17.8743 9.6368L19.4335 11.2298H17.9386H9.54826C9.13434 11.2298 8.79834 11.5748 8.79834 11.9998C8.79834 12.4258 9.13434 12.7698 9.54826 12.7698H19.4335L17.8743 14.3628C17.5811 14.6628 17.5802 15.1498 17.8723 15.4518C18.0194 15.6028 18.2113 15.6788 18.4041 15.6788C18.595 15.6788 18.7868 15.6028 18.9329 15.4538L21.7787 12.5458C21.9199 12.4008 21.9998 12.2048 21.9998 11.9998C21.9998 11.7958 21.9199 11.5998 21.7787 11.4548Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name"> تسجيل الخروج</span>
                            </a>
                        </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>