@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-3">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Monthly AR Tenant</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('monthlyartenants.create') }}">Tambah Monthly AR Tenant</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_site">Site</th>
                    <th class="sort" data-sort="id_tower">Tower</th>
                    <th class="sort" data-sort="id_unit">Unit</th>
                    <th class="sort" data-sort="id_tenant">Tenant</th>
                    <th class="sort" data-sort="no_monthly_invoice">No Monthly Invoice</th>
                    <th class="sort" data-sort="periode_bulan">Periode Bulan</th>
                    <th class="sort" data-sort="periode_tahun">Periode Tahun</th>
                    <th class="sort" data-sort="total_tagihan_ipl">Total Tagihan IPL</th>
                    <th class="sort" data-sort="total_tagihan_utility">Total Tagihan Utility</th>
                    <th class="sort" data-sort="total_denda">Total Denda</th>
                    <th class="sort" data-sort="biaya_lain">Biaya Lain</th>
                    <th class="sort" data-sort="tgl_jt_invoice">Tanggal Jatuh Invoice</th>
                    <th class="sort" data-sort="tgl_bayar_invoice">Tanggal Bayar Invoice</th>
                    <th class="sort">Action</th>
                </tr>   
            </thead>
            <tbody>
                @foreach ($monthlyartenants as $key => $monthlyartenant)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $monthlyartenant->id_site }}</td>
                        <td>{{ $monthlyartenant->id_tower }}</td>
                        <td>{{ $monthlyartenant->id_unit }}</td>
                        <td>{{ $monthlyartenant->id_tenant }}</td>
                        <td>{{ $monthlyartenant->no_monthly_invoice }}</td>
                        <td>{{ $monthlyartenant->periode_bulan }}</td>
                        <td>{{ $monthlyartenant->periode_tahun }}</td>
                        <td>{{ $monthlyartenant->total_tagihan_ipl }}</td>
                        <td>{{ $monthlyartenant->total_tagihan_utility }}</td>
                        <td>{{ $monthlyartenant->total_denda }}</td>
                        <td>{{ $monthlyartenant->biaya_lain }}</td>
                        <td>{{ $monthlyartenant->tgl_jt_invoice }}</td>
                        <td>{{ $monthlyartenant->tgl_bayar_invoice }}</td>
                        <td>
                            <a href="{{ route('monthlyartenants.edit', $monthlyartenant->id_monthly_ar_tenant) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('monthlyartenants.destroy', $monthlyartenant->id_monthly_ar_tenant) }}" method="post">
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

