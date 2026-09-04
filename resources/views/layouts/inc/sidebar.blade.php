<style>
    .custom-sidebar {
        width: 250px;
        min-width: 250px;
        min-height: 100vh;
        background: rgb(0, 85, 0);
        position: relative;
        padding: 25px 12px;
        box-sizing: border-box;
        flex-shrink: 0;
        
    }

    /* LOGO */
    .custom-sidebar-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2px;
        padding: 10px 5px 25px;
        border-bottom: 1px solid rgba(255,255,255,0.25);
    }

    .custom-sidebar-logo img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .custom-sidebar-logo span {
        color: white;
        font-size: 25px;
        font-weight: bold;
        white-space: nowrap;
    }

    /* MENU */
    .custom-menu {
        list-style: none;
        padding: 0;
        margin: 25px 0 0;
    }

    .custom-menu-title {
        color: #b9e59c;
        font-size: 12px;
        font-weight: bold;
        margin: 25px 20px 12px;
    }

    .custom-menu li {
        margin-bottom: 8px;
    }

    .custom-menu a {
        display: flex;
        align-items: center;
        gap: 18px;
        color: white;
        text-decoration: none;
        padding: 14px 20px;
        border-radius: 10px;
        font-size: 16px;
        transition: 0.2s;
    }

    .custom-menu a:hover,
    .custom-menu a.active {
        background: #c5e8a7;
        color: #111;
    }

    .custom-menu i {
        width: 22px;
        text-align: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .custom-divider {
        border: 0;
        border-top: 1px solid rgba(255,255,255,0.25);
        margin: 18px 12px;
    }

    .page-wrapper {
        position: relative;
        min-height: 100vh;
    }
</style>


<div class="custom-sidebar">

    {{-- LOGO --}}
    <div class="custom-sidebar-logo">
        <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
        <span>Matcha Mori</span>
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