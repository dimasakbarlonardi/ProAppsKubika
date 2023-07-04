@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Akun</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('bapp.store') }}">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Tiket</label>
                            <select name="no_tiket" class="form-control" id="email">
                                @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->no_tiket }}">{{ $ticket->no_tiket }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Request Permit</label>
                            <select name="no_request_permit" class="form-control" id="email">
                                @foreach ($rps as $rp)
                                    <option value="{{ $rp->no_request_permit }}">{{ $rp->no_request_permit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">No Work Permit</label>
                            <select name="no_work_permit" class="form-control" id="email">
                                @foreach ($wps as $wp)
                                    <option value="{{ $wp->no_work_permit }}">{{ $wp->no_work_permit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Penyelesaian</label>
                            <input type="date" class="form-control" name="tanggal_penyelesaian">
                        </div>
                    </div>
                </div>
                <h5 class="mt-5">Informasi Deposit</h5>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Jumlah deposit</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                <input class="form-control" type="number" name="jumlah_deposit" />
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Jumlah Potongan</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                <input class="form-control" type="number" name="jumlah_potongan" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Jumlah kembali deposit</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                <input class="form-control" type="number" name="jumlah_kembali_deposit" />
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="mt-5">Informasi BANK</h5>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">BANK pemohon</label>
                            <input type="text" class="form-control" name="bank_pemohon">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama rekening pemohon</label>
                            <input type="text" class="form-control" name="nama_rek_pemohon">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">No rekening pemohon</label>
                            <input type="text" class="form-control" name="rek_pemohon">
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('#email').select2({
            theme: 'bootstrap-5'
        });
    </script>
@endsection
