@extends('layouts.dashboard')

@push('css')
    <style>
        .list-group li:hover {
            cursor: pointer;
            background-color: #EEE;
        }
    </style>
@endpush

@section('content')

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Master Data</h4>
            <div class="card rounded p-4">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex" onclick="document.location.href = '{{ Request::url().'/matakuliah' }}'">
                            Mata Kuliah
                            <div class="ml-auto bd-highlight align-self-center pl-3"><i class="fa fa-chevron-right"></i></div>
                        </li>
                        <li class="list-group-item d-flex" onclick="document.location.href = '{{ Request::url().'/prodi' }}'">
                            Program Studi
                            <div class="ml-auto bd-highlight align-self-center pl-3"><i class="fa fa-chevron-right"></i></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection