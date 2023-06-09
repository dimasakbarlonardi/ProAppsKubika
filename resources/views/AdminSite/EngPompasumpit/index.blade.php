@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Engeneering PompaSumpit</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('engpompas.create') }}">Tambah Engeneering PompaSumpit</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="nama_eng_pompasumpit">Nama Engeneering PompaSumpit</th>
                    <th class="sort" data-sort="subject">Subject</th>
                    <th class="sort" data-sort="dsg">DSG</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($engpompas as $key => $engpompa)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $engpompa->nama_eng_pompasumpit }}</td>
                        <td>{{ $engpompa->subject }}</td>
                        <td>{{ $engpompa->dsg }}</td>
                        <td>
                            <a href="{{ route('engpompas.edit', $engpompa->id_eng_pompasumpit) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('engpompas.destroy', $engpompa->id_eng_pompasumpit) }}" method="post">
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

