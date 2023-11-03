@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('utilitys.index') }}" class="text-white">
                                    List Utility</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Utility</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('utilitys.update', $utility->id_utility) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6 ">
                            <label class="form-label">Nama Utility</label>
                            <input type="text" name="nama_utility" value="{{ $utility->nama_utility }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h6> ISI BIAYA
                            <hr>
                        </h6>
                        <div class="col-6 mt-3 ">
                            <label class="form-label">Biaya Admin</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-primary" id="basic-addon2">Rp</span>
                                <input class="form-control" type="text" id="show_biaya_admin"
                                    value="{{ RupiahNumber($utility->biaya_admin) }}" />
                                <input type="hidden" id="biaya_admin" name="biaya_admin" value="{{ $utility->biaya_admin }}" />
                            </div>
                        </div>
                        <div class="col-6 mt-3 ">
                            <label class="form-label">Biaya / KWH</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-primary">Rp</span>
                                <input class="form-control" type="text" id="show_biaya_kwh" value="{{ RupiahNumber($utility->biaya_m3) }}"/>
                                <input type="hidden" name="biaya_m3" id="biaya_kwh" value="{{ $utility->biaya_m3 }}"/>
                            </div>
                        </div>
                        <div class="col-6 mt-3 ">
                            <label class="form-label">Biaya Abodemen</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-primary">Rp</span>
                                <input class="form-control" type="text"
                                    value="{{ RupiahNumber($utility->biaya_abodemen) }}" id="show_biaya_abodemen" />
                                <input name="biaya_abodemen" id="biaya_abodemen" type="hidden"
                                    value="{{ $utility->biaya_abodemen }}" />
                            </div>
                        </div>
                        <div class="col-6 mt-3 ">
                            <label class="form-label">Biaya Tetap</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-primary" id="basic-addon2">Rp</span>
                                <input class="form-control" type="text" id="show_biaya_tetap"
                                    value="{{ RupiahNumber($utility->biaya_tetap) }}" />
                                <input type="hidden" value="{{ $utility->biaya_tetap }}" name="biaya_tetap"
                                    id="biaya_tetap" />
                            </div>
                        </div>

                        <div class="col-6 mt-3 ">
                            <label class="form-label">Biaya PPJ</label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="biaya_ppj"
                                value="{{ $utility->biaya_ppj }}" aria-describedby="basic-addon2" />
                                <span class="input-group-text text-primary" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-5">
                        <a class="text-white btn btn-danger" href="{{ route('utilitys.index') }}">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="margin-left: 10px">Submit</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
@endsection

@section('script')
    <script>
        var showBiayaTetap = $('#show_biaya_tetap');
        var biayaTetap = $('#biaya_tetap');
        var showBiayaAdmin = $('#show_biaya_admin');
        var biayaAdmin = $('#biaya_admin');
        var showBiayaAbodemen = $('#show_biaya_abodemen');
        var biayaAbodemen = $('#biaya_abodemen');
        var showBiayaKWH = $('#show_biaya_kwh');
        var biayaKWH = $('#biaya_kwh');

        $('#show_biaya_admin').keyup(function() {
            var value = $(this).val();

            var newValueBiayaAdmin = value.replace(".", "")
            newValueBiayaAdmin = newValueBiayaAdmin.replace(",", ".")
            biayaAdmin.val(newValueBiayaAdmin);

            $(this).val(formatRupiah(value.toString()));
        })

        $('#show_biaya_tetap').keyup(function() {
            var value = $(this).val();

            var newValueBiayaTetap = value.replace(".", "")
            newValueBiayaTetap = newValueBiayaTetap.replace(",", ".")
            biayaTetap.val(newValueBiayaTetap);

            $(this).val(formatRupiah(value.toString()));
        })

        $('#show_biaya_abodemen').keyup(function() {
            var value = $(this).val();

            var newValueBiayaAbodemen = value.replace(".", "")
            newValueBiayaAbodemen = newValueBiayaAbodemen.replace(",", ".")
            biayaAbodemen.val(newValueBiayaAbodemen);

            $(this).val(formatRupiah(value.toString()));
        })

        $('#show_biaya_kwh').keyup(function() {
            var value = $(this).val();

            var newValueBiayaKWH = value.replace(".", "")
            newValueBiayaKWH = newValueBiayaKWH.replace(",", ".")
            biayaKWH.val(newValueBiayaKWH);

            $(this).val(formatRupiah(value.toString()));
        })
    </script>
@endsection
