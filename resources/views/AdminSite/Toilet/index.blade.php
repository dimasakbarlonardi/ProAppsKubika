@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-white">List Inspection HouseKeeping</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm " href="{{ route('housekeeping.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Parameter</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <div id="tableExample3" data-list='{"valueNames":["nama_hk_toilet"],"page":10,"pagination":true}'>
            <div class="row justify-content-end g-0">
                <div class="col-auto col-sm-5 mb-3">
                    <form>
                        <div class="input-group"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search..." aria-label="search" />
                            <div class="input-group-text bg-transparent"><span class="fa fa-search fs--1 text-600"></span></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table table-bordered table-striped fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="sort" data-sort="">No</th>
                            <th class="sort" data-sort="nama_hk_toilet">Inspection HouseKeeping Parameter</th>
                            <th class="sort">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($housekeeping as $key => $toilet)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td class="nama_hk_toilet">{{ $toilet->nama_hk_toilet }}</td>
                            <td>
                                <a href="{{ route('housekeeping.edit', $toilet->id_hk_toilet) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                                <!-- <form class="d-inline" action="{{ route('housekeeping.destroy', $toilet->id_hk_toilet) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')"><span class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                            </form> -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
            </div>
        </div>
    </div>
</div>
@endsection