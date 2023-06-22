@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Karyawan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('karyawans.update', $karyawan->id_karyawan) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nama Site</label>
                        <input type="text" value="Park Royale" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID User</label>
                        <select class="form-control" name="id_user" required>
                            <option selected disabled>-- Pilih ID User --</option>
                            @foreach ($idusers as $iduser)
                            <option value="{{ $iduser->id }}" {{ $iduser->id == $karyawan->id_user ? 'selected' : '' }}>{{ $iduser->nama_user }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Card Karyawan</label>
                        <select class="form-control" name="id_card_type" required>
                            <option selected disabled>-- Pilih ID Card --</option>
                            @foreach ($idcards as $idcard)
                            <option value="{{ $idcard->id_card_type }}" {{ $idcard->id_card_type == $karyawan->id_card_type ? 'selected' : ''}}>{{ $idcard->card_id_name }} {{ $idcard->id_card_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nik Karyawan</label>
                        <input type="text" name="nik_karyawan" value="{{$karyawan->nik_karyawan}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama Karyawan</label>
                        <input type="text" name="nama_karyawan" value="{{$karyawan->nama_karyawan}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Status Karyawan</label>
                        <select class="form-control" name="id_status_karyawan" readonly>
                            <option selected disabled>-- Pilih Status Karyawan --</option>
                            @foreach ($statuskaryawans as $statuskaryawan)
                            <option value="{{ $statuskaryawan->id_status_karyawan }}" {{ $statuskaryawan->id_status_karyawan == $karyawan->id_status_karyawan ? 'selected' : '' }}>{{ $statuskaryawan->status_karyawan }} </option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Status Kawin Karyawan</label>
                            <select class="form-control" name="id_status_kawin_karyawan" required>
                                <option selected disabled>-- Pilih Status Kawin --</option>
                                @foreach ($statuskawins as $statuskawin)
                                <option value="{{ $statuskawin->id_status_kawin }}" {{ $statuskawin->id_status_kawin == $karyawan->id_status_kawin_karyawan ? 'selected' : '' }}>{{ $statuskawin->status_kawin }} </option>
                                @endforeach
                            </select>
                        </div>
                    <div class="col-6">
                        <label class="form-label">ID Status Aktif Karyawan</label>
                        <select class="form-control" name="id_status_aktif_karyawan" value="{{$karyawan->id_status_aktif_karyawan}}" required>
                            <option selected disabled>-- Pilih Status Pemilik --</option>
                            @foreach ($statusaktifkaryawans as $statusaktifkaryawan)
                            <option value="{{ $statusaktifkaryawan->id_status_aktif_karyawan }}" {{ $statusaktifkaryawan->id_status_aktif_karyawan == $karyawan->id_status_aktif_karyawan ? 'selected' : ''}}>{{ $statusaktifkaryawan->status_aktif_karyawan }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan" value="{{$karyawan->kewarganegaraan}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Masa Berlaku ID</label>
                        <input type="date" name="masa_berlaku_id" value="{{$karyawan->masa_berlaku_id}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Alamat KTP Karyawan</label>
                        <input type="text" name="alamat_ktp_karyawan" value="{{$karyawan->alamat_ktp_karyawan}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No Telp Karyawan</label>
                        <input type="text" name="no_telp_karyawan" value="{{$karyawan->no_telp_karyawan}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">NIK Pasangan Penjamin</label>
                        <input type="text" name="nik_pasangan_penjamin" value="{{$karyawan->nik_pasangan_penjamin}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama Pasangan Penjamin</label>
                        <input type="text" name="nama_pasangan_penjamin" value="{{$karyawan->nama_pasangan_penjamin}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                        <input type="text" name="alamat_ktp_pasangan_penjamin" value="{{$karyawan->alamat_ktp_pasangan_penjamin}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                        <input type="text" name="alamat_tinggal_pasangan_penjamin" value="{{$karyawan->alamat_tinggal_pasangan_penjamin}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Hubungan Penjamin</label>
                        <input type="text" name="hubungan_penjamin" value="{{$karyawan->hubungan_penjamin}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No Telp Penjamin</label>
                        <input type="text" name="no_telp_penjamin" value="{{$karyawan->no_telp_penjamin}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" value="{{$karyawan->tgl_masuk}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tanggal Keluar</label>
                        <input type="date" name="tgl_keluar" value="{{$karyawan->tgl_keluar}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Jabatan</label>
                        <select class="form-control" name="id_jabatan" required>
                            <option selected disabled>-- Pilih Jabatan --</option>
                            @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id_jabatan }}" {{ $jabatan->id_jabatan == $karyawan->id_jabatan ? 'selected' : ''}}>{{ $jabatan->nama_jabatan }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Divisi</label>
                        <select class="form-control" name="id_divisi" required>
                            <option selected disabled>-- Pilih Divisi --</option>
                            @foreach ($divisis as $divisi)
                            <option value="{{ $divisi->id_divisi }}"  {{ $divisi->id_divisi == $karyawan->id_divisi ? 'selected' : ''}}>{{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Departement</label>
                        <select class="form-control" name="id_departemen" required>
                            <option selected disabled>-- Pilih Departement --</option>
                            @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id_departemen }}" {{ $departemen->id_departemen == $karyawan->id_departemen ? 'selected' : ''}}>{{ $departemen->nama_departemen }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Penempatan</label>
                        <select class="form-control" name="id_penempatan" required>
                            <option selected disabled>-- Pilih Penempatan --</option>
                            @foreach ($penempatans as $penempatan)
                            <option value="{{ $penempatan->id_penempatan }}" {{ $penempatan->id_penempatan == $karyawan->id_penempatan ? 'selected' : ''}}>{{ $penempatan->lokasi_penempatan }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{$karyawan->tempat_lahir}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" name="tgl_lahir" value="{{$karyawan->tgl_lahir}}" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Jenis Kelamin</label>
                        <select class="form-control" name="id_jenis_kelamin" required>
                            <option selected disabled>-- Pilih Jenis Kelamin --</option>
                            @foreach ($jeniskelamins as $jeniskelamin)
                            <option value="{{ $jeniskelamin->id_jenis_kelamin }}" {{ $jeniskelamin->id_jenis_kelamin == $karyawan->id_jenis_kelamin ? 'selected' : ''}}>{{ $jeniskelamin->jenis_kelamin }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Agama</label>
                        <select class="form-control" name="id_agama" required>
                            <option selected disabled>-- Pilih Agama --</option>
                            @foreach ($agamas as $agama)
                            <option value="{{ $agama->id_agama }}" {{ $agama->id_agama == $karyawan->id_agama ? 'selected' : ''}}>{{ $agama->nama_agama }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Status Kawin Karyawan</label>
                        <select class="form-control" name="id_status_kawin_karyawan" required>
                            <option selected disabled>-- Pilih Status Kawin --</option>
                            @foreach ($statuskawins as $statuskawin)
                            <option value="{{ $statuskawin->id_status_kawin_karyawan }}" {{ $statuskawin->id_status_kawin == $karyawan->id_status_kawin_karyawan ? 'selected' : ''}}>{{ $statuskawin->status_kawin }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
