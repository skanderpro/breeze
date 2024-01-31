@extends('layouts.app')

@section('content')
<?php $title = 'Company <span>List</span>'; ?>
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


        @foreach($companies as $company)

        <div class="row user_entry">
          <div class="col-md-2 user_entry_email">
            <label class="main">Company Name</label>
            {{ $company->companyName }}
          </div>
          <div class="col-md-2 user_entry_email">
            <label class="main">Company Phone</label>
            {{ $company->companyPhone }}
          </div>
          <div class="col-md-2 user_entry_email">
            <label class="main">Company Fax</label>
            {{ $company->companyFax }}
          </div>
          <div class="col-md-2 user_entry_email">
            <label class="main">Company Contact</label>
            {{ $company->companyContact }}
          </div>
          <div class="col-md-2 user_entry_email">
            <label class="main">Company Address</label>
            {{ $company->companyAddress }}
          </div>
          <div class="col-md-2 user_entry_email">



            <a href="{{ url('company-edit') }}/{{ $company->id }}">
              <img src="{{ asset('/images/edit.svg') }}" alt="Edit Company">
            </a>

            @if ($company->disabled == 1)
            <a href="{{ url('company-enable') }}/{{ $company->id }}">
              <img src="{{ asset('/images/enable-company.svg') }}" alt="Disable Company">
            </a>
            @else
            <a href="{{ url('company-disable') }}/{{ $company->id }}">
              <img src="{{ asset('/images/disable-company.svg') }}" alt="Disable Company">
            </a>
            @endif



          </div>
        </div>
        @endforeach

      {{ $companies->links() }}
    </div>
  </div>
</div>
@endsection
