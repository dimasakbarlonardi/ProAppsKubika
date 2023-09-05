@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="card">
<div class="card-header py-2">
    <div class="row flex-between-center">
        <div class="my-3 col-auto">
            <h6 class="mb-0 text-white">List Inspection Gartur Security</h6>
            </div>
                </div>
                </div>
                    <div class="p-5">
                        <button class="btn btn-primary mb-4" type="button" class="fas fa-plus" data-bs-toggle="modal" data-bs-target="#error-modal">+ Import Excel</button>
                        <table class="table" id="table-security">
                            <thead>
                                <tr>
                                    <th class="sort" data-sort="">No</th>
                                    <th class="sort" data-sort="equiqment">Guard</th>
                                    <th class="sort" data-sort="id_room">CheckPoint Name</th>
                                    <th class="sort" data-sort="tgl_patrol">Patrol Date</th>
                                </tr>
                            </thead>
                            <tbody id="checklist_body">
                                @foreach ($securitys as $key => $security)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $security->id_guard}}</td>
                                    <td>{{ $security->checkpoint_name }}</td>
                                    <td>{{ $security->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                          <div class="modal-content position-relative">
                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                              <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                              <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                <h4 class="mb-4" id="modalExampleDemoLabel">Upload Excel File </h4>
                                
                                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" name="excel_file" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </form>
                                
                            </div>
                            </div>
                            <div class="modal-footer">
                              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>

        </div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#table-security');
</script>
@endsection
