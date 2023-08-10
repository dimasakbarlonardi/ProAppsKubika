@extends('layouts.master')

@section('content')
    @if ($transaction->MonthlyARTenant)
        @include('Tenant.Notification.Invoice.monthlyARTenant')
        @if (!$transaction->MonthlyARTenant->NextMonthBill())
            <div class="text-center">
                <button class="btn btn-success btn-lg my-4" type="button" id="pay-button">
                    Bayar
                </button>
            </div>
        @endif
    @endif
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
        })
    </script>
@endsection
