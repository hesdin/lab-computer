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
        </style>
    </head>
    <body>
        <table>
            @foreach ($daftarSlip as $slip)
                <tr>
                    <th>{{ $loop->iteration }}.</th>
                    <td>{{ $slip->username }}</td>
                    <td>{{ $slip->nama }}</td>
                    <td>{{ $slip->nominal }}</td>
                </tr>
            @endforeach
        </table>
    </body>
    </html>
