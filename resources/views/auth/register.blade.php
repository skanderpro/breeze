@extends('layouts.app')

@section('content')
<?php
  //page title
  $title = 'Add <span>New User</span>';
?>
<div class="container-fluid user">
    <div class="row">
      <div class="col-md-5 col-lg-3 contactdetails">
        <img class="add" src="{{ asset('/images/add-icon.svg') }}" alt="">

        <h3>Company</h3>
        <p class="company">{{ $company->companyName }}</p>
        <h3>Operator</h3>
        <p>{{ Auth::user()->name }}</p>

        <h3>Date</h3>
        <p><?php echo date('d.m.y') ?></p>

      </div>
      <div class="col-md-7 col-lg-9 form">
        @if (Auth::check())

        @if (Auth::user()->accessLevel == 1 || Auth::user()->accessLevel == 2)

        <div class="row">

          <div class="col-md-8 form_wrapper">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">

                    <div class="offset-md-3 col-md-8">
                      <label for="name" class="col-form-label">{{ __('Name') }}</label>

                      <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                      @if ($errors->has('name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>

                <div class="form-group row">


                    <div class="offset-md-3 col-md-8">
                      <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



                <div class="form-group row">

                    <div class="offset-md-3 col-md-8">

                      @if (Auth::check())

                        @if (Auth::user()->accessLevel == 1)
                        <label for="company" class="col-form-label">{{ __('Company') }}</label>
                        <select class="form-control{{ $errors->has('companyId') ? ' is-invalid' : '' }}" name="companyId" required>
                          <option value="">Select a company</option>
                          @foreach($companyList as $companies)
                            <option value="{{ $companies->id }}">{{ $companies->companyName }}</option>
                          @endforeach
                        </select>

                        @else

                        <input id="companyId" type="companyId" style="display: none;" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="companyId" value="{{ Auth::user()->companyId }}" required>


                        @endif

                      @endif

                        @if ($errors->has('companyId'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companyId') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



                <div class="form-group row">


                    <div class="offset-md-3 col-md-8">
                      <label for="name" class="col-form-label">{{ __('Phone') }}</label>
                        <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>

                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



                    <div class="form-group row">


                        <div class="offset-md-3 col-md-8">

                          @if (Auth::check())

                          @if (Auth::user()->accessLevel == 1)
                          <label for="name" class="col-form-label">{{ __('Access Level') }}</label>
                          <select class="form-control" name="accessLevel" id="accessLevel">
                            <option value="">Select an access level</option>
                            <option value="2">Company Admin</option>
                            <option value="3">Company User</option>
                            <!-- <option value="3">User</option> -->
                          </select>

                          @else

                          <input id="accessLevel" type="text" style="display: none;" class="form-control{{ $errors->has('accessLevel') ? ' is-invalid' : '' }}" name="accessLevel" value="3" required autofocus>

                        @endif

                        @endif


                      </div>
                    </div>





                <div class="form-group row">


                    <div class="offset-md-3 col-md-8">
                      <label for="password" class="col-form-label">{{ __('Password') }}</label>

                      <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">


                    <div class="offset-md-3 col-md-8">
                      <label for="password-confirm" class="col-form-label ">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-3">

                    </div>
                </div>

          </div>

          <div class="col-md-3 form_wrapper_details">

            <label for="name" class="col-form-label">{{ __('Company Name') }}</label>
            <p class="company"><img src="{{ asset('/images/company-icon_navy.svg') }}" alt="User Account Details"> {{ $company->companyName }}</p>

            @if (session('message'))
              <div class="flash-message">
                NEW USER<br />
                SUCCESSFULLY<br />
                ADDED.
              </div>
            @endif

            <button type="submit" class="btn btn-primary">
                {{ __('Add User') }}
            </button>
            </form>
          </div>

        </div>

          @else

          You have no business being here

          @endif

          @endif
      </div>
    </div>
</div>
@endsection
