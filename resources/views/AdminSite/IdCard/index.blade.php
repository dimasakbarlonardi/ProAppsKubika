@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-light">List ID Card</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('idcards.create') }}">Tambah ID Card</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="card_id_name">Card ID Name</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($idcards as $key => $idcard)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $idcard->card_id_name }}</td>
                        <td>
                            <a href="{{ route('idcards.edit', $idcard->id_card_type) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('idcards.destroy', $idcard->id_card_type) }}" method="post">
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

