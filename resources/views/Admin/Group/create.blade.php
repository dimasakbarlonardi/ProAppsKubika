@extends('layouts.master')

@section('header')
    Create Group
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Create Group</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('groups.store') }}">
                @csrf
                <div class="mb-3">
                     <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nama Group</label>
                            <input type="text" name="nama_group" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="10" required></textarea>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" name="kode_pos" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Telp 1</label>
                                <input type="text" name="no_telp1" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Telp 2 (optional)</label>
                                <input type="text" name="no_telp2" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="email" name="provinsi" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" name="fb" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Instagram</label>
                                <input type="text" name="ig" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection
