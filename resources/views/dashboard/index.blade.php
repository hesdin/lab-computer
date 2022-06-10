@extends('layouts.dashboard')

@push('css')
    <style>
        .table tr td {
            border-top: 0px;
        }
    </style>
@endpush

@section('content')
    @php
        $lengkap = \App\Models\Biodata::count();
        $belumLengkap = \App\Models\User::where('status', '1')->where('level', 'user')->orWhere('level', 'asisten')->orWhere('level', 'koasisten')->get()->count() - $lengkap;
    @endphp

    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Dashboard</h4>
                <div id="status">
                    @livewire('status-dashboard')
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card rounded">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fas fa-clipboard-list mr-3"></i>Data Mahasiswa</h4>
                            </div>
                            <div class="card-body pb-5">
                                <canvas id="myChart" width="300" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card rounded">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fas fa-tools mr-3"></i>User Logs</h4>
                            </div>
                            <div class="card-body">
                                <div id="userlogs">
                                    @livewire('user-logs')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var ctx = $('#myChart');
        var x = 10;
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Lengkap', 'Belum lengkap'],
                datasets: [{
                    label: '# of Votes',
                    data: [{{ $lengkap }}, {{ $belumLengkap }}],
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        '#DDD'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                cutoutPercentage: 60
            }
        });

        var url = "{{ Request::url() }}";
        setInterval(function()
        {
            $("#userlogs").load(url+" #userlogs");
            $("#status").load(url+" #status");
            // myChart.data.datasets[0].data[0] = {{ $lengkap }};
            // myChart.data.datasets[0].data[1] = {{ $belumLengkap }};
            // myChart.update();
        }, 5000);
    </script>
@endpush
