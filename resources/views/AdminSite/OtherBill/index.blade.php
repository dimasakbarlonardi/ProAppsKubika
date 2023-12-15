@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0">List Biaya Lainnya</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bill Name</th>
                        <th>Price</th>
                        <th>Require Unit Volume?</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_bills as $key => $bill)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $bill->bill_name }}</td>
                            <td>{{ $bill->bill_price }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="isRequireUnitVolume{{ $bill->id }}"
                                        onclick="changeReuireUnitVolume({{ $bill->id }})" type="checkbox"
                                        {{ $bill->is_require_unit_volume ? 'checked' : '' }} />
                                    <span
                                        id="isRequireUnitVolumeSpan{{ $bill->id }}">{{ $bill->is_require_unit_volume ? 'Active' : 'Non Active' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="isActive{{ $bill->id }}"
                                        onclick="changeActiveOtherBill({{ $bill->id }})" type="checkbox"
                                        {{ $bill->is_active ? 'checked' : '' }} />
                                    <span
                                        id="is_{{ $bill->id }}_active">{{ $bill->is_active ? 'Active' : 'Non Active' }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function changeActiveOtherBill(id) {
            $.ajax({
                url: `/admin/other-bill/isactive/${id}`,
                type: 'POST',
                success: function(resp) {
                    if (resp.status == 1) {
                        $(`#is_${id}_active`).html('Active');
                        $(`#isActive${id}`).prop('checked');
                    } else {
                        $(`#is_${id}_active`).html('Non Active');
                        $(`#isActive${id}`).removeAttr('checked');;
                    }
                }
            })
        }

        function changeReuireUnitVolume(id) {
            $.ajax({
                url: `/admin/other-bill/is-require-unit-volume/${id}`,
                type: 'POST',
                success: function(resp) {
                    if (resp.status == 1) {
                        $(`#isRequireUnitVolumeSpan${id}`).html('Active');
                        $(`#isRequireUnitVolume${id}`).prop('checked');
                    } else {
                        $(`#isRequireUnitVolumeSpan${id}`).html('Non Active');
                        $(`#isRequireUnitVolume${id}`).removeAttr('checked');;
                    }
                }
            })
        }
    </script>
@endsection
