@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Detail Karyawan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('karyawans.update', $karyawan->id) }}">
                @method('PUT')
                @csrf
                <div class="karyawan">
                    <h5>Karyawan</h5>
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Site</label>
                                <input type="text" value="Park Royale" class="form-control" disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">User</label>
                                <select class="form-control" name="id_user" required disabled>
                                    <option selected disabled>-- Pilih ID User --</option>
                                    @foreach ($idusers as $iduser)
                                        <option value="{{ $iduser->id }}"
                                            {{ $iduser->id == $karyawan->id_user ? 'selected' : '' }}>
                                            {{ $iduser->nama_user }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">ID Card Karyawan</label>
                                <select class="form-control" name="id_card_type" required disabled>
                                    <option selected disabled>-- Pilih ID Card --</option>
                                    @foreach ($idcards as $idcard)
                                        <option value="{{ $idcard->id_card_type }}"
                                            {{ $idcard->id_card_type == $karyawan->id_card_type ? 'selected' : '' }}>
                                            {{ $idcard->card_id_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">NIK Karyawan</label>
                                <input type="text" maxlength="16" name="nik_karyawan"
                                    value="{{ $karyawan->nik_karyawan }}" class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Karyawan</label>
                                <input type="text" name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}"
                                    class="form-control" required disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" value="{{ $karyawan->kewarganegaraan }}"
                                    class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Masa Berlaku ID</label>
                                <input type="date" name="masa_berlaku_id" value="{{ $karyawan->masa_berlaku_id }}"
                                    class="form-control" required disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Alamat KTP Karyawan</label>
                                <input type="text" name="alamat_ktp_karyawan"
                                    value="{{ $karyawan->alamat_ktp_karyawan }}" class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">No Telp Karyawan</label>
                                <input type="text" name="no_telp_karyawan" value="{{ $karyawan->no_telp_karyawan }}"
                                    class="form-control" required disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">NIK Pasangan Penjamin</label>
                                <input type="text" maxlength="16" value="{{ $karyawan->nik_pasangan_penjamin }}"
                                    name="nik_pasangan_penjamin" class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" value="{{ $karyawan->tgl_masuk }}"
                                    class="form-control" required disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tanggal Keluar</label>
                                <input type="date" name="tgl_keluar" value="{{ $karyawan->tgl_keluar }}"
                                    class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Departement</label>
                                <select class="form-control" name="id_departemen" required disabled>
                                    <option selected disabled>-- Pilih Departement --</option>
                                    @foreach ($departemens as $departemen)
                                        <option value="{{ $departemen->id_departemen }}"
                                            {{ $departemen->id_departemen == $karyawan->id_departemen ? 'selected' : '' }}>
                                            {{ $departemen->nama_departemen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Divisi</label>
                                <select class="form-control" name="id_divisi" required disabled>
                                    <option selected disabled>-- Pilih Divisi --</option>
                                    @foreach ($divisis as $divisi)
                                        <option value="{{ $divisi->id_divisi }}"
                                            {{ $divisi->id_divisi == $karyawan->id_divisi ? 'selected' : '' }}>
                                            {{ $divisi->nama_divisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Jabatan</label>
                                <select class="form-control" name="id_jabatan" required disabled>
                                    <option selected disabled>-- Pilih Jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id_jabatan }}"
                                            {{ $jabatan->id_jabatan == $karyawan->id_jabatan ? 'selected' : '' }}>
                                            {{ $jabatan->nama_jabatan }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Penempatan</label>
                                <select class="form-control" name="id_penempatan" required disabled>
                                    <option selected disabled>-- Pilih Penempatan --</option>
                                    @foreach ($penempatans as $penempatan)
                                        <option value="{{ $penempatan->id_penempatan }}"
                                            {{ $penempatan->id_penempatan == $karyawan->id_penempatan ? 'selected' : '' }}>
                                            {{ $penempatan->lokasi_penempatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" value="{{ $karyawan->tgl_keluar }}"
                                    class="form-control" required disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ $karyawan->tgl_keluar }}"
                                    class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Agama</label>
                                <select class="form-control" name="id_agama" required disabled>
                                    <option selected disabled>-- Pilih Agama --</option>
                                    @foreach ($agamas as $agama)
                                        <option value="{{ $agama->id_agama }}"
                                            {{ $agama->id_agama == $karyawan->id_agama ? 'selected' : '' }}>
                                            {{ $agama->nama_agama }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control" name="id_jenis_kelamin" required disabled>
                                    <option selected disabled>-- Pilih Jenis Kelamin --</option>
                                    @foreach ($jeniskelamins as $jeniskelamin)
                                        <option value="{{ $jeniskelamin->id_jenis_kelamin }}"
                                            {{ $jeniskelamin->id_jenis_kelamin == $karyawan->id_jenis_kelamin ? 'selected' : '' }}>
                                            {{ $jeniskelamin->jenis_kelamin }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Status Kawin</label>
                                <select class="form-control" name="id_status_kawin" required disabled>
                                    <option selected disabled>-- Pilih Status Kawin --</option>
                                    @foreach ($statuskawins as $statuskawin)
                                        <option value="{{ $statuskawin->id_status_kawin }}"
                                            {{ $statuskawin->id_status_kawin == $karyawan->id_status_kawin ? 'selected' : '' }}>
                                            {{ $statuskawin->status_kawin }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="penjamin mt-5">
                    <h5>Penjamin</h5>
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Pasangan Penjamin</label>
                                <input type="text" name="nama_pasangan_penjamin"
                                    value="{{ $karyawan->nama_pasangan_penjamin }}" class="form-control" required
                                    disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                                <input type="text" name="alamat_ktp_pasangan_penjamin"
                                    value="{{ $karyawan->alamat_ktp_pasangan_penjamin }}" class="form-control" required
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                                <input type="text" name="alamat_tinggal_pasangan_penjamin"
                                    value="{{ $karyawan->alamat_tinggal_pasangan_penjamin }}" class="form-control"
                                    required disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Hubungan Penjamin</label>
                                <input type="text" name="hubungan_penjamin"
                                    value="{{ $karyawan->hubungan_penjamin }}" class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">No Telp Penjamin</label>
                                <input type="text" name="no_telp_penjamin" value="{{ $karyawan->no_telp_penjamin }}"
                                    class="form-control" required disabled>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <div class="mb-3">
                    <div class="row">
                        <div class="col-5">
                            <label class="form-label">ID Status Karyawan</label>
                            <select class="form-control" name="id_status_karyawan" required disabled>
                                <option selected disabled>-- Pilih Status Karyawan --</option>
                                @foreach ($statuspemiliks as $statuspemilik)
                                <option value="{{ $statuspemilik->id_status_aktif_pemilik }}">{{ $statuspemilik->status_hunian_pemilik }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <label class="form-label">ID Status Kawin Karyawan</label>
                            <select class="form-control" name="id_status_kawin_karyawan" required disabled>
                                <option selected disabled>-- Pilih Status Pemilik --</option>
                                @foreach ($statuskawinkaryawans as $statuskawinkaryawan)
                                <option value="{{ $statuskawinkaryawan->id_status_kawin_karyawan }}">{{ $statuskawinkaryawan-> }}</option>
                                @endforeach
                            </select>
                        </div>
                       <div class="col-5">
                            <label class="form-label">ID Status Aktif Karyawan</label>
                            <select class="form-control" name="id_status_aktif_karyawan" required disabled>
                                <option selected disabled>-- Pilih Status Pemilik --</option>
                                @foreach ($statusaktifkaryawans as $statusaktifkaryawan)
                                <option value="{{ $statusaktifkaryawan->id_status_aktif_karyawan }}">{{ $statusaktifkaryawan-> }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> --}}
                <div class="text-end">
                    <a class="btn btn-warning" id="button-cancel" style="display: none;">Cancel</a>
                    <button type="submit" class="btn btn-success" style="display: none"
                        id="button-update">Update</button>
                </div>
            </form>
            <div class="text-end">
                <a class="btn btn-primary" id="button-edit">Edit</a>
                <form class="d-inline" action="{{ route('karyawans.destroy', $karyawan->id) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-danger"
                        id="button-delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var isEdit = false;
        $('document').ready(function() {
            // $('#button-edit').on('click', function() {
            //     isEdit = !isEdit;
            //     if (isEdit) {
            //         $('#button-back').css('display', 'inline')
            //         $('#button-edit').css('display', 'none');
            //         $('#button-update').css('display', 'inline');
            //         $('#button-delete').css('display', 'none');
            //         $('.form-control').removeAttr('disabled');
            //     } else {
            //         $('.form-control').prop('disabled', true);
            //     }
            // })
            // $('#button-back').on('click', function() {
            //     if (isEdit) {
            //         $('.form-control').prop('disabled', true);
            //     } else {
            //         $('#button-back').css('display', 'none')
            //         $('#button-edit').css('display', 'inline');
            //         $('#button-update').css('display', 'none');
            //         $('#button-delete').css('display', 'inline');
            //     }
            // })
            $('#button-edit').on('click', function() {
                $('.form-control').removeAttr('disabled');
                $('#button-edit').css('display', 'none')
                $('#button-update').css('display', 'inline')

                $('#button-back').css('display', 'none')
                $('#button-cancel').css('display', 'inline')
                $('#button-delete').css('display', 'none')
            })

            $('#button-cancel').on('click', function() {
                $('.form-control').prop('disabled', true);
                $('#button-edit').css('display', 'inline')
                $('#button-update').css('display', 'none')

                $('#button-back').css('display', 'inline')
                $('#button-cancel').css('display', 'none')
                $('#button-delete').css('display', 'inline')

            })
        })
    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
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
                        <label class="form-label">ID Card Karyawan</label>
                        <input type="text" value="{{$karyawan->IdCard->card_id_name}}" class="form-control" readonly>
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
                        <input type="text" value="{{$karyawan->Jabatan->nama_jabatan}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Divisi</label>
                        <input type="text" value="{{$karyawan->Divisi->nama_divisi}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Departement</label>
                        <input type="text" value="{{$karyawan->Departemen->nama_departemen}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Penempatan</label>
                        <input type="text" value="{{$karyawan->Penempatan->lokasi_penempatan}}" class="form-control" readonly>
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
                        <input type="text" value="{{$karyawan->JenisKelamin->jenis_kelamin}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Agama</label>
                        <input type="text" value="{{$karyawan->Agama->nama_agama}}" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ID Status Kawin</label>
                        <input type="text" value="{{$karyawan->StatusKawin->status_kawin}}" class="form-control" readonly>
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
