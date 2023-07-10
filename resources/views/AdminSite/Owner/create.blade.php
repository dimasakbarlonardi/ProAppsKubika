@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Tambah Owner</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('owners.store') }}">
                @csrf
                <div class="owner">
                    <h5>Owner</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Nama Site</label>
                            <input type="text" value="Park Royale" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email Owner</label>
                            <input type="email" value="{{ old('email_owner') }}" name="email_owner" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">ID Card Pemilik</label>
                            <select class="form-control" name="id_card_type" required>
                                <option selected disabled>-- Pilih ID Card --</option>
                                @foreach ($idcards as $idcard)
                                    <option value="{{ $idcard->id_card_type }}" @if (old('id_card_type') == $idcard->id_card_type) selected @endif>{{ $idcard->card_id_name }}
                                        {{ $idcard->id_card_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nik Pemilik</label>
                            <input type="text" value="{{ old('nik_pemilik') }}" maxlength="16" name="nik_pemilik" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" value="{{ old('nama_pemilik') }}" name="nama_pemilik" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" value="{{ old('kewarganegaraan') }}" name="kewarganegaraan" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Masa Berlaku ID</label>
                            <input type="date" value="{{ old('masa_berlaku_id') }}" name="masa_berlaku_id" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pemilik</label>
                            <input type="text" value="{{ old('alamat_ktp_pemilik') }}" name="alamat_ktp_pemilik" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pemilik</label>
                            <input type="text" value="{{ old('alamat_tinggal_pemilik') }}" name="alamat_tinggal_pemilik" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" value="{{ old('provinsi') }}" name="provinsi" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" value="{{ old('kode_pos') }}" name="kode_pos" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Pemilik </label>
                            <input type="text" value="{{ old('no_telp_pemilik') }}" name="no_telp_pemilik" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" value="{{ old('tgl_masuk') }}" name="tgl_masuk" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Keluar</label>
                            <input type="date" value="{{ old('tgl_keluar') }}" name="tgl_keluar" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" value="{{ old('tempat_lahir') }}" name="tempat_lahir" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" value="{{ old('tgl_lahir') }}" name="tgl_lahir" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">ID Jenis Kelamin</label>
                            <select class="form-control" name="id_jenis_kelamin" required>
                                <option selected disabled>-- Pilih Jenis Kelamin --</option>
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender->id_jenis_kelamin }}" @if (old('id_jenis_kelamin') == $gender->id_jenis_kelamin) selected @endif>{{ $gender->jenis_kelamin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Agama</label>
                            <select class="form-control" name="id_agama" required>
                                <option selected disabled>-- Pilih Agama --</option>
                                @foreach ($agamas as $agama)
                                    <option value="{{ $agama->id_agama }}" @if (old('id_agama') == $agama->id_agama) selected @endif>{{ $agama->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" value="{{ old('pekerjaan') }}" name="pekerjaan" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Status Kawin</label>
                            <select class="form-control" name="id_status_kawin" id="id_status_kawin" required>
                                <option selected disabled>-- Pilih Status Kawin --</option>
                                @foreach ($statuskawins as $statuskawin)
                                    <option value="{{ $statuskawin->id_status_kawin }}" @if (old('id_status_kawin') == $statuskawin->id_status_kawin) selected @endif>{{ $statuskawin->status_kawin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="penjamin mt-5" id="penjamin">
                    <h5>Penjamin</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Nik Pasangan Penjamin</label>
                            <input type="text" value="{{ old('nik_pasangan_penjamin') }}" maxlength="16" name="nik_pasangan_penjamin" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Pasangan Penjamin</label>
                            <input type="text" value="{{ old('nama_pasangan_penjamin') }}" name="nama_pasangan_penjamin" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                            <input type="text" value="{{ old('alamat_ktp_pasangan_penjamin') }}" name="alamat_ktp_pasangan_penjamin" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                            <input type="text" value="{{ old('alamat_tinggal_pasangan_penjamin') }}" name="alamat_tinggal_pasangan_penjamin" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Hubungan Penjamin</label>
                            <input type="text" value="{{ old('hubungan_penjamin') }}" name="hubungan_penjamin" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Penjamin</label>
                            <input type="text" value="{{ old('no_telp_penjamin') }}" name="no_telp_penjamin" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="pic mt-5" id="pic">
                    <h5>PIC</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">NIK Kontak PIC</label>
                            <input type="text" value="{{ old('nik_kontak_pic') }}" maxlength="16" name="nik_kontak_pic" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Kontak PIC</label>
                            <input type="text" value="{{ old('nama_kontak_pic') }}" name="nama_kontak_pic" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Kontak PIC</label>
                            <input type="text" value="{{ old('alamat_tinggal_kontak_pic') }}" name="alamat_tinggal_kontak_pic" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email Kontak PIC</label>
                            <input type="text" value="{{ old('email_kontak_pic') }}" name="email_kontak_pic" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">No Telp Kontak PIC</label>
                            <input type="text" value="{{ old('no_telp_kontak_pic') }}" name="no_telp_kontak_pic" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Hubungan Kontak PIC</label>
                            <input type="text" value="{{ old('hubungan_kontak_pic') }}" name="hubungan_kontak_pic" class="form-control" required>
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
        $(document).ready(function() {
            var status = $('#id_status_kawin').val();
            console.log(status)
            if (status == 1) {
                $('#penjamin').css('display', 'block')
            } else {
                $('#penjamin').css('display', 'none')
            }

            $('#id_status_kawin').on('change', function() {
                var status = $(this).val();

                if (status == 1) {
                    $('#penjamin').css('display', 'block')
                } else {
                    $('#penjamin').css('display', 'none')
                }
            })
        })
    </script>
@endsection
