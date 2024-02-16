@extends('layouts.app')

@section('content')
<?php $title = 'Purchase Order <span>Created</span>'; ?>
<div class="container-fluid po-created">
  <div class="row">
    <div class="col-md-5 col-lg-3 po-created_instructions">

      @if (session('message'))
      <label>Purchase Order Number For Merchant</label>

      <p class="po-created_instructions_id">
         <span>EM-</span>{{ session('message') }}
         <a href="{{ url('/po-edit') }}/{{ session('message') }}"><img src="{{ asset('/images/add-pod_icon.svg') }}" alt="add POD"></a>
      </p>
      @endif

      @if ($selectedMerchant)

      <label>Merchant Number</label>

        <p class="po-created_merchant_id">

          {{ $selectedMerchant->merchantId }}

        </p>

      @endif

      <label>Time Stamp</label>

        <p class="po-created_merchant_id">

          <?php echo date('H:i d/m/Y '); ?>

        </p>

      <label>What to do next</label>


      <div class="row">
        <div class="col-6 instruction">
          <span>#01</span>
          @if (session('poType') == 'alternate')
            <img src="{{ asset('/images/alt_po.svg') }}" alt="You must phone this number to have payment issued over the phone via credit card. Please quote the above P/O number to the merchant.">
            <p>Call this number for credit card payment, please quote above Purchase Number to merchant.</p>
            <a href="tel:+442838446170">028 3844 6170</a>
          @else
            <img src="{{ asset('/images/present_po.svg') }}" alt="Give this number to the merchant when collecting the goods">
            <p>You must give this number to the merchant when collecting the goods.</p>
          @endif




        </div>

        <div class="col-6 instruction">
          <span>#02</span> <img src="{{ asset('/images/present_pod.svg') }}" alt="Give this number to the merchant when collecting the goods">
          <p>Once the goods are collected you must insist a Proof Of Delivery Docket or receipt is issued and uploaded to this P/O as a photo.</p>
        </div>

        <div class="col-12">
          <a href="{{ url('/po-create') }}" class="btn new">Create New Purchase Order</a>
        </div>

        <div class="col-12">
          <a href="{{ url('/po-list') }}" class="btn manage">View Purchase Orders</a>
        </div>

      </div>


    </div>
    <div class="col-md-7 col-lg-9 tagline d-none d-md-block">
              <h2><span>the right products <br>
              the first time</span> <br>
              one invoice.</h2>
              <img src="//localhost:3000/images/em_logomark.svg" alt="">
    </div>
  </div>
  </div>
</div>



@endsection
