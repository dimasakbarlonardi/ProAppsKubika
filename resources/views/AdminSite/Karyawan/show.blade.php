@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Detail Karyawan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
                <div class="mb-3">
                    <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nama Site</label>
                        <input type="text" value="Park Royale" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID User</label>
                        <input type="text" value="{{$karyawan->id_user}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Card Karyawan</label>
                        <input type="text" value="{{$karyawan->id_card_type}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nik Karyawan</label>
                        <input type="text" value="{{$karyawan->nik_karyawan}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama Karyawan</label>
                        <input type="text" value="{{$karyawan->nama_karyawan}}" class="form-control" readonly>
                    </div>
                    {{-- <div class="col-6">
                        <label class="form-label">ID Status Karyawan</label>
                        <select class="form-control" value="{{$karyawan->id_status_karyawan" readonly>
                            <option selected disabled>-- Pilih Status Karyawan --</option>
                            @foreach ($statuspemiliks as $statuspemilik)
                            <option value="{{ $statuspemilik->id_status_aktif_pemilik }}">{{ $statuspemilik->status_hunian_pemilik }} </option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="col-6">
                        <label class="form-label">ID Status Kawin Karyawan</label>
                        <select class="form-control" value="{{$karyawan->id_status_kawin_karyawan" readonly>
                            <option selected disabled>-- Pilih Status Pemilik --</option>
                            @foreach ($statuskawinkaryawans as $statuskawinkaryawan)
                            <option value="{{ $statuskawinkaryawan->id_status_kawin_karyawan }}">{{ $statuskawinkaryawan-> }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="col-6">
                        <label class="form-label">ID Status Aktif Karyawan</label>
                        <select class="form-control" value="{{$karyawan->id_status_aktif_karyawan" readonly>
                            <option selected disabled>-- Pilih Status Pemilik --</option>
                            @foreach ($statusaktifkaryawans as $statusaktifkaryawan)
                            <option value="{{ $statusaktifkaryawan->id_status_aktif_karyawan }}">{{ $statusaktifkaryawan-> }} </option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col-6">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" value="{{$karyawan->kewarganegaraan}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Masa Berlaku ID</label>
                        <input type="date" value="{{$karyawan->masa_berlaku_id}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Alamat KTP Karyawan</label>
                        <input type="text" value="{{$karyawan->alamat_ktp_karyawan}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No Telp Karyawan</label>
                        <input type="text" value="{{$karyawan->no_telp_karyawan}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">NIK Pasangan Penjamin</label>
                        <input type="text" value="{{$karyawan->nik_pasangan_penjamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama Pasangan Penjamin</label>
                        <input type="text" value="{{$karyawan->nama_pasangan_penjamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                        <input type="text" value="{{$karyawan->alamat_ktp_pasangan_penjamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                        <input type="text" value="{{$karyawan->alamat_tinggal_pasangan_penjamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Hubungan Penjamin</label>
                        <input type="text" value="{{$karyawan->hubungan_penjamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No Telp Penjamin</label>
                        <input type="text" value="{{$karyawan->no_telp_penjamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" value="{{$karyawan->tgl_masuk}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tanggal Keluar</label>
                        <input type="date" value="{{$karyawan->tgl_keluar}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Jabatan</label>
                        <input type="text" value="{{$karyawan->id_jabatan}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Divisi</label>
                        <input type="text" value="{{$karyawan->id_divisi}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Departement</label>
                        <input type="text" value="{{$karyawan->id_departemen}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Penempatan</label>
                        <input type="text" value="{{$karyawan->id_penempatan}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" value="{{$karyawan->tempat_lahir}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" value="{{$karyawan->tgl_lahir}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Jenis Kelamin</label>
                        <input type="text" value="{{$karyawan->id_jenis_kelamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Agama</label>
                        <input type="text" value="{{$karyawan->id_agama}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Status Kawin</label>
                        <input type="text" value="{{$karyawan->id_status_kawin}}" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <a href="{{ route('karyawans.edit', $karyawan->id_karyawan) }}" class="btn btn-sm btn-warning">Edit</a>
            <form class="d-inline" action="{{ route('karyawans.destroy', $karyawan->id_karyawan) }}" method="post">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('are you sure?')">Hapus</button>
            </form>
        </div>
    </div>
@endsection
