@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Usage Recording Water</h6>
                </div>
                <div class="col-auto d-flex ">
                    <a class="btn btn-falcon-default btn-sm dropdown-toggle ms-2 dropdown-caret-none"
                        href="{{ route('create-usr-water') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Data</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit</th>
                        <th>Previous</th>
                        <th>Current</th>
                        <th>Usage</th>
                        <th>Period</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($waterUSS as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->Unit->nama_unit }}</td>
                            <td>{{ $item->nomor_air_awal }}</td>
                            <td>{{ $item->nomor_air_akhir }}</td>
                            <td>{{ $item->nomor_air_akhir - $item->nomor_air_awal }}</td>
                            <td>{{ $item->periode_bulan }} - {{ $item->periode_tahun }}</td>
                            <td>
                                @if ($item->is_approve && $item->ElecUUSrelation()->is_approve)
                                    <span class="badge bg-success">Approved</span> <br>
                                    @if (!$item->MonthlyUtility)
                                        <form class="d-inline" action="{{ route('generateMonthlyInvoice') }}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="periode_bulan" value="{{ $item->periode_bulan }}">
                                            <input type="hidden" name="periode_tahun" value="{{ $item->periode_tahun }}">
                                            <button type="submit" class="btn btn-info btn-sm mt-3"
                                                onclick="return confirm('are you sure?')">
                                                <span class="fas fa-check fs--2 me-1"></span>
                                                Calculate Invoice
                                            </button>
                                        </form>
                                    @else
                                        <a href="#" class="btn btn-info btn-sm mt-3"
                                            onclick="return confirm('are you sure?')">
                                            <span class="fas fa-check fs--2 me-1"></span>
                                            Invoice
                                        </a>
                                        <form class="d-inline"
                                            action="{{ route('blastMonthlyInvoice', $item->MonthlyUtility->MonthlyTenant->id_monthly_ar_tenant) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm mt-3"
                                                onclick="return confirm('are you sure?')">
                                                <span class="fas fa-check fs--2 me-1"></span>
                                                Kirim Invoice
                                            </button>
                                        </form>
                                    @endif
                                @elseif (!$item->is_approve)
                                    <form class="d-inline" action="{{ route('approve-usr-water', $item->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('are you sure?')">
                                            <span class="fas fa-check fs--2 me-1"></span>
                                            Approve
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Approved</span> <br>
                                    <small>
                                        *Menunggu tagihan air untuk di approve
                                    </small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection