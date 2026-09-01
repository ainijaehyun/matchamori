<nav class="navbar navbar-expand navbar-light matcha-navbar">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('img/undraw_profile_1.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
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
                        </li>

                    </ul>

                </nav>

<style>
    .matcha-navbar {

        height: 75px;

        background: #b9df9f;

        display: flex;

        align-items: center;

        justify-content: flex-end;

        padding: 0 25px;

        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
        z-index: 900;
    }



    .navbar-toggle {

        border: none;

        background: transparent;

        color: #333;

        font-size: 20px;

        cursor: pointer;

        padding: 8px 12px;

    }


    .navbar-toggle:hover {

        color: #006b00;

    }




    .navbar-right {

        margin-left: auto;

        display: flex;

        align-items: center;

    }




    .user-menu {

        display: flex;

        align-items: center;

        text-decoration: none;

        padding: 8px 5px;

    }


    .user-name {

        color: #333;

        font-size: 15px;

        margin-right: 12px;

    }


    .user-image {

        width: 40px;

        height: 40px;

        object-fit: contain;

    }



    .profile-dropdown {

        min-width: 170px;

        border: none;

        border-radius: 10px;

        padding: 8px 0;

        box-shadow: 0 5px 15px rgba(0,0,0,0.15);

    }


    .profile-dropdown .dropdown-item {

        display: flex;

        align-items: center;

        padding: 10px 18px;

        color: #333;

        font-size: 14px;

    }


    .profile-dropdown .dropdown-item i {

        width: 25px;

        margin-right: 8px;

        color: #777;

    }


    .profile-dropdown .dropdown-item:hover {

        background: #e5f3d7;

        color: #111;

    }


    .profile-dropdown .dropdown-divider {

        margin: 5px 15px;

    }
    .img-profile {
            width: 38px !important;
            height: 38px !important;
            object-fit: cover;
        }

        .topbar .nav-link {
            padding: 0.5rem 0.75rem;
        }


    /* ==========================================
    RESPONSIVE
    ========================================== */

    @media (max-width: 768px) {

        .matcha-navbar {

            padding: 0 15px;

        }

        .user-name {

            display: none;

        }

    }

</style>