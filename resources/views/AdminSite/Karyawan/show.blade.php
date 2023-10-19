@extends('layouts.master')

@section('content')
<div class="card">
    <!-- <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="my-3">Employee Data</h6>
            </div>
        </div>
    </div> -->
    <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('karyawans.index')}}" class="text-white">Back Employee Data </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Employee</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    <div class="p-5">
        <form method="post" action="{{ route('karyawans.update', $karyawan->id) }}">
            @method('PUT')
            @csrf
            <div class="karyawan">
                <h5>Employee</h5>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Site Name</label>
                            <input type="text" value="Park Royale" class="form-control" disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email</label>
                            <input type="email" value="{{ $karyawan->email_karyawan }}" name="email_karyawan" class="form-control" required disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Employee Name</label>
                            <input type="text" name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}" class="form-control" required disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Card</label>
                            <select class="form-control" name="id_card_type" id="id_card_type" required disabled>
                                <option selected disabled>-- Choose ID Card --</option>
                                @foreach ($idcards as $idcard)
                                <option value="{{ $idcard->id_card_type }}" {{ $idcard->id_card_type == $karyawan->id_card_type ? 'selected' : '' }}>
                                    {{ $idcard->card_id_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Number</label>
                            <input type="text" maxlength="16" name="nik_karyawan" value="{{ $karyawan->nik_karyawan }}" class="form-control" readonly disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Domicile ID Card</label>
                            <input type="text" name="alamat_ktp_karyawan" value="{{ $karyawan->alamat_ktp_karyawan }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Date Of Birth</label>
                            <input type="date" name="tgl_lahir" value="{{$karyawan->tgl_lahir}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Place Of Birth</label>
                            <input type="text" name="tempat_lahir" value="{{$karyawan->tempat_lahir}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Citizenship</label>
                            <input type="text" name="kewarganegaraan" value="{{ $karyawan->kewarganegaraan }}" class="form-control" required disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Call Number</label>
                            <input type="text" name="no_telp_karyawan" value="{{ $karyawan->no_telp_karyawan }}" class="form-control" readonly>
                        </div>
                    <div class="col-6">
                        <label class="form-label">Date In</label>
                        <input type="date" name="tgl_masuk" value="{{ $karyawan->tgl_masuk }}" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Date Out</label>
                        <input type="date" name="tgl_keluar" value="{{ $karyawan->tgl_keluar }}" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Departement</label>
                        <select class="form-control" name="id_departemen" id="id_departemen" required disabled>
                            <option selected disabled>-- Pilih Departement --</option>
                            @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id_departemen }}" {{ $departemen->id_departemen == $karyawan->id_departemen ? 'selected' : '' }}>
                                {{ $departemen->nama_departemen }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Divisi</label>
                        <select class="form-control" name="id_divisi" id="id_divisi" required disabled>
                            <option selected disabled>-- Pilih Divisi --</option>
                            @foreach ($divisis as $divisi)
                            <option value="{{ $divisi->id_divisi }}" {{ $divisi->id_divisi == $karyawan->id_divisi ? 'selected' : '' }}>
                                {{ $divisi->nama_divisi }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Position</label>
                        <select class="form-control" name="id_jabatan" required>
                            <option selected disabled>-- Pilih Jabatan --</option>
                            @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id_jabatan }}" {{ $jabatan->id_jabatan == $karyawan->id_jabatan ? 'selected' : ''}}>{{ $jabatan->nama_jabatan }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="id_penempatan" id="id_penempatan" required disabled>
                            <option selected disabled>-- Pilih Status --</option>
                            @foreach ($penempatans as $penempatan)
                            <option value="{{ $penempatan->id_penempatan }}" {{ $penempatan->id_penempatan == $karyawan->id_penempatan ? 'selected' : '' }}>
                                {{ $penempatan->lokasi_penempatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Religion</label>
                        <select class="form-control" name="id_agama" id="id_agama" required disabled>
                            <option selected disabled>-- Pilih Penempatan --</option>
                            @foreach ($agamas as $agama)
                            <option value="{{ $agama->id_agama }}" {{ $agama->id_agama == $karyawan->id_agama ? 'selected' : '' }}>
                                {{ $agama->nama_agama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Gender</label>
                        <select class="form-control" name="id_jenis_kelamin" required>
                            <option selected disabled>-- Pilih Jenis Kelamin --</option>
                            @foreach ($jeniskelamins as $jeniskelamin)
                            <option value="{{ $jeniskelamin->id_jenis_kelamin }}" {{ $jeniskelamin->id_jenis_kelamin == $karyawan->id_jenis_kelamin ? 'selected' : ''}}>{{ $jeniskelamin->jenis_kelamin }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Marital Status</label>
                        <select class="form-control" name="id_status_kawin" id="id_status_kawin" required disabled>
                            <option selected disabled>-- Pilih Status Kawin --</option>
                            @foreach ($statuskawins as $statuskawin)
                            <option value="{{ $statuskawin->id_status_kawin }}" {{ $statuskawin->id_status_kawin == $karyawan->id_status_kawin ? 'selected' : '' }}>
                                {{ $statuskawin->status_kawin }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Approver</label>
                        <select class="form-control" name="is_can_approve" id="is_can_approve" required disabled>
                            <option selected disabled>-- Pilih Status --</option>
                            <option {{ $karyawan->is_can_approve ? 'selected' : '' }} value="1">Yes</option>
                            <option {{ !$karyawan->is_can_approve ? 'selected' : '' }} value="">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="penjamin mt-5" id="penjamin">
                <h5>Emergency Contact</h5>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="nama_pasangan_penjamin" value="{{ $karyawan->nama_pasangan_penjamin }}" class="form-control" disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Domicile</label>
                            <input type="text" name="alamat_ktp_pasangan_penjamin" value="{{ $karyawan->alamat_ktp_pasangan_penjamin }}" class="form-control" disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Relation</label>
                            <input type="text" name="hubungan_penjamin" value="{{ $karyawan->hubungan_penjamin }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Call Number</label>
                            <input type="text" name="no_telp_penjamin" value="{{ $karyawan->no_telp_penjamin }}" class="form-control" readonly>
                        </div>
                        {{-- <div class="col-6">
                                <label class="form-label">NIK Karyawan</label>
                                <input type="text" maxlength="16" name="nik_karyawan"
                                    value="{{ $karyawan->nik_pasangan_penjamin }}" class="form-control" disabled>
                    </div> --}}
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                </div>
            </div>
    </div>
    <div class="text-end">
        <a class="btn btn-warning" id="button-cancel" style="display: none;">Cancel</a>
        <button type="submit" class="btn btn-success" style="display: none" id="button-update">Update</button>
    </div>
    </form>
    <div class="text-end">
        <a class="btn btn-primary" id="button-edit">Edit</a>
        <form class="d-inline" action="{{ route('karyawans.destroy', $karyawan->id) }}" method="post">
            @method('DELETE')
            @csrf
            <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-danger" id="button-delete">Delete</button>
        </form>
    </div>
</div>
</div>
@endsection

@section('script')
<script>
    var isEdit = false;
    $('document').ready(function() {
        $('#button-edit').on('click', function() {
            $('.form-control').removeAttr('disabled');
            $('#button-edit').css('display', 'none')
            $('#button-update').css('display', 'inline')

            $('#button-back').css('display', 'none')
            $('#button-cancel').css('display', 'inline')
            $('#button-delete').css('display', 'none')
        })

        $('#button-cancel').on('click', function() {
            $('.form-control').prop('disabled', true);
            $('#button-edit').css('display', 'inline')
            $('#button-update').css('display', 'none')

            $('#button-back').css('display', 'inline')
            $('#button-cancel').css('display', 'none')
            $('#button-delete').css('display', 'inline')

        })

        $('#id_status_kawin').on('change', function() {
            var status = $(this).val();
            if (status == 1) {
                $('#penjamin').css('display', 'block')
            } else {
                $('#penjamin').css('display', 'none')
            }
        })
    })
</script>
@endsection