<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<nav id="navbar" class="navbar navbar-expand-lg navbar-transparant  navbar-transparent">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center mt-1" id="navbarNav">
            <ul class="navbar-nav d-flex align-items-center">
                {{-- <li class="nav-item justify-content-start">
                    <a class="navbar-brand me-5" href="#">
                        <img src="{{ asset('template/dist/assets/compiled/png/medical_life.png') }}" alt="Logo">
                    </a>
                </li> --}}
                <li class="nav-item me-5 justify-content-end" >
                    <h1 style="font-size: 24px; color: #ED127C; margin: 0;">MedicaLife</h1> <!-- Added Medicalife text -->
                </li>

                <li class="nav-item me-5">
                    <a class="nav-link" href="/#shop" style="color: #ED127C; font-size: 18px;">Shop</a>
                </li>
                {{-- <li class="nav-item">

                    <a class="nav-link" href="#about-us" style="color: #7D0A0A; font-size: 18px;">About Us</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link me-5" href="/cart" style="color: #ED127C; font-size: 18px;">
                        <i class="bi bi-cart-fill"></i>
                        @if ($cartCount > 0)
                            <span class="position-relative d-inline-block ms-2">
                                <span
                                    class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">
                                    {{ $cartCount }}
                                </span>
                            </span>
                        @endif
                    </a>
                </li>


                <li class="nav-item">
                    @if (Route::has('login'))
                        @auth
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="color: #ED127C; font-size: 18px;">
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a href="{{ url('/') }}" class="dropdown-item"
                                            style="color: #ED127C; font-size: 18px;
                            ">Home</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item"  style="color: #ED127C; font-size: 18px;">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="nav-link"
                                 style="color:#ED127C; font-size: 18px;">Login</a>


                            {{-- <a href="{{ route('login') }}" class="nav-link me-5"
                                style="color: #ffffff; font-size: 18px;">Sign In</a> --}}
                        @endauth
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- <script>
    window.onscroll = function() {
        var navbar = document.getElementById("navbar");
        if (window.pageYOffset > 50) { // Jika scroll lebih dari 50px
            navbar.classList.add("bg-dark");
            navbar.classList.remove("navbar-transparent");
        } else {
            navbar.classList.remove("bg-dark");
            navbar.classList.add("navbar-transparent");
        }
    };
</script> --}}
<style>
    .badge {
        font-size: 0.75rem;
        padding: 0.3em 0.6em;
        border-radius: 1rem;
    }

    .position-relative {
        position: relative;
    }

    .position-absolute {
        position: absolute;
    }
</style>
<!-- Bootstrap JS -->
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
