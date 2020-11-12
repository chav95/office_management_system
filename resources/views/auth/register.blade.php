@extends('layouts.app')

@section('content')
{{-- <body>
<div class="container" id="app">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div> --}}

<body class="hold-transition login-page"">
  <div id="app">
    <div class="login-box">
      <div class="login-logo">
          <span><b>Register</b></span>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg pb-0">For Salary Slip User</p>

        <div class="card-body pt-1">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group mb-0">
              <label for="" class="mb-0">Name</label>
            </div>
            <div class="input-group mb-2">
              <input type="text" name="name" 
                class="form-control @error('name') is-invalid @enderror" placeholder="Name" 
                value="{{ old('name') }}" required autocomplete="name" autofocus >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
              
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="input-group mb-0">
              <label for="" class="mb-0">NIK</label>
            </div>
            <div class="input-group mb-2">
              <input type="text" name="username" 
                class="form-control @error('username') is-invalid @enderror" placeholder="NIK" 
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
            
            <div class="input-group mb-0">
              <label for="" class="mb-0">Password</label>
            </div>
          <div class="input-group mb-2">
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
            
            <div class="input-group mb-0">
              <label for="" class="mb-0">Confirm Password</label>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password_confirmation" 
                class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password"
                required autocomplete="current-password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            
            {{-- <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div> --}}

            <div class="row">
              {{-- <div class="col-md-6 offset-md-4"> --}}
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">
                  {{ __('Register') }}
                </button>
              </div>
            </div>
              
            <hr class="header-line-bot" style="border-bottom: 1px solid #666;">
            <div class="row">
              <div class="col-12">
                <a href="/login"><strong>Back To Login</strong></a>
              </div>
            </div>
          </form>
        </div>

                
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
  </div>
</body>
            {{-- </div>
        </div>
    </div>
</div>   
</body> --}}
@endsection
