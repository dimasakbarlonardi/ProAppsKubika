@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Package</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="image">Image</th>
                        <th class="sort" data-sort="package_receipt_number">Receipt Number</th>
                        <th class="sort" data-sort="unit">Unit</th>
                        <th class="sort" data-sort="courier_type">Courier</th>
                        <th class="sort" data-sort="received_location">Received Location</th>
                        <th class="sort" data-sort="receive_time">Pickup DateTime</th>
                        <!-- <th class="sort" data-sort="status">Description</th> -->
                        <th class="sort" data-sort="status">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                <a href="{{ $item->image ? asset($item->image) : asset('/assets/img/team/3-thumb.png') }}"
                                    data-bs-toggle="modal" data-bs-target="#error-modal"
                                    data-image="{{ $item->image ? asset($item->image) : asset('/assets/img/team/3-thumb.png') }}">
                                    <img src="{{ $item->image ? asset($item->image) : asset('/assets/img/team/3-thumb.png') }}"
                                        alt="{{ $item->image }}" class="img-thumbnail "
                                        style="max-width: 50px; height: 50px">
                                </a>
                            </td>
                            <td>{{ $item->package_receipt_number }}</td>
                            <td>{{ $item->Unit->nama_unit }}</td>
                            <td>{{ $item->courier_type }}</td>
                            <td>{{ $item->received_location}}</td>
                            <td>{{ HumanDateTime($item->created_at) }} </td>
                            <!-- <td>{{ $item->description}}</td>  -->
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                <div class="modal-content position-relative">
                    {{-- <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                      <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> --}}
                    <img id="modal-image"
                        {{-- src="{{ $packages->image ? asset($packages->image) : asset('/assets/img/team/3-thumb.png') }}" --}}>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-package');
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