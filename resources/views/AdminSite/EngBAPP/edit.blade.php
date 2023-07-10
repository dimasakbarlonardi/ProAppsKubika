@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Role</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('roles.update', $role->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nama Role</label>
                            <input type="text" name="nama_role" value="{{ $role->nama_role }}" class="form-control"
                                required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Work Relation</label>
                            <select class="form-control" name="work_relation_id" id="work_relation_id" required>
                                <option selected disabled>-- Pilih Work Relation --</option>
                                @foreach ($work_relations as $work_relation)
                                    <option value="{{ $work_relation->id_work_relation }}"
                                        {{ $work_relation->id_work_relation == $role->work_relation_id ? 'selected' : '' }}>
                                        {{ $work_relation->work_relation }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
