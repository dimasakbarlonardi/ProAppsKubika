@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Utility</h6>
                </div>
                {{-- <div class="col-auto d-flex ">
                <a class="btn btn-falcon-default btn-sm dropdown-toggle ms-2 dropdown-caret-none" href="{{ route('utilitys.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Utility</a>
            </div> --}}
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="nama_utility">Nama Utility</th>
                        <th class="sort" data-sort="biaya_admin">Biaya Admin</th>
                        <th class="sort" data-sort="biaya_tetap">Biaya Tetap Abodemen</th>
                        <th class="sort" data-sort="biaya_m3">Biaya</th>
                        <th class="sort" data-sort="biaya_ppj">Biaya PPJ</th>
                        <th class="sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($utilitys as $key => $utility)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>

                            <td>{{ $utility->nama_utility }}</td>
                            <td>{{ RupiahNumber($utility->biaya_admin) }}</td>
                            <td>{{ RupiahNumber($utility->biaya_tetap) }}</td>
                            <td>
                                {{ DecimalRupiahRP($utility->biaya_m3) }}
                                @if ($utility->id_utility == 1)
                                    / KwH
                                @else
                                    / M <sup>3</sup>
                                @endif
                            </td>
                            <td>{{ DecimalRupiah($utility->biaya_ppj) }} %</td>
                            <td>
                                <a href="{{ route('utilitys.edit', $utility->id_utility) }}" class="btn btn-sm btn-warning">
                                    <span class="fas fa-pencil-alt fs--2 me-1"></span>Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
