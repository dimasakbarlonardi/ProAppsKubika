@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto d-flex my-2 align-items-center">
                    <a href="{{ route('toolshousekeeping.index') }}" class="btn btn-falcon-default btn-sm" style="margin-right: 15px" type="button">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                    <h6 class="my-3 text-light">Create Tools HouseKeeping</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('toolshousekeeping.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-6 mb-3">
                        <label class="form-label">Tools Name</label>
                        <input type="text" name="name_tools" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Total Tools</label>
                        <div class="input-group">
                            <input type="number" name="total_tools" class="form-control" min="0" required>
                            <select name="unity" id="" class="form-control">
                                <option value="Tube">Tube</option>
                                <option value="Pcs">Pcs</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
