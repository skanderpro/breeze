<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Express Merchants | <?php echo $title; ?></title>

    <!-- Scripts -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" charset="utf-8" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfU2hsPF_D_DwXwxr8QEk2NU_RPzBO4YA&libraries=places&callback=initMap"></script>

    <script type="text/javascript" src="{{ asset('js/infobubble-compiled.js') }}"></script>
	  <script type="text/javascript" src="{{ asset('js/store-locator.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/em-static-ds.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/map.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>
    <link rel="shortcut icon" type="image/ico" href="{{ url('/favicon.ico') }}"/>
    <link rel="apple-touch-icon" sizes="128x128" href="{{ url('/favicon.ico') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/storelocator.css') }}"> -->
</head>
<body onload="initMap()">
    <div class="container-fluid app">
      <header>
        <!-- <nav class="navbar navbar-expand-md navbar-light navbar-laravel"> -->
          <div class="container-fluid">

            <div class="row">
              <div class="col-3 col-md-6 app_brand d-flex flex-row">
                <a class="navbar-brand" href="{{ url('/') }}">
                  <img src="{{ asset('/images/express-merchants-head_blue_logo.svg') }}" alt="Express Merchants v1.4.2" title="Express Merchants v1.5">
                </a>
                <h1><?php echo $title; ?></h1>
              </div>
              <div class="col-9 col-md-6 nav flex-row-reverse">
                <span class="navopen" onclick="openNav()">
                  <img src="{{ asset('/images/nav_icon.svg') }}" alt="You are logged in as an Admin User">
                </span>

                @if (Auth::user()->accessLevel == '1')
                  <a class="d-none d-md-block" href="{{ url('/') }}">
                    <img src="{{ asset('/images/admin_user.svg') }}" alt="You are logged in as an Admin User">
                  </a>
                @endif

                <p><span class="companyname">{{ $company->companyName }}</span><br>{{ Auth::user()->name }} </p>

              </div>
            </div>
          </div>
        <!-- </nav> -->

      </header>

      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ url('/home') }}"><img src="{{ asset('/images/control-panel.svg') }}" alt="Control Panel"> Control Panel</a>
        <a href="{{ url('/merchant-find') }}"><img src="{{ asset('/images/merchant.svg') }}" alt="Find Merchants"> Find Merchants</a>
        <a href="{{ url('/po-create') }}"><img src="{{ asset('/images/create-po.svg') }}" alt="Create Purchase Order"> Create Purchase Order</a>
        <a href="{{ url('/po-list') }}"><img src="{{ asset('/images/manage-po.svg') }}" alt="Manage Purchase Orders"> Manage Purchase Orders</a>
        <a href="{{ url('/account') }}"><img src="{{ asset('/images/account-details.svg') }}" alt="User Account Details"> User Account Details</a>

        @if (Auth::user()->accessLevel == '1')
        <a href="{{ url('/notification-list') }}"><img src="{{ asset('/images/bell.svg') }}" alt="Manage Notifications"> Manage Notifications</a>
        @endif

        <a href="#" onclick="return confirm('User Guide Coming Soon')"><img src="{{ asset('/images/user-guide.svg') }}" alt="Express Merchants"> User Guide</a>
        <a href="#" onclick="return confirm('Get Help Coming Soon')"><img src="{{ asset('/images/get-help.svg') }}" alt="Express Merchants"> Get Help</a>
        <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             {{ __('Logout') }} <img src="{{ asset('/images/account-details.svg') }}" alt="Express Merchants">
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>


        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            © Express Merchants  |  <a href="#" target="_blank">Data Policy</a>
          </div>
          <div class="col-md-6 byline">
             <span>Built By <a href="https://www.cornellstudios.com" target="_blank">Cornell</a></span>
          </div>
        </div>
      </div>

    </footer>
    <!-- Scripts -->
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}" defer></script>
    <script src="{{ asset('js/jquery.matchHeight.js') }}" defer></script>

    <script>



    $("#selectMerchant").select2( {
    	placeholder: "Select a merchant",
    	allowClear: true
    	} );

    $("#userSearch").select2( {
    	placeholder: "Select a User",
    	allowClear: true
    	} );

      $("#userSearchDownload").select2( {
      	placeholder: "Select a User",
      	allowClear: true,
        dropdownParent: $('.modal')
      	} );

    $("#companySearch").select2( {
    	placeholder: "Select a Company",
    	allowClear: true
    	} );

    $("#merchantSearch").select2( {
    	placeholder: "Select a Merchant",
    	allowClear: true
    	} );

      $("#merchantSearchDownload").select2( {
      	placeholder: "Select a Merchant",
      	allowClear: true,
        dropdownParent: $('.modal')
      	} );

    $("#u_id").select2( {
    	placeholder: "Select a User",
    	allowClear: true
    	} );

    $("#companyId").select2( {
    	placeholder: "Select a Company",
    	allowClear: true
    	} );


    $("#poFinanceStatus").select2( {
    	placeholder: "Select an Order Status",
    	allowClear: true,
      dropdownParent: $('.modal')
    	} );

    $("#poFinanceCompany").select2( {
    	placeholder: "Select a Company",
    	allowClear: true,
      dropdownParent: $('.modal')
    	} );







    </script>
  </body>
</html>
