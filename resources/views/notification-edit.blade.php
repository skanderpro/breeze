@extends('layouts.app')

@section('content')
<?php $title = 'Edit <span>Notification</span>'; ?>
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


          <form class="form-horizontal" role="form" method="POST" action="{{ url('/notification-edit/') }}/{{ $notificationedit->id }}" enctype="multipart/form-data">
          {!! csrf_field() !!}

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="companyName" value="{{ $notificationedit->title }}" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Content</label>
                <textarea class="form-control" name="content" id="content" rows="8" cols="80" required>{{ $notificationedit->content }}</textarea>
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
              NOTIFICATION<br />
              SUCCESSFULLY<br />
              UPDATED.
              <a href="{{ url('/notification-list/') }}"> < Back to Notification List</a>
            </div>
          @endif
        </div>
    </div>


  </div>

</div>



@endsection
