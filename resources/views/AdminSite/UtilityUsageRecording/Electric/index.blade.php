@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Utility</h6>
                </div>
                <div class="col-auto d-flex ">
                    <a class="btn btn-falcon-default btn-sm dropdown-toggle ms-2 dropdown-caret-none"
                        href="{{ route('create-usr-electric') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Data</a>
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
                    @foreach ($elecUSS as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->Unit->nama_unit }}</td>
                            <td>{{ $item->nomor_listrik_awal }}</td>
                            <td>{{ $item->nomor_listrik_akhir }}</td>
                            <td>{{ $item->nomor_listrik_akhir - $item->nomor_listrik_awal }}</td>
                            <td>{{ $item->periode_bulan }} - {{ $item->periode_tahun }}</td>
                            <td>
                                @if ($item->no_refrensi)
                                    <a target="_blank" href="{{ route('invoice', $item->CR->id) }}"
                                        class="btn btn-info btn-sm">
                                        Invoice
                                    </a>
                                    @if ($item->CR->transaction_status == 'PAYED')
                                        <span class="badge bg-success">Payed</span>
                                    @else
                                        <span class="badge bg-danger">Not Payed</span>
                                    @endif
                                @elseif (!$item->is_approve)
                                    <form class="d-inline" action="{{ route('approve-usr-electric', $item->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('are you sure?')">
                                            <span class="fas fa-check fs--2 me-1"></span>
                                            Approve
                                        </button>
                                    </form>
                                @elseif($item->is_approve)
                                    <span class="badge bg-success">Approved</span> <br>
                                    <small>
                                        *Menunggu tagihan air untuk di approve
                                    </small>
                                @endif

                                {{ $item->Unit->WaterUUS[0]->periode_bulan == $item->periode_bulan &&
                                    $item->Unit->WaterUUS[0]->periode_tahun == $item->periode_tahun }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
