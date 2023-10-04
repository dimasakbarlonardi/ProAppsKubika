@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Buat Ticket</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('open-tickets.store') }}" enctype="multipart/form-data"
                id="my-awesome-dropzone">
                @csrf
                <div class="row">
                <div class="mb-3">
                    <label class="form-label">Jenis Request</label>
                    <select name="id_jenis_request" class="form-control" id="id_jenis_request">
                        @foreach ($jenis_requests as $jr)
                            <option value="{{ $jr->id_jenis_request }}">{{ $jr->jenis_request }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Request</label>
                    <input type="text" maxlength="50" value="{{ old('judul_request') }}" name="judul_request"
                        class="form-control" required>
                </div>
                <!-- <div class="mb-3"> -->
                        <div class="col-6">
                            <label class="form-label">No HP</label>
                            <input type="text" value="{{ old('no_hp') }}" maxlength="13" name="no_hp"
                                class="form-control" required>
                        </div>
                        @if ($user->user_category == 2)
                            <div class="col-6">
                                <label class="form-label">Tenant</label>
                                <select class="form-control" id="id_tenant">
                                    <option disabled selected>-- Pilih Tenant ---</option>
                                    @foreach ($tenants as $tenant)
                                        <option value="{{ $tenant->id_tenant }}">{{ $tenant->nama_tenant }} -
                                            {{ $tenant->email_tenant }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="col-6">
                                <label class="form-label">Unit</label>
                                <select name="id_unit" class="form-control" id="id_unit">
                                    @if ($user->user_category != 2)
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->unit->id_unit }}">{{ $unit->unit->nama_unit }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif
                    <!-- </div> -->
                </div>
                <div class="mb-3">
                    @if ($user->user_category == 2)
                        <div class="col-6">
                            <label class="form-label">Unit</label>
                            <select name="id_unit" class="form-control" id="id_unit">
                                @if ($user->user_category != 2)
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->unit->id_unit }}">{{ $unit->unit->nama_unit }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi Request</label>
                    <textarea class="form-control" name="deskripsi_request" id="myeditorinstance" cols="30" rows="10"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload Foto</label>
                    <input class="form-control" type="file" name="upload_image" />
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });

        $('#id_tenant').on('change', function() {
            $('#id_unit').html('');
            var id_tenant = $(this).val();
            $.ajax({
                url: '/admin/units-by-tenant/' + id_tenant,
                type: 'GET',
                success: function(resp) {
                    resp.data.map((item, i) => {
                        $('#id_unit').append(
                            `
                                <option value="${item.unit.id_unit}">${item.unit.nama_unit}</option>
                            `
                        )
                    })
                }
            })
        })
    </script>
@endsection
