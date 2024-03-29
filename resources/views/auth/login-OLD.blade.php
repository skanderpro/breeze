@extends('layouts.login')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-3 matchheight">

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
                <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="email" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                <div class="col-md-12">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                        <a class="btn btn-link" href="mailto:helpdesk@expressmerchants.com?subject=Requesting a new account" target="_blank">Request New User Account.</a>
                </div>
            </div>

            <img class="login_branding" src="{{ asset('/images/express-merchants_logo.svg') }}" alt="Express Merchants">

        </form>

      </div>
        <div class="col-md-9 content d-none d-md-block matchheight">
          <h1>the right products<br />
          the first time<br />
          <span>one invoice.</span></h1>

          <p>Do you want to find out more about how we can help your business through being more streamlined?</p>

          <p>Would you like to save money in time and duplication of working and join a huge network of suppliers?</p>

          <p><strong>Call us today to see how we can help your business.</strong></p>

          <a href="tel:+442838446170">+44 (0)28 3844 6170</a>

        </div>
    </div>
</div>
@endsection
