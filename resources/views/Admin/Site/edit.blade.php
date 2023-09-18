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
    <form method="post" action="{{ route('sites.update', $site->id_site) }}">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-5">
                    <label class="form-label">Pengurus</label>
                    <select class="form-control" name="id_pengurus" required>
                        <option selected disabled>-- Pilih Pengurus --</option>
                        @foreach ($penguruses as $pengurus)
                            <option value="{{ $pengurus->id_pengurus }}"  {{ $site->id_pengurus == $pengurus->id_pengurus ? 'selected' : '' }}>{{ $pengurus->nama_pengurus }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label class="form-label">ID Site</label>
                    <input type="text" maxlength="6" name="id_site" value="{{ $site->id_site }}" class="form-control" required>
                </div>
                <div class="col-5">
                    <label class="form-label">Nama Site</label>
                    <input type="text" name="nama_site" value="{{ $site->nama_site }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="10" required>{!! $site->alamat !!}</textarea>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input value="{{ $site->kode_pos }}" type="text" name="kode_pos" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp 1</label>
                        <input value="{{ $site->no_telp1 }}" type="text" name="no_telp1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp 2 (optional)</label>
                        <input value="{{ $site->no_telp2 }}" type="text" name="no_telp2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input value="{{ $site->email }}" type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <input value="{{ $site->provinsi }}" type="text" name="provinsi" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Facebook</label>
                        <input value="{{ $site->fb }}" type="text" name="fb" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Instagram</label>
                        <input value="{{ $site->ig }}" type="text" name="ig" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
 </div>
</div>
@endsection
