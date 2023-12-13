@extends('layouts.master')

@section('css')
    <script id="midtrans-script" type="text/javascript" src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        data-environment="sandbox" data-client-key="SB-Mid-client-y5Egraipa_G9sOjU"></script>
@endsection

@section('content')
    <ul class="nav nav-pills justify-content-around bg-white p-3 rounded mb-3" id="pill-myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                class="nav-link
                {{ Session::get('active') == 'unit' || Session::get('active') == null ? 'active' : '' }} selectTypePayment"
                data-bs-toggle="pill" data-bs-target="#pill-tab-home" type="button" role="tab" payment-type="utility">
                <span class="fas fa-hand-holding-water me-2"></span>
                <span class="fs--1">Utility</span>
            </button>
        </li>


        <li class="nav-item" role="presentation">
            <button class="nav-link btn-primary {{ Session::get('active') == 'member' ? 'active' : '' }} selectTypePayment"
                data-bs-toggle="pill" data-bs-target="#pill-tab-profile" type="button" role="tab" payment-type="ipl">
                <span class="fas fa-home me-2"></span>
                <span class="d-none d-md-inline-block fs--1">IPL</span>
            </button>
        </li>


        <li class="nav-item" role="presentation">
            <button class="nav-link {{ Session::get('active') == 'vehicle' ? 'active' : '' }} selectTypePayment"
                data-bs-toggle="pill" data-bs-target="#pill-tab-kendaraan" type="button" role="tab">
                <span class="fas fa-grip-horizontal me-2"></span>
                <span class="d-none d-md-inline-block fs--1">Other</span>
            </button>
        </li>
    </ul>
    <div class="container bg-white rounded" id="splitPaymentData">
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('document').ready(function() {
            SelectType('utility');
        })

        var admin_tax = 0.11;
        var admin_fee = 0;
        var type = '';
        var bank = '';
        var arID = 0;

        $('.selectTypePayment').on('click', function() {
            type = $(this).attr('payment-type');

            SelectType(type);
        })

        function SelectType(type) {
            $('#splitPaymentData').html("")

            arID = "{{ $transaction->id_monthly_ar_tenant }}"

            $.ajax({
                url: `/api/v1/get-splited-billing`,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                data: {
                    type,
                    arID
                },
                type: 'GET',
                success: function(resp) {
                    $('#splitPaymentData').html(resp.html)
                }
            });
        }

        $('#expDate').on('input', function() {
            var inputVal = $(this).val();

            // Remove all non-digit characters
            var cleanedVal = inputVal.replace(/\D/g, '');

            // Insert a slash after the first two characters
            if (cleanedVal.length > 2) {
                cleanedVal = cleanedVal.slice(0, 2) + '/' + cleanedVal.slice(2);
            }

            $(this).val(cleanedVal);
        })

        function onCreateTransaction(id) {
            $.ajax({
                url: `/api/v1/create-transaction/${id}`,
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                type: 'POST',
                data: {
                    admin_fee,
                    type,
                    bank
                },
                success: function(resp) {
                    console.log(resp);
                    if (resp.meta.code === 200) {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil mengupdate Work Order!',
                            'success'
                        ).then(() =>
                            window.location.replace(`/admin/payment-monthly-page/${ar}/${id}`)
                        )
                    } else {
                        Swal.fire(
                            'Sorry!',
                            'Our server is busy',
                            'info'
                        ).then(() =>
                            window.location.reload()
                        )
                    }
                }
            });
        }
    </script>
@endsection
