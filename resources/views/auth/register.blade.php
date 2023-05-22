<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://static.cdninstagram.com/rsrc.php/v3/yb/r/lswP1OF1o6P.png" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Instagram') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/images.js', 'resources/sass/home.scss'])
</head>
<style>
    a {
        color: #007bff;
    }
    a:hover {
        color: #90b1d7;
        background: transparent;
    }
</style>
<body style="background-color: #fff;color: black;">
    <div class="container" style="margin-left: 250px;   ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card justify-content-center align-items-center" style="margin-left: 40%;height: auto;width: 40%;background-color: #fff;">
                    <img src="{{ asset('images/instagram-logo.png') }}" alt="" style="height: 60px;margin-top: 40px;margin-bottom: 20px;">
                    <h4 style="font-size: 20px" class="text-center">Sign up to see photos and videos from your friends.</h4>
                    <div class="text-center">
                        <a style="text-decoration: none;font-size: 20px;" href="https://www.facebook.com/login.php?skip_api_login=1&api_key=124024574287414&kid_directed_site=0&app_id=124024574287414&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fclient_id%3D124024574287414%26redirect_uri%3Dhttps%253A%252F%252Fwww.instagram.com%252Faccounts%252Fsignup%252F%26state%3D%257B%2522fbLoginKey%2522%253A%25221le0nho1nhg77fs4d6iin2xb4g1v6tpqzjn2riajf2gxqgsttdm%2522%252C%2522fbLoginReturnURL%2522%253A%2522%252Ffxcal%252Fdisclosure%252F%253Fnext%253D%25252F%2522%257D%26scope%3Demail%26response_type%3Dcode%252Cgranted_scopes%26locale%3Den_US%26ret%3Dlogin%26fbapp_pres%3D0%26logger_id%3D34c3603a-0b1a-4162-9bd7-b70134ef292a%26tp%3Dunspecified&cancel_url=https%3A%2F%2Fwww.instagram.com%2Faccounts%2Fsignup%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D%257B%2522fbLoginKey%2522%253A%25221le0nho1nhg77fs4d6iin2xb4g1v6tpqzjn2riajf2gxqgsttdm%2522%252C%2522fbLoginReturnURL%2522%253A%2522%252Ffxcal%252Fdisclosure%252F%253Fnext%253D%25252F%2522%257D%23_%3D_&display=page&locale=en_US&pl_dbl=0">
                            <i class="mdi mdi-facebook" style="font-size: 20px;color: cornflowerblue;"></i>
                            Sign In with Facebook
                        </a>
                    </div>
                    <div class="card-body" style="width: 90%;">
                        <div style="display: flex; align-items: center; margin: 10px 0;">
                            <hr style="flex: 1; margin-right: 10px;">
                            <div class="text-muted"><b>OR</b></div>
                            <hr style="flex: 1; margin-left: 10px;">
                        </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                                <input placeholder="Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <p class="text-center text-muted" style="font-size: 12.5px;">
                                    People who use our service may have uploaded your contact information to Instagram.
                                    <a href="https://www.facebook.com/help/instagram/261704639352628">Learn More</a>
                                </p>
                                <p class="text-center text-muted" style="font-size: 12px;">
                                    By signing up, you agree to our <a href="">Terms</a> , <a href="">Privacy Policy</a> and
                                    <a href="">Cookies Policy</a> .
                                </p>
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    {{ __('Sign Up') }}
                                </button>
                    </form>
                        <div class="card-footer text-center">Have an account? <a href="{{ route('login') }}">Log in</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
