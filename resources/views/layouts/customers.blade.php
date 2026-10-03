<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Matcha Mori')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/customer-layout.css') }}" rel="stylesheet">    

    @stack('styles')

</head>
<body>
    <div class="customer-container">
        {{--navbar--}}
        <nav class="customer-navbar">
            {{--logo--}}
            <div class="customer-logo">
                <img src="{{ asset('img/leaf1.png') }}"alt="Matcha Mori">
                <span>MATCHA MORI</span>
            </div>
            {{-- navigasi --}}
            <div class="customer-nav">
                <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    Home
                </a>

                <a href="{{ route('customer.categories.index') }}" class="{{ request()->routeIs('customer.categories.index') ? 'active' : '' }}">
                    Category
                </a>

                <a href="{{ route('customer.products.index') }}" class="{{ request()->routeIs('customer.products.index') ? 'active' : '' }}">
                    Product
                </a>

                <a href="{{ route('customer.orders.index') }}" class="{{ request()->routeIs('customer.orders.index') ? 'active' : '' }}">
                    Order
                </a>

            </div>

            {{-- icon --}}
            <div class="customer-icons">

                {{-- cari --}}
                <form action="{{ route('customer.products.index') }}" method="GET" class="customer-search">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">

                    <button type="submit" title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                {{-- keranjang --}}
                <a href="{{ route('customer.cart.index') }}" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                </a>

                {{-- profile --}}
                <div class="profile-dropdown dropdown">
                    <button class="profile-button dropdown-toggle" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </button>

                    <div class="profile-menu dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a href="{{ route('customer.profile') }}">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        
        @yield('content')

        <footer class="custom-footer">
            <span>
                Copyright &copy; Matcha Mori {{ date('Y') }}
            </span>
        </footer>

    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
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


