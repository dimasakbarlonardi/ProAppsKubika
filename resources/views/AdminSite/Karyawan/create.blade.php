@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('karyawans.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Employee</div>
            </div>
        </div>
    </div>

    <div class="p-5">
        <form method="post" action="{{ route('karyawans.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="karyawan">
                <h5>Employee</h5>
                <hr>
                <div class="mb-3">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label">Site Name</label>
                                <input type="text" value="Park Royale" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" value="{{ old('email_karyawan') }}" name="email_karyawan" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">ID Card</label>
                                <select class="form-control" name="id_card_type" required>
                                    <option selected disabled>-- Choose ID Card --</option>
                                    @foreach ($idcards as $idcard)
                                    <option value="{{ $idcard->id_card_type }}" @if (old('id_card_type')==$idcard->id_card_type) selected @endif>{{ $idcard->card_id_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">ID Number</label>
                                <input type="text" value="{{ old('nik_karyawan') }}" maxlength="16" name="nik_karyawan" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Employee Name</label>
                                <input type="text" value="{{ old('nama_karyawan') }}" name="nama_karyawan" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Citizenship</label>
                                <input type="text" value="{{ old('kewarganegaraan') }}" name="kewarganegaraan" class="form-control" required>
                            </div>

                            <div class="col-6 mb-2">
                                <label class="form-label">Domicile</label>
                                <input type="text" value="{{ old('alamat_ktp_karyawan') }}" name="alamat_ktp_karyawan" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Call Number</label>
                                <input type="text" value="{{ old('no_telp_karyawan') }}" name="no_telp_karyawan" class="form-control" required id="callNumberInput">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Join Date</label>
                                <input type="date" value="{{ old('tgl_masuk') }}" name="tgl_masuk" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Resign Date</label>
                                <input type="date" value="{{ old('tgl_keluar') }}" name="tgl_keluar" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Departement</label>
                                <select class="form-control" name="id_departemen" required>
                                    <option selected disabled>-- Pilih Departement --</option>
                                    @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen->id_departemen }}" @if (old('id_departemen')==$departemen->id_departemen) selected @endif>
                                        {{ $departemen->nama_departemen }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Divisi</label>
                                <select class="form-control" name="id_divisi" required>
                                    <option selected disabled>-- Pilih Divisi --</option>
                                    @foreach ($divisis as $divisi)
                                    <option value="{{ $divisi->id_divisi }}" @if (old('id_divisi')==$divisi->id_divisi) selected @endif>
                                        {{ $divisi->nama_divisi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Position</label>
                                <select class="form-control" name="id_jabatan" required>
                                    <option selected disabled>-- Pilih Jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id_jabatan }}" @if (old('id_jabatan')==$jabatan->id_jabatan) selected @endif>
                                        {{ $jabatan->nama_jabatan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Penempatan</label>
                                <select class="form-control" name="id_penempatan" required>
                                    <option selected disabled>-- Pilih Penempatan --</option>
                                    @foreach ($penempatans as $penempatan)
                                    <option value="{{ $penempatan->id_penempatan }}" @if (old('id_penempatan')==$penempatan->id_penempatan) selected @endif>
                                        {{ $penempatan->lokasi_penempatan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Date Of Birth</label>
                                <input type="date" value="{{ old('tgl_lahir') }}" name="tgl_lahir" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Place Of Birth</label>
                                <input type="text" value="{{ old('tempat_lahir') }}" name="tempat_lahir" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Religion</label>
                                <select class="form-control" name="id_agama" required>
                                    <option selected disabled>-- Pilih Agama --</option>
                                    @foreach ($agamas as $agama)
                                    <option value="{{ $agama->id_agama }}" @if (old('id_agama')==$agama->id_agama) selected @endif>{{ $agama->nama_agama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Gender</label>
                                <select class="form-control" name="id_jenis_kelamin" required>
                                    <option selected disabled>-- Pilih Jenis Kelamin --</option>
                                    @foreach ($jeniskelamins as $jeniskelamin)
                                    <option value="{{ $jeniskelamin->id_jenis_kelamin }}" @if (old('id_jenis_kelamin')==$jeniskelamin->id_jenis_kelamin) selected @endif>
                                        {{ $jeniskelamin->jenis_kelamin }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">ID Status Karyawan</label>
                                <select class="form-control" name="id_status_karyawan" readonly>
                                    <option selected disabled>-- Pilih Status Karyawan --</option>
                                    @foreach ($statuskaryawans as $statuskaryawan)
                                    <option value="{{ $statuskaryawan->id_status_karyawan }}">
                                        {{ $statuskaryawan->status_karyawan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Approver</label>
                                <select class="form-control" name="is_can_approve" id="is_can_approve" required>
                                    <option selected disabled>-- Pilih Status --</option>
                                    <option value="1">Yes</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">Marital Status</label>
                                <select class="form-control" name="id_status_kawin" id="id_status_kawin" required>
                                    <option selected disabled>-- Pilih Status Kawin --</option>
                                    <option value="1">
                                        Menikah
                                    </option>
                                    <option value="2">
                                        Belum Menikah
                                    </option>
                                </select>
                            </div>
                            <div class="col-6 mb-2 mt-3">
                                <div class="col-6">
                                    <label class="form-label">Image Employee</label>
                                    <input class="form-control" type="file" name="profile_picture">
                                </div>
                            </div>
                        </div>
                        <div class="penjamin mt-5" id="penjamin">
                            <h5>Emergency Contact</h5>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" value="{{ old('nama_pasangan_penjamin') }}" name="nama_pasangan_penjamin" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">ID Number</label>
                                    <input type="text" value="{{ old('nik_pasangan_penjamin') }}" maxlength="16" name="nik_pasangan_penjamin" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Domicile ID Card</label>
                                    <input type="text" value="{{ old('alamat_ktp_pasangan_penjamin') }}" name="alamat_ktp_pasangan_penjamin" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Domicile</label>
                                    <input type="text" value="{{ old('alamat_tinggal_pasangan_penjamin') }}" name="alamat_tinggal_pasangan_penjamin" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Relation</label>
                                    <input type="text" value="{{ old('hubungan_penjamin') }}" name="hubungan_penjamin" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Call Number</label>
                                    <input type="text" value="{{ old('no_telp_penjamin') }}" name="no_telp_penjamin" class="form-control" required id="callNumberInput">
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
    document.addEventListener("input", function(e) {
        var input = e.target;
        if (input.id === "callNumberInput") {
            input.value = input.value.replace(/\D/g, ""); // Hanya membiarkan angka
        }
    });
</script>
@endsection
