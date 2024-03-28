@extends('layouts.app')

@section('content')
<?php $title = 'Create <span>New Merchant</span>'; ?>
<div class="container-fluid user">
  <div class="row">
    <div class="col-md-5 col-lg-3 contactdetails">

      <h3>Company</h3>
      <p class="company">{{ $company->companyName }}</p>
      <h3>Operator</h3>
      <p>{{ Auth::user()->name }}</p>

      @cannot (\App\Enums\Permission::MENU_READ_ADMIN)

        <h3>For assistance please call</h3>
        <p class="phone">{{ $adminusr->phone }}</p>

      @endcannot

      <h3>Date</h3>
      <p><?php echo date('d.m.y') ?></p>

    </div>
    <div class="col-md-7 col-lg-9 form">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/merchant-create') }}">
      {!! csrf_field() !!}

      <div class="form-group{{ $errors->has('merchantId') ? ' has-error' : '' }} row">
        <div class="offset-md-3 col-md-6">
          <label for="name" class="col-form-label">{{ __('Merchant ID') }}</label>

          <input type="text" class="form-control" id="merchantId" name="merchantId" value="" required>

          @if ($errors->has('merchantId'))
          <span class="help-block">
            <strong>{{ $errors->first('merchantId') }}</strong>
          </span>
          @endif
        </div>
      </div>

        <div class="form-group{{ $errors->has('merchantName') ? ' has-error' : '' }} row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Name') }}</label>

            <input type="text" class="form-control" id="merchantName" name="merchantName" value="" required>

            @if ($errors->has('merchantName'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantName') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">

            <div class="row">
            <div class="col-lg-4 {{ $errors->has('green_supplier') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Green Supplier') }}</label>
                <input type="checkbox" id="green_supplier" name="green_supplier" value="1">
            </div>
              <div class="col-lg-4 {{ $errors->has('merchantPlumbing') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Plumbing') }}</label>
                <input type="checkbox" id="merchantPlumbing" name="merchantPlumbing" value="YES">
              </div>
              <div class="col-lg-4 {{ $errors->has('merchantElectrical') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Electrical') }}</label>
                <input type="checkbox" id="merchantElectrical" name="merchantElectrical" value="YES">
              </div>
              <div class="col-lg-4 {{ $errors->has('merchantBuilders') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Builders') }}</label>
                <input type="checkbox" id="merchantBuilders" name="merchantBuilders" value="YES">
              </div>
              <div class="col-lg-4 {{ $errors->has('merchantHire') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Hire') }}</label>
                <input type="checkbox" id="merchantHire" name="merchantHire" value="YES">
              </div>


              <div class="col-lg-4 {{ $errors->has('merchantDecorating') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Painting & Decorating') }}</label>
                <input type="checkbox" id="merchantDecorating" name="merchantDecorating" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantFlooring') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Flooring') }}</label>
                <input type="checkbox" id="merchantFlooring" name="merchantFlooring" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantAuto') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Auto Parts') }}</label>
                <input type="checkbox" id="merchantAuto" name="merchantAuto" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantAggregate') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Aggregate') }}</label>
                <input type="checkbox" id="merchantAggregate" name="merchantAggregate" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantRoofing') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Roofing') }}</label>
                <input type="checkbox" id="merchantRoofing" name="merchantRoofing" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantFixings') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Fixings & Fasteners') }}</label>
                <input type="checkbox" id="merchantFixings" name="merchantFixings" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantIronmongery') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Ironmongery & Hardware') }}</label>
                <input type="checkbox" id="merchantIronmongery" name="merchantIronmongery" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantTyres') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Tyres') }}</label>
                <input type="checkbox" id="merchantTyres" name="merchantTyres" value="YES">
              </div>

              <div class="col-lg-4 {{ $errors->has('merchantHealth') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Health & Safety') }}</label>
                <input type="checkbox" id="merchantHealth" name="merchantHealth" value="YES">
              </div>


            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Address 1') }}</label>
            <input type="text" class="form-control" id="merchantAddress1" name="merchantAddress1" value="" required>

            @if ($errors->has('merchantAddress1'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantAddress1') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Address 2') }}</label>

            <input class="form-control" id="merchantAddress2" name="merchantAddress2" value="">

            @if ($errors->has('merchantAddress2'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantAddress2') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant County') }}</label>
            <input class="form-control" id="merchantCounty" name="merchantCounty" value="" required>

            @if ($errors->has('merchantCounty'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantCounty') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Postcode') }}</label>
            <input class="form-control" id="merchantPostcode" name="merchantPostcode" value="" required>

            @if ($errors->has('merchantPostcode'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantPostcode') }}</strong>
            </span>
            @endif
          </div>
        </div>


        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Country') }}</label>
            <input class="form-control" id="merchantCountry" name="merchantCountry" value="" required>

            @if ($errors->has('merchantCountry'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantCountry') }}</strong>
            </span>
            @endif
          </div>
        </div>


        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Phone #') }}</label>
            <input class="form-control" id="merchantPhone" name="merchantPhone" value="" required>

            @if ($errors->has('merchantPhone'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantPhone') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Fax #') }}</label>
            <input class="form-control" id="merchantFax" name="merchantFax" value="" >

            @if ($errors->has('merchantFax'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantFax') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Email') }}</label>
            <input class="form-control" id="merchantEmail" name="merchantEmail" value="" required>

            @if ($errors->has('merchantEmail'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantEmail') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Web Address') }}</label>
            <input class="form-control" id="merchantWeb" name="merchantWeb" value="" required>

            @if ($errors->has('merchantWeb'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantWeb') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Longitute') }}</label>
            <input type="text" class="form-control" id="lng" name="lng" value="" required>

            @if ($errors->has('lng'))
            <span class="help-block">
              <strong>{{ $errors->first('lng') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Latitude') }}</label>
            <input type="text" class="form-control" id="lat" name="lat" value="" required>

            @if ($errors->has('lat'))
            <span class="help-block">
              <strong>{{ $errors->first('lat') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Contact Name') }}</label>
            <input class="form-control" id="merchantContactName" name="merchantContactName" value="">

            @if ($errors->has('merchantContactName'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantContactName') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <!-- <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Contact Email') }}</label>
            <input class="form-control" id="merchantContactEmail" name="merchantContactEmail" value="" required>

            @if ($errors->has('merchantContactEmail'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantContactEmail') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Merchant Contact Phone #') }}</label>
            <input class="form-control" id="merchantContactPhone" name="merchantContactPhone" value="">

            @if ($errors->has('merchantContactPhone'))
            <span class="help-block">
              <strong>{{ $errors->first('merchantContactPhone') }}</strong>
            </span>
            @endif
          </div>
        </div>-->



        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-3">
          <button type="submit" class="btn btn-primary">Submit </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>



@endsection
