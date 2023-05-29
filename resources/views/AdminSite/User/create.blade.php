@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Akun</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('users.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="email" class="form-control" id="email">
                        @foreach ($data['email'] as $key => $item)
                            <option value="{{ $item }}">{{ $data['nik'][$key] }} - {{ $data['nama'][$key] }} - {{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password_user" class="form-control" required>
                </div>
                {{-- <div class="mb-3">
                    <label class="form-label">ID Status User</label>
                    <input type="text" name="id_status_user" class="form-control">
                </div> --}}
                <div class="mb-3">
                    <label class="form-label">ID Role HDR</label>
                    <select name="id_role_hdr" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('#email').select2({
            theme: 'bootstrap-5'
        });
    </script>
@endsection
