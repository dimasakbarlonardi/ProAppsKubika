@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Unit</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('units.create') }}">Tambah Unit</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_unit">Kode Unit</th>
                    <th class="sort" data-sort="nama_hunian">Nama Hunian</th>
                    <th class="sort" data-sort="nama_unit">Nama Unit</th>
                    <th class="sort" data-sort="luas_unit">Luas Unit</th>
                    <th class="sort" data-sort="barcode_meter_air">Barcode Meter Air</th>
                    <th class="sort" data-sort="barcode_meter_listrik">Barcode Meter Listrik</th>
                    <th class="sort" data-sort="barcode_meter_gas">Barcode Meter Gas</th>   
                    <th class="sort" data-sort="no_meter_air">No Meter Air</th>
                    <th class="sort" data-sort="no_meter_listrik">No Meter Listrik</th>
                    <th class="sort" data-sort="no_meter_gas">No Meter Gas</th>  
                    <th class="sort" data-sort="meter_air_awal">Meter Air Awal</th>   
                    <th class="sort" data-sort="meter_air_akhir">Meter Air Akhir</th>
                    <th class="sort" data-sort="meter_listrik_awal">Meter Listrik Awal</th>
                    <th class="sort" data-sort="meter_listrik_akhir">Meter Listrik Akhir</th>  
                    <th class="sort" data-sort="meter_gas_awal">Meter Gas Awal</th>
                    <th class="sort" data-sort="meter_gas_akhir">Meter Gas Akhir</th>  
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $key => $unit)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $unit->id_unit }}</td>  
                        <td>{{ $unit->hunian->nama_hunian }}</td>    
                        <td>{{ $unit->nama_unit }}</td>
                        <td>{{ $unit->luas_unit }}</td>
                        <td>{{ $unit->barcode_meter_air }}</td>
                        <td>{{ $unit->barcode_meter_listrik }}</td>
                        <td>{{ $unit->barcode_meter_gas }}</td>
                        <td>{{ $unit->no_meter_air }}</td>
                        <td>{{ $unit->no_meter_listrik }}</td>
                        <td>{{ $unit->no_meter_gas }}</td>
                        <td>{{ $unit->meter_air_awal }}</td>
                        <td>{{ $unit->meter_air_akhir }}</td>
                        <td>{{ $unit->meter_listrik_awal }}</td>
                        <td>{{ $unit->meter_listrik_akhir }}</td>
                        <td>{{ $unit->meter_gas_awal }}</td>
                        <td>{{ $unit->meter_gas_akhir }}</td>                   
                        <td>{{ $unit->keterangan }}</td>
                        <td>
                            <a href="{{ route('units.edit', $unit->id_unit) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('units.destroy', $unit->id_unit) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

