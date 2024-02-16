@extends('layouts.app')

@section('content')
<?php $title = 'My Account <span>Details</span>'; ?>


<div class="container-fluid account">
    <div class="row">
      <div class="col-md-3 account_details matchheight">

        <div class="label">
          Details
        </div>

        <p><img src="{{ asset('/images/account-details.svg') }}" alt="User Account Details"> {{ Auth::user()->name }}</p>

        <p><img src="{{ asset('/images/phone_icon.svg') }}" alt="User Account Details"> {{ Auth::user()->phone }}</p>

        <p><img src="{{ asset('/images/email-icon.svg') }}" alt="User Account Details"> <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>

        <p><img src="{{ asset('/images/company-icon.svg') }}" alt="User Account Details"> {{ $company->companyName }}</p>

      </div>
        <div class="col-md-9 account_quote d-none d-md-block matchheight">
          <!-- <div class="blue"> -->
              <h2><span>the right products <br />
              the first time</span> <br />
              one invoice.</h2>
              <img src="{{ asset('/images/em_logomark.svg') }}" alt="">
          <!-- </div> -->
        </div>
    </div>
</div>
@endsection
