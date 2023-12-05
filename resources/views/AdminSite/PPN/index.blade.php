@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0">List PPN</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="nama_ipl_type">Nama PPN</th>
                        <th class="sort" data-sort="biaya_procentage">Biaya Procentage</th>
                        <th>Status</th>
                        <th class="sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ppns as $key => $ppn)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $ppn->nama_ppn }}</td>
                            <td>{{ $ppn->biaya_procentage ? persen($ppn->biaya_procentage) : '-' }} </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="isActivePPN{{ $ppn->id_ppn }}"
                                        onclick="changeActivePPN({{ $ppn->id_ppn }})" type="checkbox"
                                        {{ $ppn->is_active ? 'checked' : '' }} />
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('ppns.edit', $ppn->id_ppn) }}" class="btn btn-sm btn-warning"><span
                                        class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                                <form class="d-inline" action="{{ route('ppns.destroy', $ppn->id_ppn) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('are you sure?')"><span
                                            class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                                </form>
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
        function changeActivePPN(id) {
            $.ajax({
                url: `/admin/ppn/isactive/${id}`,
                type: 'POST',
                success: function(data) {
                    if (data.data.status === 'OK') {

                        window.location.reload();
                    }
                }
            })

        }
    </script>
@endsection
