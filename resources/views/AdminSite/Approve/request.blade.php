@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit approve request</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('updateSystemApprove', $approve->id_approval_subject) }}">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Approve 1</label>
                            <select name="approval_1" class="form-control">
                                @foreach ($roles as $role)
                                    <option {{ $role->id == $approve->approval_1 ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Approve 2</label>
                            <select name="approval_2" class="form-control">
                                @foreach ($karyawans as $karyawan)
                                    <option {{ $karyawan->User->id_user == $approve->approval_2 ? 'selected' : '' }}  value="{{ $karyawan->User->id_user }}">{{ $karyawan->nama_karyawan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
