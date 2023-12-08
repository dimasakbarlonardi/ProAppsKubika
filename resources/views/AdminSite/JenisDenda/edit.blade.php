@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Jenis Denda</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jenisdendas.update', $jenisdenda->id_jenis_denda) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label"><b>ID Jenis Denda</label>
                        <input type="text" value="{{ $jenisdenda->id_jenis_denda }}" class="form-control" readonly></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Jenis Denda</label>
                        <input type="text" name="jenis_denda" value="{{ $jenisdenda->jenis_denda }}"
                            class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Pilih Biaya</label>
                        <select class="form-control" name="pilihipl" id="pilihbiayaipl" required>
                            <option selected disabled>-- Pilih Biaya --</option>
                            <option value="1" {{ $jenisdenda->denda_flat_procetage ? 'selected' : '' }}>Flat Procetage
                            </option>
                            <option value="2" {{ $jenisdenda->denda_flat_amount ? 'selected' : '' }}>Flat Amount
                            </option>
                        </select>
                    </div>

                    <div class="mt-5" id="biaya" style="display: none">
                        <h5>Isi Biaya</h5>
                        <hr>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6" id="denda_flat_procetage">
                                    <label class="form-label">Denda Flat Procetage</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="text"
                                            value="{{ $jenisdenda->denda_flat_procetage }}" name="denda_flat_procetage"
                                            aria-describedby="basic-addon2" />
                                        <span class="input-group-text text-primary" id="basic-addon2">%</span>
                                        <span class="input-group-text ">
                                            <select name="unity_procentage" class="form-control" id="">
                                                <option value="day">/ Day</option>
                                                <option value="month">/ Month</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6" id="denda_flat_amount">
                                    <label class="form-label">Denda Flat Amount</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-primary" id="basic-addon2">Rp</span>
                                        <input class="form-control" type="text"
                                            value="{{ RupiahNumber($jenisdenda->denda_flat_amount) }}" id="show_flat_amount" />
                                        <input type="hidden" id="flat_amount" name="denda_flat_amount" />
                                        <span class="input-group-text ">
                                            <select name="unity_flat" class="form-control">
                                                <option value="day">/ Day</option>
                                                <option value="month">/ Month</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
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
    <script>
        $(document).ready(function() {
            var status = $('#pilihbiayaipl').val();

            selectBiayaIPL(status);
        })

        $('#show_flat_amount').keyup(function() {
            var value = $(this).val();
            var amount = $('#flat_amount');

            var newJumlahBayar = value.replace(".", "")
            amount.val(newJumlahBayar);

            $(this).val(formatRupiah(value.toString()));
        })

        $('#pilihbiayaipl').on('change', function() {
            var status = $(this).val();
            selectBiayaIPL(status);
        })

        function selectBiayaIPL(status) {
            $('#biaya').css('display', 'block')
            if (status == '1') {
                $('#denda_flat_procetage').css('display', 'block')
                $('#denda_flat_amount').css('display', 'none')

            } else {
                $('#denda_flat_amount').css('display', 'block')
                $('#denda_flat_procetage').css('display', 'none')

            }
        }
    </script>
@endsection
