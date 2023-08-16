@extends('layouts.master')

@section('css')
    <script id="midtrans-script" type="text/javascript" src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        data-environment="sandbox" data-client-key="SB-Mid-client-y5Egraipa_G9sOjU"></script>
@endsection

@section('content')
    @include('Tenant.Notification.Invoice.monthlyARTenant')
    <div class="card-footer bg-light">
        <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything else we
            can do, please let us know!
        </p>
    </div>
@endsection
