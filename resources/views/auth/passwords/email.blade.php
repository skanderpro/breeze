@extends('layouts.login')

@section('content')
<?php
  //page title
  $title = 'Reset <span>Password</span>';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 matchheight">
              <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif

                  <form method="POST" action="{{ route('password.email') }}">
                      @csrf

                      <div class="form-group row">
                          <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->
                              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="E-Mail Address" value="{{ old('email') }}" required>

                              @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                      </div>

                      <div class="form-group row mb-0">
                          <button type="submit" class="btn btn-primary">
                              {{ __('Send Password Reset Link') }}
                          </button>
                      </div>
                  </form>
              </div>
        </div>

      <div class="col-md-9 content d-none d-md-block matchheight">
          <h1>Password<br />
          <span>reset.</span></h1>

          <p>Do you want to find out more about how we can help your business through being more streamlined?</p>

          <p>Would you like to save money in time and duplication of working and join a huge network of suppliers?</p>

          <p><strong>Call us today to see how we can help your business.</strong></p>

          <a href="tel:028 3835 1388">028 3835 1388</a>

        </div>
    </div>
</div>
@endsection
