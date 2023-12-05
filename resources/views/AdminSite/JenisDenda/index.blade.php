@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0">List Jenis Denda</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Denda</th>
                        <th>Denda Flat Procetage</th>
                        <th>Denda Flat Amount</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jenisdendas as $key => $jenisdenda)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $jenisdenda->jenis_denda }}</td>
                            <td>{{ $jenisdenda->denda_flat_procetage ? persen($jenisdenda->denda_flat_procetage) . ' / Hari' : '-' }}
                            </td>
                            <td>{{ $jenisdenda->denda_flat_amount ? rupiah($jenisdenda->denda_flat_amount) . ' / Hari' : '-' }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="isActiveDenda{{ $jenisdenda->id_jenis_denda }}"
                                        onclick="changeActiveDenda({{ $jenisdenda->id_jenis_denda }})" type="checkbox"
                                        {{ $jenisdenda->is_active ? 'checked' : '' }} />
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('jenisdendas.edit', $jenisdenda->id_jenis_denda) }}"
                                    class="btn btn-sm btn-warning">
                                    <span class="fas fa-pencil-alt fs--2 me-1"></span>Edit
                                </a>
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
        function changeActiveDenda(id) {
            $.ajax({
                url: `/admin/jenis-denda/isactive/${id}`,
                type: 'POST',
                success: function(data) {
                    if (data.data.status === 'OK') {

                        window.location.reload()

                    }
                }
            })

        }
    </script>
@endsection
