@extends('layouts.master')  {{-- Gantilah 'layouts.app' dengan layout yang sesuai --}}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Detail Package
                </div>
                <div class="card-body">
                    <h5 class="card-title">Package Receipt Number: {{ $package->package_receipt_number }}</h5>
                    <p class="card-text">Receiver: {{ $package->receiver_id }}</p>
                    <p class="card-text">Received Location: {{ $package->received_location }}</p>
                    <p class="card-text">Courier Type: {{ $package->courier_type }}</p>
                    <p class="card-text">Courier Name: {{ $package->courier_name }}</p>
                    <p class="card-text">Received Time: {{ $package->receive_time }}</p>
                    <p class="card-text">Status: {{ $package->status }}</p>
                    
                    {{-- Tampilkan gambar --}}
                    <img src="{{ asset($package->image) }}" class="img-fluid rounded" alt="Package Image">

                    {{-- Tampilkan barcode --}}
                    <div class="barcode-container mt-4">
                        <p class="mb-2">Barcode Package:</p>
                        <img src="{{ asset($package->barcode_package) }}" alt="Barcode" class="img-fluid">
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('packages.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
