@extends('layouts.master')

@section('header')
    Edit Site
@endsection

@section('content')
<div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Site</h6>
                </div>
            </div>
        </div>
<div class="p-5">
    <form method="post" action="{{ route('penguruses.update', $pengurus->id_pengurus) }}">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-5">
                    <label class="form-label">Group</label>
                    <select class="form-control" name="id_group" required>
                        <option selected disabled>-- Pilih Group --</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id_group }}" {{ $group->id_group == $pengurus->id_group ? 'selected' : '' }}>{{ $group->nama_group }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5">
                    <label class="form-label">Nama Pengurus</label>
                    <input type="text" name="nama_pengurus" value="{{ $pengurus->nama_pengurus }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="10" required>
                        {!! $pengurus->alamat !!}
                    </textarea>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input value="{{ $pengurus->kode_pos }}" type="text" name="kode_pos" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp 1</label>
                        <input value="{{ $pengurus->no_telp1 }}" type="text" name="no_telp1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp 2 (optional)</label>
                        <input value="{{ $pengurus->no_telp2 }}" type="text" name="no_telp2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input value="{{ $pengurus->email }}" type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <input value="{{ $pengurus->provinsi }}" type="text" name="provinsi" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Facebook</label>
                        <input value="{{ $pengurus->fb }}" type="text" name="fb" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Instagram</label>
                        <input value="{{ $pengurus->ig }}" type="text" name="ig" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>
@endsection
