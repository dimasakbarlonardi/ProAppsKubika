@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Create Sites</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('sites.store') }}">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-5">
                            <label class="form-label">Pengurus</label>
                            <select class="form-control" name="id_pengurus" required>
                                <option selected disabled>-- Pilih Pengurus --</option>
                                @foreach ($penguruses as $pengurus)
                                    <option value="{{ $pengurus->id_pengurus }}">{{ $pengurus->nama_pengurus }}</option>
                                @endforeach
                            </select>
                        </div>
                      
                        <div class="col-5">
                            <label class="form-label">Nama Site</label>
                            <input type="text" name="nama_site" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="10" required></textarea>
                        </div>
                        <div class="col-6 mt-4">
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
                                <input type="text" name="provinsi" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Facebook</label>
                            <input type="text" name="fb" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Instagram</label>
                            <input type="text" name="ig" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
