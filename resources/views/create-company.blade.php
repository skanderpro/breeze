@extends('layouts.app')

@section('content')
<?php $title = 'Create <span>New Company</span>'; ?>
<div class="container-fluid user">

  <div class="row">
    <div class="col-md-5 col-lg-3 contactdetails">

      <h3>Company</h3>
      <p class="company">{{ $company->companyName }}</p>
      <h3>Operator</h3>
      <p>{{ Auth::user()->name }}</p>

      @if (Auth::user()->accessLevel == '3' || Auth::user()->accessLevel == '2')

        <h3>For assistance please call</h3>
        <p class="phone">{{ $adminusr->phone }}</p>

      @endif

      <h3>Date</h3>
      <p><?php echo date('d.m.y') ?></p>

    </div>
    <div class="col-md-7 col-lg-9 form">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/company-create') }}">
      {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('companyName') ? ' has-error' : '' }} row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Company Name') }}</label>
            <input type="text" class="form-control" id="companyName" name="companyName" value="" required>

            @if ($errors->has('companyName'))
            <span class="help-block">
              <strong>{{ $errors->first('companyName') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Company Phone') }}</label>
            <input type="text" class="form-control" id="companyPhone" name="companyPhone" value="" required>

              @if ($errors->has('companyPhone'))
              <span class="help-block">
                <strong>{{ $errors->first('companyPhone') }}</strong>
              </span>
              @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Company Fax') }}</label>

            <input class="form-control" id="companyFax" name="companyFax" value="">

            @if ($errors->has('companyFax'))
            <span class="help-block">
              <strong>{{ $errors->first('companyFax') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Company Contact') }}</label>

            <input class="form-control" id="companyContact" name="companyContact" value="" required>

            @if ($errors->has('companyContact'))
            <span class="help-block">
              <strong>{{ $errors->first('companyContact') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Company Contact Email') }}</label>

            <input class="form-control" id="companyContactEmail" name="companyContactEmail" value="" required>

            @if ($errors->has('companyContactEmail'))
            <span class="help-block">
              <strong>{{ $errors->first('companyContactEmail') }}</strong>
            </span>
            @endif
          </div>
        </div>


        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Company Address') }}</label>

            <input class="form-control" id="companyAddress" name="companyAddress" value="" required>

            @if ($errors->has('companyAddress'))
            <span class="help-block">
              <strong>{{ $errors->first('companyAddress') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-3">
            <button type="submit" class="btn btn-primary">
              {{ __('Add Company') }}
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

</div>



@endsection
