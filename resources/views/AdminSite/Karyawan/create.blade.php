@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Tambah Karyawan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('karyawans.store') }}">
                @csrf
                <div class="karyawan">
                    <h5>Karyawan</h5>
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Site</label>
                                <input type="text" value="Park Royale" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Email</label>
                                <input type="email" value="{{ old('email_karyawan') }}" name="email_karyawan"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Card Karyawan</label>
                                <select class="form-control" name="id_card_type" required>
                                    <option selected disabled>-- Pilih ID Card --</option>
                                    @foreach ($idcards as $idcard)
                                        <option value="{{ $idcard->id_card_type }}"
                                            @if (old('id_card_type') == $idcard->id_card_type) selected @endif>{{ $idcard->card_id_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Nik Karyawan</label>
                                <input type="text" value="{{ old('nik_karyawan') }}" maxlength="16" name="nik_karyawan"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Karyawan</label>
                                <input type="text" value="{{ old('nama_karyawan') }}" name="nama_karyawan"
                                    class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Kewarganegaraan</label>
                                <input type="text" value="{{ old('kewarganegaraan') }}" name="kewarganegaraan"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Masa Berlaku ID</label>
                                <input type="date" value="{{ old('masa_berlaku_id') }}" name="masa_berlaku_id"
                                    class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Alamat KTP Karyawan</label>
                                <input type="text" value="{{ old('alamat_ktp_karyawan') }}" name="alamat_ktp_karyawan"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">No Telp Karyawan</label>
                                <input type="text" value="{{ old('no_telp_karyawan') }}" name="no_telp_karyawan"
                                    class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" value="{{ old('tgl_masuk') }}" name="tgl_masuk" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tanggal Keluar</label>
                                <input type="date" value="{{ old('tgl_keluar') }}" name="tgl_keluar"
                                    class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Departement</label>
                                <select class="form-control" name="id_departemen" required>
                                    <option selected disabled>-- Pilih Departement --</option>
                                    @foreach ($departemens as $departemen)
                                        <option value="{{ $departemen->id_departemen }}"
                                            @if (old('id_departemen') == $departemen->id_departemen) selected @endif>
                                            {{ $departemen->nama_departemen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Divisi</label>
                                <select class="form-control" name="id_divisi" required>
                                    <option selected disabled>-- Pilih Divisi --</option>
                                    @foreach ($divisis as $divisi)
                                        <option value="{{ $divisi->id_divisi }}"
                                            @if (old('id_divisi') == $divisi->id_divisi) selected @endif>
                                            {{ $divisi->nama_divisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Jabatan</label>
                                <select class="form-control" name="id_jabatan" required>
                                    <option selected disabled>-- Pilih Jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id_jabatan }}"
                                            @if (old('id_jabatan') == $jabatan->id_jabatan) selected @endif>
                                            {{ $jabatan->nama_jabatan }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Penempatan</label>
                                <select class="form-control" name="id_penempatan" required>
                                    <option selected disabled>-- Pilih Penempatan --</option>
                                    @foreach ($penempatans as $penempatan)
                                        <option value="{{ $penempatan->id_penempatan }}"
                                            @if (old('id_penempatan') == $penempatan->id_penempatan) selected @endif>
                                            {{ $penempatan->lokasi_penempatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" value="{{ old('tgl_lahir') }}" name="tgl_lahir"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" value="{{ old('tempat_lahir') }}" name="tempat_lahir"
                                    class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Agama</label>
                                <select class="form-control" name="id_agama" required>
                                    <option selected disabled>-- Pilih Agama --</option>
                                    @foreach ($agamas as $agama)
                                        <option value="{{ $agama->id_agama }}"
                                            @if (old('id_agama') == $agama->id_agama) selected @endif>{{ $agama->nama_agama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control" name="id_jenis_kelamin" required>
                                    <option selected disabled>-- Pilih Jenis Kelamin --</option>
                                    @foreach ($jeniskelamins as $jeniskelamin)
                                        <option value="{{ $jeniskelamin->id_jenis_kelamin }}"
                                            @if (old('id_jenis_kelamin') == $jeniskelamin->id_jenis_kelamin) selected @endif>
                                            {{ $jeniskelamin->jenis_kelamin }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">ID Status Karyawan</label>
                                <select class="form-control" name="id_status_karyawan" readonly>
                                    <option selected disabled>-- Pilih Status Karyawan --</option>
                                    @foreach ($statuskaryawans as $statuskaryawan)
                                        <option value="{{ $statuskaryawan->id_status_karyawan }}">
                                            {{ $statuskaryawan->status_karyawan }} </option>
<<<<<<< HEAD
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Bisa Approve</label>
                                <select class="form-control" name="is_can_approve" id="is_can_approve" required>
                                    <option selected disabled>-- Pilih Status --</option>
                                    <option value="1">Yes</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status Kawin</label>
                                <select class="form-control" name="id_status_kawin" id="id_status_kawin" required>
                                    <option selected disabled>-- Pilih Status Kawin --</option>
                                    @foreach ($statuskawins as $statuskawin)
                                        <option value="{{ $statuskawin->id_status_kawin }}" @if(old('id_status_kawin') == $statuskawin->id_status_kawin) selected @endif>{{ $statuskawin->status_kawin }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="col-6">
                            <label class="form-label">Status Kawin</label>
                            <select class="form-control" name="id_status_kawin" id="id_status_kawin" required>
                                <option selected disabled>-- Pilih Status Kawin --</option>
                                @foreach ($statuskawins as $statuskawin)
                                    <option value="{{ $statuskawin->id_status_kawin }}"
                                        @if (old('id_status_kawin') == $statuskawin->id_status_kawin) selected @endif>
                                        {{ $statuskawin->status_kawin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="penjamin mt-5" id="penjamin">
                    <h5>Penjamin</h5>
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Pasangan Penjamin</label>
                                <input type="text" value="{{ old('nama_pasangan_penjamin') }}"
                                    name="nama_pasangan_penjamin" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">NIK Pasangan Penjamin</label>
                                <input type="text" value="{{ old('nik_pasangan_penjamin') }}" maxlength="16"
                                    name="nik_pasangan_penjamin" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                                <input type="text" value="{{ old('alamat_ktp_pasangan_penjamin') }}"
                                    name="alamat_ktp_pasangan_penjamin" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                                <input type="text" value="{{ old('alamat_tinggal_pasangan_penjamin') }}"
                                    name="alamat_tinggal_pasangan_penjamin" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Hubungan Penjamin</label>
                                <input type="text" value="{{ old('hubungan_penjamin') }}" name="hubungan_penjamin"
                                    class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">No Telp Penjamin</label>
                                <input type="text" value="{{ old('no_telp_penjamin') }}" name="no_telp_penjamin"
                                    class="form-control">
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
        $('#id_status_kawin').on('change', function() {
            var status = $(this).val();
            if (status == 1) {
                $('#penjamin').css('display', 'block')
            } else {
                $('#penjamin').css('display', 'none')
            }
        })
    </script>
@endsection
