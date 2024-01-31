@extends('layouts.app')

@section('content')
<?php $title = 'User Command <span>Console</span>'; ?>
<div class="container-fluid dashboard">
    <div class="row justify-content-center">
        <div class="col-md-4 col-lg-3 col1">

          <div class="blue findmerch">
            <div class="hash">
              #
            </div>
            <a href="{{ url('/merchant-find') }}">
              <span>Find</span><br />Merchant
            </a>
          </div>

          @if (Auth::user()->accessLevel == '1')
            <div class="blue">
              <div class="hash">
                #
              </div>
              <a href="{{ url('/merchant-create') }}">
                <span>Create</span><br />Merchant
              </a>
            </div>

            <div class="blue">
              <div class="hash">
                #
              </div>
              <a href="{{ url('/merchant-list') }}">
                <span>Manage</span><br />Merchants
              </a>
            </div>

            <div class="blue">
              <div class="hash">
                #
              </div>
              <a href="{{ url('/company-create') }}">
                <span>Create</span><br />Company
              </a>
            </div>

            <div class="blue">
              <div class="hash">
                #
              </div>
              <a href="{{ url('/company-list') }}">
                <span>Manage</span><br />Companies
              </a>
            </div>

            <div class="blue">
              <div class="hash">
                #
              </div>
              <a href="{{ url('/notification-create') }}">
                <span>Create</span><br />Notification
              </a>
            </div>
          @endif
          {{-- @if (Auth::user()->accessLevel != '1') --}}
          <div class="navy">
            <div class="hash">
              #
            </div>
            <a href="{{ url('/po-create') }}">
              <span>Create</span> <br />
              Purchase <br />
              Order Now
            </a>
          </div>
          {{-- @endif --}}
        </div>
        <div class="col-md-4 col-lg-3 col2">
          <div class="red">
            <div class="hash">
              #
            </div>
            <a href="{{ url('/po-list') }}">
              <h2><span>Manage</span> <br />
              Purchase <br />
              Orders</h2>
            </a>
            <p><strong>{{ $countresult }}</strong> Uploads Required</p>
          </div>
        </div>
        <div class="col-md-4 col-lg-3 col3 d-none d-lg-block">
          <div class="blue">


              @if ($notification)

              <h2>{{ $notification->title }}</h2>
              <p>{{ $notification->content }}</p>

              @else

              <h2><span>the right products <br />
              the first time</span> <br />
              one invoice.</h2>

              @endif

              <img src="{{ asset('/images/em_logomark.svg') }}" alt="">
          </div>
        </div>
        <div class="col-md-4 col-lg-3 col4">


            <div class="users">

              <a href="{{ url('/account') }}">
                <div class="row details">
                  <div class="col-6">
                    <span>My User</span><br />Account Details
                  </div>
                  <div class="col-6 icon">
                    <img src="{{ asset('/images/user-details_icon.svg') }}" alt="Express Merchants">
                  </div>
                </div>
              </a>
              @if (Auth::user()->accessLevel == '1' || Auth::user()->accessLevel == '2')
              <a href="{{ url('/register') }}">
                <div class="row add">
                  <div class="col-6">
                    <span>Add</span><br /> New <br/>User
                  </div>
                  <div class="col-6 icon">
                    <img src="{{ asset('/images/add-user_icon.svg') }}" alt="Express Merchants">
                  </div>
                </div>
              </a>
              <a href="{{ url('/userlist') }}">
                <div class="row manage">
                  <div class="col-6">
                      <span>Manage</span><br />Users

                  </div>
                  <div class="col-6 icon">
                    <img src="{{ asset('/images/manage-user_icon.svg') }}" alt="Express Merchants">
                  </div>
                </div>
              </a>
              @endif
            </div>



          <div class="row">
            <div class="col-6">
              <div class="blue gethelp">
                <a href="#" onclick="return confirm('Coming Soon')">
                  <span>Get</span> <br /> Help
                </a>
              </div>
            </div>
            <div class="col-6">
              <div class="blue userguide">
                <a href="#" onclick="return confirm('Coming Soon')">
                  <span>User</span> <br /> Guide
                </a>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
