@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Checklist Listrik Detail</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('listrikdetails.index') }}"><span class=""></span><< Back Check list Listrik</a>
                <a class="btn btn-sm "></a>
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('listrikdetails.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Check list Listrik Detail</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="no_checklist_listrik">Nomer Check list Listrik</th>
                    <th class="sort" data-sort="nilai">Nilai</th>
                    <th class="sort" data-sort="hasil">Hasil</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listrikdetails as $key => $listrikdetail)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $listrikdetail->no_checklist_listrik }}</td>
                        <td>{{ $listrikdetail->nilai }}</td>
                        <td>{{ $listrikdetail->hasil }}</td>
                        <td>{{ $listrikdetail->keterangan }}</td>
                        <td>
                            <a href="{{ route('listrikdetails.edit', $listrikdetail->id_eng_listrik) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('listrikdetails.destroy', $listrikdetail->id_eng_listrik) }}" method="post">
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