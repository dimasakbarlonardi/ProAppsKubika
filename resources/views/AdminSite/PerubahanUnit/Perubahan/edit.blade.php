@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Perpanjang Sewa Unit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form action="{{ route('updateTenantUnit', $tenantunit->id_tenant_unit) }}" method="post">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <div class="row">
                          <div class="col-6">
                            <label class="form-label">Unit :</label>
                            <select class="form-control" name="id_unit" required>
                                <option selected disabled>-- Pilih Unit --</option>
                                @foreach ($getCreateUnits as $unit)
                                    <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="col-form-label">Owner :</label>
                            <select class="form-control" name="id_pemilik" required>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id_pemilik }}">
                                        {{ $owner->nama_pemilik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="col-form-label">Periode
                                Sewa:</label>
                            <div class="input-group">
                                <select class="form-control" name="id_periode_sewa" id="periode" required>
                                    @foreach ($periodeSewa as $periode)
                                        <option value="{{ $periode->id_periode_sewa }}">
                                            {{ $periode->periode_sewa }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">Bulan</span>
                            </div>
                        </div>
                    </div>
                </div>
                iv class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        masuk:</label>
                                    <input class="form-control" type="date" name="tgl_masuk" id="tgl_masuk" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        keluar:</label>
                                    <input class="form-control" type="date" name="tgl_keluar" id="tgl_keluar"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        jatuh tempo IPL:</label>
                                    <input class="form-control" type="date" name="tgl_jatuh_tempo_ipl" id=""
                                        required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        jatuh tempo utility:</label>
                                    <input class="form-control" type="date" name="tgl_jatuh_tempo_util" required>
                                </div>
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
