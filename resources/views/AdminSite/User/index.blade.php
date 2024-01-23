@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Users</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('users.create') }}" style="margin-right: 10px;">Add User</a>
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('BlastEmailKaryawan') }}" onclick="confirmBlastEmail('BlastEmailKaryawan', event)" style="margin-right: 10px;">Send Blast Email Karyawan</a>
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('BlastEmail') }}" onclick="confirmBlastEmailTenant('BlastEmail', event)" style="margin-right: 10px;">Send Blast Email Tenant</a>
            </div>
        </div>
    </div>

    <div class="p-5">
        <div id="tableExample3" data-list='{"valueNames":["nama_user", "nama_site", "login_user"],"page":12,"pagination":true}'>
            <div class="row justify-content-end g-0">
                <div class="col-auto col-sm-5 mb-3">
                    <form>
                        <div class="input-group"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search..." aria-label="search" />
                            <div class="input-group-text bg-transparent"><span class="fa fa-search fs--1 text-600"></span></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table table-bordered table-striped fs--1 mb-0">
                    <thead class="bg-200 text-900">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama User</th>
                            <th scope="col">ID Site</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td class="login_user">{{ $user->login_user }}</td>
                            <td class="nama_user">{{ $user->nama_user }}</td>
                            <td class="id_site">{{ $user->id_site }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form class="d-inline" action="{{ route('users.destroy', $user->id_user) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('are you sure?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function confirmBlastEmail(route, event) {
        var userConfirmed = confirm('Are you sure you want to send a blast email?');

        if (!userConfirmed) {
            event.preventDefault();
        }
    }
</script>
<script>
    function confirmBlastEmailTenant(route, event) {
        var userConfirmed = confirm('Are you sure you want to send a blast email?');

        if (!userConfirmed) {
            event.preventDefault();
        }
    }
</script>
@endsection

