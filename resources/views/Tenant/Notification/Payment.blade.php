@extends('layouts.master')

@section('content')
    @if ($transaction->MonthlyARTenant)
        @include('Tenant.Notification.Invoice.monthlyARTenant')
    @endif
    <div class="text-center">
        @if ($transaction->MonthlyARTenant && $transaction->MonthlyARTenant->denda_bulan_sebelumnya != 0)
            <button class="btn btn-success btn-lg my-4" type="button" id="advance-pay-button">
                Bayar 1
            </button>
        @else
            <button class="btn btn-success btn-lg my-4" type="button" id="pay-button">
                Bayar 2
            </button>
        @endif
    </div>
    <div class="card-footer bg-light">
        <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything else we
            can do, please let us know!</p>
    </div>
@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        $('document').ready(function() {
            var token = '{{ $transaction->snap_token }}'
            $('#pay-button').on('click', function(e) {
                e.preventDefault();
                snap.pay(token, {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        // console.log(result)
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        // console.log(result)
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        // console.log(result)
                    }
                });
            })

            $('#advance-pay-button').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/admin/regenerate-snap-token',
                    type: 'POST',
                    data: {
                        token,
                    },
                    success: function(data) {
                        if (data.status === 'ok') {
                            snap.pay(token, {
                                // Optional
                                onClose: function() {
                                    /* You may add your own implementation here */
                                    window.location.reload();
                                },
                                onSuccess: function(result) {
                                    /* You may add your own js here, this is just example */
                                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                    // console.log(result)
                                },
                                // Optional
                                onPending: function(result) {
                                    /* You may add your own js here, this is just example */
                                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                    // console.log(result)
                                },
                                // Optional
                                onError: function(result) {
                                    /* You may add your own js here, this is just example */
                                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                    // console.log(result)
                                }
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Gagal mengambil data!',
                                'failed'
                            )
                        }
                    }
                })
            })

            $.ajax({
                url: '/admin/get-montly-ar',
                type: 'POST',
                data: {
                    token
                },
                success: function(resp) {
                    $('#periode_bulan').html(`Bulan ${resp[0].periode_bulan}, ${resp[0].periode_tahun}`);
                    $('#jml_hari').html(`${resp[0].jml_hari_jt} Hari`);
                    console.log(resp[0].periode_bulan);
                }
            })
        })
    </script>
@endsection
