@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Owner</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('owners.create') }}">Tambah Owner</a>
            </div>
        </div>
    </div>
    <div class="p-5 table-responsive scrollbar">
        <table class="table table-striped table-bordered ">
            <thead class="table-success bg-200 text-900">
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_pemilik">IDPemilik</th>
                    <th class="sort" data-sort="id_card_type">IDCardType</th>
                    {{-- <th class="sort" data-sort="nik_pemilik">Nik Pemilik</th>  --}}
                    <th class="sort" data-sort="nama_pemilik">Owner</th>
                    <th class="sort" data-sort="alamat_tinggal_pemilik">AlamatTinggalPemilik</th>
                    <th class="sort" data-sort="id_status_aktif_pemilik">IDStatusAktifPemilik</th>
                    {{-- <th class="sort" data-sort="kewarganegaraan">Kewarganegaraan</th> --}}
                    {{-- <th class="sort" data-sort="masa_berlaku_id">Masa Berlaku ID</th> --}}
                    {{-- <th class="sort" data-sort="alamat_ktp_pemilik">Alamat KTP Pemilik</th> --}}
                    {{-- <th class="sort" data-sort="provinsi">Provinsi</th>
                    <th class="sort" data-sort="kode_pos">Kode Pos</th>
                    <th class="sort" data-sort="no_telp_pemilik">No Telpon Pemilik</th>
                    <th class="sort" data-sort="nik_pasangan_penjamin">NIK Pasangan Penjamin</th>
                    <th class="sort" data-sort="nama_pasangan_penjamin">Nama Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_ktp_pasangan_penjamin">Alamat KTP Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_tinggal_pasangan_penjamin">Alamat Tinggal Pasangan Penjamin</th>
                    <th class="sort" data-sort="hubungan_penjamin">Hubungan Penjamin</th>
                    <th class="sort" data-sort="no_telp_penjamin">No Telpon Penjamin</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    <th class="sort" data-sort="id_kempemilikan_unit">ID Kepemilikan Unit</th>
                    <th class="sort" data-sort="tempat_lahir">Tempat Lahir</th>
                    <th class="sort" data-sort="tgl_lahir">Tanggal Lahir</th>
                    <th class="sort" data-sort="id_jenis_kelamin">ID Jenis Kelamin</th>
                    <th class="sort" data-sort="id_agama">ID Agama</th>
                    <th class="sort" data-sort="id_status_kawin">ID Status Kawin</th>
                    <th class="sort" data-sort="pekerjaan">Pekerjaan</th>
                    <th class="sort" data-sort="nik_kontak_pic">NIK Kontak PIC</th>
                    <th class="sort" data-sort="nama_kontak_pic">Nama Kontak PIC</th>
                    <th class="sort" data-sort="alamat_tinggal_kontak_pic">Alamat Tinggal Kontak PIC</th>
                    <th class="sort" data-sort="email_kontak_pic">Email Kontak PIC</th>
                    <th class="sort" data-sort="no_telp_kontak_pic">No Telp Kontak PIC</th>
                    <th class="sort" data-sort="hubungan_kontak_pic">Hubungan Kontak PIC</th>                  --}}
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody class="list" >
                @foreach ($owners as $key => $owner)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $owner->id_pemilik }}</td>
                        <td class="masa_berlaku_id">
                            {{-- <span> <b> KTP : </b>  <br> {{ $owner->IdCard->card_id_name }}</span> <br> --}}
                            <span> <b> Masa Berlaku : </b> <br> {{ $owner->masa_berlaku_id}}</span> <br> 
                        </td>
                        {{-- <td>{{ $owner->nik_pemilik }}</td> --}}
                        <td class="nama_pemilik">
                            <span> <b> Nama Pemilik : </b> <br> {{ $owner->nama_pemilik  }}</span> <br>
                            <span> <b> Nik : </b> <br> {{ $owner->nik_pemilik }} </span> <br>
                            <span> <b> Kewarganegaraan : </b> <br> {{ $owner->kewarganegaraan }} </span> <br>
                            <span> <b> No Telp : </b> <br> {{ $owner->no_telp_pemilik }} </span> <br>
                        </td>
                        <td class="alamat_tinggal_pemilik">
                            <span> <b> Alamat : </b> <br> {{ $owner->alamat_tinggal_pemilik }} </span> <br>
                            <span> <b> Kode Pos : </b> <br> {{ $owner->kode_pos }} </span> <br>
                            <span> <b> Provinsi : </b> <br> {{ $owner->provinsi }} </span> <br>
                        </td>
                        <td>{{ $owner->id_status_aktif_pemilik }}</td>
                        {{-- <td>{{ $owner->kewarganegaraan }}</td> --}}
                        {{-- <td>{{ $owner->masa_berlaku_id }}</td> --}}
                        {{-- <td>{{ $owner->alamat_ktp_pemilik }}</td> --}}
                        {{-- <td>{{ $owner->provinsi }}</td>
                        <td>{{ $owner->kode_pos }}</td>
                        <td>{{ $owner->no_telp_pemilik }}</td>
                        <td>{{ $owner->nik_pasangan_penjamin }}</td>
                        <td>{{ $owner->nama_pasangan_penjamin }}</td>
                        <td>{{ $owner->alamat_ktp_pasangan_penjamin }}</td>
                        <td>{{ $owner->alamat_tinggal_pasangan_penjamin }}</td>
                        <td>{{ $owner->hubungan_penjamin }}</td>
                        <td>{{ $owner->no_telp_penjamin }}</td>
                        <td>{{ $owner->tgl_masuk }}</td>
                        <td>{{ $owner->tgl_keluar }}</td>
                        <td>{{ $owner->id_kempemilikan_unit }}</td>
                        <td>{{ $owner->tempat_lahir }}</td>
                        <td>{{ $owner->tgl_lahir }}</td>
                        <td>{{ $owner->id_jenis_kelamin }}</td>
                        <td>{{ $owner->id_agama }}</td>
                        <td>{{ $owner->id_status_kawin }}</td>
                        <td>{{ $owner->pekerjaan }}</td>
                        <td>{{ $owner->nik_kontak_pic }}</td>
                        <td>{{ $owner->nama_kontak_pic }}</td>
                        <td>{{ $owner->alamat_tinggal_kontak_pic }}</td>
                        <td>{{ $owner->email_kontak_pic }}</td>
                        <td>{{ $owner->no_telp_kontak_pic }}</td>
                        <td>{{ $owner->hubungan_kontak_pic }}</td> --}}
                        <td>
                            <a href="{{ route('owners.show', $owner->id_pemilik) }}" class="btn btn-sm btn-warning">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

