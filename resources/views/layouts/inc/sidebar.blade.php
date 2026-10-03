
<div class="custom-sidebar">

    {{-- LOGO --}}
    <div class="custom-sidebar-logo">
        <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
        <span>MATCHA MORI</span>
    </div>


    <ul class="custom-menu">

        {{-- DASHBOARD --}}
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="custom-divider">


        {{-- MANAGEMENT --}}
        <div class="custom-menu-title">
            MANAGEMENT
        </div>


        {{-- CATEGORY --}}
        <li>
            <a href="{{ route('admin.categories.index') }}"
               class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Category</span>
            </a>
        </li>


        {{-- PRODUCT --}}
        <li>
            <a href="{{ route('admin.products.index') }}"
               class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-cube"></i>
                <span>Product</span>
            </a>
        </li>


        {{-- ORDER --}}
        <li>
            <a href="{{ route('admin.orders.index') }}"
               class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                <span>Order</span>
            </a>
        </li>


        {{-- CUSTOMER --}}
        <li>
            <a href="{{ route('admin.customers.index') }}"
               class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Customer</span>
            </a>
        </li>


        <hr class="custom-divider">


        {{-- REPORT --}}
        <div class="custom-menu-title">
            REPORT
        </div>


        {{-- SALES REPORT --}}
        <li>
            <a href="{{ route('admin.reports.index') }}"
               class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Sales Report</span>
            </a>
        </li>

    </ul>

</div>