@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Detail Owner</h6>
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
                           <input type="text" value="{{ $owner->id_user  }}" class="form-control" readonly>
                       </div>
                        <div class="col-6">
                            <label class="form-label">ID Card Pemilik</label>
                            <input type="text" value="{{ $owner->id_card_type  }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nik Pemilik</label>
                            <input type="text" value="{{ $owner->nik_pemilik }}" class="form-control" readonly>
                        </div>
            
                        <div class="col-6">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" value="{{$owner->nama_pemilik}}" class="form-control" readonly>
                        </div>
                        {{-- <div class="col-5">
                            <label class="form-label">ID Status Aktif Pemilik</label>
                            <select class="form-control" name="id_status_aktif_pemilik" readonly>
                                <option selected disabled>-- Pilih Status Pemilik --</option>
                                @foreach ($statuspemiliks as $statuspemilik)
                                <option value="{{ $statuspemilik->id_status_aktif_pemilik }}">{{ $statuspemilik->status_hunian_pemilik }} {{ $statushunian->id_status_aktif_pemilik }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-6">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text"  value="{{$owner->kewarganegaraan}}" class="form-control" readonly>
                        </div>
         
                        <div class="col-6">
                            <label class="form-label">Masa Berlaku ID</label>
                            <input type="text" value="{{$owner->masa_berlaku_id}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pemilik</label>
                            <input type="text" value="{{$owner->alamat_ktp_pemilik}}" class="form-control" readonly>
                        </div>
              
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pemilik</label>
                            <input type="text" value="{{$owner->alamat_tinggal_pemilik}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" value="{{$owner->provinsi}}" class="form-control" readonly>
                        </div>
          
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" value="{{$owner->kode_pos}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Pemilik </label>
                            <input type="text" value="{{$owner->no_telp_pemilik}}" class="form-control" readonly>
                        </div>
      
                        <div class="col-6">
                            <label class="form-label">Nik Pasangan Penjamin</label>
                            <input type="text" value="{{$owner->nik_pasangan_penjamin}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Pasangan Penjamin</label>
                            <input type="text" value="{{$owner->nama_pasangan_penjamin}}" class="form-control" readonly>
                        </div>
              
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                            <input type="text" value="{{$owner->alamat_ktp_pasangan_penjamin}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                            <input type="text" value="{{$owner->alamat_tinggal_pasangan_penjamin}}" class="form-control" readonly>
                        </div>
                
                        <div class="col-6">
                            <label class="form-label">Hubungan Penjamin</label>
                            <input type="text" value="{{$owner->hubungan_penjamin}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Penjamin</label>
                            <input type="text" value="{{$owner->no_telp_penjamin}}" class="form-control" readonly>
                        </div>
              
                        <div class="col-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="text" value="{{$owner->tgl_masuk}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Keluar</label>
                            <input type="text" value="{{$owner->tgl_keluar}}" class="form-control" readonly>
                        </div>
             
                        {{-- {-- <div class="col-5">
                            <label class="form-label">ID Status Aktif Pemilik</label>
                            <select class="form-control" name="id_kempemilikan_unit" readonly>
                                <option selected disabled>-- Pilih Status Pemilik --</option>
                                @foreach ($statuspemiliks as $statuspemilik)
                                <option value="{{ $statuspemilik->id_kempemilikan_unit }}">{{ $statuspemilik->status_hunian_pemilik }} {{ $statushunian->id_kempemilikan_unit }}</option>
                                @endforeach
                            </select>
                        </div> --}} 
                        {{-- <div class="col-6">
                            <label class="form-label">ID Kepemilikan Unit</label>
                            <input type="text" name="" value="{{$kepemilikan->id_kempemilikan_unit}}" class="form-control" readonly>
                        </div> --}}
            
                        <div class="col-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" value="{{$owner->tempat_lahir}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" value="{{$owner->tgl_lahir}}" class="form-control" readonly>
                        </div>
          
                        <div class="col-6">
                            <label class="form-label">ID Jenis Kelamin</label>
                            <input type="text" value="{{ $owner->id_jenis_kelamin }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Agama</label>
                            <input type="text" value="{{ $owner->id_agama }}" class="form-control" readonly>
                        </div>
                
                        <div class="col-6">
                            <label class="form-label">ID Status Kawin</label>
                            <input type="text" value="{{$owner->id_status_kawin }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" value="{{$owner->pekerjaan}}" class="form-control" readonly>
                        </div>
          
                        <div class="col-6">
                            <label class="form-label">NIK Kontak PIC</label>
                            <input type="text" value="{{$owner->nik_kontak_pic}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Kontak PIC</label>
                            <input type="text" value="{{$owner->nama_kontak_pic}}" class="form-control" readonly>
                        </div>
               
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Kontak PIC</label>
                            <input type="text" value="{{$owner->alamat_tinggal_kontak_pic}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email Kontak PIC</label>
                            <input type="text" value="{{$owner->email_kontak_pic}}" class="form-control" readonly>
                        </div>

                        <div class="col-6">
                            <label class="form-label">No Telp Kontak PIC</label>
                            <input type="text" value="{{$owner->no_telp_kontak_pic}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Hubungan Kontak PIC</label>
                            <input type="text" value="{{$owner->hubungan_kontak_pic}}" class="form-control" readonly>
                        </div>
                </div>
                </div>

            {{-- </form> --}}
                        <a href="{{ route('owners.edit', $owner->id_pemilik) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('owners.destroy', $owner->id_pemilik) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
        </div>
    </div>
@endsection
