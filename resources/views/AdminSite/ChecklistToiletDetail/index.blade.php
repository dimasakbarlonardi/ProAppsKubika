@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">List Inspection Engineering</h6>
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
                                    <th class="sort" data-sort="">No</th>
                                    <th class="sort" data-sort="image">Foto</th>
                                    <th class="sort" data-sort="equipment">Equipment</th>
                                    <th class="sort" data-sort="room">Lokasi</th>
                                    <th class="sort" data-sort="status">Status</th>
                                    <th class="sort" data-sort="inspection">Inspection HouseKeeping</th>
                                    <th class="sort" data-sort="pic">PIC</th>
                                    <th class="sort" data-sort="tgl_checklist">Pelaksanaan</th>
                                    <th class="sort" data-sort="keterangan">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="checklist_body">
                                @foreach ($equiqmentdetails as $key => $detail)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td><img src="{{ $detail->image ? $detail->image : '/assets/img/team/3-thumb.png' }}"
                                                alt="{{ $detail->image }}"></td>
                                        <td>{{ $detail->equipment->equipment }}</td>
                                        <td>{{ $detail->room->nama_room }}</td>
                                        <td>{{ $detail->status }}</td>
                                        <td scope="row">
                                            @foreach ($parameters as $parameter)
                                                @if ($parameter['id_equiqment'] == $detail->id_equipment)
                                                    {{ $parameter->checklisttoilet->nama_hk_toilet }} <br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $detail->role->nama_role }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($detail->usage_return)->format(' d M Y') }}
                                        </td>
                                        <td>{{ $detail->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#table-housekeepinghistory');
</script>
@endsection
