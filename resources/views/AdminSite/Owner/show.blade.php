@extends('layouts.master')

@section('content')
<div class="card">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('owners.index') }}" class="btn btn-falcon-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="ml-3">Detail Landlord</div>
        </div>
    </div>
</div>
    <div class="p-5">
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Management Name</label>
                    <input type="text" value="{{ $owners->nama_kepengurusan }}" class="form-control" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label">Building Name</label>
                    <input type="text" value="{{ $owners->nama_building }}" class="form-control" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label">Building Address</label>
                    <input type="text" value="{{ $owners->alamat_building }}" class="form-control" readonly>
                </div>
               

            </div>
        </div>

        {{-- </form> --}}
        <!-- <a href="{{ route('owners.edit', $owners->id_pemilik) }}" class="btn btn-sm btn-warning">Edit</a> -->
        <a class="btn btn-sm btn-danger" href="{{ route('owners.index')}}">Back</a>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var status = $('#id_status_kawin').val();
        if (status == 1) {
            $('#penjamin').css('display', 'block')
            $('#pasangan').css('display', 'none')
        } else {
            $('#penjamin').css('display', 'none')
            $('#pasangan').css('display', 'block')
        }

        $('#id_status_kawin').on('change', function() {
            var status = $(this).val();

            if (status == 1) {
                $('#penjamin').css('display', 'block')
                $('#pasangan').css('display', 'none')
            } else {
                $('#penjamin').css('display', 'none')
                $('#pasangan').css('display', 'block')
            }
        })
    })
</script>
@endsection