@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('schedulesecurity.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Detail Schedule Security</div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <form method="post" action="{{ route('schedulesecurity.update', $ScheduleSecurity->id) }}">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Location</label>
                    <select class="form-control editable" name="id_room" id="id_room" disabled>
                        <option selected disabled>-- Select Room --</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id_room }}" {{ $room->id_room == $ScheduleSecurity->id_room ? 'selected' : '' }}>
                           {{$room->tower->nama_tower}} - {{ $room->floor->nama_lantai }} - {{ $room->nama_room }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Schedule</label>
                    <input type="date" name="schedule" value="{{ $ScheduleSecurity->schedule }}" disabled class="form-control editable">
                </div>
                <div class="col-6">
                    <label class="form-label">Shift</label>
                    <select class="form-control editable" name="id_shift" id="id_shift" disabled>
                        <option selected disabled>-- Select Shift --</option>
                        @foreach ($shift as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $ScheduleSecurity->id_shift ? 'selected' : '' }}>
                            {{ $item->shift }} - ( {{ HumanTime($item->start_time) }}-{{ HumanTime($item->end_time) }} )
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <h4>Parameter Security</h4>
                <hr>
            </div>

            <div class="form-group">
                <div class="row d-flex justify-content-between">
                    <div class="col-5">
                        <select name="from[]" id="search" class="form-control editable" size="8" multiple="multiple" disabled>
                            @foreach ($parameters as $item)
                            @if (!isset($item->Checklist))
                            <option {{ !isset($item->Checklist) ? '' : 'disabled' }} value="{{ $item->id }}">
                                {{ $item->name_parameter_security }}
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
                        <select name="to[]" id="search_to" class="form-control editable" size="8" multiple="multiple" disabled>
                            @if ($checklistparameters)
                            @foreach ($checklistparameters as $item)
                            <option value="{{ $item->ChecklistSec->id }}">
                                {{ $item->ChecklistSec->name_parameter_security }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a class="btn btn-warning" id="button-cancel" style="display: none;">Cancel</a>
                <button type="submit" class="btn btn-success" style="display: none" id="button-update">Update</button>
            </div>
        </form>
        <div class="text-end">
            <a class="btn btn-primary" id="button-edit">Edit</a>
        </div>
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
                left: '<input type="text" name="q" class="form-control editable" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control editable" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length > 2;
            }
        });
    });
</script>

<script>
    var isEdit = false;
    $('document').ready(function() {
        $('#button-edit').on('click', function() {
            $('.editable').removeAttr('disabled');
            $('#button-edit').css('display', 'none')
            $('#button-update').css('display', 'inline')

            $('#button-back').css('display', 'none')
            $('#button-cancel').css('display', 'inline')
            $('#button-delete').css('display', 'none')
        })

        $('#button-cancel').on('click', function() {
            $('.form-control').prop('disabled', true);
            $('#button-edit').css('display', 'inline')
            $('#button-update').css('display', 'none')

            $('#button-back').css('display', 'inline')
            $('#button-cancel').css('display', 'none')
            $('#button-delete').css('display', 'inline')

        })
    })
</script>
@endsection