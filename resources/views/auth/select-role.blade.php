@extends('auth.layout')

@section('content')
    <div class="col-md-7 d-flex flex-center">
        <div class="p-4 p-md-5 flex-grow-1">
            <div class="row flex-between-center">
                <div class="col-auto mb-5">
                    <h3 class="text-primary">Login</h3>
                </div>
            </div>
            <form method="POST" action="{{ route('updateRoleID') }}">
                @csrf
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="card-password">Select Role</label>
                    </div>
                    <select name="role_id" id="" class="form-control">
                        <option value="1">Owner</option>
                        <option value="2">Management</option>
                        <option value="3">Tenant</option>
                    </select>
                </div>
                <div class="my-5">
                    <button class="btn btn-primary d-block w-100 mt-3" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
