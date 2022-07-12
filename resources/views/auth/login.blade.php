<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <title>Login - Sistem Informasi Akademik Pesantren</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sistem Informasi Akademik Pesantren" name="description" />
        <meta content="SIAPtren" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('') }}assets/images/favicon.ico">

        <!-- App css -->
        <link href="{{ asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('') }}assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg bg-gradient">

            <div class="account-pages mt-5 pt-5 mb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card bg-pattern">
    
                                <div class="card-body p-4">
                                    
                                    <div class="text-center w-75 m-auto">
                                        <a href="">
                                            <span><img src="assets/images/logo-dark.png" alt="" height="18"></span>
                                        </a>
                                        <h5 class="text-uppercase text-center font-bold mt-4">Sign In</h5>
                                    </div>
    
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="username">Username</label>
                                            <input class="form-control" type="text" name="username" id="username" required="" placeholder="Username atau Email">
                                        </div>
    
                                        <div class="form-group mb-3">
                                            {{-- <a href="pages-recoverpw.html" class="text-muted float-right"><small>Forgot your password?</small></a> --}}
                                            <label for="password">Password</label>
                                            <input class="form-control" type="password" name="password" required="" id="password" placeholder="Password">
                                        </div>
    
                                        {{-- <div class="form-group mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                            </div>
                                        </div> --}}
                                        @error('error')
                                        <div class="form-group text-center">
                                            <div class="col-12">
                                                <div class="text-danger small">{{ $message }}</div>
                                            </div>
                                        </div>
                                        @enderror
    
                                        <div class="form-group mb-0 text-center">
                                            <button class="btn btn-gradient btn-block" type="submit"> Log In </button>
                                        </div>
    
                                    </form>
    
                                </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->

                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end page -->


        <!-- Vendor js -->
        <script src="{{ asset('') }}assets/js/vendor.min.js"></script>
        <!-- App js -->
        <script src="{{ asset('') }}assets/js/app.min.js"></script>
        
    </body>
</html>