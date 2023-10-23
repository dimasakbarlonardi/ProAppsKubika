@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto d-flex my-2 align-items-center">
                    <a href="{{ route('toolsengineering.index') }}" class="btn btn-falcon-default btn-sm" style="margin-right: 15px" type="button">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                    <h6 class="mb-0 text-white">List Tools Engineering</h6>
                </div>
            </div>
        </div>
        <div class="p-5 justify-content-center">
            <table class="table" id="table-toolshk">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="name_tools">Tools</th>
                        <th class="sort" data-sort="status">Action</th>
                        <th class="sort" data-sort="status">Qty</th>
                        <th class="sort" data-sort="date_out">Borrower</th>
                        <th class="sort" data-sort="date_out">Status</th>
                    </tr>
                </thead>
                <tbody id="checklist_body">
                    @foreach ($histories as $key => $history)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $history->ENGTool->name_tools }}</td>
                            <td>{{ $history->action }}</td>
                            <td>{{ $history->qty }} {{ $history->ENGTool->unity }}</td>
                            <td>{{ $history->Borrower->nama_user }}</td>
                            <td>{{ $history->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-toolshk');

        function showModalTool(id) {
            console.log(id);
            $(`#edit-tools${id}`).modal('show')
            // if (units === 0){
            //     id_pemilik = $('#id_pemilik').val();
            //     $('#id_pemilik_modal').val(id_pemilik);
            // } else {
            //     $('#modalValidation').modal('show')
            // }
        }
    </script>
@endsection
