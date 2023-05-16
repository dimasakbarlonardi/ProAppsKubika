@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Karyawan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('karyawans.create') }}">Tambah Karyawan</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_karyawan">ID Karyawan</th>
                    <th class="sort" data-sort="id_site">ID Site</th>
                    <th class="sort" data-sort="id_card_type">ID Card Type</th>
                    <th class="sort" data-sort="nik_karyawan">Nik Karyawan</th>
                    <th class="sort" data-sort="nama_karyawan">Nama Karyawan</th>
                    <th class="sort" data-sort="id_status_karyawan">ID Status Karyawan</th>
                    <th class="sort" data-sort="id_status_kawin_karyawan">ID Status Kawin Karyawan</th>
                    <th class="sort" data-sort="id_status_aktif_karyawan">ID Status Aktif Karyawan</th>
                    <th class="sort" data-sort="kewarganegaraan">Kewarganegaraan</th>
                    <th class="sort" data-sort="masa_berlaku_id">Masa Berlaku ID</th>
                    <th class="sort" data-sort="alamat_ktp_karyawan">Alamat KTP Karyawan</th>
                    <th class="sort" data-sort="no_telp_karyawan">No Telpon Karyawan</th>
                    <th class="sort" data-sort="nik_pasangan_penjamin">NIK Pasangan Penjamin</th>
                    <th class="sort" data-sort="nama_pasangan_penjamin">Nama Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_ktp_pasangan_penjamin">Alamat KTP Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_tinggal_pasangan_penjamin">Alamat Tinggal Pemilik</th>
                    <th class="sort" data-sort="hubungan_penjamin">Hubungan Penjamin</th>
                    <th class="sort" data-sort="no_telp_penjamin">No Telpon Penjamin</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    <th class="sort" data-sort="id_unit">Provinsi</th>
                    <th class="sort" data-sort="id_jabatan">Kode Pos</th>
                    <th class="sort" data-sort="id_divisi">Alamat Tinggal Pasangan Penjamin</th>
                    <th class="sort" data-sort="id_departemen">ID Kepemilikan Unit</th>
                    <th class="sort" data-sort="id_penempatan">Tempat Lahir</th>
                    <th class="sort" data-sort="tempat_lahir">Tanggal Lahir</th>
                    <th class="sort" data-sort="tgl_lahir">ID Jenis Kelamin</th>
                    <th class="sort" data-sort="id_agama">ID Agama</th>
                    <th class="sort" data-sort="id_jenis_kelamin">ID Status Kawin</th>             
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawans as $key => $karyawan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $karyawan->id_karyawan }}</td>
                        <td>{{ $karyawan->id_site }}</td>
                            {{dd($karyawan)}}
                        <td>{{ $karyawan->idcard}}</td>
                        <td>{{ $karyawan->nik_karyawan }}</td>
                        <td>{{ $karyawan->nama_karyawan }}</td>
                        <td>{{ $karyawan->id_status_karyawan}}</td>
                        <td>{{ $karyawan->id_status_kawin_karyawan }}</td>
                        <td>{{ $karyawan->id_status_aktif_karyawan }}</td>
                        <td>{{ $karyawan->kewarganegaraan }}</td>
                        <td>{{ $karyawan->masa_berlaku_id }}</td>
                        <td>{{ $karyawan->alamat_ktp_karyawan }}</td>
                        <td>{{ $karyawan->no_telp_karyawan }}</td>
                        <td>{{ $karyawan->nik_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->nama_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->alamat_ktp_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->alamat_tinggal_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->hubungan_penjamin }}</td>
                        <td>{{ $karyawan->no_telp_penjamin }}</td>
                        <td>{{ $karyawan->tgl_masuk }}</td>
                        <td>{{ $karyawan->tgl_keluar }}</td>
                        <td>{{ $karyawan->id_jabatan }}</td>
                        <td>{{ $karyawan->id_divisi }}</td>
                        <td>{{ $karyawan->id_departemen }}</td>
                        <td>{{ $karyawan->id_penempatan }}</td>
                        <td>{{ $karyawan->tempat_lahir }}</td>
                        <td>{{ $karyawan->tgl_lahir }}</td>
                        <td>{{ $karyawan->id_agama }}</td>
                        <td>{{ $karyawan->id_jenis_kelamin }}</td>
                        <td>{{ $karyawan->id_status_kawin }}</td>
                        <td>
                            <a href="{{ route('karyawans.edit', $karyawan->id_karyawan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('karyawans.destroy', $karyawan->id_karyawan) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
