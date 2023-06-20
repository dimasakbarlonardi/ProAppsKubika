<div class="card mt-2" id="detail_work_order">
    <div class="card-body">
        <div class="card-body p-0">
            <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                <div class="col-9 col-md-8 py-2">Detil Pekerjaan</div>
                <div class="col-3 col-md-4 py-2 text-end">Detil Biaya Alat</div>
            </div>

                <div class="row gx-card mx-0 border-bottom border-200">
                    <div class="col-9 py-3">
                        <input class="form-control" type="text" value=""
                            disabled>
                    </div>
                    <div class="col-3 py-3 text-end">
                        <input class="form-control" type="text" value="Rp "
                            disabled>
                    </div>
                </div>


            <div class="row fw-bold gx-card mx-0">
                <div class="col-12 col-md-4 py-2 text-end text-900">Total</div>
                <div class="col px-0">
                    <div class="row gx-card mx-0">
                        <div class="col-md-8 py-2 d-none d-md-block text-center">
                            {{ count($wo->WODetail) }} ({{ count($wo->WODetail) > 1 ? 'Items' : 'Item' }})
                        </div>
                        <div class="col-12 col-md-4 text-end py-2" id="totalServicePrice">
                            Rp {{ $wo->jumlah_bayar_wo }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
