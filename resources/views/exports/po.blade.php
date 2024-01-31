<table>
    <thead>
    <tr>
        <th>EM Number</th>
        <!-- <th>Tech Name</th> -->
        <th>Supplier Type</th>
        <th>Job Type</th>
        <th>Supplier Name</th>
        <th>PO Supplier	Cost</th>

        @if (Auth::user()->accessLevel == 1)
        <th>PO Billable Value</th>
        @endif

        <th>Material Brief</th>
        <th>Job Location</th>
        <th>Job Number</th>
        <th>POD Uploaded</th>
        @if (Auth::user()->accessLevel == 1)
        <th>PO Job Status</th>
        @endif
        @if (Auth::user()->accessLevel == 1)
        <th>PO Order Status</th>
        @endif

        @if (Auth::user()->accessLevel == 1 || Auth::user()->accessLevel == 2)
        <th>Company Po</th>
        @endif

        <th>PO Note</th>
        <th>Tech Name</th>
        <th>PO Cancelled</th>
        <th>PO Cancelled by</th>
        <th>Date Created</th>
    </tr>
    </thead>
    <tbody>
    @foreach($poExports as $poExport)

        <tr>
            <td>{{ $poExport->id }}</td>
            <!-- <td>{{ $poExport->name }}</td> -->
            <td>{{ $poExport->poType }}</td>
            <td>{{ $poExport->poPurpose }}</td>
            <td>{{ $poExport->merchantName }} </td> <!-- posible issue with data in database-->
            <td>{{ $poExport->poValue }}</td>

            @if (Auth::user()->accessLevel == 1)
            <td>{{ $poExport->poCostSheet }}</td>
            @endif

            <td></td> <!-- posible issue with data in database-->
            <td>{{ $poExport->poProjectLocation }}</td>
            <td>{{ $poExport->poProject }}</td>
            <td>
              @if ($poExport->poPod)
              Yes
              @else
              No
              @endif
            </td>


            @if (Auth::user()->accessLevel == 1)
            <th>
              @if ($poExport->poJobStatus == 1) New Purchase @endif
              @if ($poExport->poJobStatus == 2) 100% Complete @endif
            </th>
            @endif

            @if (Auth::user()->accessLevel == 1)
            <th>

              @if ($poExport->poFinanceStatus == 1) New Order @endif
              @if ($poExport->poFinanceStatus == 2) Pending Invoice @endif
              @if ($poExport->poFinanceStatus == 3) Awaiting Payments @endif
              @if ($poExport->poFinanceStatus == 4) 100% Paid @endif
              @if ($poExport->poFinanceStatus == 5) Awaiting Company PO @endif

            </th>
            @endif

            @if (Auth::user()->accessLevel == 1 || Auth::user()->accessLevel == 2)
            <th>{{ $poExport->poCompanyPo }}</th>
            @endif


            <td>{{ $poExport->poNotes }}</td>

            <td>

              <?php $engineer = DB::table('users')->where('id', $poExport->u_id )->first(); ?>

              {{ $engineer->name }}



            </td>

            <td>
              @if ($poExport->poCancelled)
              Yes
              @endif
            </td>

            <td>
              @if ($poExport->poCancelled)
              {{ $poExport->poCancelledBy }}
              @endif
            </td>

            <td>{{ $poExport->created_at }}</td>
        </tr>

    @endforeach
    </tbody>
</table>
