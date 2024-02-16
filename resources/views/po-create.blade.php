@extends('layouts.app')

@section('content')
<?php $title = 'Create <span>Purchase Order</span>'; ?>
<div class="container-fluid po-create">
  <div class="row">

    @if(Auth::user()->disabled == '1' || $company->disabled == '1')

    <div class="col-md-5 col-lg-4 po-create_suspended">
      <h2>Your ability to create Purchase Orders has been <span>temporarily suspended</span></h2>

      <a href="{{ url('/po-list') }}">Manage your existing Purchase Orders</a>

    </div>

    @else

    <div class="col-md-6 col-lg-5 col-xl-4 matchheight">

        <div class="row">
          <div class="col-12 po-create_selectCompany">


            <?php
            if(empty($_GET['companyId'])) {

              $companyId = "";

            } else {
              $companyId = $_GET['companyId'];
            }
            ?>

            <?php
            if(empty($_GET['id'])) {

            } else {
              $merchantid = $_GET['id'];
            }
            ?>


            @if (Auth::user()->accessLevel == '1')

            <form class="form-horizontal" role="form" method="GET">

              <label class="main">Select Company (Super Admin Only)</label>

              <select style="display: none;" class="form-control{{ $errors->has('companyId') ? ' is-invalid' : '' }}" name="id" id="id">
                <option value="">Select a merchant</option>
                @foreach($merchants as $merchant)
                  <option value="{{ $merchant->id }}" @if (empty($_GET['id'])) @else @if ($merchant->id == $merchantid) selected  @endif @endif>

                    {{ $merchant->merchantName }}, {{ $merchant->merchantCounty }} {{ $merchant->merchantPostcode }}

                  </option>
                @endforeach
              </select>

              <select class="form-control" name="companyId" id="companyId">
                <option value="">Select a Company</option>
                @foreach($companies as $company)

                <option value="{{ $company->id }}" @if (empty($_GET['companyId'])) @else @if ($company->id == $companyId) selected  @endif @endif>{{ $company->companyName }}</option>

                @endforeach
              </select>

              @if ($errors->has('companyId'))
              <span class="help-block">
                <strong>{{ $errors->first('companyId') }}</strong>
              </span>
              @endif


              <button class="btn btn-default" type="submit">Select Company</button>

            </form>

            @endif



          </div>
        </div>





      <form class="form-horizontal" role="form" method="POST" action="{{ url('/po-create') }}">
      {!! csrf_field() !!}



        <div class="form-group{{ $errors->has('poType') ? ' has-error' : '' }}">

          <label class="main">Supplier Type</label>
          <input type="radio" id="pre-approved" name="poType" value="Pre Approved" checked required>
          <label for="pre-approved">PRE-APPROVED SUPPLIER <span>(NORMAL)</label><br>
          <input type="radio" id="alternate" name="poType" value="alternate" required>
          <label for="Alternate">ALTERNATIVE SUPPLIER <span>(UNLISTED)</span></label>

          @if ($errors->has('poType'))
          <span class="help-block">
            <strong>{{ $errors->first('poType') }}</strong>
          </span>
          @endif
        </div>



        <div class="form-group row selectMerchant">
          <div class="col-12">
            <label class="main">Selected Merchant</label>
            <select class="form-control{{ $errors->has('companyId') ? ' is-invalid' : '' }}" name="selectMerchant" id="selectMerchant" required>
              <option value="">Select a merchant</option>
              @foreach($merchants as $merchant)
                <option value="{{ $merchant->id }}" @if (empty($_GET['id'])) @else @if ($merchant->id == $merchantid) selected  @endif @endif>

                  {{ $merchant->merchantName }}, {{ $merchant->merchantCounty }} {{ $merchant->merchantPostcode }}

                </option>
              @endforeach
            </select>

            @if ($errors->has('selectMerchant'))
            <span class="help-block">
              <strong>{{ $errors->first('selectMerchant') }}</strong>
            </span>
            @endif

          </div>
        </div>


        <div class="form-group row inputMerchant" style="display: none;">
          <div class="col-12">
            <label class="main">Unlisted Merchant Details</label>
            <input class="form-control" id="inputMerchant" name="inputMerchant" value="" placeholder="Merchant Name, Address, Contact #">
          </div>
        </div>

        @if ($errors->has('inputMerchant'))
        <span class="help-block">
          <strong>{{ $errors->first('inputMerchant') }}</strong>
        </span>
        @endif

        <div class="form-group row">
          <div class="col-12">
            <label class="main">Order Purpose</label>
          </div>
          <div class="col-4">
            <input type="radio" id="project" name="poPurpose" value="Project" required>
            <label for="project">Project</label>
          </div>
          <div class="col-4">
            <input type="radio" id="reactive" name="poPurpose" value="Reactive" required>
            <label for="reactive">Reactive</label>
          </div>
          <div class="col-4">
            <input type="radio" id="overhead" name="poPurpose" value="Overhead" required>
            <label for="overhead">Overhead</label>
          </div>
          <div class="col-4">
            <input type="radio" id="van-stock" name="poPurpose" value="Van Stock" required>
            <label for="van-stock">Van Stock</label>
          </div>
          <div class="col-4">
            <input type="radio" id="ppm" name="poPurpose" value="Project" required>
            <label for="ppm">PPM</label>
          </div>

          @if ($errors->has('popurpose'))
          <span class="help-block">
            <strong>{{ $errors->first('poPurpose') }}</strong>
          </span>
          @endif

        </div>

        <div class="form-group row ">

          <div class="col-md-6">
            <label class="main">Supplier	Cost</label>
            <input autocomplete="off" class="form-control" id="poValue" name="poValue" value="" placeholder="Input Supplier	Cost">

            @if ($errors->has('poValue'))
            <span class="help-block">
              <strong>{{ $errors->first('poValue') }}</strong>
            </span>
            @endif
          </div>

          <div class="col-md-6 poProject">
            <label class="main">Task/Project Number</label>
            <input class="form-control" id="poProject" name="poProject" value="" placeholder="Input project number">

            @if ($errors->has('poProject'))
            <span class="help-block">
              <strong>{{ $errors->first('poProject') }}</strong>
            </span>
            @endif
          </div>

        </div>

        <div class="form-group row">

          <div class="col-6 @if (Auth::user()->accessLevel == '1') d-none @endif">
            <label class="main">Company Name</label>


            @if (Auth::user()->accessLevel == '1')


              <input type="text" class="form-control d-none" id="companyId" name="companyId" placeholder="companyId" value="{{ $companyId }}">

            @else

            {{ $company->companyName }}

              <input type="text" class="form-control d-none" id="companyId" name="companyId" placeholder="companyId" value="{{ Auth::user()->companyId }}">

            @endif



          </div>

          <div class="col-6">
            <label class="main">User Name</label>

            @if (Auth::user()->accessLevel == '1')

              <select class="form-control" name="u_id" id="u_id">
                <option value="">Select a User</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->companyName }})</option>
                @endforeach
              </select>

            @elseif (Auth::user()->accessLevel == '2')

            <select class="form-control" name="u_id" id="u_id">
              <option value="">Select a User</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>

            @else

            {{ Auth::user()->name }}

              <input type="text" class="form-control d-none" id="u_id" name="u_id" placeholder="u_id" value="{{ Auth::user()->id }}">

            @endif

            @if ($errors->has('u_id'))
            <span class="help-block">
              <strong>{{ $errors->first('u_id') }}</strong>
            </span>
            @endif

          </div>
        </div>


        <div class="form-group row">
          <div class="col-12">
            <label>Job Location</label>
            <input class="form-control" id="poProjectLocation" name="poProjectLocation" value="" placeholder="Input project location" required>
          </div>


          @if ($errors->has('poProjectLocation'))
          <span class="help-block">
            <strong>{{ $errors->first('poProjectLocation') }}</strong>
          </span>
          @endif
        </div>

        @if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android'))
        <div class="form-group row d-block d-sm-block d-md-none">
          <div class="col-12">
            <label class="main">Material Brief</label>
            <textarea class="form-control" cols="20" name="poMaterials" id="poMaterials" placeholder="Add materials" value=""></textarea>
          </div>
        </div>
        @endif

        <input type="text" class="form-control d-none" id="poJobStatus" name="poJobStatus" value="1">
        <input type="text" class="form-control d-none" id="poFinanceStatus" name="poFinanceStatus" value="1">



        <div class="form-group custom-search-form">
          <button id="poSubmit" type="submit" class="btn btn-default">Submit & Generate PO</button>
        </div>


    </div>

    @if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android'))

    @else
      <div class="col-md-6 col-lg-6 col-xl-7 textarea matchheight d-none d-md-block d-lg-block">
        <label class="main">Material Brief</label>
        <textarea class="form-control" cols="50" name="poMaterials" id="poMaterials" placeholder="Add materials" value=""></textarea>
      </div>
    @endif

    </form>

    @endif

  </div>

</div>



@endsection
