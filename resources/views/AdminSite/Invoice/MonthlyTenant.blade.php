<div class="table-responsive scrollbar mt-4 fs--1">
    <table class="table">
        <tbody>
            @if ($data->CashReceipt->PreviousMonthBill($data->periode_bulan, $data->periode_tahun))
                @foreach ($data->CashReceipt->PreviousMonthBill($data->periode_bulan, $data->periode_tahun) as $prevBill)
                    <tr class="alert alert-success my-3">
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Tagihan bulan
                                {{ $prevBill->MonthlyARTenant->id_monthly_ar_tenant }}
                                {{ $prevBill->MonthlyARTenant->periode_bulan }},
                                {{ $prevBill->MonthlyARTenant->periode_tahun }}</h6>
                        </td>
                        <td class="align-middle text-center">
                        </td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-3 text-nowrap">Tagihan Utility</h6>
                            <p class="mb-0">Listrik</p>
                            <hr>
                            <p class="mb-0">Air</p>
                        </td>
                        <td>
                            <h6 class="mb-3 text-nowrap">Previous Usage</h6>
                            <p class="mb-0">
                                {{ $prevBill->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_awal }}
                            </p>
                            <hr>
                            <p class="mb-0">
                                {{ $prevBill->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_awal }}
                            </p>
                        </td>
                        <td class="align-middle">
                            <h6 class="mb-3 text-nowrap">Current Usage</h6>
                            <p class="mb-0">
                                {{ $prevBill->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_akhir }}
                            </p>
                            <hr>
                            <p class="mb-0">
                                {{ $prevBill->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_akhir }}
                            </p>
                        </td>
                        <td class="align-middle text-center">
                            <h6 class="text-nowrap mb-3">Usage</h6>
                            <span>{{ $prevBill->MonthlyARTenant->MonthlyUtility->ElectricUUS->usage }} KwH</span>
                            <br>
                            <hr>
                            <span>{{ $prevBill->MonthlyARTenant->MonthlyUtility->WaterUUS->usage }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <h6 class="text-nowrap mb-3">Price</h6>
                            <span>{{ DecimalRupiahRP($electric->biaya_m3) }} / KwH</span> <br>
                            <hr>
                            <span>{{ Rupiah($water->biaya_m3) }} / m<sup>3</sup></span>
                        </td>
                        <td class="align-middle text-center">
                            <h6 class="text-nowrap mb-3">PPJ
                                <small>({{ $electric->biaya_ppj }}%)</small>
                            </h6>
                            <span>{{ DecimalRupiahRP($prevBill->MonthlyARTenant->MonthlyUtility->ElectricUUS->ppj) }}</span>
                            <br>
                            <hr>
                            <span>-</span>
                        </td>
                        <td class="align-middle text-end">
                            <h6 class="text-nowrap mb-3 text-end">Total</h6>
                            <span>{{ DecimalRupiahRP($prevBill->MonthlyARTenant->MonthlyUtility->ElectricUUS->total) }}</span>
                            <br>
                            <hr>
                            <span>{{ Rupiah($prevBill->MonthlyARTenant->MonthlyUtility->WaterUUS->total) }}</span>
                        </td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-3 mt-3 text-nowrap">Tagihan IPL</h6>
                            <p class="mb-0">Service Charge</p>
                            <hr>
                            <p class="mb-0">Sink Fund</p>
                        </td>
                        <td class="align-middle text-center">
                            <h6 class="mb-3 mt-3 text-nowrap">Luas Unit</h6>
                            <span>{{ $prevBill->MonthlyARTenant->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span>
                            <br>
                            <hr>
                            <span>{{ $prevBill->MonthlyARTenant->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span>
                        </td>
                        <td class="align-middle text-center" colspan="2">
                            <h6 class="mb-3 mt-3">Biaya Permeter / Biaya Procentage</h6>
                            <span>{{ $sc->biaya_procentage ? $sc->biaya_procentage . '%' : Rupiah($sc->biaya_permeter) }}</span>
                            <br>
                            <hr>
                            <span>{{ $sf->biaya_procentage ? $sf->biaya_procentage . '%' : Rupiah($sf->biaya_permeter) }}</span>
                        </td>
                        <td>
                        </td>
                        <td></td>
                        <td class="align-middle text-end" colspan="2">
                            <h6 class="mb-3 mt-3">Total</h6>
                            <span>{{ Rupiah($prevBill->MonthlyARTenant->MonthlyIPL->ipl_service_charge) }}</span>
                            <br>
                            <hr>
                            <span>{{ Rupiah($prevBill->MonthlyARTenant->MonthlyIPL->ipl_sink_fund) }}</span>
                        </td>
                    </tr>
                @endforeach
            @endif
            <tr class="alert alert-success my-3">
                <td class="align-middle">
                    <h6 class="mb-0 text-nowrap">Tagihan bulan {{ $data->id_monthly_ar_tenant }}
                        {{ $data->periode_bulan }},
                        {{ $data->periode_tahun }}</h6>
                </td>
                <td class="align-middle text-center">
                </td>
                <td class="align-middle text-end"></td>
                <td class="align-middle text-end"></td>
                <td class="align-middle text-end"></td>
                <td class="align-middle text-end"></td>
                <td class="align-middle text-end"></td>
            </tr>
            <tr>
                <td class="align-middle">
                    <h6 class="mb-3 text-nowrap">Tagihan Utility</h6>
                    <p class="mb-0">Listrik</p>
                    <hr>
                    <p class="mb-0">Air</p>
                </td>
                <td class="align-middle">
                    <h6 class="mb-3 text-nowrap">Previous Usage</h6>
                    <p class="mb-0">
                        {{ $data->MonthlyUtility->ElectricUUS->nomor_listrik_awal }}
                    </p>
                    <hr>
                    <p class="mb-0">
                        {{ $data->MonthlyUtility->WaterUUS->nomor_air_awal }}
                    </p>
                </td>
                <td class="align-middle">
                    <h6 class="mb-3 text-nowrap">Current Usage</h6>
                    <p class="mb-0">
                        {{ $data->MonthlyUtility->ElectricUUS->nomor_listrik_akhir }}
                    </p>
                    <hr>
                    <p class="mb-0">
                        {{ $data->MonthlyUtility->WaterUUS->nomor_air_akhir }}
                    </p>
                </td>
                <td class="align-middle text-center">
                    <h6 class="text-nowrap mb-3">Usage</h6>
                    <span>{{ $data->MonthlyUtility->ElectricUUS->usage }} KWh</span> <br>
                    <hr>
                    <span>{{ $data->MonthlyUtility->WaterUUS->usage }} m<sup>3</sup></span>
                </td>
                <td class="align-middle text-center">
                    <h6 class="text-nowrap mb-3">Price</h6>
                    <span>{{ DecimalRupiahRP($electric->biaya_m3) }} / KWh</span> <br>
                    <hr>
                    <span>{{ Rupiah($water->biaya_m3) }} / m<sup>3</sup></span>
                </td>
                <td class="align-middle text-center">
                    <h6 class="text-nowrap mb-3">PPJ
                        <small>({{ $electric->biaya_ppj }}%)</small>
                    </h6>
                    <span>{{ DecimalRupiahRP($data->MonthlyUtility->ElectricUUS->ppj) }}</span>
                    <br>
                    <hr>
                    <span>-</span>
                </td>
                <td class="align-middle text-end">
                    <h6 class="text-nowrap mb-3 text-end">Total</h6>
                    <span>{{ DecimalRupiahRP($data->MonthlyUtility->ElectricUUS->total) }}</span>
                    <br>
                    <hr>
                    <span>{{ Rupiah($data->MonthlyUtility->WaterUUS->total) }}</span>
                </td>
            </tr>
            <tr>
                <td class="align-middle">
                    <h6 class="mb-3 mt-3 text-nowrap">Tagihan IPL</h6>
                    <p class="mb-0">Service Charge</p>
                    <hr>
                    <p class="mb-0">Sink Fund</p>
                </td>
                <td class="align-middle text-center">
                    <h6 class="mb-3 mt-3 text-nowrap">Luas Unit</h6>
                    <span>{{ $data->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span> <br>
                    <hr>
                    <span>{{ $data->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span>
                </td>
                <td class="align-middle text-center" colspan="2">
                    <h6 class="mb-3 mt-3">Biaya Permeter / Biaya Procentage</h6>
                    <span>{{ $sc->biaya_procentage ? $sc->biaya_procentage . '%' : Rupiah($sc->biaya_permeter) }}</span>
                    <br>
                    <hr>
                    <span>{{ $sf->biaya_procentage ? $sf->biaya_procentage . '%' : Rupiah($sf->biaya_permeter) }}</span>
                </td>
                <td>
                </td>
                <td></td>
                <td class="align-middle text-end" colspan="2">
                    <h6 class="mb-3 mt-3">Total</h6>
                    <span>{{ Rupiah($data->MonthlyIPL->ipl_service_charge) }}</span> <br>
                    <hr>
                    <span>{{ Rupiah($data->MonthlyIPL->ipl_sink_fund) }}</span>
                </td>
            </tr>
            @if ($installment)
                <tr class="alert alert-success mt-3">
                    <td class="align-middle" colspan="6">
                        <h6 class="mb-0 text-nowrap">Others
                        </h6>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle">
                        <h6 class="mb-3 text-nowrap">Item</h6>
                        <p class="mb-0">Installment</p>
                    </td>
                    <td class="align-middle">
                        <h6 class="mb-3 text-nowrap">Invoice</h6>
                        <p class="mb-0">
                            {{ $installment->no_invoice }} ({{ $installment->rev }})
                        </p>
                    </td>
                    <td class="align-middle">

                    </td>
                    <td class="align-middle text-center">

                    </td>
                    <td class="align-middle text-center">

                    </td>
                    <td class="align-middle text-center">

                    </td>
                    <td class="align-middle text-end">
                        <h6 class="text-nowrap mb-3 text-end">Amount</h6>
                        <p>
                            {{ Rupiah($installment->amount) }}
                        </p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@if ($data->denda_bulan_sebelumnya)
    <div class="table-responsive scrollbar mt-4 fs--1">
        <table class="table border-bottom">
            <thead class="alert alert-danger">
                <th class="align-middle">
                    <h6 class="mb-0 text-nowrap">Denda keterlambatan</h6>
                </th>
                <th></th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($data->PreviousMonthBill() as $prevBill)
                    <tr>
                        <td>
                            Denda tagihan bulan {{ $prevBill->periode_bulan }}
                        </td>
                        <td class="align-middle">
                            {{ $prevBill->jml_hari_jt }} Hari
                        </td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end">
                            {{ rupiah($prevBill->total_denda) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </tbody>
        </table>
    </div>
@endif
