@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Jenis Denda</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('jenisdendas.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Jenis Denda</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="jenis_denda">Jenis Denda</th>
                    <th class="sort" data-sort="denda_flat_procetage">Denda Flat Procetage</th>
                    <th class="sort" data-sort="denda_flat_amount">Denda Flat Amount</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenisdendas as $key => $jenisdenda)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $jenisdenda->jenis_denda }}</td>
                        <td>{{ $jenisdenda->denda_flat_procetage ? persen($jenisdenda->denda_flat_procetage) : '-'}} </td>
                        <td>{{ $jenisdenda->denda_flat_amount ? rupiah($jenisdenda->denda_flat_amount) : '-' }}</td>
                        <td>
                            <a href="{{ route('jenisdendas.edit', $jenisdenda->id_jenis_denda) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('jenisdendas.destroy', $jenisdenda->id_jenis_denda) }}" method="post">
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