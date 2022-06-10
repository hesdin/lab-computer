<div>

    <div class="row">
        <div class="col-sm">
            <div class="card card-stats card-warning rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="icon-big text-center">
                                <i class="fas fa-file"></i>
                            </div>
                        </div>
                        <div class="col-8 d-flex align-items-center px-0">
                            <div class="numbers">
                                <p class="card-category">Slip Pembayaran</p>
                                <h4 class="card-title">{{ $slip }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card card-stats card-danger rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="icon-big text-center">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="col-8 d-flex align-items-center px-0">
                            <div class="numbers">
                                <p class="card-category">Mahasiswa Aktif</p>
                                <h4 class="card-title">{{ $akunAktif }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card card-stats card-primary rounded">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-4">
                            <div class="icon-big text-center">
                                <i class="far fa-clock"></i>
                            </div>
                        </div>
                        <div class="col-8 d-flex align-items-center px-0">
                            <div class="numbers">
                                <p class="card-category">Mahasiswa Pending</p>
                                <h4 class="card-title">{{ $akunPending }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
