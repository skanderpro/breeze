<table>
    <thead>
    <tr>
        <th>uuid</th>
        <th>Fcilty_nam</th>
        <th>Merchant_id</th>
        <th>Shp_num_an</th>
        <th>Shp_centre</th>
        <th>Street_add</th>
        <th>Postcode</th>
        <th>Country</th>
        <th>Telephone</th>
        <th>Web_address</th>
        <th>Plumbing</th>
        <th>Electrical</th>
        <th>Builders</th>
        <th>Hire</th>
        <th>Decorating</th>
        <th>Flooring</th>
        <th>Auto</th>
        <th>Aggregate</th>
        <th>Roofing</th>
        <th>Fixings</th>
        <th>Ironmongery</th>
        <th>Tyres</th>
        <th>Health</th>
        <th>Display_wd</th>
        <th>Ycoord</th>
        <th>Xcoord</th>
        <th>result</th>
    </tr>
    </thead>
    <tbody>
    @foreach($merchants as $merchant)
        <tr>
            <td>{{ $merchant->id }}</td>
            <td>{{ $merchant->merchantName }}</td>
            <td>{{ $merchant->merchantId }}</td>
            <td>{{ $merchant->merchantAddress1 }}</td>
            <td>{{ $merchant->merchantAddress2 }}</td>
            <td>{{ $merchant->merchantCounty }}</td>
            <td>{{ $merchant->merchantPostcode }}</td>
            <td>{{ $merchant->merchantCountry }}</td>
            <td>{{ $merchant->merchantPhone }}</td>
            <td>{{ $merchant->merchantWeb }}</td>

            <td>{{ $merchant->merchantPlumbing }}</td>
            <td>{{ $merchant->merchantElectrical }}</td>
            <td>{{ $merchant->merchantBuilders }}</td>
            <td>{{ $merchant->merchantHire }}</td>
            <td>{{ $merchant->merchantDecorating }}</td>
            <td>{{ $merchant->merchantFlooring }}</td>
            <td>{{ $merchant->merchantAuto }}</td>
            <td>{{ $merchant->merchantAggregate }}</td>
            <td>{{ $merchant->merchantRoofing }}</td>
            <td>{{ $merchant->merchantFixings }}</td>
            <td>{{ $merchant->merchantIronmongery }}</td>
            <td>{{ $merchant->merchantTyres }}</td>
            <td>{{ $merchant->merchantHealth }}</td>

            <td>1.5</td>
            <td>{{ $merchant->lng }}</td>
            <td>{{ $merchant->lat }}</td>
            <td>999</td>
        </tr>
    @endforeach
    </tbody>
</table>
