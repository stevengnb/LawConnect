<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    @yield('custom-styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary px-5" style="position: fixed; width: 100%;">
        <div class="container-fluid">
          <a class="navbar-brand" href="#" style="width: 10%">
            <img src="{{ asset('LawConnect-Horizontal.png') }}" style="width: 100%" alt="">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('getLawyers') }}">Lawyers/Consultant</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="articles">Articles</a>
              </li>
            </ul>

            <div class="dropdown d-flex">
                <a class="profile-img" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::guard('lawyer')->check())
                    <img src="{{Storage::url(Auth::guard('lawyer')->user()->profile)}}" alt="">

                    @else
                    <img src="{{Storage::url(Auth::user()->profile)}}" alt="">
                    @endif

                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="d-grid">
                            <button class="dropdown-item d-flex align-items-center" type="submit"><i class="bi bi-box-arrow-right me-2 d-flex"></i>Logout</button>
                        </div>
                    </form>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </nav>
    @yield('content')
    <footer>
        <div class="part">
            <div class="part-one-top">
                <div class="part-in-one"><img src="{{ asset('LawConnect-Logo.png') }}" height="35px" alt="LawConnect Logo"></div>
                <p class="part-in-two">LawConnect is a web-based platform enabling users to book legal consultations easily, access educational law articles, and connect with verified lawyers, enhancing accessibility, transparency, and public legal literacy in Indonesia.</p>
                <div class="part-in-three">
                    <p>More about us</p>
                    <img src="{{ asset('arrow-right.png') }}" height="20px" alt="LawConnect Logo">
                </div>
            </div>
            <div>&copy; 2024 LawConnect. All rights reserved.</div>
        </div>
        <div class="part">
            <div class="part-two-top">
                <div class="part-component">
                    <p>Features</p>
                    <div class="part-component-body">
                        <p>Book a lawyer</p>
                        <p>Legal Resources</p>
                        <p>Articles</p>
                    </div>
                </div>
                <div class="part-component">
                    <p>More</p>
                    <div class="part-component-body">
                        <p>Help Center</p>
                        <p>Contact House</p>
                        <p>Feedback</p>
                    </div>
                </div>
                <div class="part-component">
                    <p>Legal</p>
                    <div class="part-component-body">
                        <p>Privacy</p>
                        <p>Terms</p>
                        <p>Refunds</p>
                    </div>
                </div>
            </div>
            <div>Made by Carissa, Hans, Nathan, Steven, Yoseftian</div>
        </div>
    </footer>
    {{-- Bootstrap JS Below --}}
</body>
</html>