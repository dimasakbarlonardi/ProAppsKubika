@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">

            </div>
        </div>
        <div class="card-body bg-light">

            <img class="card-img-top" src="" alt="" />
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-xxl-9">
                        <div class="card">
                            <div class="card">
                                <div class="card-header d-flex flex-between-center">
                                    <h6 class="mb-0">Work Request Detail</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" name="deskripsi_wr" id="deskripsi_wr" cols="10" rows="5" disabled>
                                                {!! $wr->deskripsi_wr !!}
                                            </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                                    <input type="text" class="form-control" disabled value="{{ $wr->status_request }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($wr->status_request == 'WORK DONE' && $user->id_role_hdr == $approve->approval_1)
                    <div class="text-center">
                        {{-- <form action="{{ route('doneWR', $wr->id) }}" method="post">
                            @csrf --}}
                            <button type="button" class="btn btn-success btn-lg my-4" onclick="doneButton({{ $wr->id }})" type="button">
                                Selesai
                            </button>
                        {{-- </form> --}}
                        <small class="d-block">For any technical issues faced, please contact
                            <a href="#!">Customer Support</a>.</small>
                    </div>
                @endif
                @if ($wr->status_request == 'DONE' && $user->id_user == $approve->approval_2)
                    <div class="text-center">
                        <form action="{{ route('completeWR', $wr->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg my-4" type="button">
                                Complete
                            </button>
                        </form>
                        <small class="d-block">For any technical issues faced, please contact
                            <a href="#!">Customer Support</a>.</small>
                    </div>
                @endif
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

        function doneButton(id) {
            let token = "{{ Request::session()->get('token') }}";

            $.ajax({
                url: `/api/v1/done/work-request/${id}`,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                type: 'POST',
                success: function(resp) {
                    if (resp.meta.code === 200) {
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
