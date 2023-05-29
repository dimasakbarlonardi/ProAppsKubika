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
                            <div class="col-6 mb-3">
                                <label class="form-label">Nama Site</label>
                                <input type="text" value="Park Royale" class="form-control" disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Email</label>
                                <input type="email" value="{{ $karyawan->email_karyawan }}" name="email_karyawan"
                                    class="form-control" required disabled>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">E-MAIL</label>
                                <input type="text" maxlength="16" name="email_karyawan"
                                    value="{{ $karyawan->email_karyawan }}" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">NIK Karyawan</label>
                                <input type="text" maxlength="16" name="nik_karyawan"
                                    value="{{ $karyawan->nik_karyawan }}" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">ID Card</label>
                                <input type="text" maxlength="16" name="id_card_type"
                                    value="{{ $karyawan->IdCard->card_id_name }}" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Nama Karyawan</label>
                                <input type="text" name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}"
                                    class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" value="{{ $karyawan->kewarganegaraan }}"
                                    class="form-control" required disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Masa Berlaku ID</label>
                                <input type="date" name="masa_berlaku_id" value="{{ $karyawan->masa_berlaku_id }}"
                                    class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Alamat KTP Karyawan</label>
                                <input type="text" name="alamat_ktp_karyawan"
                                    value="{{ $karyawan->alamat_ktp_karyawan }}" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">No Telp Karyawan</label>
                                <input type="text" name="no_telp_karyawan" value="{{ $karyawan->no_telp_karyawan }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">NIK Pasangan Penjamin</label>
                                <input type="text" maxlength="16" value="{{ $karyawan->nik_pasangan_penjamin }}"
                                    name="nik_pasangan_penjamin" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" value="{{ $karyawan->tgl_masuk }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tanggal Keluar</label>
                                <input type="date" name="tgl_keluar" value="{{ $karyawan->tgl_keluar }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Departement</label>
                                <input type="text" name="id_departemen" value="{{ $karyawan->Departemen }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Divisi</label>
                                <input type="text" name="id_divisi" value="{{ $karyawan->Divisi->nama_divisi }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="id_jabatan" value="{{ $karyawan->Jabatan->nama_jabatan }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Penempatan</label>
                                <input type="text" name="id_penempatan" value="{{ $karyawan->Penempatan->lokasi_penempatan }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" value="{{ $karyawan->tgl_keluar }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ $karyawan->tgl_keluar }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Agama</label>
                                <input type="text" name="id_agama" value="{{ $karyawan->Agama->nama_agama }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <input type="text" name="id_jenis_kelamin" value="{{ $karyawan->jeniskelamin->jenis_kelamin }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status Kawin</label>
                                <select class="form-control" name="id_status_kawin" id="id_status_kawin" required disabled>
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
                <div class="penjamin mt-5" id="penjamin">
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
                                <label class="form-label">NIK Karyawan</label>
                                <input type="text" maxlength="16" name="nik_karyawan"
                                    value="{{ $karyawan->nik_karyawan }}" class="form-control" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                                <input type="text" name="alamat_ktp_pasangan_penjamin"
                                    value="{{ $karyawan->alamat_ktp_pasangan_penjamin }}" class="form-control" required
                                    disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                                <input type="text" name="alamat_tinggal_pasangan_penjamin"
                                    value="{{ $karyawan->alamat_tinggal_pasangan_penjamin }}" class="form-control"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Hubungan Penjamin</label>
                                <input type="text" name="hubungan_penjamin"
                                    value="{{ $karyawan->hubungan_penjamin }}" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">No Telp Penjamin</label>
                                <input type="text" name="no_telp_penjamin" value="{{ $karyawan->no_telp_penjamin }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
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
