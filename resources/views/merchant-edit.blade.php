@extends('layouts.app')

@section('content')
<?php $title = 'Edit <span>Merchant</span>'; ?>
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

      <div class="row">

        <div class="col-md-8 form_wrapper">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/merchant-edit/') }}/{{ $merchants->id }}" enctype="multipart/form-data">
          {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('poType') ? ' has-error' : '' }}">

              <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                  <label class="main">Merchant Name</label>
                  <input type="text" class="form-control" id="merchantName" name="merchantName" placeholder="merchantName" value="{{ $merchants->merchantName }}" required />
                  @if ($errors->has('merchantName'))
                  <span class="help-block">
                    <strong>{{ $errors->first('merchantName') }}</strong>
                  </span>
                  @endif
                </div>
            </div>

              <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                  <label class="main">Merchant ID</label>
                  <input type="text" class="form-control" id="merchantId" name="merchantId" placeholder="merchantId" value="{{ $merchants->merchantId }}" required>
                  @if ($errors->has('merchantId'))
                  <span class="help-block">
                    <strong>{{ $errors->first('merchantId') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>


            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Address 1</label>
                <input type="text" class="form-control" id="merchantAddress1" name="merchantAddress1" value="{{ $merchants->merchantAddress1 }}" required>
                @if ($errors->has('merchantAddress1'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantAddress1') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Address 2</label>
                <input class="form-control" id="merchantAddress2" name="merchantAddress2" value="{{ $merchants->merchantAddress2 }}" required>
                @if ($errors->has('merchantAddress2'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantAddress2') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant County</label>
                <input class="form-control" id="merchantCounty" name="merchantCounty" value="{{ $merchants->merchantCounty }}" required>
                @if ($errors->has('merchantCounty'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantCounty') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Postcode</label>
                <input class="form-control" id="merchantPostcode" name="merchantPostcode" value="{{ $merchants->merchantPostcode }}" required>
                @if ($errors->has('merchantPostcode'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantPostcode') }}</strong>
                </span>
                @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Phone</label>
                <input class="form-control" id="merchantPhone" name="merchantPhone" value="{{ $merchants->merchantPhone }}" required>
                @if ($errors->has('merchantPhone'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantPhone') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Fax</label>
                <input class="form-control" id="merchantFax" name="merchantFax" value="{{ $merchants->merchantFax }}">
                @if ($errors->has('merchantFax'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantFax') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Email</label>
                <input class="form-control" id="merchantEmail" name="merchantEmail" value="{{ $merchants->merchantEmail }}">
                @if ($errors->has('merchantEmail'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantEmail') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Web</label>
                <input class="form-control" id="merchantWeb" name="merchantWeb" value="{{ $merchants->merchantWeb }}">
                @if ($errors->has('merchantWeb'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantWeb') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 {{ $errors->has('green_supplier') ? ' has-error' : '' }}">
                    <label for="name" class="col-form-label">{{ __('Green Supplier') }}</label>


                    <input type="checkbox" id="green_supplier" name="green_supplier" value="1" @if($merchants->green_supplier) checked @endif>

                    @if ($errors->has('green_supplier'))
                        <span class="help-block">
                  <strong>{{ $errors->first('green_supplier') }}</strong>
                </span>
                    @endif

                </div>

              <div class="col-lg-2 {{ $errors->has('merchantPlumbing') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Plumbing') }}</label>

                <input type="hidden" name="merchantPlumbing" value="">
                <input type="checkbox" id="merchantPlumbing" name="merchantPlumbing" value="YES" @if($merchants->merchantPlumbing) checked @endif>

                @if ($errors->has('merchantPlumbing'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantPlumbing') }}</strong>
                </span>
                @endif

              </div>
              <div class="col-lg-2 {{ $errors->has('merchantElectrical') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Electrical') }}</label>

                <input type="hidden" name="merchantElectrical" value="">
                <input type="checkbox" id="merchantElectrical" name="merchantElectrical" value="YES" @if($merchants->merchantElectrical) checked @endif>

                @if ($errors->has('merchantElectrical'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantElectrical') }}</strong>
                </span>
                @endif

              </div>
              <div class="col-lg-2 {{ $errors->has('merchantBuilders') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Builders') }}</label>

                <input type="hidden" name="merchantBuilders" value="">
                <input type="checkbox" id="merchantBuilders" name="merchantBuilders" value="YES" @if($merchants->merchantBuilders) checked @endif>

                @if ($errors->has('merchantBuilders'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantBuilders') }}</strong>
                </span>
                @endif

              </div>
              <div class="col-lg-2 {{ $errors->has('merchantHire') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Hire') }}</label>

                <input type="hidden" name="merchantHire" value="">
                <input type="checkbox" id="merchantHire" name="merchantHire" value="YES" @if($merchants->merchantHire) checked @endif>

                @if ($errors->has('merchantHire'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantHire') }}</strong>
                </span>
                @endif

              </div>



              <div class="col-lg-2 {{ $errors->has('merchantDecorating') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Painting & Decorating') }}</label>
                <input type="checkbox" id="merchantDecorating" name="merchantDecorating" value="YES" @if($merchants->merchantDecorating) checked @endif>

                @if ($errors->has('merchantDecorating'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantDecorating') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantFlooring') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Flooring') }}</label>

                <input type="hidden" name="merchantFlooring" value="">
                <input type="checkbox" id="merchantFlooring" name="merchantFlooring" value="YES" @if($merchants->merchantFlooring) checked @endif>

                @if ($errors->has('merchantFlooring'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantFlooring') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantAuto') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Auto Parts') }}</label>

                <input type="hidden" name="merchantAuto" value="">
                <input type="checkbox" id="merchantAuto" name="merchantAuto" value="YES" @if($merchants->merchantAuto) checked @endif>

                @if ($errors->has('merchantAuto'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantAuto') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantAggregate') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Aggregate') }}</label>

                <input type="hidden" name="merchantAggregate" value="">
                <input type="checkbox" id="merchantAggregate" name="merchantAggregate" value="YES" @if($merchants->merchantAggregate) checked @endif>

                @if ($errors->has('merchantAggregate'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantAggregate') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantRoofing') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Roofing') }}</label>

                <input type="hidden" name="merchantRoofing" value="">
                <input type="checkbox" id="merchantRoofing" name="merchantRoofing" value="YES" @if($merchants->merchantRoofing) checked @endif>

                @if ($errors->has('merchantRoofing'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantRoofing') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantFixings') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Fixings & Fasteners') }}</label>

                <input type="hidden" name="merchantFixings" value="">
                <input type="checkbox" id="merchantFixings" name="merchantFixings" value="YES" @if($merchants->merchantFixings) checked @endif>

                @if ($errors->has('merchantFixings'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantFixings') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantIronmongery') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Ironmongery & Hardware') }}</label>

                <input type="hidden" name="merchantIronmongery" value="">
                <input type="checkbox" id="merchantIronmongery" name="merchantIronmongery" value="YES" @if($merchants->merchantIronmongery) checked @endif>

                @if ($errors->has('merchantIronmongery'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantIronmongery') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantTyres') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Tyres') }}</label>

                <input type="hidden" name="merchantTyres" value="">
                <input type="checkbox" id="merchantTyres" name="merchantTyres" value="YES" @if($merchants->merchantTyres) checked @endif>

                @if ($errors->has('merchantTyres'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantTyres') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-lg-2 {{ $errors->has('merchantHealth') ? ' has-error' : '' }}">
                <label for="name" class="col-form-label">{{ __('Health & Safety') }}</label>

                <input type="hidden" name="merchantHealth" value="">
                <input type="checkbox" id="merchantHealth" name="merchantHealth" value="YES" @if($merchants->merchantHealth) checked @endif>

                @if ($errors->has('merchantHealth'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantHealth') }}</strong>
                </span>
                @endif

              </div>
            </div>

            <div class="form-group row">
              <div class="offset-md-3 col-md-3">
                <label class="main">Merchant Lng</label>
                <input type="text" class="form-control" id="lng" name="lng" value="{{ $merchants->lng }}" required>
                @if ($errors->has('lng'))
                <span class="help-block">
                  <strong>{{ $errors->first('lng') }}</strong>
                </span>
                @endif
              </div>

              <div class="col-md-3">
                <label class="main">Merchant Lat</label>
                <input type="text" class="form-control" id="lat" name="lat" value="{{ $merchants->lat }}" required>
                @if ($errors->has('lat'))
                <span class="help-block">
                  <strong>{{ $errors->first('lat') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Contact Name</label>
                <input class="form-control" id="merchantContactName" name="merchantContactName" value="{{ $merchants->merchantContactName }}">
                @if ($errors->has('merchantContactName'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantContactName') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <!-- <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">Merchant Contact Email</label>
                <input class="form-control" id="merchantContactEmail" name="merchantContactEmail" value="{{ $merchants->merchantContactEmail }}">
              </div>
            </div> -->

            <div class="form-group row">
                <div class="offset-md-3 col-md-8">
                <label class="main">merchant Contact Phone</label>
                <input class="form-control" id="merchantContactPhone" name="merchantContactPhone" value="{{ $merchants->merchantContactPhone }}">
                @if ($errors->has('merchantContactPhone'))
                <span class="help-block">
                  <strong>{{ $errors->first('merchantContactPhone') }}</strong>
                </span>
                @endif
              </div>
            </div>



            <div class="form-group row">
              <div class="offset-md-3 col-md-8">

                <button type="submit" class="btn btn-default">Update</button>

              </div>
            </div>

            </form>

        </div>

        <div class="col-md-3 form_wrapper_details">

          @if (session('message'))
            <div class="flash-message">
              MERCHANT <br />
              SUCCESSFULLY<br />
              UPDATED.
              <a href="{{ url('/merchant-list/') }}"> < Back to Merchant List</a>
            </div>
          @endif
        </div>
      </div>

    </div>

</div>



@endsection
