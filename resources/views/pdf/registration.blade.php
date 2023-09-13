<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> --}}
    <title>UG - Conference </title>

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
        <div style="display:table; width: 100%;">
            <div style="display: table-cell; text-align: center; vertical-align: middle;">
                <img src="{{public_path() . '/assets/img/logo.png'}}"  height="100px" />
            </div>
        </div>

        <div style="display:table; width: 100%;">
            <div style="display: table-cell; text-align: center; vertical-align: middle;">
                <h1> - PROOF OF REGISTRATION -</h1>
                <h3>{{$conference->title}}</h3>
            </div>
        </div>
        
        <hr />
        <div class="header">
            <div class="headeritem" >
                <p><strong>FULL NAME:</strong> {{$application?->title}}, {{$application?->firstname.' '.$application?->lastname}} </p>
                <p><strong>EMAIL ADDRESS:</strong>  {{$application?->email}}</p>
                <p><strong>PHONE NO:</strong> {{$application?->phone}}</p>
                <p><strong>REGISTRATION TYPE:</strong> {{$application?->occupation}}</p>
                <p><strong>REGISTRATION CODE/NO:</strong> {{$application?->reg_no}}</p>
                <p><strong>REGISTRATION AMOUNT:</strong> {{$application?->reg_currency}} {{$application?->reg_amount}}</p>

            </div>
            
        </div>
       
    
        @if($application->payment_category_name == 'Bank Account Payment / Deposit')
            <div style="display:table; width: 100%;">
                <div style="display: table-cell; text-align: center; vertical-align: middle;">
                    <p style="color:red; font-weight:bold;">To Complete registration, Please make a deposit of {{$application->reg_currency.' '.$application->reg_amount}} to the below bank account</p>

                    {!! $conference->bankinfo !!}
                </div>
            </div>
        @elseif($application->payment_category_name == 'Onsite Payment')
            <div style="display:table; width: 100%;">
                <div style="display: table-cell; text-align: center; vertical-align: middle;">
                    <p style="color:red; font-weight:bold;">Please make available an amount of {{$application->reg_currency.' '.$application->reg_amount}} on conference ground as registration fee. Thank you</p>
                </div>
            </div>
        @endif
     
        <!-- <hr /> -->
        <div style="margin-top: 50px;">
        </div>
        
        <div class="col-md-12 " style="display:table; width: 100%;">
            

            <div class="" style="display: table-cell; text-align: center; vertical-align: middle;">
                <img style="height: 200px; width: 200px; " src="{{storage_path('app/public/qrcodes/'.$application->reg_no.'_qrcode.svg')}}" />
                <p>Scan to download conference brochure</p>
                

                <h2>REG CODE: {{$application?->reg_no}}</h2>
            </div>


            
        </div>
    </div>
</body>
</html>