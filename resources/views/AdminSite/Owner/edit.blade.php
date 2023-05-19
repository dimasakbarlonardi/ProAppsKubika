@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Owner</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('owners.update', $owner->id_pemilik) }}">
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
                                <option value="{{ $iduser->id }}" {{ $iduser->id == $owner->id_user ? 'selected' : '' }} >{{ $iduser->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">ID Card Pemilik</label>
                            <select class="form-control" name="id_card_type" required>
                                <option selected disabled >-- Pilih ID Card --</option>
                                @foreach ($idcards as $idcard)
                                <option value="{{ $idcard->id_card_type }}" {{ $idcard->id_card_type == $owner->id_card_type ? 'selected' : ''}}>{{ $idcard->card_id_name }} {{ $idcard->id_card_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    <div class="col-6">
                        <label class="form-label">Nik Pemilik</label>
                        <input type="text" name=nik_pemilik value="{{ $owner->nik_pemilik }}" class="form-control" required>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" name=nama_pemilik value="{{$owner->nama_pemilik}}" class="form-control" required>
                        </div>
                        {{-- <div class="col-5">
                            <label class="form-label">ID Status Aktif Pemilik</label>
                            <select class="form-control" name="id_status_aktif_pemilik" required>
                                <option selected disabled>-- Pilih Status Pemilik --</option>
                                @foreach ($statuspemiliks as $statuspemilik)
                                <option value="{{ $statuspemilik->id_status_aktif_pemilik }}">{{ $statuspemilik->status_hunian_pemilik }} {{ $statushunian->id_status_aktif_pemilik }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-6">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" value="{{$owner->kewarganegaraan}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Masa Berlaku ID</label>
                            <input type="date" name="masa_berlaku_id" value="{{$owner->masa_berlaku_id}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pemilik</label>
                            <input type="text" name="alamat_ktp_pemilik" value="{{$owner->alamat_ktp_pemilik}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pemilik</label>
                            <input type="text" name="alamat_tinggal_pemilik" value="{{$owner->alamat_tinggal_pemilik}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" value="{{$owner->provinsi}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" value="{{$owner->kode_pos}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Pemilik </label>
                            <input type="text" name="no_telp_pemilik" value="{{$owner->no_telp_pemilik}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nik Pasangan Penjamin</label>
                            <input type="text" name="nik_pasangan_penjamin" value="{{$owner->nik_pasangan_penjamin}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Pasangan Penjamin</label>
                            <input type="text" name="nama_pasangan_penjamin" value="{{$owner->nama_pasangan_penjamin}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                            <input type="text" name="alamat_ktp_pasangan_penjamin" value="{{$owner->alamat_ktp_pasangan_penjamin}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                            <input type="text" name="alamat_tinggal_pasangan_penjamin" value="{{$owner->alamat_tinggal_pasangan_penjamin}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Hubungan Penjamin</label>
                            <input type="text" name="hubungan_penjamin" value="{{$owner->hubungan_penjamin}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Penjamin</label>
                            <input type="text" name="no_telp_penjamin" value="{{$owner->no_telp_penjamin}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tgl_masuk" value="{{$owner->tgl_masuk}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Keluar</label>
                            <input type="date" name="tgl_keluar" value="{{$owner->tgl_keluar}}" class="form-control" required>
                        </div>
                    </div>
                        {{-- {-- <div class="col-5">
                            <label class="form-label">ID Status Aktif Pemilik</label>
                            <select class="form-control" name="id_kempemilikan_unit" required>
                                <option selected disabled>-- Pilih Status Pemilik --</option>
                                @foreach ($statuspemiliks as $statuspemilik)
                                <option value="{{ $statuspemilik->id_kempemilikan_unit }}">{{ $statuspemilik->status_hunian_pemilik }} {{ $statushunian->id_kempemilikan_unit }}</option>
                                @endforeach
                            </select>
                        </div> --}} 
                        {{-- <div class="col-6">
                            <label class="form-label">ID Kepemilikan Unit</label>
                            <input type="text" name="" value="{{$kepemilikan->id_kempemilikan_unit}}" class="form-control" required>
                        </div> --}}
                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{$owner->tempat_lahir}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" value="{{$owner->tgl_lahir}}" class="form-control" required>
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <label class="form-label">ID Jenis Kelamin</label>
                            <select class="form-control" name="id_jenis_kelamin" required>
                                <option selected disabled>-- Pilih Jenis Kelamin --</option>
                                @foreach ($genders as $gender)
                                <option value="{{ $owner->id_jenis_kelamin }}">{{ $gender->jenis_kelamin }}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="col-6">
                            <label class="form-label">ID Agama</label>
                            <select class="form-control" name="id_agama" required>
                                <option selected disabled>-- Pilih Agama --</option>
                                @foreach ($agamas as $agama)
                                <option value="{{ $owner->id_agama }}">{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div> 
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <label class="form-label">ID Status Kawin</label>
                            <select class="form-control" name="id_status_kawin" required>
                                <option selected disabled>-- Pilih Status Kawin --</option>
                                @foreach ($statuskawins as $statuskawin)
                                <option value="{{ $owner->id_status_kawin }}">{{ $statuskawin->status_kawin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="{{$owner->pekerjaan}}" class="form-control" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">NIK Kontak PIC</label>
                            <input type="text" name="nik_kontak_pic" value="{{$owner->nik_kontak_pic}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Kontak PIC</label>
                            <input type="text" name="nama_kontak_pic" value="{{$owner->nama_kontak_pic}}" class="form-control" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Kontak PIC</label>
                            <input type="text" name="alamat_tinggal_kontak_pic" value="{{$owner->alamat_tinggal_kontak_pic}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email Kontak PIC</label>
                            <input type="text" name="email_kontak_pic" value="{{$owner->email_kontak_pic}}" class="form-control" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">No Telp Kontak PIC</label>
                            <input type="text" name="no_telp_kontak_pic" value="{{$owner->no_telp_kontak_pic}}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Hubungan Kontak PIC</label>
                            <input type="text" name="hubungan_kontak_pic" value="{{$owner->hubungan_kontak_pic}}" class="form-control" required>
                        </div>
                        </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
