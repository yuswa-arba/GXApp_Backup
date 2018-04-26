<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>QRCode</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        .qr-desc {
            text-align: center;
            color: black;
            border-top: 1px dashed black;
            font-size: 16px;
            padding-top: 10px
        }
        .sn {
            font-size: 12px;
            text-align: center;
            margin-top: -10px;
        }

    </style>
</head>
<body>

<h2 style="text-align: center"></h2>

<table>
    <thead></thead>
    <tbody>
    <tr>

        @foreach($qrCodeData as $key => $data)
            <td>
                <div class="column">
                    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->margin('0')->merge('/public/images/company/logo/gx-logo-vertical.png')->size(220)->generate($data['data'])) }} ">
                    <p class="qr-desc"> ID: {{$data['id']}} | {{$data['name']}}</p>
                    <p class="sn">{{$data['SN']}}</p>
                </div>
            </td>
            @if(($key+1)%5==0)
            </tr><tr>
            @endif
        @endforeach


    </tr>

    </tbody>
</table>


</body>
</html>