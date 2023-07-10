{{-- @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection --}}

<div class="table-responsive scrollbar">
    <table class="table" id="table-pindah">
        <thead>
            <tr>
                <th class="sort" data-sort="">No</th>
                <th class="sort" data-sort="">Owner</th>
                <th class="sort" data-sort="">Unit</th>
                <th class="sort" data-sort="">Status Hunian</th>
                <th class="sort">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kepemilikans as $key => $kepemilikan)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $kepemilikan->Pemilik->nama_pemilik }}</td>
                    <td>
                        {{ $kepemilikan->unit->nama_unit }}
                    </td>
                    <td> {{ $kepemilikan->StatusHunianTenant->status_hunian_tenant }}</td>
                    <td>
                        <div>
                            <a class="btn btn-sm btn-warning"
                                href="{{ route('kepemilikans', $kepemilikan->id) }}">Detail</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="edit-kepemilikan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body-kepemilikan-edit p-0">

            </div>
        </div>
    </div>
</div>
