    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Download Excel</title>

        <style>
            .page-break {
                page-break-after: always;
            }
            table {
                width: 99%;
            }
            table img { 
                width: 100%;
                padding-bottom: 5px;
                text-align: right;
            }
            @page {
                margin: 0.1cm;
                margin-bottom: 0cm;
            }
            html {
                margin: 0.1cm;
                margin-bottom: 0cm;
            }
            body {
                margin: 0.1cm;
                margin-bottom: 0cm;
            }
        </style>
    </head>
    <body>
        <table style="margin-right: 50px" class="table table-bordered">
            {{-- <thead>
                <tr>
                    <th>Tanggal Bayar</th>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Nominal</th>
                </tr>
            </thead> --}}
            @foreach ($daftarSlipExcel as $slip)                        
                <tr>                    
                    <td>{{Carbon\Carbon::parse($slip->tanggal_bayar)->translatedFormat('d F Y')}}</td>
                    <td>{{$slip->username}}</td>
                    <td>{{Str::upper($slip->nama)}}</td>
                    <td>{{$slip->nominal}}</td>
                    {{-- <td>@nominal($slip->nominal)</td> --}}
                </tr>
            @endforeach
        </table>

        @php
            //die;
        @endphp
    </body>
    </html>
