@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">System Setting</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('system-settings.store') }}">
                @csrf
                {{-- <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Group</label>
                            <select class="form-control" name="id_group" required>
                                <option selected disabled>-- Pilih Unit --</option>
                                <option value="">141</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pengurus</label>
                            <select class="form-control" name="id_pengurus" required>
                                <option selected disabled>-- Pilih Pengurus --</option>
                                <option value="">P3SRS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Strata</label>
                            <select class="form-control" name="id_strata" required>
                                <option selected disabled>-- Pilih Strata --</option>
                                <option value="">141</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Site</label>
                            <select class="form-control" name="id_site" required>
                                <option selected disabled>-- Pilih Pengurus --</option>
                                <option value="">Park Royale</option>
                            </select>
                        </div>
                    </div>
                </div> --}}
                {{-- <h4>Kode Unik</h4>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Kode Unik Request</label>
                            <input class="form-control" maxlength="3" disabled type="text" name="kode_unik_tiket"
                                value="{{ $system->kode_unik_tiket }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kode Unik Work Request</label>
                            <input class="form-control" maxlength="3" disabled type="text" name="kode_unik_wr"
                                value="{{ $system->kode_unik_wr }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Kode Unik Work Order</label>
                            <input class="form-control" maxlength="3" disabled type="text" name="kode_unik_wo"
                                value="{{ $system->kode_unik_wo }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kode Unik Permit Request</label>
                            <input class="form-control" maxlength="3" disabled type="text" name="kode_unik_pr"
                                value="{{ $system->kode_unik_pr }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Kode Unik Permit Order</label>
                            <input class="form-control" maxlength="3" disabled type="text" name="kode_unik_po"
                                value="{{ $system->kode_unik_po }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kode Unik Invoice</label>
                            <input class="form-control" maxlength="3" disabled type="text" name="kode_unik_invoice"
                                value="{{ $system->kode_unik_invoice }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Kode Unik Cash Receipt</label>
                            <input class="form-control" maxlength="3" disabled type="text" name="kode_unik_cash_receipt"
                                value="{{ $system->kode_unik_cash_receipt }}">
                        </div>
                    </div>
                </div>
                <h4 class="mt-5 mb-3">Sequence Number</h4>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Sequence No Request</label>
                            <input class="form-control" maxlength="6" disabled type="text" name="sequence_notiket"
                                value="{{ $system->sequence_notiket }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Sequence No Work Request</label>
                            <input class="form-control" maxlength="6" disabled type="text" name="sequence_no_wr"
                                value="{{ $system->sequence_no_wr }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Sequence No Work Order</label>
                            <input class="form-control" maxlength="6" disabled type="text" name="sequence_no_wo"
                                value="{{ $system->sequence_no_wo }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Sequence No Permit Request</label>
                            <input class="form-control" maxlength="6" disabled type="text" name="sequence_no_pr"
                                value="{{ $system->sequence_no_pr }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Sequence No Permit Order</label>
                            <input class="form-control" maxlength="6" disabled type="text" name="sequence_no_po"
                                value="{{ $system->sequence_no_po }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Sequence No Invoice</label>
                            <input class="form-control" maxlength="6" disabled type="text"
                                name="sequence_no_invoice" value="{{ $system->sequence_no_invoice }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Sequence No Cash Payment</label>
                            <input class="form-control" maxlength="6" disabled type="text"
                                name="sequence_no_cash_payment" value="{{ $system->sequence_no_cash_payment }}">
                        </div>

                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-warning" id="button-back">Back</button>
                    <button type="button" class="btn btn-warning" style="display: none"
                        id="button-cancel">Cancel</button>
                    <button type="button" class="btn btn-primary" id="button-edit">Edit</button>
                    <button type="submit" class="btn btn-success" style="display: none"
                        id="button-update">Update</button>
                </div> --}}
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            $('#button-edit').on('click', function() {
                $('.form-control').removeAttr('disabled');
                $('#button-edit').css('display', 'none')
                $('#button-update').css('display', 'inline')

                $('#button-back').css('display', 'none')
                $('#button-cancel').css('display', 'inline')
            })

            $('#button-cancel').on('click', function() {
                $('.form-control').prop('disabled', true);
                $('#button-edit').css('display', 'inline')
                $('#button-update').css('display', 'none')

                $('#button-back').css('display', 'inline')
                $('#button-cancel').css('display', 'none')
            })
        })
    </script>
@endsection
