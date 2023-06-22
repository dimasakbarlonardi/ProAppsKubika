@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Engeneering DeepWheel</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('engdeeps.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Engeneering DeepWheel</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="nama_eng_deep">Nama Engeneering DeepWheel</th>
                    <th class="sort" data-sort="subject">Subject</th>
                    <th class="sort" data-sort="dsg">DSG</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($engdeeps as $key => $engdeep)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $engdeep->nama_eng_deep }}</td>
                        <td>{{ $engdeep->subject }}</td>
                        <td>{{ $engdeep->dsg }}</td>
                        <td>
                            <a href="{{ route('engdeeps.edit', $engdeep->id_eng_deep) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('engdeeps.destroy', $engdeep->id_eng_deep) }}" method="post">
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

