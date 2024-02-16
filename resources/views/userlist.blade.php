@extends('layouts.app')

@section('content')
<?php $title = 'Manage <span>User Accounts</span>'; ?>
<div class="container-fluid user">
    <div class="row justify-content-center">
        <div class="col-md-12">

          <form class="form_search">
            <label>Search Users</label>
            <input name="search" type="text" class="form-control" placeholder="Search by Name, Email or Company " value="{{ $search }}">
            @if ($search) <a href="{{ url('userlist') }}">clear search</a> @endif
          </form>

          @if (session('message'))
            <div class="flash-message">
             <div class="alert alert-success alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 {{ session('message') }}
             </div>
            </div>
          @endif


          @foreach($users as $user)
          <div class="row user_entry">
            <div class="col-6 col-md-5 col-lg-3">
              <div class="user_entry_name clearfix">
                <div class="vert-align">
                  <span>{{ $user->name }}</span>
                </div>
                <a href="{{ url('/po-list') }}?u_id={{ $user->id }}"><img src="{{ asset('/images/view-all-pos.svg') }}" alt="View all POs"></a>
              </div>
            </div>
            <div class="col-6 col-lg-2 user_entry_email">
              <label for="">Email</label>
              <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
            </div>
            <div class="col-4 col-lg-1 col-xl-2 user_entry_email">
              <label for="">Company</label>

              <?php

              $compName = DB::table('companies')->where('id', $user->companyId )->first();

               ?>

              {{ $compName->companyName }}


            </div>
            <div class="col-4 col-lg-1 user_entry_email">
              <label for="">Phone</label>
              {{ $user->phone }}
            </div>
            <div class="col-4 col-lg-1 user_entry_pos">
              <label for="">P/O’s</label>

              <?php $poquery = DB::table('pos')->where('u_id', '=', $user->id)->get();
              $poqueryCount = count($poquery)
               ?>

              {{ $poqueryCount }}

            </div>
            <div class="col-6 col-lg-1 user_entry_pod">
              <label for="">POD Needed</label>

              <?php $podquery = DB::table('pos')->where('u_id', '=', $user->id)->where('poPod', "")->get();
              $podqueryCount = count($podquery)
               ?>

              {{ $podqueryCount }}

            </div>
            <div class="col-6 col-lg-3 col-xl-2 user_entry_controls">

              @if ($user->disabled == 1)

              <!-- <a href="{{ url('delete-user') }}/{{ $user->id }}" onclick="return confirm('This action cannot be undone, are you sure?')">
                <img src="{{ asset('/images/remove-user.svg') }}" alt="Remove User">
              </a> -->
              <a href="{{ url('enable-user') }}/{{ $user->id }}" onclick="return confirm('Are you sure you wish to enable {{ $user->name }}?')">
                <img src="{{ asset('/images/enable-user.svg') }}" alt="Enable User">
              </a>
              <a href="{{ url('users') }}/{{ $user->id }}">
                <img src="{{ asset('/images/edit.svg') }}" alt="Edit User">
              </a>
              @else
              <!-- <a href="{{ url('delete-user') }}/{{ $user->id }}" onclick="return confirm('This action cannot be undone, are you sure?')">
                <img src="{{ asset('/images/remove-user.svg') }}" alt="Remove User">
              </a> -->
              <a href="{{ url('disable-user') }}/{{ $user->id }}" onclick="return confirm('Are you sure you wish to disable {{ $user->name }}?')">
                <img src="{{ asset('/images/disable-user.svg') }}" alt="Disable User">
              </a>
              <a href="{{ url('users') }}/{{ $user->id }}">
                <img src="{{ asset('/images/edit.svg') }}" alt="Edit User">
              </a>
              @endif

            </div>
          </div>
          @endforeach


        {{ $users->links() }}
      </div>
    </div>
</div>
@endsection
