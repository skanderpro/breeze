@extends('layouts.app')

@section('content')
<?php $title = 'Edit <span>Company</span>'; ?>
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


          <form class="form-horizontal" role="form" method="POST" action="{{ url('/company-edit/') }}/{{ $companyedit->id }}" enctype="multipart/form-data">
          {!! csrf_field() !!}

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Company Name</label>
                <input type="text" class="form-control" id="companyName" name="companyName" placeholder="companyName" value="{{ $companyedit->companyName }}" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Company Phone</label>
                <input type="text" class="form-control" id="companyPhone" name="companyPhone" placeholder="companyPhone" value="{{ $companyedit->companyPhone }}" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Company Fax</label>
                <input type="text" class="form-control" id="companyFax" name="companyFax" placeholder="Company Fax" value="{{ $companyedit->companyFax }}">
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Company Contact</label>
                <input type="text" class="form-control" id="companyContact" name="companyContact" placeholder="Company Contact" value="{{ $companyedit->companyContact }}" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Company Contact Email</label>
                <input type="text" class="form-control" id="companyContactEmail" name="companyContactEmail" placeholder="Company Contact Email" value="{{ $companyedit->companyContactEmail }}" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="offset-md-3 col-md-8">
                <label class="main">Company Address</label>
                <input type="text" class="form-control" id="companyAddress" name="companyAddress" placeholder="Company Address" value="{{ $companyedit->companyAddress }}" required>
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
              COMPANY <br />
              SUCCESSFULLY<br />
              UPDATED.
              <a href="{{ url('/company-list/') }}"> < Back to Company List</a>
            </div>
          @endif
        </div>
    </div>


  </div>

</div>



@endsection
