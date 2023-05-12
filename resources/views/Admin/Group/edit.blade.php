@extends('layouts.master')

@section('header')
    Edit Group
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Group</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('groups.update', $group->id_group) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">ID Group</label>
                            <input type="text" maxlength="2" name="id_group" value="{{ $group->id_group }}" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Group</label>
                            <input type="text" name="nama_group" class="form-control" value="{{ $group->nama_group }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="10" required>
                                {!! $group->alamat !!}
                            </textarea>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input value="{{ $group->kode_pos }}" type="text" name="kode_pos" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Telp 1</label>
                                <input value="{{ $group->no_telp1 }}" type="text" name="no_telp1" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Telp 2 (optional)</label>
                                <input value="{{ $group->no_telp2 }}" type="text" name="no_telp2" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input value="{{ $group->email }}" type="email" name="email" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <input value="{{ $group->provinsi }}" type="text" name="provinsi" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Facebook</label>
                                <input value="{{ $group->fb }}" type="text" name="fb" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Instagram</label>
                                <input value="{{ $group->ig }}" type="text" name="ig" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
