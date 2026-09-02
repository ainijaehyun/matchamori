<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Matcha Mori')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    @stack('styles')

</head>

<body>

    <div class="customer-container">

        {{--navbar--}}
        <nav class="customer-navbar">

            {{--logo--}}
            <div class="customer-logo">
                <img src="{{ asset('img/leaf1.png') }}"alt="Matcha Mori">
                <span>Matcha Mori</span>
            </div>

            {{-- navigasi --}}

            <div class="customer-nav">
                <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    Home
                </a>

                <a href="#categories">
                    Category
                </a>

                <a href="{{ route('customer.products.index') }}">
                    Product
                </a>

                <a href="#orders">
                    Order
                </a>

            </div>

            {{-- icon --}}

            <div class="customer-icons">

                {{-- cari --}}
                <a href="#" title="Search">
                    <i class="fas fa-search"></i>
                </a>

                {{-- keranjang --}}
                <a href="{{ route('customer.cart.index') }}" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('customer.profile') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>

                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </div>

            </div>


        </nav>

        
        @yield('content')

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @stack('scripts')

</body>
</html>