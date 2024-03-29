@foreach ($elecUSS as $key => $item)
    <tr>
        <th class="align-middle white-space-nowrap">
            <div class="form-check mb-0">
                <input class="form-check-input" name="bulk-elect" type="checkbox"
                    id="{{ $item->id }}"
                    data-bulk-select-row="data-bulk-select-row" />
            </div>
        </th>
        <th class="align-middle">
            <img width="50" src="{{ asset('assets/img/icons/spot-illustrations/proapps.png') }}" alt="">
        </th>
        <th class="align-middle">{{ $item->Unit->nama_unit }}</th>
        <th class="align-middle">
            @if ($item->WaterUUSrelation())
                Previous - <b>{{ $item->WaterUUSrelation()->nomor_air_awal }}</b> <br>
                Current - <b>{{ $item->WaterUUSrelation()->nomor_air_akhir }}</b> <br>
                Usage - <b>{{ $item->WaterUUSrelation()->usage }}</b> <br>
            @else
                <span class="badge bg-danger">Belum ada data</span>
            @endif
        </th>
        <th class="align-middle">
            Previous - <b>{{ $item->nomor_listrik_awal }}</b> <br>
            Current - <b>{{ $item->nomor_listrik_akhir }}</b> <br>
            Usage - <b>{{ $item->usage }}</b> <br>
        </th>
        <th>{{ $item->periode_bulan }} - {{ $item->periode_tahun }}</th>
        </th>
        <th>
            @if ($item->is_approve && $item->WaterUUSrelation()->is_approve)
                <span class="badge bg-success">Approved</span> <br>
                @if ($item->MonthlyUtility)
                    {{-- <form class="d-inline" action="{{ route('generateMonthlyInvoice') }}" method="post">
                        @csrf
                        <input type="hidden" name="periode_bulan" value="{{ $item->periode_bulan }}">
                        <input type="hidden" name="periode_tahun" value="{{ $item->periode_tahun }}">
                        <button type="submit" class="btn btn-info btn-sm mt-3"
                            onclick="return confirm('are you sure?')">
                            <span class="fas fa-check fs--2 me-1"></span>
                            Calculate Invoice
                        </button>
                    </form> --}}
                    @if ($item->MonthlyUtility->MonthlyTenant->tgl_bayar_invoice)
                        <span class="badge bg-success mt-3" onclick="return confirm('are you sure?')">
                            <span class="fas fa-check fs--2 me-1"></span>
                            Payed
                        </span>
                    @elseif (!$item->MonthlyUtility->MonthlyTenant->tgl_bayar_invoice && $item->MonthlyUtility->sign_approval_2)
                        <span class="badge bg-danger mt-3">
                            <span class="fas fa-check fs--2 me-1"></span>
                            Not Payed
                        </span>
                    @endif
                    @if (!$item->MonthlyUtility->sign_approval_2)
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
                @endif
            @elseif (!$item->is_approve)
                <form class="d-inline" action="{{ route('approve-usr-electric', $item->id) }}" method="post">
                    @csrf
                    <span type="submit" class="badge bg-warning">
                        <span class="fas fa-check fs--2 me-1"></span>
                        Approve
                    </span>
                </form>
            @else
                <span class="badge bg-success">Approved</span> <br>
                <small>
                    *Menunggu tagihan air untuk di approve
                </small>
            @endif
        </th>
    </tr>
@endforeach
