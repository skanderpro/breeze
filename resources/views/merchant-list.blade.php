@extends('layouts.app')

@section('content')
<?php $title = 'Merchant <span>List</span>'; ?>
<div class="container-fluid user">

  <div class="row">
      <div class="col-md-12">

        <form class="form_search">
          <label>Search Merchants</label>
          <input name="search" type="text" class="form-control" placeholder="Search by Id, Name, Address or email " value="{{ $search }}">
          @if ($search) <a href="{{ url('merchant-list') }}">clear search</a> @endif
        </form>

        @if (session('message'))
          <div class="flash-message">
           <div class="alert alert-success alert-dismissible" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               {{ session('message') }}
           </div>
          </div>
        @endif

        @foreach($merchants as $merchant)
        <div class="row user_entry">
          <div class="col-md-3 user_entry_email">
            <label>Merchant Name</label>
            {{ $merchant->merchantName }}
          </div>
          <div class="col-md-3 user_entry_email">
            <label>Merchant Address</label>
            {{ $merchant->merchantAddress1 }},
            {{ $merchant->merchantCounty }},
            {{ $merchant->merchantPostcode }}
            <a href="https://maps.google.com/?ll={{ $merchant->lng }},{{ $merchant->lat }}" target="_blank">View on Google Maps</a>
          </div>
          <div class="col-md-2 user_entry_email">
            <label>Merchant Contact Details</label>
            {{ $merchant->merchantContactName }}<br />
            {{ $merchant->merchantContactPhone }}
          </div>
          <div class="col-md-2 user_entry_email">
            <label>Merchant Contact Email</label>
            <a href="mailto:{{ $merchant->merchantContactEmail }}" target="_blank">{{ $merchant->merchantContactEmail }}</a>
          </div>
          <div class="col-md-2 user_entry_email">
            @if (Auth::user()->accessLevel == '1')
              <a href="{{ url('merchant-delete') }}/{{ $merchant->id }}" onclick="return confirm('This action cannot be undone, are you sure you want to remove {{ $merchant->merchantName }}?')">
                <img src="{{ asset('/images/remove.svg') }}" alt="Remove Merchant">
              </a>
              <a href="{{ url('merchant-edit') }}/{{ $merchant->id }}">
                <img src="{{ asset('/images/edit.svg') }}" alt="Edit Company">
              </a>
            @endif
          </div>
        </div>
        @endforeach

      {{ $merchants->links() }}
    </div>
  </div>
</div>
@endsection
