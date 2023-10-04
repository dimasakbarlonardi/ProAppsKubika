@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0 text-white">List GIGO</h6>
                </div>
                <div class="col-auto d-flex">
                    {{-- <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('agamas.create') }}">Tambah Agama</a> --}}
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="nama_agama">No GIGO</th>
                        <th class="sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gigos as $key => $gigo)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $gigo->no_request_gigo }}</td>
                            <td>
                                <a href="{{ route('gigo.show', $gigo->id) }}" class="btn btn-sm btn-warning">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // $('#exampleModal').modal('show');
    </script>
@endsection
