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
                           <label class="form-label">User</label>
                           @foreach ($idusers as $iduser)
                           <input type="text" value="{{ $iduser->name}}" class="form-control" readonly>
                           @endforeach
                       </div>
                        <div class="col-6">
                            <label class="form-label">Card Pemilik</label>
                            <input type="text" value="{{ $owners->IdCard->card_id_name }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nik Pemilik</label>
                            <input type="text" value="{{ $owners->nik_pemilik }}" class="form-control" readonly>
                        </div>
            
                        <div class="col-6">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" value="{{$owners->nama_pemilik}}" class="form-control" readonly>
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
                            <input type="text"  value="{{$owners->kewarganegaraan}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Masa Berlaku ID</label>
                            <input type="text" value="{{\Carbon\Carbon::parse($owners->masa_berlaku_id)->format('d-M-Y')}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pemilik</label>
                            <input type="text" value="{{$owners->alamat_ktp_pemilik}}" class="form-control" readonly>
                        </div>
              
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pemilik</label>
                            <input type="text" value="{{$owners->alamat_tinggal_pemilik}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" value="{{$owners->provinsi}}" class="form-control" readonly>
                        </div>
          
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" value="{{$owners->kode_pos}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Pemilik </label>
                            <input type="text" value="{{$owners->no_telp_pemilik}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="text" value="{{\Carbon\Carbon::parse($owners->tgl_masuk)->format('d-M-Y')}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Keluar</label>
                            <input type="text" value="{{\Carbon\Carbon::parse($owners->tgl_keluar)->format('d-M-Y')}}" class="form-control" readonly>
                        </div>
             
                    
                        {{-- <div class="col-6">
                            <label class="form-label">ID Kepemilikan Unit</label>
                            <input type="text" name="" value="{{$kepemilikan->id_kempemilikan_unit}}" class="form-control" readonly>
                        </div> --}}
                        
                        <div class="col-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" value="{{$owners->tempat_lahir}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" value="{{\Carbon\Carbon::parse($owners->tgl_lahir)->format('d-M-Y')}}" class="form-control" readonly>
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <input type="text" value="{{ $owners->jeniskelamin->jenis_kelamin }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Agama</label>
                            <input type="text" value="{{ $owners->agama->nama_agama }}" class="form-control" readonly>
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label">Status Kawin</label>
                            <input type="text" id="id_status_kawin" value="{{$owners->statuskawin->status_kawin }}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" value="{{$owners->pekerjaan}}" class="form-control" readonly>
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label">NIK Kontak PIC</label>
                            <input type="text" value="{{$owners->nik_kontak_pic}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Kontak PIC</label>
                            <input type="text" value="{{$owners->nama_kontak_pic}}" class="form-control" readonly>
                        </div>
               
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Kontak PIC</label>
                            <input type="text" value="{{$owners->alamat_tinggal_kontak_pic}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email Kontak PIC</label>
                            <input type="text" value="{{$owners->email_kontak_pic}}" class="form-control" readonly>
                        </div>

                        <div class="col-6">
                            <label class="form-label">No Telp Kontak PIC</label>
                            <input type="text" value="{{$owners->no_telp_kontak_pic}}" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Hubungan Kontak PIC</label>
                            <input type="text" value="{{$owners->hubungan_kontak_pic}}" class="form-control" readonly>
                        </div>
                        
                        <div class="penjamin mt-5" id="penjamin">
                            <h5>Penjamin</h5>
                            <hr>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Nik Penjamin</label>
                                        <input type="text" value="{{$owners->nik_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Nama Penjamin</label>
                                        <input type="text" value="{{$owners->nama_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                          
                                    <div class="col-6">
                                        <label class="form-label">Alamat KTP Penjamin</label>
                                        <input type="text" value="{{$owners->alamat_ktp_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Alamat Tinggal Penjamin</label>
                                        <input type="text" value="{{$owners->alamat_tinggal_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                            
                                    <div class="col-6">
                                        <label class="form-label">Hubungan Penjamin</label>
                                        <input type="text" value="{{$owners->hubungan_penjamin}}" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">No Telp Penjamin</label>
                                        <input type="text" value="{{$owners->no_telp_penjamin}}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="penjamin mt-5" id="pasangan">
                            <h5>Pasangan</h5>
                            <hr>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Nik Pasangan</label>
                                        <input type="text" value="{{$owners->nik_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Nama Pasangan</label>
                                        <input type="text" value="{{$owners->nama_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                          
                                    <div class="col-6">
                                        <label class="form-label">Alamat KTP Pasangan</label>
                                        <input type="text" value="{{$owners->alamat_ktp_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Alamat Tinggal Pasangan</label>
                                        <input type="text" value="{{$owners->alamat_tinggal_pasangan_penjamin}}" class="form-control" readonly>
                                    </div>
                            
                                    <div class="col-6">
                                        <label class="form-label">Hubungan Pasangan</label>
                                        <input type="text" value="{{$owners->hubungan_penjamin}}" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">No Telp Pasangan</label>
                                        <input type="text" value="{{$owners->no_telp_penjamin}}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                </div>

            {{-- </form> --}}
                        <a href="{{ route('owners.edit', $owners->id_pemilik) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('owners.index')}}">Back</a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var status = $('#id_status_kawin').val();
            console.log(status)
            if (status == 1) {
                $('#penjamin').css('display', 'block')
                $('#pasangan').css('display', 'none')
            } else {
                $('#penjamin').css('display', 'none')
                $('#pasangan').css('display', 'block')
            }

            $('#id_status_kawin').on('change', function() {
                var status = $(this).val();

                if (status == 1) {
                    $('#penjamin').css('display', 'block')
                    $('#pasangan').css('display', 'none')
                } else {
                    $('#penjamin').css('display', 'none')
                    $('#pasangan').css('display', 'block')
                }
            })
        })
    </script>
@endsection
