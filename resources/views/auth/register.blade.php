@extends('auth.templates.main')
@section('title')
    Register
@endsection
@section('content')
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <a href="/" class="logo">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="22" class="logo-light mx-auto">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="22" class="logo-dark mx-auto">
                        </a>
                        <p class="text-muted mt-2 mb-4">Professional Federation Accounting</p>
                    </div>
                    <div class="card">

                        <div class="card-body p-4">
                            
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Register</h4>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> <br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> <br>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            <form action="{{ route('auth.register') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="fullname">Company Name</label>
                                    <input class="form-control" type="text" id="fullname" placeholder="Enter your name" required name="fullname" value="{{ old('fullname') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input class="form-control" type="email" id="email" required placeholder="Enter your email" name="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" required id="password" placeholder="Enter your password" name="password" value="{{ old('password') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Confirm Password</label>
                                    <input class="form-control" type="password" required id="password" placeholder="Enter your password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> Sign Up </button>
                                </div>
                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted">Already have account?  <a href="{{ route('auth.login.view') }}" class="text-dark ml-1"><b>Sign In</b></a></p>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection