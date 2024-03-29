@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">

        <div class="card-body bg-light">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xxl-6">
                    <div class="card shadow-none mb-3"><img class="card-img-top" src="" alt="" />
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xxl-12 col-xl-8">
                                    <div class="card">
                                        <div class="card">
                                            <div class="card-header d-flex flex-between-center">
                                                <h6 class="mb-0">Work Request Detail</h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <textarea class="form-control" name="deskripsi_wr" id="deskripsi_wr" cols="10" rows="5" disabled>
                                                {!! $ticket->deskripsi_request !!}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-xl-4">
                                    <div class="row g-3 position-sticky top-0">
                                        <div class="col-md-6 col-xl-12 rounded-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="mb-0">Status</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $ticket->status_request }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($sysApprove->approval_1 == $user->id_role_hdr && !$ticket->sign_approve_1)
                                                <div class="card-footer border-top border-200 py-x1">
                                                    <form action="{{ route('ticketApprove1', $ticket->id) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary w-100">Selesai</button>
                                                    </form>
                                                </div>
                                            @endif
                                            @if ($sysApprove->approval_2 == $user->id_user && !$ticket->sign_approve_2)
                                                <div class="card-footer border-top border-200 py-x1">
                                                    <form action="{{ route('ticketApprove2', $ticket->id) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary w-100">Selesai</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        tinyMCE.init({
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            readonly: true,
            height: "180"
        });
    </script>
@endsection
