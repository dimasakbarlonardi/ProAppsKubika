@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Perhitungan Denda</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('perhitdendas.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Perhitungan Denda</a>
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
                @foreach ($perhitdendas as $key => $perhitdenda)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $perhitdenda->jenis_denda }}</td>
                        <td>{{ $perhitdenda->denda_flat_procetage ? persen($perhitdenda->denda_flat_procetage) : '-' }}</td>
                        <td>{{ $perhitdenda->denda_flat_amount ? rupiah($perhitdenda->denda_flat_amount) : '-' }}</td>
                        <td>
                            <a href="{{ route('perhitdendas.edit', $perhitdenda->id_perhit_denda) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('perhitdendas.destroy', $perhitdenda->id_perhit_denda) }}" method="post">
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