@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-white">List Pembayaran</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('bayarnons.create') }}">Tambah Pembayaran</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="bayarnon">Pembayaran</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bayarnons as $key => $bayarnon)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $bayarnon->bayarnon }}</td>
                        <td>
                            <a href="{{ route('bayarnons.edit', $bayarnon->id_bayarnon) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('bayarnons.destroy', $bayarnon->id_bayarnon) }}" method="post">
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

