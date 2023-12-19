<div class="p-4 text-justify">
    Dengan Hormat,

    Bersama ini kami sampaikan, dari data yang kami miliki terhadap kewajiban Invoice bapak/ibu
    sebesar
    <b>{{ Rupiah($ar->LastBill()->CashReceipt->sub_total) }}</b>
    <b>({{ Terbilang($ar->LastBill()->CashReceipt->sub_total) }})</b>, sampai dengan bulan
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
            @if ($ar->PreviousMonthBill())
                @foreach ($ar->PreviousMonthBill() as $key => $prevBill)
                    @php
                        $key += 1;
                    @endphp
                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-3 text-nowrap">{{ $key }}</h6>
                        </td>
                        <td class="align-middle text-center">
                            Monthly Billing <br> (Utility & Service Charge)
                        </td>
                        <td class="align-middle text-center">
                            {{ HumanDate($prevBill->created_at) }}
                        </td>
                        <td class="align-middle text-center">
                            {{ HumanDate($prevBill->tgl_jt_invoice) }}
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
                            {{ Rupiah($prevBill->total_tagihan_ipl + $prevBill->total_tagihan_utility + $prevBill->denda_bulan_sebelumnya) }}
                        </td>
                    </tr>
                @endforeach
            @endif
            <tr class="my-3">
                <td class="align-middle">
                    <h6 class="mb-0 text-nowrap">{{ $key + 1 }}</h6>
                </td>
                <td class="align-middle text-center">
                    Monthly Billing <br> (Utility & Service Charge)
                </td>
                <td class="align-middle text-center">
                    {{ HumanDate($ar->created_at) }}
                </td>
                <td class="align-middle text-center">
                    {{ HumanDate($ar->tgl_jt_invoice) }}
                </td>
                <td class="align-middle text-center">
                    {{ Rupiah($ar->total_tagihan_ipl + $ar->total_tagihan_utility) }}
                </td>
                <td class="align-middle text-center">
                    {{ $ar->jml_hari_jt }} {{ $ar->jml_hari_jt ? 'Hari' : '-' }}
                </td>
                <td class="align-middle text-center">
                    {{ $ar->total_denda ? Rupiah($ar->total_denda) : '-' }}
                </td>
                <td class="align-middle text-center">
                    {{ Rupiah($ar->total_tagihan_ipl + $ar->total_tagihan_utility + $ar->total_denda) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
