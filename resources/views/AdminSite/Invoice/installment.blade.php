@extends('layouts.master')

@section('content')
    @php
        $months = [['value' => '01', 'name' => 'January', 'isDisabled' => false], ['value' => '02', 'name' => 'February', 'isDisabled' => false], ['value' => '03', 'name' => 'March', 'isDisabled' => false], ['value' => '04', 'name' => 'April', 'isDisabled' => false], ['value' => '05', 'name' => 'May', 'isDisabled' => false], ['value' => '06', 'name' => 'June', 'isDisabled' => false], ['value' => '07', 'name' => 'July', 'isDisabled' => false], ['value' => '08', 'name' => 'August', 'isDisabled' => false], ['value' => '09', 'name' => 'September', 'isDisabled' => false], ['value' => '10', 'name' => 'Oktober', 'isDisabled' => false], ['value' => '11', 'name' => 'November', 'isDisabled' => false], ['value' => '12', 'name' => 'December', 'isDisabled' => false]];

        foreach ($months as $key => $month) {
            if ($month['value'] == $transaction->MonthlyARTenant->periode_bulan) {
                $months[$key]['isDisabled'] = true;
                $currentMonth = $months[$key];
            }
        }
    @endphp
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                <div class="card-body p-0">
                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                        <div class="col-9 col-md-8 py-2">Invoice Detail</div>
                    </div>
                    <hr>
                    <div class="row gx-card mx-0">
                        <div class="col-8 py-3">
                            <label class="mb-1">Nomor Invoice</label>
                            <input class="form-control" type="text" value="{{ $transaction->no_invoice }}" disabled>
                        </div>
                        <div class="col-4 mt-3">
                            <label class="mb-1">Total Invoice</label>
                            <input class="form-control" type="text" value="{{ Rupiah($transaction->sub_total) }}"
                                disabled>
                        </div>
                    </div>
                    <div class="row gx-card mx-0">
                        <div class="col-8 py-3">
                            <label class="mb-1">Periode</label>
                            <input class="form-control" type="text" value="{{ $currentMonth['name'] }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3 p-3 modal-footer">
            <h3 class="text-danger" id="sub_total">{{ Rupiah($transaction->sub_total) }}</h3>
        </div>
        @if (count($transaction->Installments) == 0)
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-body p-0">
                        <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                            <div class="col-9 col-md-8 py-2">Installment</div>
                        </div>

                        <div id="detailInstallments">
                        </div>

                        <hr>
                        <div id="form-input-item">
                            <div class="row gx-card mx-0">
                                <div class="col-4 py-3">
                                    <label class="mb-1">Bulan</label>
                                    <select class="form-control" name="bulan" id="input_nama_bulan">
                                        <option value="Januari" period="01">Januari</option>
                                        <option value="Febuari" period="02">Febuari</option>
                                        <option value="Maret" period="03">Maret</option>
                                        <option value="April" period="04">April</option>
                                        <option value="Mei" period="05">Mei</option>
                                        <option value="Juni" period="06">Juni</option>
                                        <option value="July" period="07">July</option>
                                        <option value="Agustus" period="08">Agustus</option>
                                        <option value="September" period="09">September</option>
                                        <option value="Oktober" period="10">Oktober</option>
                                        <option value="November" period="11">November</option>
                                        <option value="Desember" period="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-4 py-3">
                                    <label class="mb-1">Tahun</label>
                                    <select class="form-control" tahun="bulan" id="input_periode_tahun">
                                        <option value="2023" id="">2023</option>
                                        <option value="2024" id="">2024</option>
                                        <option value="2025" id="">2025</option>
                                        <option value="2026" id="">2026</option>
                                        <option value="2027" id="">2027</option>
                                    </select>
                                </div>
                                <div class="col-4 mt-3">
                                    <label class="mb-1">Jumlah</label>
                                    <input class="form-control" type="text" id="show_jumlah_bayar">
                                    <input type="hidden" type="text" id="jumlah_bayar">
                                </div>
                            </div>
                            <div class="text-end mr-5">
                                <button type="button" class="btn btn-primary mt-3" id="onClickItem"
                                    onclick="onAddItem()">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-3 mt-3">
                <div class="text-end">
                    <button class="btn btn-success" id="submitInstallment">Submit</button>
                </div>
            </div>
        @else
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-body p-0">
                        <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                            <div class="col-9 col-md-8 py-2">Installment</div>
                        </div>

                        @foreach ($transaction->Installments as $installment)
                            <div class='row gx-card mx-0 align-items-center border-bottom border-200'
                                id="installment${item.id}">
                                <div class='col-8 py-3'>
                                    <div class='d-flex align-items-center'>
                                        <div class='flex-1'>
                                            <table>
                                                <tr>
                                                    <td><b>Periode</b></td>
                                                    <td class="mr-5">&ensp;:&ensp;</td>
                                                    <td>{{ $installment->periode }} - {{ $installment->tahun }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Jumlah bayar</b></td>
                                                    <td class="mr-5">&ensp;:&ensp;</td>
                                                    <td> {{ $installment->amount }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <hr>
                    </div>
                </div>
            </div>
            @if (count($transaction->Installments) == 0)
                <div class="card p-3 mt-3">
                    <div class="text-end">
                        <button class="btn btn-success" id="submitInstallment">Submit</button>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection

@section('script')
    <script>
        const d = new Date();
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October",
            "November", "December"
        ];

        var lastID = 0;
        var installments = [];
        var idInstall = 0;
        var valuePeriod = 1;
        var period = 0;
        var month = "";
        var subTotal = parseInt('{{ $transaction->sub_total }}')
        var year = d.getFullYear();
        var addYear = 0;
        var jumlahBayar = 0;

        IncPeriod(valuePeriod);

        var input = document.getElementById("show_jumlah_bayar");
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("onClickItem").click();
            }
        });

        $('#submitInstallment').on('click', function(e) {
            e.preventDefault();
            id = '{{ $transaction->id }}'
            $.ajax({
                url: `/admin/invoice/installment/${id}`,
                type: 'POST',
                data: {
                    "installments": installments
                },
                success: function(resp) {
                    if (resp.status === 'ok') {
                        Swal.fire(
                            'Success!',
                            'Success create Installment!',
                            'success'
                        ).then(() => window.location.replace('/admin/invoices'));
                    }
                }
            })
        })

        function IncPeriod(valuePeriod) {
            console.log(d.getMonth(), valuePeriod);
            month = months[(d.getMonth() + valuePeriod) % months.length];
            period = months.indexOf(month) + 1;

            if (period == '01') {
                addYear += 1
                year = d.getFullYear() + addYear;
            }

            if (period < 10) {
                period = '0' + period;
            }

            $('#input_periode').val(month);
        }

        function onAddItem() {
            jumlahBayar = $('#jumlah_bayar').val();
            jumlahBayar = parseInt(jumlahBayar.replace(".", ""));

            month = $('#input_nama_bulan').val()
            period = $("#input_nama_bulan option:selected" ).attr('period');
            year = $('#input_periode_tahun').val();

            console.log(subTotal, jumlahBayar);

            if (jumlahBayar > subTotal) {
                console.log('cannot');
                return;
            }
            console.log(period, month, year);
            if (!jumlahBayar) {
                Swal.fire(
                    'Failed!',
                    'Please fill all field',
                    'error'
                )
            } else {
                lastID += 1;

                $('#jumlah_barang').val('');

                let installment = {
                    'id': lastID,
                    'period': period,
                    'month': month,
                    'year': year,
                    'jumlah_bayar': jumlahBayar
                }

                valuePeriod += 1;
                // IncPeriod(valuePeriod);

                installments.push(installment);
                detailInstallments();
                $('#jumlah_bayar').val('');

                subTotal -= jumlahBayar;
                $('#sub_total').html(formatRupiah(subTotal.toString()));
                $('#show_jumlah_bayar').val('')
            }

            if (subTotal == 0) {
                $('#form-input-item').css('display', 'none');
            }
        }

        function onRemoveItem(id) {
            idInstall -= 1;
            valuePeriod -= 1;

            month = months[(d.getMonth() + valuePeriod) % months.length];
            period = months.indexOf(month);

            if (period == 0) {
                addYear -= 1
                year = d.getFullYear() + addYear;
            }
            $('#input_periode').val(month);

            subTotal += installments[id].jumlah_bayar;
            installments.splice(id, 1);

            $('#sub_total').html(formatRupiah(subTotal.toString()));
            detailInstallments();
            if (subTotal > 0) {
                $('#form-input-item').css('display', 'block');
            }
        }

        function detailInstallments() {
            $('#detailInstallments').html('');
            installments.map((item, i) => {
                lastElement = installments[installments.length - 1];

                $('#detailInstallments').append(
                    `<div class='row gx-card mx-0 align-items-center border-bottom border-200' id="installment${item.id}">
                        <div class='col-8 py-3'>
                            <div class='d-flex align-items-center'>
                                <div class='flex-1'>
                                    <table>
                                        <tr>
                                            <td><b>Periode</b></td>
                                            <td class="mr-5">&ensp;:&ensp;</td>
                                            <td>${item.month} - ${item.year}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Jumlah bayar</b></td>
                                            <td class="mr-5">&ensp;:&ensp;</td>
                                            <td>Rp${formatRupiah(item.jumlah_bayar.toString())}</td>
                                        </tr>
                                    </table>
                                    <div class='fs--2 fs-md--1'>
                                       ${buttonDelete(lastElement.id, item.id, i)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`
                )
            })
        }

        function buttonDelete(lastID, itemID, i) {
            if (itemID == lastID) {
                return `<a class='text-danger' onclick='onRemoveItem(${i})'>Remove</a>`;
            }
            return "";
        }

        $('#show_jumlah_bayar').keyup(function() {
            var value = $(this).val();
            var jumlah_bayar = $('#jumlah_bayar');

            var newJumlahBayar = value.replace(".", "")
            $('#jumlah_bayar').val(newJumlahBayar);

            $(this).val(formatRupiah(value.toString()));
        })
    </script>
@endsection
