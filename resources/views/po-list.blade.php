@extends('layouts.app')

@section('content')
<?php $title = 'Purchase Order <span>List</span>'; ?>
<div class="container-fluid po_list">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-3 contactdetails">


          <h3>Company</h3>
          <p class="company">{{ $company->companyName }}</p>
          <h3>Operator</h3>
          <p>{{ Auth::user()->name }}</p>

          @if (Auth::user()->accessLevel == '3' || Auth::user()->accessLevel == '2')

            <h3>For assistance please call</h3>
            <p class="phone">{{ $adminusr->phone }}</p>

          @endif

          <a class="btn btn-primary" href="{{ url('/po-export-no-date') }}">Export All POs</a>

          @if (Auth::user()->accessLevel != '3')

            <!-- Large modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Reporting</button>

            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                  <div class="modal-header">

                    <h4 class="modal-title" id="myLargeModalLabel">Export POs</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row">

                        <div class="col-md-6 col-lg-3 form-group">

                          <h3>Engineer</h3>


                            <form method="GET" action="{{ url('/po-export-engineer') }}">

                              <div class="form-group">
                                <select class="form-control" name="exportu_id" id="userSearchDownload">
                                  <option value="">Select a User</option>
                                  @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if($u_id == $user->id ) selected @endif>{{ $user->name }}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="form-group">

                                <h3>Date From</h3>
                                <input class="form-control" type="date" name="exportDateFrom" placeholder="dd/mm/yyyy" value="2018-01-01" required>

                              </div>

                              <div class="form-group">

                                <h3>Date To <?php echo date("Y-m-d") ?></h3>
                                <input class="form-control" type="date" name="exportDateTo" placeholder="dd/mm/yyyy" value="<?php echo date("Y-m-d") ?>" required>

                              </div>

                              <button class="btn btn-primary">Download</button>
                            </form>



                        </div>

                        <div class="col-md-6 col-lg-3 form-group">
                          <h3>By Site</h3>

                          <form method="GET" action="{{ url('/po-export-site') }}">

                            <div class="form-group">
                              <input class="form-control" type="text" name="exportpoProjectLocation" placeholder="Site" value="{{ $poLocation }}">
                            </div>

                            <div class="form-group">

                              <h3>Date From</h3>
                              <input class="form-control" type="date" name="exportDateFrom" placeholder="dd/mm/yyyy" value="2018-01-01" required>

                            </div>

                            <div class="form-group">

                              <h3>Date To</h3>
                              <input class="form-control" type="date" name="exportDateTo" placeholder="dd/mm/yyyy" value="<?php echo date("Y-m-d") ?>" required>

                            </div>

                            <button class="btn btn-primary">Download</button>
                          </form>

                        </div>

                        <div class="col-md-6 col-lg-3 form-group">

                          <h3>By Task / Job Number</h3>


                          <form method="GET" action="{{ url('/po-export-task') }}">

                            <div class="form-group">
                              <input class="form-control" type="text" name="exportpoProject" placeholder="Task / Job Number" value="{{ $poProject }}">
                            </div>

                            <div class="form-group">

                              <h3>Date From</h3>
                              <input class="form-control" type="date" name="exportDateFrom" placeholder="dd/mm/yyyy" value="2018-01-01" required>

                            </div>

                            <div class="form-group">

                              <h3>Date To</h3>
                              <input class="form-control" type="date" name="exportDateTo" placeholder="dd/mm/yyyy" value="<?php echo date("Y-m-d") ?>" required>

                            </div>

                            <button class="btn btn-primary">Download</button>
                          </form>
                        </div>

                        <div class="col-md-6 col-lg-3 form-group">
                          <h3>By Merchant</h3>

                          <form method="GET" action="{{ url('/po-export-merchant') }}">

                            <div class="form-group">
                              <select class="form-control" name="exportmerchant_id" id="merchantSearchDownload">
                                <option value="">Select a Merchant</option>
                                @foreach($merchants as $merchant)
                                  <option value="{{ $merchant->id }}"  @if($merchant_id == $merchant->id ) selected @endif>{{ $merchant->merchantName }}</option>
                                @endforeach
                              </select>
                            </div>

                            <div class="form-group">

                              <h3>Date From</h3>
                              <input class="form-control" type="date" name="exportDateFrom" placeholder="dd/mm/yyyy" value="2018-01-01" required>

                            </div>

                            <div class="form-group">

                              <h3>Date To</h3>
                              <input class="form-control" type="date" name="exportDateTo" placeholder="dd/mm/yyyy" value="<?php echo date("Y-m-d") ?>" required>

                            </div>

                            <button class="btn btn-primary">Download</button>
                          </form>

                        </div>

                        @if (Auth::user()->accessLevel == '1')

                        <div class="col-md-6 col-lg-3 mt-3 form-group">

                          <h3>By Order Status</h3>


                            <form method="GET" action="{{ url('/po-export-finance') }}">

                              <div class="form-group">

                                <select class="form-control" name="poFinanceStatus" id="poFinanceStatus" required>
                                  <option value="">Select an order status</option>
                                  <option value="1">New Order</option>
                                  <option value="2">Pending Invoice</option>
                                  <option value="3">Awaiting Payments</option>
                                  <option value="4">100% Paid</option>
                                  <option value="5">Awaiting Company PO</option>

                                </select>

                              </div>

                              <div class="form-group">

                                <select class="form-control" name="poFinanceCompany" id="poFinanceCompany" required>
                                  <option value="">Select a Company</option>
                                  @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->companyName }}</option>
                                  @endforeach
                                </select>

                              </div>

                              <div class="form-group">

                                <h3>Date From</h3>
                                <input class="form-control" type="date" name="exportDateFrom" placeholder="dd/mm/yyyy" value="2018-01-01" required>

                              </div>

                              <div class="form-group">

                                <h3>Date To</h3>
                                <input class="form-control" type="date" name="exportDateTo" placeholder="dd/mm/yyyy" value="<?php echo date("Y-m-d") ?>" required>

                              </div>

                              <button class="btn btn-primary">Download</button>
                            </form>



                        </div>

                        @endif

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          @endif


          <hr />


          <p>
            <a class="filter" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              Filter

                @if ($date || $u_id || $company_id || $poPod)
                  <span><a class="clear" href="{{ url('/po-list') }}">  (clear filter)</a></span>
                  @else
                @endif


            </a>
          </p>
          <div class="collapse" id="collapseExample">
            <!-- <div class="card card-body"> -->
              <form method="GET" class="filter">
                @if (Auth::user()->accessLevel != '3')
                <div class="form-group">
                  <h3>User</h3>
                  <select class="form-control" name="u_id" id="userSearch">
                    <option value="">Select a User</option>
                    @foreach($users as $user)
                      <option value="{{ $user->id }}" @if($u_id == $user->id ) selected @endif>{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>
                @endif

                @if (Auth::user()->accessLevel == '1')
                <div class="form-group">
                  <h3>Company</h3>
                  <select class="form-control" name="company_id" id="companySearch">
                    <option value="">Select a Company</option>
                    @foreach($companies as $company)
                      <option value="{{ $company->id }}" @if($company_id == $company->id ) selected @endif>{{ $company->companyName }}</option>
                    @endforeach
                  </select>
                </div>
                @endif

                @if (Auth::user()->accessLevel == '1')
                <div class="form-group">
                  <h3>Merchant</h3>
                  <select class="form-control" name="merchant_id" id="merchantSearch">
                    <option value="">Select a Merchant</option>
                    @foreach($merchants as $merchant)
                      <option value="{{ $merchant->id }}" @if($merchant_id == $merchant->id ) selected @endif>{{ $merchant->merchantName }}</option>
                    @endforeach
                  </select>
                </div>
                @endif

                @if (Auth::user()->accessLevel == '1')

                  <!-- <div class="form-group">
                    <h3>Job Status</h3>

                    <select class="form-control" name="poJobStatus" id="poJobStatus">
                      <option value="">Select a job status</option>
                      <option value="1" @if( $poJobStatus == 1 ) selected @endif >New Purchase</option>
                      <option value="2" @if( $poJobStatus == 2 ) selected @endif >100% Complete</option>
                    </select>

                  </div> -->

                  <div class="form-group">
                    <h3>Order Status</h3>

                    <select class="form-control" name="poFinanceStatus" id="poFinanceStatus">
                      <option value="">Select an order status</option>
                      <option value="1" @if( $poFinanceStatus == 1 ) selected @endif >New Order</option>
                      <option value="2" @if( $poFinanceStatus == 2 ) selected @endif >Pending Invoice</option>
                      <option value="3" @if( $poFinanceStatus == 3 ) selected @endif >Awaiting Payments</option>
                      <option value="4" @if( $poFinanceStatus == 4 ) selected @endif >100% Paid</option>
                      <option value="4" @if( $poFinanceStatus == 5 ) selected @endif >Awaiting Company PO</option>
                    </select>

                  </div>

                @endif

                <div class="form-group">
                  <h3>PO Number</h3>
                  <input class="form-control" type="number" name="poId" placeholder="PO Number" value="{{ $poId }}">
                </div>

                <div class="form-group">
                  <h3>Task/Project #</h3>
                  <input class="form-control" type="text" name="poProject" placeholder="Task/Project #" value="{{ $poProject }}">
                </div>

                <div class="form-group">
                  <h3>Location</h3>
                  <input class="form-control" type="text" name="poLocation" placeholder="Location" value="{{ $poLocation }}">
                </div>

                <div class="form-group">
                  <h3>Date From</h3>
                  <input class="form-control" type="date" name="dateFrom" placeholder="dd/mm/yyyy" value="{{ $dateFrom }}">
                </div>

                <div class="form-group">
                  <h3>Date To</h3>
                  <input class="form-control" type="date" name="dateTo" placeholder="dd/mm/yyyy" value="{{ $dateTo }}">
                </div>

                <div class="form-group">
                  <h3>Date</h3>
                  <input class="form-control" type="date" name="date" placeholder="dd/mm/yyyy" value="{{ $date }}">
                </div>

                <div class="form-group">
                  <h3>POD Empty</h3>
                  <input class="" type="checkbox" name="poPod" value="1" @if( $poPod ) checked @endif> Yes<br />
                </div>
                <button> Apply Filter</button>
              </form>
            <!-- </div> -->
          </div>



      </div>
        <div class="col-md-7 col-lg-9 list">

          @if (session('message'))
            <div class="flash-message">
             <div class="alert alert-success alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 {{ session('message') }}
             </div>
            </div>
          @endif

          @if($pos->isEmpty())
          <div class="row col-12 list_nopos">
            <h2>No Purchase Orders <span>To View</span></h2>
          </div>
          @else

          <div class="row">

          @foreach($pos as $po)

          <?php $date = date('d.m.y', strtotime($po->created_at));  ?>



            <div class="col-md-6 col-lg-4">

              <p class="date">{{ $date }}</p>

              <div class="po_entry @if ($po->poCancelled) alert-dark @elseif ( !$po->poPod ) alert-error @elseif( !$po->poCompanyPo ) alert-warning @endif">

              <div class="row">
                <div class="col-lg-5 align-self-center">

                    @if ($po->poCancelled)
                      Cancelled
                      @else
                      {{ $po->poProject }}
                      @endif
                      <br />
                    <a href="{{ url('/po-edit') }}/{{ $po->id }}">VIEW FULL P/O</a>

                </div>
                <div class="col-lg-7 po_number align-self-center">

                  EM-{{ $po->id }}

                </div>

              </div>

              <!-- <div class="row"> -->
                <div class="po_status align-self-center">
                  @if (Auth::user()->accessLevel == '1')


                    <?php $companyName = DB::table('companies')->where('id', $po->companyId )->first(); ?>
                    <?php $engineer = DB::table('users')->where('id', $po->u_id )->first(); ?>
                    <?php $merchName = DB::table('merchants')->where('id', $po->selectMerchant )->first(); ?>

                    <?php //print_r($merchName); ?>


                    <div class="row po_details align-self-center">
                      <div class="col-12 col-sm-6">
                        <strong>Client Name:</strong> {{ $companyName->companyName }}
                      </div>

                      <div class="col-12 col-sm-6">
                        <strong>Project Location:</strong> {{ $po->poProjectLocation }}
                      </div>

                      <div class="col-12 col-sm-6">
                        @if ($merchName)

                        <strong>Supplier Name:</strong> {{ $merchName->merchantName }}

                        @else

                        <strong>Supplier Name:</strong> {{ $po->inputMerchant }}

                        @endif
                      </div>

                      <div class="col-12 col-sm-6">
                        <strong>Engineer Name:</strong> {{ $engineer->name }}
                      </div>

                      <!-- <div class="col-12 col-sm-6"> -->
                        <!-- @if ($po->poJobStatus) -->
                          <!-- <strong>Job Status:</strong> @if ($po->poJobStatus == 1) New Purchase @endif @if ($po->poJobStatus == 2) 100% Complete @endif <br /> -->
                        <!-- @endif -->
                      <!-- </div> -->

                      <div class="col-12 col-sm-6">
                          <strong>Company PO:</strong> @if ($po->poCompanyPo) {{ $po->poCompanyPo }} @else -- @endif <br />
                      </div>

                      <div class="col-12 col-sm-6">
                        @if ($po->poFinanceStatus)
                          <strong>Finance Status:</strong> @if ($po->poFinanceStatus == 1) New Order @endif @if ($po->poFinanceStatus == 2) Pending Invoice @endif @if ($po->poFinanceStatus == 3) Awaiting Payments @endif @if ($po->poFinanceStatus == 4) 100% Paid @endif @if ($po->poFinanceStatus == 5) Awaiting Company PO @endif
                        @endif
                      </div>

                    </div>


                  @endif
                </div>
              <!-- </div> -->



              <div class="add_pod">
                @if ($po->poCancelled)
                  <img src="{{ asset('/images/cancelled_pod.svg') }}" alt="Cancelled POD">
                @elseif ($po->poPod )
                  <img src="{{ asset('/images/uploaded_pod.svg') }}" alt="Uploaded POD">
                @else
                  <a href="{{ url('/po-edit') }}/{{ $po->id }}">

                    <div class="upload_pod">

                      <img src="{{ asset('/images/upload_pod.svg') }}" alt="Upload POD">

                      UPLOAD POD

                    </div>


                  </a>
                @endif
              </div>

              </div>


            </div>

          @endforeach

        </div>

          @endif

          </tbody>
        </table>

        {{ $pos->links() }}

      </div>
    </div>
</div>
@endsection
