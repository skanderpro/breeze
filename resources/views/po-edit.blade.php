@extends('layouts.app')

@section('content')
<?php $title = 'Edit <span>Purchase Order</span>'; ?>


@if (session('message'))
  <div class="flash-message">
   <div class="alert alert-success alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       {{ session('message') }}
       <a href="{{ url('/po-list/') }}" class="alert-link"> < Back to P/O List </a>
   </div>
  </div>
@endif


<div class="container-fluid po-create">



  <form class="form-horizontal" role="form" method="POST" action="{{ url('/po-edit/') }}/{{ $po->id }}" enctype="multipart/form-data">
  {!! csrf_field() !!}

  <div class="row">

      <div class="col-md-6 col-lg-4 po-create__data">

          <div class="form-group row">
            <div class="col-6">
              <label class="main">Em Number</label>
              EM-{{ $po->id }}
            </div>
            <div class="col-6">
              <label class="main">Created</label>
              {{ $po->created_at->format('d.m.Y H:i:s') }}
            </div>
          </div>

          <div class="form-group row">
            <div class="col-6">
              <label class="main">Name</label>
              {{ $po->name }}

            </div>
            <div class="col-6">
              <label class="main">Company Name</label>
              {{ $po->companyName }}
            </div>
          </div>

          <div class="form-group">
            <input type="text" class="form-control d-none" id="companyId" name="companyId" placeholder="companyId" value="{{ $po->companyId }}">
          </div>

          <div class="form-group">
            <input type="text" class="form-control d-none" id="u_id" name="u_id" placeholder="u_id" value="{{ $po->u_id }}">
          </div>


        <div class="form-group row">
          <div class="col-6">
            <label class="main">Supplier Type</label>
            {{ $po->poType }}
            <input type="text" class="form-control d-none" id="poPurpose" name="poPurpose" value="{{ $po->poPurpose }}">
          </div>

          <div class="col-6">
            @if ($po->merchantName)
              <div class="form-group">
                <label class="main">Selected Merchant</label>
                {{ $po->merchantName }}
              </div>
            @else
              <div class="form-group">
                <label class="main">Selected Merchant</label>
                {{ $po->inputMerchant }}
                <input type="text" class="form-control d-none" id="inputMerchant" name="inputMerchant" value="{{ $po->inputMerchant }}">
              </div>
            @endif
          </div>

        </div>

        <div class="form-group">
          <label class="main">Order Purpose</label>
          {{ $po->poPurpose }}
          <input type="text" class="form-control d-none" id="poType" name="poType" placeholder="poType" value="{{ $po->poType }}">
        </div>


        <div class="form-group row">

          <div class="col-6">
            <label class="main">Task/Project</label>
            {{ $po->poProject }}
            <input class="form-control d-none" id="poProject" name="poProject" value="{{ $po->poProject }}">
          </div>

          <div class="col-6">
            <label class="main">Project Location</label>
            {{ $po->poProjectLocation }}
            <input class="form-control d-none" id="poProjectLocation" name="poProjectLocation" value="{{ $po->poProjectLocation }}">
          </div>



        </div>

      </div>

      <div class="col-md-6 col-lg-4 po-create__data">

        <div class="form-group row">
          <div class="col-6">
            <label class="main">Supplier Cost</label>
              @if(Auth::user()->accessLevel == 1)
              <input autocomplete="off" class="form-control" id="poValue" name="poValue" value="{{ $po->poValue }}" placeholder="Add Supplier Cost">
              @else
              {{ $po->poValue }}
              @endif

            @if ($errors->has('poValue'))
            <span class="help-block">
              <strong>{{ $errors->first('poValue') }}</strong>
            </span>
            @endif
          </div>

          @if(Auth::user()->accessLevel == 1)
          <div class="col-6">
            <label class="main">Billable Value</label>
            <input class="form-control" id="poCostSheet" name="poCostSheet" value="{{ $po->poCostSheet }}" placeholder="Add Billable Value">

            @if ($errors->has('poCostSheet'))
            <span class="help-block">
              <strong>{{ $errors->first('poCostSheet') }}</strong>
            </span>
            @endif
          </div>
          @endif

        </div>

        @if(Auth::user()->accessLevel == 1)

          <div class="form-group row">
            <div class="col-md-6">
              <label class="main">Merchant Invoice #</label>
              <input class="form-control" id="poInvoice" name="poInvoice" value="{{ $po->poInvoice }}" placeholder="Add Merchant Invoice #">

              @if ($errors->has('poInvoice'))
              <span class="help-block">
                <strong>{{ $errors->first('poInvoice') }}</strong>
              </span>
              @endif
            </div>
            <div class="col-md-6">
              <label class="main">EM Invoice #</label>
              <input class="form-control" id="poEMInvoice" name="poEMInvoice" value="{{ $po->poEMInvoice }}" placeholder="Add EM Invoice #">

              @if ($errors->has('poEMInvoice'))
              <span class="help-block">
                <strong>{{ $errors->first('poEMInvoice') }}</strong>
              </span>
              @endif
            </div>
          </div>

        @endif


        @if(Auth::user()->accessLevel == 2 && $po->poInvoice)

            <div class="form-group">
              <label class="main">Merchant Invoice #</label>
              {{ $po->poInvoice }}
            </div>

        @endif

        @if(Auth::user()->accessLevel == 2 && $po->poEMInvoice)

            <div class="form-group">
              <label class="main">EM Invoice #</label>
              {{ $po->poEMInvoice }}
            </div>

        @endif


        <div class="form-group">

          @if ($po->poPod)
          <label class="main">View Proof of Delivery</label>


          @if (str_contains($po->poPod, '.jpg') || str_contains($po->poPod, '.pdf') || str_contains($po->poPod, '.jpeg'))
            <a href="{{ url('/uploads/') }}/{{ $po->poPod }}" target="_blank">View POD</a><br />
            <a href="{{ url('/uploads/') }}/{{ $po->poPod }}" download>Download POD</a>
          @else
            <a href="{{ url('/uploads/') }}/{{ $po->id }}.jpg" target="_blank">View POD</a><br />
            <a href="{{ url('/uploads/') }}/{{ $po->id }}.jpg" download>Download POD</a>
          @endif



          <br /><br />
          <label class="main">Update Proof of Delivery</label>
          <input type="file" id="poPod" name="poPod" accept="application/pdf,image/jpeg">
          @else

          <label class="main">Proof of Delivery</label>
            <input type="file" id="poPod" name="poPod" accept="application/pdf,image/jpeg">


          @endif



          @if ($errors->has('poPod'))
          <span class="help-block">
            <strong>{{ $errors->first('poPod') }}</strong>
          </span>
          @endif
        </div>

        @if(Auth::user()->accessLevel == 1 || Auth::user()->accessLevel == 2)

          <div class="form-group">
            <label class="main">Company P/O</label>
            <input class="form-control" id="poCompanyPo" name="poCompanyPo" value="{{ $po->poCompanyPo }}" placeholder="Add Company P/O #">

            @if ($errors->has('poCompanyPo'))
            <span class="help-block">
              <strong>{{ $errors->first('poCompanyPo') }}</strong>
            </span>
            @endif
          </div>

        @endif

      </div>

      <div class="col-lg-4 po-create__data">

        @if(Auth::user()->accessLevel == 1)

        <div class="row">
          <!-- <div class="col-md-6">
            <div class="form-group">
              <label for="name" class="col-form-label">{{ __('Job Status') }}</label>

              <select class="form-control" name="poJobStatus" id="poJobStatus">
                <option value="">Select a job status</option>
                <option value="1" @if ($po->poJobStatus == 1) selected @endif>New Purchase</option>
                <option value="2" @if ($po->poJobStatus == 2) selected @endif>100% Complete</option>
              </select>

              @if ($errors->has('poJobStatus'))
              <span class="help-block">
                <strong>{{ $errors->first('poJobStatus') }}</strong>
              </span>
              @endif
            </div>
          </div> -->

          <div class="col-md-12">
            <div class="form-group">
              <label for="name" class="col-form-label">{{ __('Order Status') }}</label>

              <select class="form-control" name="poFinanceStatus" id="poFinanceStatus">
                <option value="">Select an order status</option>
                <option value="1" @if ($po->poFinanceStatus == 1) selected @endif>New Order</option>
                <option value="2" @if ($po->poFinanceStatus == 2) selected @endif>Pending Invoice</option>
                <option value="3" @if ($po->poFinanceStatus == 3) selected @endif>Awaiting Payments</option>
                <option value="4" @if ($po->poFinanceStatus == 4) selected @endif>100% Paid</option>
                <option value="5" @if ($po->poFinanceStatus == 5) selected @endif>Awaiting Company PO</option>



              </select>

              @if ($errors->has('poFinanceStatus'))
              <span class="help-block">
                <strong>{{ $errors->first('poFinanceStatus') }}</strong>
              </span>
              @endif
            </div>
          </div>
        </div>



        @endif

        <label class="main">Material Brief</label>

        <p>{{ $po->poMaterials }}</p>

        <input class="form-control d-none" type="textarea" name="poMaterials" id="poMaterials" value="{{ $po->poMaterials }}">

        @if(Auth::user()->accessLevel == 1)
          @if (!$po->poNotes)


          <label class="main">Note</label>

            <p>
            <a class="main" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              Add	a	Note to PO
            </a>
            </p>

            <div class="collapse form-group" id="collapseExample">
              <!-- <div class="card card-body"> -->
                <textarea class="form-control" id="poNotes" name="poNotes" value="" placeholder="Add a P/O note"></textarea>
              <!-- </div> -->
              @if ($errors->has('poNotes'))
              <span class="help-block">
                <strong>{{ $errors->first('poNotes') }}</strong>
              </span>
              @endif
            </div>
          @else

          <label class="main">Note</label>

          <p>{{ $po->poNotes }}</p>


            <!-- <p>
            <a class="main" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              Click here to view/add a note
            </a>
          </p> -->

          <div class="collapse form-group" id="collapseExample">
            <!-- <div class="card card-body"> -->
              <input class="form-control" id="poNotes" name="poNotes" value="{{ $po->poNotes }}">
            <!-- </div> -->
            @if ($errors->has('poNotes'))
            <span class="help-block">
              <strong>{{ $errors->first('poNotes') }}</strong>
            </span>
            @endif
          </div>
          @endif
        @endif



        @if ($po->poCancelled)

        @else
          <div class="form-group">

            @if(Auth::user()->accessLevel == 1)
            <label class="main">Cancel?</label>
            <input type="checkbox" class="form-control" id="poCancelled" name="poCancelled" value="1">
            @endif

            @if ($errors->has('poCompanyPo'))
            <span class="help-block">
              <strong>{{ $errors->first('poCancelled') }}</strong>
            </span>
            @endif
          </div>


          <div style="display: none;">
            <label class="main">Cancelled By</label>
            <input class="form-control" id="poCancelledBy" name="poCancelledBy" value="{{ Auth::user()->name }}">

            @if ($errors->has('poCancelledBy'))
            <span class="help-block">
              <strong>{{ $errors->first('poCancelledBy') }}</strong>
            </span>
            @endif
          </div>

        @endif

        @if ($po->poCancelled)
        <div class="alert alert-danger" role="alert">
          This P/O has been cancelled by <strong>{{ $po->poCancelledBy }}</strong> and cannot be edited/updated
        </div>
        @else
        <div class="form-group custom-search-form">
          <button type="submit" class="btn btn-default">Update</button>
        </div>
        @endif





      </div>


</div>

</form>



@endsection
