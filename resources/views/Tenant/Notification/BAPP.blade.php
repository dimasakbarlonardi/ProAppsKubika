@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
       
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-8">
                    <div class="card" id="permit_detail">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Work Permit</h6>
                        </div>
                        <div class="px-5">
                            <div class="my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">No Tiket</label>
                                        <input type="text" class="form-control"
                                            value="{{ $bapp->no_tiket }}" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">No Request Permit</label>
                                        <input type="text" class="form-control" value="{{ $bapp->no_request_permit }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">No Work Permit</label>
                                        <input value="{{ $bapp->no_work_permit }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">No BAPP</label>
                                        <input value="{{ $bapp->no_bapp }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Tanggal penyelesaian</label>
                                        <input value="{{ HumanDateTime($bapp->tgl_penyelesaian) }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Jumlah Deposit</label>
                                        <input value="{{ $bapp->jumlah_deposit }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">Jumlah Potongan</label>
                                        <input value="{{ $bapp->jumlah_potongan }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Jumlah kembali deposit</label>
                                        <input value="{{ $bapp->jumlah_kembali_deposit }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-3">
                    <div class="row g-3 position-sticky top-0">
                        <div class="col-md-6 col-xl-12 rounded-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Info BANK</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4 mt-n2"><label class="mb-1">BANK</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $bapp->bank_pemohon }}">
                                    </div>
                                    <div class="mb-4 mt-n2"><label class="mb-1">No Rekening</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $bapp->rek_pemohon }}">
                                    </div>
                                    <div class="mb-4 mt-n2"><label class="mb-1">Nama rekening</label>
                                        <input class="form-control" type="text"
                                            value="{{ $bapp->nama_rek_pemohon }}" disabled>
                                    </div>
                                </div>
                            </div>
                            @if (!$bapp->sign_approval_1 && $bapp->status_pengembalian == 1 && $bapp->Ticket->Tenant->User->id_user == $user->id_user)
                                <div class="card-footer border-top border-200 py-x1">
                                    <form action="{{ route('bappApprove1', $bapp->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">Sudah diterima</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        tinyMCE.init({
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            readonly: true,
            height: "180"
        });

        function approve4(id) {
            $.ajax({
                url: `/admin/work-permit/approve4/${id}`,
                type: 'POST',
                success: function(data) {
                    if (data.status === 'ok') {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil mengupdate Work Order!',
                            'success'
                        ).then(() => window.location.reload())
                    }
                }
            })
        }
    </script>
@endsection
