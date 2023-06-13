@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/dropzone/dropzone.min.css') }}" rel="stylesheet" />
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
            <form method="post" action="{{ route('open-tickets.store') }}" enctype="multipart/form-data" id="my-awesome-dropzone">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Request</label>
                    <input type="text" maxlength="50" value="{{ old('judul_request') }}" name="judul_request"
                        class="form-control" required>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">No HP</label>
                            <input type="text" value="{{ old('no_hp') }}" maxlength="13" name="no_hp"
                                class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Unit</label>
                            <select name="id_unit" class="form-control">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->unit->id_unit }}">{{ $unit->unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi Request</label>
                    <textarea class="form-control" name="deskripsi_request" id="" cols="30" rows="10"></textarea>
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
    <script src="{{ asset('assets/vendors/dropzone/dropzone.min.js') }}"></script>
@endsection
