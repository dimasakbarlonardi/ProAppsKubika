@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Kepemilikan Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="accordion" id="accordionExample">
                @foreach ($kepemilikans as $key => $kepemilikan)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="heading{{ $key }}"><button class="accordion-button text-black"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                aria-expanded="true" aria-controls="collapse{{ $key }}"><b>Unit   {{ $kepemilikan->Owner->nama_pemilik}} </b>
                               </button></h3> 
                        <div class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                            id="collapse{{ $key }}" aria-labelledby="heading{{ $key }}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form method="post" action="{{ route('kepemilikans.update', $kepemilikan->id_kepemilikan_unit) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row justify-content-between">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">ID Pemilik</label>
                                                <select class="form-control" name="id_pemilik" required>
                                                    <option selected disabled>-- Ubah ID Pemilik --</option>
                                                    @foreach ($owners as $owner)
                                                        <option value="{{ $owner->id_pemilik }}">{{ $owner->nama_pemilik }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">ID Unit</label>
                                                <select class="form-control" name="id_unit" required>
                                                    <option selected disabled>-- Ubah ID Unit --</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">ID Status Hunian</label>
                                                <select class="form-control" name="id_status_hunian" required>
                                                    <option selected disabled>-- Pilih Status Hunian --</option>
                                                    @foreach ($statushunians as $statushunian)
                                                        <option value="{{ $statushunian->id_statushunian_tenant }}">
                                                            {{ $statushunian->status_hunian_tenant }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-6 text-end">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Luas Unit</label>
                                                        <input type="text" name="luas_unit" class="form-control" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Barcode Unit</label>
                                                        <input type="text" name="barcode_unit" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Luas Unit</label>
                                                        <input type="text" name="luas_unit" class="form-control" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Barcode Unit</label>
                                                        <input type="text" name="barcode_unit" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Luas Unit</label>
                                                        <input type="text" name="luas_unit" class="form-control" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Barcode Unit</label>
                                                        <input type="text" name="barcode_unit" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        
                                    </div>
                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1"><button class="accordion-button collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true"
                                aria-controls="collapse1">How long do payouts take?</button></h2>
                        <div class="accordion-collapse collapse show" id="collapse1" aria-labelledby="heading1"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">Once you’re set up, payouts arrive in your bank account on a 2-day
                                rolling basis. Or you can opt to receive payouts weekly or monthly.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2"><button class="accordion-button collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true"
                                aria-controls="collapse2">How do refunds work?</button></h2>
                        <div class="accordion-collapse collapse" id="collapse2" aria-labelledby="heading2"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">You can issue either partial or full refunds. There are no fees to
                                refund a charge, but the fees from the original charge are not returned.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3"><button class="accordion-button collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true"
                                aria-controls="collapse3">How much do disputes costs?</button></h2>
                        <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">Disputed payments (also known as chargebacks) incur a $15.00 fee. If
                                the customer’s bank resolves the dispute in your favor, the fee is fully refunded.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4"><button class="accordion-button collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true"
                                aria-controls="collapse4">Is there a fee to use Apple Pay or Google Pay?</button></h2>
                        <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">There are no additional fees for using our mobile SDKs or to accept
                                payments using consumer wallets like Apple Pay or Google Pay.</div>
                        </div>
                    </div>
                </div> --}}
            </div>

        </div>
    </div>
@endsection
