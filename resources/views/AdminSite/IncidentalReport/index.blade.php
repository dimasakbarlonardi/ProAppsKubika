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
                <h6 class="mb-0 text-white">List Incidental Report</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('incidentalreport.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Incident Report</a>
            </div>
        </div>
    </div>
    <div class="p-5 justify-content-center">
        <table class="table" id="table-incidental">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="reported_name">Reported By</th>
                    <th class="sort" data-sort="incident_name">Incident</th>
                    <th class="sort" data-sort="location">Location</th>
                    <th class="sort" data-sort="date">Date</th>
                    <th class="sort" data-sort="time">Time</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                    <th class="sort" data-sort="image">Image</th>
                </tr>
            </thead>
            <tbody id="checklist_body">
                @foreach ($incidental as $key => $incident)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $incident->reported_name }}</td>
                        <td>{{ $incident->incident_name }}</td>
                        <td>{{ $incident->location }}</td>
                        <td>{{\Carbon\Carbon::parse($incident->incident_date)->format('d-M-Y')}}</td>
                        <td>{{ $incident->incident_time }}</td>
                        <td>{{ $incident->desc }}</td>
                        <td>
                            <a href="{{ $incident->image ? asset($incident->image) : asset('/assets/img/team/3-thumb.png') }}" data-bs-toggle="modal" data-bs-target="#error-modal" data-image="{{ $incident->image ? asset($incident->image) : asset('/assets/img/team/3-thumb.png') }}">
                                <img src="{{ $incident->image ? asset($incident->image) : asset('/assets/img/team/3-thumb.png') }}" alt="{{ $incident->incident_image }}" style="max-width: 50px; height: 50px">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
              <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                  <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <img id="modal-image" alt="{{ $incident->image }}" class="img-thumbnail">
             
               </div>
              </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-incidental');
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