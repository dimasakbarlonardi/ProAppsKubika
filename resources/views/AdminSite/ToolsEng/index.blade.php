@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Tools Engineering</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('toolsengineering.create') }}"><span
                            class="fas fa-plus fs--2 me-1"></span>Create Tools Engineering</a>
                </div>
            </div>
        </div>
        <div class="p-5 justify-content-center">
            <table class="table table-striped" id="table-toolseng">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="name_tools">Tools</th>
                        <th class="sort" data-sort="status">Stock</th>
                        <th class="sort" data-sort="status">Out</th>
                        <th class="sort" data-sort="date_out">Current Stock</th>
                        <th class="sort" data-sort="borrower">Borrower</th>
                        <th class="sort" data-sort="status">Status</th>
                        <th class="sort" data-sort="action">Action</th>
                    </tr>
                </thead>
                <tbody id="checklist_body">
                    @foreach ($toolsengineer as $key => $tools)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $tools->name_tools }}</td>
                            <td>{{ $tools->total_tools }}</td>
                            <td>
                                @empty($tools->borrow)
                                    -
                                @else
                                    {{ $tools->borrow }}
                                @endempty
                            </td>
                            <td>
                                @empty($tools->current_totals)
                                    -
                                @else
                                    {{ $tools->current_totals }}
                                @endempty
                            </td>
                            <td>
                                @foreach ($idusers as $iduser)
                                    @empty($tools->borrow)
                                        -
                                    @else
                                        {{ $iduser->name }}
                                    @endempty
                                @endforeach
                            </td>
                            <td>
                                @if ($tools->status == 0)
                                    <span class="badge rounded-pill badge-subtle-success">Item Completed</span>
                                @elseif ($tools->status == 1)
                                    <span class="badge rounded-pill badge-subtle-warning">Item Not Completed</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="dropdown font-sans-serif position-static">
                                    <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="dropdown"
                                        data-boundary="window" aria-haspopup="true" aria-expanded="false">
                                        <span class=""></span>Borrow / Return
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0">
                                        <div class="py-2">
                                            @if ($tools->status == 0)
                                            @elseif ($tools->status == 1)
                                                <a class="dropdown-item" href="#">
                                                    <form action="{{ route('return.tool', ['id' => $tools->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <input class="form-control" type="number" name="return_qty"
                                                                    required>
                                                            </div>
                                                            <div class="col-4">
                                                                <button class="btn btn-warning btn-sm" type="submit"
                                                                    id="return_qty">Return</button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="date_out"
                                                            value="{{ $tools->date_out }}">
                                                    </form>
                                                </a>
                                            @endif
                                            <a class="dropdown-item text-danger" href="#">
                                                <form action="{{ route('borrow.tool', ['id' => $tools->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <input class="form-control" type="number" name="borrow_qty"
                                                                required id="borrow_qty">
                                                        </div>
                                                        <div class="col-4">
                                                            <button class="btn btn-success btn-sm"
                                                                type="submit">Borrow</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </a>
                                        </div>
                                    </div>
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
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-toolseng');
    </script>
@endsection
