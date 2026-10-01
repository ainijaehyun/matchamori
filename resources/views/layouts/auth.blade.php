<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>


<body class="auth-page">
    <div class="auth-background"></div>
    <div class="auth-overlay"></div>
    <div class="auth-wrapper">
        @yield('content')
    </div>

    @yield('scripts')   
    
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>

<style>

    .auth-page {
        margin: 0;
        min-height: 100vh;
        position: relative;
        font-family: Georgia, "Times New Roman", serif;
        background: #e4efdc;
        overflow-x: hidden;
    }


    /* FOTO BACKGROUND */
    .auth-background {
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/leafmatcha.jpg') }}');
        background-size: cover;
        background-position: center;
        filter: blur(2px);
        transform: scale(1.03);
        z-index: 0;
    }


    /* LAPISAN LEMBUT DI ATAS FOTO */
    .auth-overlay {
        position: fixed;
        inset: 0;
        background: rgba(232, 241, 224, .78);
        z-index: 1;
    }

    /* PEMBUNGKUS FORM */
    .auth-wrapper {
        position: relative;
        z-index: 2;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 20px;
        box-sizing: border-box;
    }


    .auth-card {
        width: 470px;
        max-width: 100%;
        background: rgba(248, 250, 242, .97);
        border-radius: 25px;
        box-shadow:
            0 12px 35px rgba(42, 65, 38, .18);
        padding: 35px 45px;
        box-sizing: border-box;
    }



    .auth-title {
        margin: 0;
        color: #111;
        text-align: center;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 27px;
        font-weight: normal;
    }
    .auth-subtitle {
        margin: 7px 0 35px;
        color: #333;
        text-align: center;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 17px;
    }


    .auth-input {
        position: relative;
        margin-bottom: 17px;
    }
    .auth-input i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #111;
        font-size: 17px;
        z-index: 2;
    }
    .auth-input input,
    .auth-input textarea {
        width: 100%;
        min-height: 42px;
        padding: 10px 42px 10px 52px;
        border: 1px solid #222;
        border-radius: 5px;
        background: #f5f5f5;
        color: #333;
        font-family: Arial, sans-serif;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }
    .auth-input input:focus,
    .auth-input textarea:focus {
        border-color: #4f6945;
        box-shadow: 0 0 0 2px rgba(79, 105, 69, .12);
    }

    .password-wrapper {
        position: relative;
    }
    .password-wrapper .toggle-password {
        position: absolute;
        right: 16px;
        left: auto;
        top: 50%;
        transform: translateY(-50%);
        color: #111;
        cursor: pointer;
        z-index: 3;
    }

    .auth-button {
        width: 100%;
        height: 42px;
        margin-top: 18px;
        border: 1px solid #304a2f;
        border-radius: 5px;
        background: #304a2f;
        color: #fff;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: .2s ease;
    }
    .auth-button:hover {
        background: #253b24;
        border-color: #253b24;
    }


    .auth-bottom {
        margin-top: 23px;
        text-align: center;
        color: #333;
        font-family: Arial, sans-serif;
        font-size: 13px;
    }
    .auth-bottom a {
        color: #304a2f;
        font-weight: 600;
        text-decoration: none;
    }
    .auth-bottom a:hover {
        color: #172516;
        text-decoration: underline;
    }


    @media (max-width: 600px) {

        .auth-wrapper {
            padding: 30px 15px;
        }
        .auth-card {
            padding: 30px 25px;
            border-radius: 20px;
        }
        .auth-logo img {
            width: 48px;
            height: 48px;
        }
        .auth-logo span {
            font-size: 25px;
        }
        .auth-title {
            font-size: 24px;
        }

    }
</style>