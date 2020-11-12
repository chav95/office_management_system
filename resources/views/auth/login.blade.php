@extends('layouts.app')

@section('content')
    <body class="hold-transition login-page"">
        <div id="app">
            <div class="login-box">
                <div class="login-logo">
                    <span><b>Office</b><br>Management</span>
                </div>
                <!-- /.login-logo -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session</p>

                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" name="username" 
                                    class="form-control @error('username') is-invalid @enderror" placeholder="Email / NIK" 
                                    value="{{ old('username') }}" required autocomplete="username" autofocus >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <input type="password" name="password" 
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required autocomplete="current-password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>

                            <hr class="header-line-bot" style="border-bottom: 1px solid #666;">
                            <div class="row">
                                <div class="col-12">
                                    <a href="/register"><strong>Register User Slip Gaji</strong></a>
                                </div>
                            </div>
                        </form>

                        {{-- <p class="mb-1">
                            <a href="register.html">Register User Slip Gaji</a>
                        </p> --}}
                        {{-- <p class="mb-0">
                            <a href="register.html" class="text-center">Register a new membership</a>
                        </p> --}}
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
    </body>
@endsection