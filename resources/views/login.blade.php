<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }} | Login </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ URL::to("img/logo.jpg") }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ URL::to('client_lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('client_lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ URL::to('client_css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ URL::to('client_css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-secondary">
    <div class="container-xxl position-relative  d-flex p-0">

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-info rounded p-4 p-sm-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route('index') }}" class="">
                                <h3 class="text-primary text-uppercase"><i
                                        class="fa fa-hashtag me-2"></i>{{ config('app.name') }}</h3>
                            </a>
                            <h3>Connexion</h3>
                        </div>
                        <div class="mt-2">
                            @if (Session::has('fail'))
                                <div class="alert alert-danger text-center">{{ Session::get('fail') }}</div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
                            @endif
                            @if (Session::has('warning'))
                                <div class="alert alert-warning text-center my-2 mx-2">{{ Session::get('warning') }}</div>
                            @endif
                        </div>
                        <form action="" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="floatingInput"
                                    placeholder="nom@exemple.com" required>
                                <label for="floatingInput">Votre Email</label>
                                @if ($errors->has('email'))
                                    <p class="help-block text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword"
                                    placeholder="Mot de Passe" required>
                                <label for="floatingPassword">Votre Mot de Passe</label>
                                @if ($errors->has('password'))
                                    <p class="help-block text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Connexion</button>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a href="{{ route('codeoublier') }}">Mot de Passe Oublier</a>
                                <p class="text-center mb-0"><a href="{{ route('creercompte') }}">Créer un Compte</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('client_lib/chart/chart.min.js') }}"></script>
    <script src="{{ URL::to('client_lib/easing/easing.min.js') }}"></script>
    <script src="{{ URL::to('client_lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ URL::to('client_lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::to('client_lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ URL::to('client_lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ URL::to('client_lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ URL::to('client_js/main.js') }}"></script>
</body>

</html>
