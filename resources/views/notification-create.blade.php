@extends('layouts.app')

@section('content')
<?php $title = 'Create <span>New Notification</span>'; ?>
<div class="container-fluid user">

  <div class="row">
    <div class="col-md-5 col-lg-3 contactdetails">

      <h3>Notification</h3>
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
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/notification-create') }}">
      {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('companyName') ? ' has-error' : '' }} row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Notification Title') }}</label>
            <input type="text" class="form-control" id="title" name="title" value="" required>

            @if ($errors->has('title'))
            <span class="help-block">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Notification Content') }}</label>
            <textarea class="form-control" id="content" name="content" rows="10" cols="30" required></textarea>

              @if ($errors->has('content'))
              <span class="help-block">
                <strong>{{ $errors->first('content') }}</strong>
              </span>
              @endif
          </div>
        </div>

        <!-- <div class="form-group row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Active?') }}</label>
            <input type="checkbox" name="active" id="active" value="1">

              @if ($errors->has('active'))
              <span class="help-block">
                <strong>{{ $errors->first('active') }}</strong>
              </span>
              @endif
          </div>
        </div> -->

        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-3">
            <button type="submit" class="btn btn-primary">
              {{ __('Add Notification') }}
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

</div>



@endsection
