@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Monthly AR Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('monthlyartenants.store') }}">
                @csrf
                <div class="row">
                <div class="col-6">
                   <label class="form-label">Nama Site</label>
                   <input type="text" value="Park Royale" class="form-control" readonly>
               </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Tower</label>
                    <input type="text" name="id_tower" class="form-control" required>
                </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Unit</label>
                    <input type="text" name="id_unit" class="form-control" required>
                </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Tenant</label>
                    <input type="text" name="id_tenant" class="form-control" required>
                </div> 
                <div class="col-3 mb-3">
                    <label class="form-label">Monthly Invoice</label>
                    <input type="text" name="no_monthly_invoice" class="form-control" required>
                </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Periode Bulan</label>
                    <input type="text" name="periode_bulan" class="form-control" required>
                </div>  
                <div class="col-3 mb-3">
                    <label class="form-label">Periode Tahun</label>
                    <input type="text" name="periode_tahun" class="form-control" required>
                </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Total Tagihan IPL</label>
                    <input type="text" name="total_taguhan_ipl" class="form-control" required>
                </div> 
                <div class="col-3 mb-3">
                    <label class="form-label">Total Tagihan Utility</label>
                    <input type="text" name="total_taguhan_utility" class="form-control" required>
                </div> 
                <div class="col-3 mb-3">
                    <label class="form-label">Tower</label>
                    <input type="text" name="total_denda" class="form-control" required>
                </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Unit</label>
                    <input type="text" name="biaya_lain" class="form-control" required>
                </div>
                <div class="col-3 mb-3">
                    <label class="form-label">Tanggal jatuh Invoice</label>
                    <input type="text" name="tgl_jt_invoice" class="form-control" required>
                </div> 
                <div class="col-3 mb-3">
                    <label class="form-label">Tanggal Bayar Invoice</label>
                    <input type="text" name="tgl_bayar_invoice" class="form-control" required>
                </div> 
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
