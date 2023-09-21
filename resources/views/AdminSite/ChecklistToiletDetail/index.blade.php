@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">List Inspection HouseKeeping</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistahus.store') }}">
                @csrf
                <div class="row">
                    <div class="p-5">
                        <table class="table table-striped" id="table-housekeepinghistory">
                            <thead>
                                <tr>
                                    <th class="align-baseline" data-sort="">No</th>
                                    <th class="align-baseline" data-sort="image">Image</th>
                                    <th class="align-baseline" data-sort="equipment">Equipment</th>
                                    <th class="align-baseline" data-sort="room">Location</th>
                                    <th class="align-baseline" data-sort="inspection">Inspection HouseKeeping</th>
                                    <th class="align-baseline" data-sort="status">Status</th>
                                    <th class="align-baseline" data-sort="user">CheckBy</th>
                                    <th class="align-baseline" data-sort="tgl_checklist">Check Date</th>
                                    <th class="align-baseline" data-sort="keterangan">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="checklist_body">
                                @foreach ($equiqmentdetails as $key => $detail)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>
                                            <a href="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                                data-bs-toggle="modal" data-bs-target="#error-modal"
                                                data-image="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}">
                                                <img src="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                                    alt="{{ $detail->image }}" class="img-thumbnail rounded-circle"
                                                    style="max-width: 50px; height: 50px">
                                            </a>
                                        </td>
                                        <td>{{ $detail->equipment->equipment }}</td>
                                        <td>{{ $detail->Room->nama_room }}</td>
                                        <td scope="row">

                                        </td>
                                        <td>

                                        </td>
                                        <td>{{ $detail->role->nama_role }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($detail->usage_return)->format(' d M Y') }}
                                        </td>
                                        <td>{{ $detail->keterangan }}</td>
                                    </tr>
                                    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document"
                                            style="max-width: 500px">
                                            <div class="modal-content position-relative">
                                                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                    <button
                                                        class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <img id="modal-image"
                                                    src="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                                    alt="{{ $detail->image }}" class="img-thumbnail">
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-housekeepinghistory');
    </script>
    <script>
        const modal = new bootstrap.Modal(document.getElementById('error-modal'));
        const modalImage = document.getElementById('modal-image');

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault();
                const imageSrc = element.getAttribute('data-image');
                modalImage.src = imageSrc;
                modal.show();
            });
        });
    </script>
@endsection
