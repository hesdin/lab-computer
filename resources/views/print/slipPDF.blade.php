    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Download PDF</title> 

        <style>
            .page-break {
                page-break-after: always;
            }
            table {
                width: 650px;
            }
            table img {
                width: 770px;
                padding-bottom: 5px;
                text-align: center;
            }
            @page {
                margin: 10px;
                margin-bottom: 10px;
            }
            html {
                margin: 10px;
                margin-bottom: 10px;
            }
            body {
                margin: 10px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <table>
            @php $no = 1; @endphp
            @foreach ($daftarSlip as $slip)
                <tr align="center">
                    <td>{{ $no++ }}.</td>
                    <td>{{Carbon\Carbon::parse($slip->tanggal_bayar)->translatedFormat('d F Y')}}</td>
                    <td>{{$slip->username}}</td>
                    <td>{{$slip->nama}}</td>
                    <td>@nominal($slip->nominal)</td>
                </tr>
                <tr align="center">
                    @php
                        $nim = explode('.', $slip->slip);
                        $matakuliah = str_replace(" ","%20",$slip->matakuliah);
                    @endphp
                    <td colspan="5"><img style="height: 400px" src="{{ url("img/slip/".$matakuliah."/".$nim[0]."/".$slip->slip) }}"></td>
                </tr>
            @endforeach
        </table>

        @php
            //die;
        @endphp
    </body>
    </html>
