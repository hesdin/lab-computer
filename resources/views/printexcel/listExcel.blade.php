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
        </style>
    </head>
    <body>
        <table>
            @foreach ($daftarSlipExcel as $slipexcel)
                <tr>
                    <th>{{ $loop->iteration }}.</th>
                    <td>{{ $slipexcel->username }}</td>
                    <td>{{ $slipexcel->nama }}</td>
                </tr>
            @endforeach
        </table>
    </body>
    </html>
