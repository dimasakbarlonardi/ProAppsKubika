@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Checklist AHU Detail</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('checklistahus.index') }}"><span class=""></span><< Back Check list AHU</a>
                <a class="btn btn-sm "></a>
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('ahudetails.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Check list AHU Detail</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="no_checklist_ahu">Nomer Check list AHU</th>
                    <th class="sort" data-sort="in_out">IN / OUT</th>
                    <th class="sort" data-sort="check_point">Checkout Point</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ahudetails as $key => $ahudetail)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $ahudetail->no_checklist_ahu }}</td>
                        <td>{{ $ahudetail->in_out }}</td>
                        <td>{{ $ahudetail->check_point }}</td>
                        <td>{{ $ahudetail->keterangan }}</td>
                        <td>
                            <a href="{{ route('ahudetails.edit', $ahudetail->id_ahu) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('ahudetails.destroy', $ahudetail->id_ahu) }}" method="post">
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

