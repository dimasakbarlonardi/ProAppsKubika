<div class="p-4 text-justify">
    Dengan Hormat,

    Bersama ini kami sampaikan, dari data yang kami miliki terhadap kewajiban Invoice bapak/ibu
    sebesar
    <b>{{ Rupiah($ar->CashReceiptsSP1()->sum('sub_total')) }}</b>
    <b>({{ Terbilang($ar->CashReceiptsSP1()->sum('sub_total')) }})</b>, sampai dengan bulan
    {{ \Carbon\Carbon::now()->formatLocalized('%B') }}

    Berikut kami lampirkan rincian penagihan atas unit <b>{{ $ar->Unit->nama_unit }}</b>, sebagai
    berikut :
</div>

<div class="table-responsive scrollbar mt-4 fs--1">
    <table class="table table-bordered border-bottom">
        <tbody>
            <tr class="alert alert-success my-3">
                <td class="align-middle">
                    <h6 class="mb-0 text-nowrap">No</h6>
                </td>
                <td class="align-middle text-center">
                    Jenis Tagihan
                </td>
                <td class="align-middle text-center">
                    Tanggal Invoice
                </td>
                <td class="align-middle text-center">
                    Jatuh Tempo
                </td>
                <td class="align-middle text-center">
                    Jumlah Belum Dibayar
                </td>
                <td class="align-middle text-center">
                    Over Due (Hari)
                </td>
                <td class="align-middle text-center">
                    Jumlah Penalti
                </td>
                <td class="align-middle text-center">
                    Total
                </td>
            </tr>
            @foreach ($ar->PreviousMonthBillSP($company->is_aplit_ar) as $key => $prevBill)
                @if ($prevBill->sp1)
                    @php
                        $key += 1;
                    @endphp
                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-3 text-nowrap">{{ $key }}</h6>
                        </td>
                        <td class="align-middle text-center">
                            Monthly Billing <br> (Utility & Service Charge {{ $company->is_split_ar ? '& Other Bill' : '' }})
                        </td>
                        <td class="align-middle text-center">
                            {{ HumanDate($prevBill->created_at) }}
                        </td>
                        <td class="align-middle text-center">
                            {{ HumanDate($prevBill->CashReceipts[0]->tgl_jt_invoice) }}
                        </td>
                        <td class="align-middle text-center">
                            {{ Rupiah($prevBill->total_tagihan_ipl + $prevBill->total_tagihan_utility) }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $prevBill->jml_hari_jt }}
                            {{ $prevBill->jml_hari_jt ? 'Hari' : '-' }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $prevBill->total_denda ? Rupiah($prevBill->total_denda) : '-' }}
                        </td>
                        <td class="align-middle text-center">
                            {{ Rupiah($prevBill->CashReceipts->sum('sub_total')) }}
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
