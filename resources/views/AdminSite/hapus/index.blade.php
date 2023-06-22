@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Check list AHU</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('checklistahus.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Check list AHU</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="barcode_room">Barcode Room</th>
                    <th class="sort" data-sort="id_room">Room</th>
                    <th class="sort" data-sort="tgl_checklist">Tanggal Checklist</th>
                    <th class="sort" data-sort="time_checklist">Time Checklist</th>
                    {{-- <th class="sort" data-sort="id_user">User</th> --}}
                    <th class="sort" data-sort="no_checklist_ahu">Nomer Check list AHU</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($checklistahus as $key => $checklistahu)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $checklistahu->barcode_room }}</td>
                        <td>{{ $checklistahu->room->nama_room }}</td>
                        <td>{{ $checklistahu->tgl_checklist }}</td>
                        <td>{{ $checklistahu->time_checklist }}</td>
                        {{-- <td>{{ $checklistahu->id_user }}</td> --}}
                        <td>{{ $checklistahu->no_checklist_ahu }}</td>
                        <td>
                            <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-0">
                                  <div class="py-2"><a class="dropdown-item text" href="{{ route('checklistahus.edit', $checklistahu->no_checklist_ahu) }}">Edit</a><a class="dropdown-item text" href="{{ route('checklistahus.show', $checklistahu ->no_checklist_ahu) }}">Detail AHU Checklist</a>
                                    <div class="dropdown-divider"></div> <form class="d-inline" action="{{ route('checklistahus.destroy', $checklistahu->id_checklist_ahu_h) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                                    </form>
                                    @endforeach
                                  </div>
                                </div>
                              </div>
                            
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

