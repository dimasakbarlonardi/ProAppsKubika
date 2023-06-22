@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Engeneering PAM</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('engpams.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Engeneering PAM</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="nama_eng_pam">Nama Engeneering PAM</th>
                    <th class="sort" data-sort="subject">Subject</th>
                    <th class="sort" data-sort="dsg">DSG</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($engpams as $key => $engpam)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $engpam->nama_eng_pam }}</td>
                        <td>{{ $engpam->subject }}</td>
                        <td>{{ $engpam->dsg }}</td>
                        <td>
                            <a href="{{ route('engpams.edit', $engpam->id_eng_pam) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('engpams.destroy', $engpam->id_eng_pam) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')"><span class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

