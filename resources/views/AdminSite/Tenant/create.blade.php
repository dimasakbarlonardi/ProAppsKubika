@extends('layouts.master')

@section('content')
    <style>
        #image-text {
            color: #000;
            text-align: center;
        }
    </style>
    <form method="post" action="{{ route('tenants.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 btn-reveal-trigger">
                    <div class="card-header position-relative min-vh-25 mb-8">
                        <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                                <img id="newavatar" src="" width="200" alt="Upload Foto">
                                <input class="d-none" name="profile_picture" id="input-file" type="file">
                                <label class="mb-0 overlay-icon d-flex flex-center" for="input-file">
                                    <span class="bg-holder overlay overlay-0"></span>
                                    <span class="z-1 text-white dark__text-white text-center fs--1">
                                        <svg class="svg-inline--fa fa-camera fa-w-16" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="camera" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z">
                                            </path>
                                        </svg>
                                        <span class="d-block">Update</span></span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('tenants.index') }}" class="btn btn-falcon-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="ml-3">Create Tenant</div>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <div class="tenant">
                    <h5>Tenant</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Site Name</label>
                            <input type="text" value="Park Royale" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tenant Name</label>
                            <input type="text" value="{{ old('nama_tenant') }}" name="nama_tenant" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Email Tenant</label>
                            <input type="text" value="{{ old('email_tenant') }}" name="email_tenant" class="form-control"
                                required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">NIK Tenant</label>
                            <input type="text" value="{{ old('nik_tenant') }}" maxlength="16" name="nik_tenant"
                                class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">ID Card Tenant</label>
                            <select class="form-control" name="id_card_type" required>
                                <option selected disabled>-- Pilih ID Card --</option>
                                @foreach ($idcards as $idcard)
                                    <option value="{{ $idcard->id_card_type }}"
                                        @if (old('id_card_type') == $idcard->id_card_type) selected @endif>{{ $idcard->card_id_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Status Hunian Tenant</label>
                            <select class="form-control" name="id_statushunian_tenant" required>
                                <option selected disabled>-- Pilih Status Hunian --</option>
                                @foreach ($statushunians as $statushunian)
                                    <option value="{{ $statushunian->id_statushunian_tenant }}"
                                        @if (old('id_statushunian_tenant') == $statushunian->id_statushunian_tenant) selected @endif>
                                        {{ $statushunian->status_hunian_tenant }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Citizenship</label>
                            <input type="text" value="{{ old('kewarganegaraan') }}" name="kewarganegaraan"
                                class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Province</label>
                            <input type="text" value="{{ old('provinsi') }}" name="provinsi" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">KTP Address Tenant</label>
                            <textarea type="text" rows="10" name="alamat_ktp_tenant" class="form-control" required>{{ old('alamat_ktp_tenant') }}</textarea>
                        </div>


                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Postal Code</label>
                            <input type="text" value="{{ old('kode_pos') }}" name="kode_pos" class="form-control"
                                required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Tenant </label>
                            <input type="text" value="{{ old('no_telp_tenant') }}" maxlength="13"
                                name="no_telp_tenant" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">Marriage Status</label>
                        <select class="form-control" name="id_status_kawin" id="id_status_kawin" required>
                            <option selected disabled>-- Select Marriage Status --</option>
                            @foreach ($statuskawins as $statuskawin)
                                <option value="{{ $statuskawin->id_status_kawin }}"
                                    @if (old('id_status_kawin') == $statuskawin->id_status_kawin) selected @endif>{{ $statuskawin->status_kawin }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="penjamin mt-5" id="pasangan">
                    <h5>Emergency Contact <small class="text-danger">(optional)</small></h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Contact Name</label>
                            <input type="text" value="{{ old('nama_pasangan_penjamin') }}"
                                name="nama_pasangan_penjamin" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">NIK Contact</label>
                            <input type="text" value="{{ old('nik_pasangan_penjamin') }}" maxlength="16"
                                name="nik_pasangan_penjamin" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">KTP Address Contact</label>
                            <input type="text" value="{{ old('alamat_ktp_pasangan_penjamin') }}"
                                name="alamat_ktp_pasangan_penjamin" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contact Address</label>
                            <input type="text" value="{{ old('alamat_tinggal_pasangan_penjamin') }}"
                                name="alamat_tinggal_pasangan_penjamin" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Contact Relationship</label>
                            <input type="text" value="{{ old('hubungan_penjamin') }}" name="hubungan_penjamin"
                                class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" value="{{ old('no_telp_penjamin') }}" maxlength="13"
                                name="no_telp_penjamin" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- <div class="mt-5"> --}}
                <button type="submit" class="btn btn-primary text-center mt-5">Submit</button>
                {{-- </div> --}}
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $('#input-file').change(function() {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    console.log(event.target.result);
                    $('#newavatar').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $(document).ready(function() {
            // var status = $('#id_status_kawin').val();

            // if (status == 1) {
            //     $('#penjamin').css('display', 'none')
            //     $('#pasangan').css('display', 'block')
            // } else {
            //     $('#penjamin').css('display', 'block')
            //     $('#pasangan').css('display', 'none')
            // }

            // $('#id_status_kawin').on('change', function() {
            //     var status = $(this).val();

            //     if (status == 1) {
            //         $('#penjamin').css('display', 'block')
            //         $('#pasangan').css('display', 'none')
            //     } else {
            //         $('#penjamin').css('display', 'none')
            //         $('#pasangan').css('display', 'block')
            //     }
            // })
        })
    </script>
@endsection
