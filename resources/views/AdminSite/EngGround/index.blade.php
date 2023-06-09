@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Engeneering Ground Roff Tank</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('enggrounds.create') }}">Tambah Engeneering Ground Roff Tank</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="nama_eng_groundrofftank">Nama Engeneering Ground Roff Tank</th>
                    <th class="sort" data-sort="subject">Subject</th>
                    <th class="sort" data-sort="dsg">DSG</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enggrounds as $key => $engground)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $engground->nama_eng_groundrofftank }}</td>
                        <td>{{ $engground->subject }}</td>
                        <td>{{ $engground->dsg }}</td>
                        <td>
                            <a href="{{ route('enggrounds.edit', $engground->id_eng_groundrofftank) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('enggrounds.destroy', $engground->id_eng_groundrofftank) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

