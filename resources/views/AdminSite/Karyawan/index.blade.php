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
    <div class="p-5 table-responsive scrollbar">
        <table class="table table-striped table-bordered">
            <thead class="table-success bg-200 text-900">
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_karyawan">ID Karyawan</th>
                    <th class="sort" data-sort="nama_karyawan">Nama Karyawan</th>
                    <th class="sort" data-sort="alamat_ktp_karyawan">Alamat KTP Karyawan</th>
{{-- 
                    <th class="sort" data-sort="id_site">ID Site</th>
                    <th class="sort" data-sort="id_card_type">ID Card Type</th>
                    <th class="sort" data-sort="nik_karyawan">Nik Karyawan</th>
                    <th class="sort" data-sort="id_status_karyawan">ID Status Karyawan</th>
                    <th class="sort" data-sort="id_status_kawin_karyawan">ID Status Kawin Karyawan</th>
                    <th class="sort" data-sort="id_status_aktif_karyawan">ID Status Aktif Karyawan</th>
                    <th class="sort" data-sort="kewarganegaraan">Kewarganegaraan</th>
                    <th class="sort" data-sort="masa_berlaku_id">Masa Berlaku ID</th>
                    <th class="sort" data-sort="no_telp_karyawan">No Telpon Karyawan</th>
                    <th class="sort" data-sort="nik_pasangan_penjamin">NIK Pasangan Penjamin</th>
                    <th class="sort" data-sort="nama_pasangan_penjamin">Nama Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_ktp_pasangan_penjamin">Alamat KTP Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_tinggal_pasangan_penjamin">Alamat Tinggal Pemilik</th>
                    <th class="sort" data-sort="hubungan_penjamin">Hubungan Penjamin</th>
                    <th class="sort" data-sort="no_telp_penjamin">No Telpon Penjamin</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    --}}
                    <th class="sort" data-sort="id_jabatan">Jabatan</th>
                    <th class="sort" data-sort="id_divisi">Divisi</th>
                    <th class="sort" data-sort="id_departemen">Departement</th>
                    {{-- <th class="sort" data-sort="id_penempatan">Penempatan</th>
                    <th class="sort" data-sort="tempat_lahir">Tempat Lahir</th>
                    <th class="sort" data-sort="tgl_lahir">ID Jenis Kelamin</th>
                    <th class="sort" data-sort="id_agama">ID Agama</th>
                    <th class="sort" data-sort="id_jenis_kelamin">ID Status Kawin</th>  --}}
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawans as $key => $karyawan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $karyawan->id_karyawan }}</td>
                        <td class="nama_karyawan">
                            <span> <b> Nama : </b> <br> {{ $karyawan->nama_karyawan  }}</span> <br>
                            <span> <b> Nik : </b> <br> {{ $karyawan->nik_karyawan }} </span> <br>
                            <span> <b> Kewarganegaraan : </b> <br> {{ $karyawan->kewarganegaraan }} </span> <br>
                            <span> <b> No Telp : </b> <br> {{ $karyawan->no_telp_karyawan }} </span> <br>
                        </td>
                        <td class="alamat_tinggal_pemilik">
                            <span> <b> Alamat : </b> <br> {{ $karyawan->alamat_ktp_karyawan }} </span> <br>
                            <span> <b> Kode Pos : </b> <br> {{ $karyawan->kode_pos }} </span> <br>
                            <span> <b> Provinsi : </b> <br> {{ $karyawan->provinsi }} </span> <br>
                        </td>
                        {{-- <td>{{ $karyawan->id_site}}</td>
                        <td>{{ $karyawan->IdCard->card_id_name}}</td> --}}
                        {{-- <td>{{ $karyawan->nik_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->nama_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->id_status_karyawan}}</td>
                        <td>{{ $karyawan->id_status_kawin_karyawan }}</td>
                        <td>{{ $karyawan->id_status_aktif_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->kewarganegaraan }}</td> --}}
                        {{-- <td>{{ $karyawan->masa_berlaku_id }}</td> --}}
                        {{-- <td>{{ $karyawan->alamat_ktp_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->no_telp_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->nik_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->nama_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->alamat_ktp_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->alamat_tinggal_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->hubungan_penjamin }}</td>
                        <td>{{ $karyawan->no_telp_penjamin }}</td>
                        <td>{{ $karyawan->tgl_masuk }}</td>
                        <td>{{ $karyawan->tgl_keluar }}</td> --}}

                        <td>{{ $karyawan->Jabatan->nama_jabatan }}</td>
                        <td>{{ $karyawan->Divisi->nama_divisi }}</td>
                        <td>{{ $karyawan->Departemen->nama_departemen }}</td> 

                        {{-- <td>{{ $karyawan->id_penempatan }}</td>
                        <td>{{ $karyawan->tempat_lahir }}</td>
                        <td>{{ $karyawan->tgl_lahir }}</td>
                        <td>{{ $karyawan->agama->nama_agama }}</td>
                        <td>{{ $karyawan->jeniskelamin->jenis_kelamin }}</td>
                        <td>{{ $karyawan->statuskawin->status_kawin }}</td>  --}}
                        <td>
                            <a href="{{ route('karyawans.show', $karyawan->id_karyawan) }}" class="btn btn-sm btn-warning">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
