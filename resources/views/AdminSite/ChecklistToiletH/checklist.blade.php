@extends('layouts.master')

@section('content')
    <div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('checklisttoilets.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Detail Parameter</div>
            </div>
        </div>
    </div>
        <div class="p-5">
            <form action="{{ route('checklistParameterHK' , $id) }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="row d-flex justify-content-between">
                        <div class="col-5">
                            <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                                @foreach ($parameters as $item)
                                    @if (!isset($item->Checklist))
                                        <option {{ !isset($item->Checklist) ? '' : 'disabled' }} value="{{ $item->id_hk_toilet }}">
                                            {{ $item->nama_hk_toilet }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-1 text-center">
                            <button type="button" id="search_rightAll" class="btn btn-primary my-3"> >>
                            </button> <br>
                            <button type="button" id="search_rightSelected" class="btn btn-primary mb-3"> >
                            </button> <br>
                            <button type="button" id="search_leftSelected" class="btn btn-primary mb-3">
                                < </button> <br>
                                    <button type="button" id="search_leftAll" class="btn btn-primary mb-3">
                                        << </button> <br>
                        </div>
                        <div class="col-5">
                            <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple">
                                @if ($checklistparameters)
                                    @foreach ($checklistparameters as $item)
                                        <option value="{{ $item->ChecklistHK->id_hk_toilet  }}">
                                            {{ $item->ChecklistHK->nama_hk_toilet }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
        < script src = "https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity = "sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin = "anonymous" >
    </script>
    <script src="{{ asset('assets/js/crlcu_multiselect.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            $('#search').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                },
                fireSearch: function(value) {
                    return value.length > 2;
                }
            });
        });
    </script>
@endsection
