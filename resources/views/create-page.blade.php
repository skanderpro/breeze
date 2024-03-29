@extends('layouts.app')

@section('content')
<?php $title = 'Create <span>New Page</span>'; ?>
<div class="container-fluid user">

  <div class="row">
    <div class="col-md-5 col-lg-3 contactdetails">

      <h3>Company</h3>
      <p class="company">{{ $company->companyName }}</p>
      <h3>Operator</h3>
      <p>{{ Auth::user()->name }}</p>

      @cannot(\App\Enums\Permission::MENU_READ_ADMIN->value)

        <h3>For assistance please call</h3>
        <p class="phone">{{ $adminusr->phone }}</p>

      @endcannot

      <h3>Date</h3>
      <p><?php echo date('d.m.y') ?></p>

    </div>
    <div class="col-md-7 col-lg-9 form">
      <form class="form-horizontal" role="form" method="POST" action="{{ !empty($page) ? route('update-page', ['page' => $page]) : route('store-page') }}">
      {!! csrf_field() !!}
        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }} row">
          <div class="offset-md-3 col-md-6">
            <label for="name" class="col-form-label">{{ __('Title') }}</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ !empty($page) ? $page->title : '' }}" required>

            @if ($errors->has('title'))
            <span class="help-block">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
            @endif
          </div>
        </div>

          <div class="form-group row  {{ $errors->has('description') ? ' has-error' : '' }}">
              <div class="offset-md-3 col-md-6">
                  <label for="name" class="col-form-label">{{ __('Description') }}</label>
                  <textarea class="form-control" id="description" name="description" rows="10" cols="30" required>
                      {{ !empty($page->description) ? $page->description : '' }}
                  </textarea>

                  @if ($errors->has('description'))
                      <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
              </span>
                  @endif
              </div>
          </div>

        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-3">
            <button type="submit" class="btn btn-primary">
              {{ !empty($page) ? __('Save Page') : __('Add page') }}
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

</div>



@endsection
