@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">Perpanjang Sewa Unit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form action="{{ route('updateTenantUnit', $tenantunit->id_tenant_unit) }}" method="post">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="col-form-label">Periode
                            Sewa:</label>
                        <div class="input-group">
                            <select class="form-control" name="id_periode_sewa" id="periode_edit">
                                @foreach ($periodeSewa as $periode)
                                    <option value="{{ $periode->id_periode_sewa }}" {{ $periode->id_periode_sewa == $tenantunit->id_periode_sewa ? 'selected' : ''}}>
                                        {{ $periode->periode_sewa }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="input-group-text">Bulan</span>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Sewa Ke</label>
                        <input type="text" value="{{ $tenantunit->sewa_ke + 1}} " class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="col-form-label">Tanggal
                            masuk:</label>
                        <input class="form-control" type="date" name="tgl_masuk" value="{{ $tenantunit->tgl_masuk }}"
                            id="tgl_masuk_edit">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="col-form-label">Tanggal
                            keluar:</label>
                        <input class="form-control" type="date" name="tgl_keluar" value="{{ $tenantunit->tgl_keluar }}"
                            id="tgl_keluar_edit" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" required>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {{-- <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('statustinggals.index')}}">Cancel</a></button> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function calcDate() {
            var periode = $('#periode_edit').find(':selected').text()
            var selectedDate = $('#tgl_masuk_edit').val();
            var date = new Date(selectedDate);
            var addMonth = date.setMonth(date.getMonth() + parseInt(periode));
            var parseDate = new Date(addMonth);
            var newDate = parseDate.toISOString().split('T')[0]

            return newDate;
        }

        $('#tgl_masuk_edit').on('change', function() {
            var date = calcDate();
            $('#tgl_keluar_edit').val(date)
        })

        $('#periode_edit').on('change', function() {
            var date = calcDate();
            $('#tgl_keluar_edit').val(date)
        })
    </script>
@endsection
