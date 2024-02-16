@extends('layouts.app')

@section('content')
<?php $title = 'Notifications <span>List</span>'; ?>
<div class="container-fluid user">
  <div class="row">
      <div class="col-md-12">

        @if (session('message'))
          <div class="flash-message">
           <div class="alert alert-success alert-dismissible" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               {{ session('message') }}
           </div>
          </div>
        @endif


        @foreach($notifications as $notification)

        <div class="row user_entry">
          <div class="col-md-5 user_entry_email">
            <label class="main">Title</label>
            {{ $notification->title }}
          </div>
          <div class="col-md-4 user_entry_email">
            <label class="main">Created Date</label>
            {{ $notification->created_at }}
          </div>
          <div class="col-md-3 user_entry_email">



            <a href="{{ url('notification-edit') }}/{{ $notification->id }}">
              <img src="{{ asset('/images/edit.svg') }}" alt="Edit Company">
            </a>



          </div>
        </div>
        @endforeach

      {{ $notifications->links() }}
    </div>
  </div>
</div>
@endsection
