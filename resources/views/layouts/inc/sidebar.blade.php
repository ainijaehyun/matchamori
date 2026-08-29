<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Matcha Mori</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Management -->
            <div class="sidebar-heading">
                MANAGEMENT
            </div>

            <!-- CATEGOIRES-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Category</span>
                </a>
            </li>

            <!-- PRODUCTS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Product</span>
                </a>
            </li>

            <!-- ORDERS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Order</span>
                </a>
            </li>

            <!-- CUSTOMERS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.customers.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Customer</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- REPORT -->
            <div class="sidebar-heading">
                REPORT
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Sales Report</span>
                </a>
            </li>
        </ul>