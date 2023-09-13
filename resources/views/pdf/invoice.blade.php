<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> --}}
    <title>PNP Invoice </title>

    <style>
        table {
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
	        vertical-align: middle;
        }

        th, td {
             border: 1px solid black;
	        padding: 8px;
        }

        caption {
        font-weight: bold;
        font-size: 24px;
        text-align: left;
        color: #333;
        }

        thead th {
        width: 25%;
        }

        /* header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        headeritem {
            flex:1;
        } */
    </style>
</head>
<body>
    <div class="container">
        <h1>PNP INVOICE</h1>
        <hr />
        <div class="header">
            <div class="headeritem" style="float:left;" >
                <p><strong>Invoice To:</strong> {{$user?->name}} </p>
                <p><strong>Email Address:</strong> {{$user?->email}}</p>
                <p><strong>Phone No:</strong> {{$user?->phoneno}}</p>
            </div>
            <div class="headeritem" style="float:right;">
                <p><strong>Invoice No#: </strong> {{$invoice->invoiceno}}</p>
                <p><strong>Order No:</strong> {{$invoice->orderno}}</p>
                <p><strong>Order Items:</strong> {{count($products)}}</p>
            </div>
        </div>
        <!-- <hr /> -->

        <div class="col-md-12 row" style="margin-top: 200px;">
            <div class="orderinfo" style="margin-bottom: 10px;">
                <legend>Order Information</legend>
            </div>

            <table class="table table-striped"  style="width: 100%!important;">
                <thead>
                    <th>NO#</th>
                    <th>DESCRIPTION</th>
                    <th>QUANTITY</th>
                    <th>UNIT PRICE (GHC)</th>
                    <th>SUB TOTAL(GHC)</th>
                </thead>

                <tbody>
                    @foreach ($products as $key=>$p)
                        <tr>
                            <td>#{{$key+1}}</td>
                            <td >{{$p->itemname}}</td>
                            <td>{{$p->qty}}</td>
                            <td>{{$p->unitprice}}</td>
                            <td>{{$p->subtotal}}</td>
                        </tr>
                    @endforeach
                    {{-- <tr></tr> --}}
                    <tr>
                        <td colspan="3" style="border-bottom-color: white; border-left-color: white;"></td>
                        
                        <td style="border-left-color: black;">TOTAL(GHC)</td>
                        <td>{{$invoice->total_amount}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>