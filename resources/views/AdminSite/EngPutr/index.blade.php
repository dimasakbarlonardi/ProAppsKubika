@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Engeneering Putr</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('engputrs.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Engeneering Putr</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="nama_eng_putr">Nama Engeneering Putr</th>
                    <th class="sort" data-sort="subject">Subject</th>
                    <th class="sort" data-sort="dsg">DSG</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($engputrs as $key => $engputr)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $engputr->nama_eng_putr }}</td>
                        <td>{{ $engputr->subject }}</td>
                        <td>{{ $engputr->dsg }}</td>
                        <td>
                            <a href="{{ route('engputrs.edit', $engputr->id_eng_putr) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('engputrs.destroy', $engputr->id_eng_putr) }}" method="post">
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

