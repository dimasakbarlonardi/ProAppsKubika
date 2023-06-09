@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Perhitungan Denda</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('perhitdendas.update', $perhitdenda->id_perhit_denda) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label"><b>ID Perhitungan Denda</label>
                        <input type="text" value="{{$perhitdenda->id_perhit_denda}}" class="form-control" readonly></b>
                    </div>
                </div>  
                <div class="row">
                <div class="col-6">
                    <label class="form-label">Jenis Denda</label>
                    <input type="text" name="jenis_denda" value="{{$perhitdenda->jenis_denda}}" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label">Pilih Biaya</label>
                    <select class="form-control" name="pilihipl" id="pilihbiayaipl" required>
                        <option selected disabled>-- Pilih Biaya --</option>
                        <option value="1">Flat Procetage </option>
                        <option value="2">Flat Amount </option>
                    </select>
                </div>
                
                <div class="mt-5" id="biaya">
                    <h5>Isi Biaya</h5>
                    <hr>
                 <div class="mb-3">
                 <div class="row">
                <div class="col-6" id="denda_flat_procetage">
                    <label class="form-label">Denda Flat Procetage</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" value="{{$perhitdenda->denda_flat_procetage}}" name="denda_flat_procetage" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">%</span></div>
                </div>
                <div class="col-6" id="denda_flat_amount">
                    <label class="form-label">Denda Flat Amount</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" value="{{$perhitdenda->denda_flat_amount}}" name="denda_flat_amount" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
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
            console.log(status)
            {
                $('#biaya').css('display', 'none')
            }

            $('#pilihbiayaipl').on('change', function() {
                var status = $(this).val();
                $('#biaya').css('display', 'block')
                if (status == '1') {
                    $('#denda_flat_procetage').css('display', 'block')
                    $('#denda_flat_amount').css('display', 'none')

                } else {
                    $('#denda_flat_amount').css('display', 'block')
                    $('#denda_flat_procetage').css('display', 'none')

                }
            })
        })
    </script>
@endsection