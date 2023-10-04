@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-aut6">

                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('ipltypes.update', $ipltype->id_ipl_type) }}">
                @method('PUT')
                @csrf
                <div class="row mt-3">
                <div class="col-6">
                    <label class="form-label">Nama IPL Type</label>
                    <input type="text" name="nama_ipl_type" value="{{$ipltype->nama_ipl_type}}" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label">Pilih Biaya</label>
                    <select class="form-control" name="pilihipl" id="pilihbiayaipl" required>
                        <option selected disabled>-- Pilih Biaya --</option>
                        <option value="1">Biaya Permeter </option>
                        <option value="2">Biaya Procentage </option>
                    </select>
                </div>
                <div class="mt-5" id="cancel">
                    <button class="btn btn-danger"><a class="text-white" href="{{route('ipltypes.index')}}">Cancel</a></button>
                </div>

                <div class="mt-5" id="biaya">
                    <h6>ISI BIAYA</h6>
                    <hr>
                 <div class="mb-3">
                 <div class="row">
                <div class="col-6" id="biaya_permeter">
                    <label class="form-label">Biaya Permeter</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" value="{{$ipltype->biaya_permeter}}" name="biaya_permeter" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
                </div>
                <div class="col-6" id="biaya_procentage">
                    <label class="form-label">Biaya Procentage</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" value="{{$ipltype->biaya_procentage}}" name="biaya_procentage" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">%</span></div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{route('ipltypes.index')}}">Cancel</a></button>
                </div>
                 </div>
                 </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var status = $('#pilihbiayaipl').val();

            {
                $('#biaya').css('display', 'none')
            }

            $('#pilihbiayaipl').on('change', function() {
                var status = $(this).val();
                $('#biaya').css('display', 'block')
                if (status == '1') {
                    $('#biaya_permeter').css('display', 'block')
                    $('#biaya_procentage').css('display', 'none')
                    $('#cancel').css('display', 'none')

                } else {
                    $('#biaya_procentage').css('display', 'block')
                    $('#biaya_permeter').css('display', 'none')
                    $('#cancel').css('display', 'none')

                }
            })
        })
    </script>
@endsection
