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
            <h6 class="mb-0 text-white">List Inspection Security</h6>
            </div>
                </div>
                </div>
                    <div class="p-5">
                        <table class="table" id="table-checklistsecurity">
                            <thead>
                                <tr>
                                    <th class="sort" data-sort="">No</th>
                                    <th class="sort" data-sort="image">Image</th>
                                    <th class="sort" data-sort="guard">Guard</th>
                                    <th class="sort" data-sort="id_room">Location</th>
                                    <th class="sort" data-sort="tgl_checklist">Inspection DateTime</th>
                                    <th class="sort" data-sort="keterangan">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="checklist_body">
                                @foreach ($checklistsecuriy as $key => $security)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>
                                        <a href="{{ $security->image ? asset($security->image) : asset('/assets/img/team/3-thumb.png') }}"
                                            data-bs-toggle="modal" data-bs-target="#error-modal"
                                            data-image="{{ $security->image ? asset($security->image) : asset('/assets/img/team/3-thumb.png') }}">
                                            <img src="{{ $security->image ? asset($security->image) : asset('/assets/img/team/3-thumb.png') }}"
                                                alt="{{ $security->image }}" class="img-thumbnail rounded-circle" style="max-width: 50p8x; width: 50px; height: 50px;">
                                        </a>
                                    </td>
                                    
                                    <td>
                                        @if ($security->guard == 0)
                                            Guard 1
                                        @elseif ($security->guard == 1)
                                            Guard 2
                                        @elseif ($security->guard == 2)
                                            Guard 3
                                        @endif
                                    </td>
                                    <td>{{ $security->room->nama_room}} - {{ $security->room->floor->nama_lantai }}</td>
                                    <td>{{ \Carbon\Carbon::parse($security->tgl_checklist)->format('d M Y') }} - {{ \Carbon\Carbon::parse($security->time_checklist)->format('H:i')}}</td>
                                    <td>{{ $security->keterangan }}</td>
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
                                    src="{{ $security->image ? asset($security->image) : asset('/assets/img/team/3-thumb.png') }}"
                                    alt="{{ $security->image }}" class="img-thumbnail">
                                {{-- <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            </div> --}}
                            </div>
                        </div>
                    </div>
        </div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#table-checklistsecurity', {
        stripeClasses: ['even', 'odd'],
        paging: true
    });
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
