@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('schedulesecurity.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Schedule Security</div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <form method="post" action="{{ route('schedulesecurity.store') }}">
            @csrf
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Location</label>
                    <select class="form-control" name="id_room" required>
                        <option selected disabled>-- Select Location --</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id_room }}">{{ $room->tower->nama_tower }} - {{ $room->nama_room }} - {{ $room->floor->nama_lantai}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Schedule</label>
                    <input type="datetime-local" name="schedule" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Shift</label>
                    <select class="form-control" name="id_shift" required>
                        <option selected disabled>-- Select Shift --</option>
                        @foreach ($shifts as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->shift }} - ( {{ $shift->start_time }}-{{ $shift->end_time }} )</option>
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
                        <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                            @foreach ($ParameterSecurity as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name_parameter_security }}
                            </option>
                            {{-- @if ($item->subMenus)
                                        @foreach ($item->subMenus as $subMenu)
                                            <option value="sub_menus|{{ $subMenu->kode_form }}|{{ $subMenu->id }}">
                            {{ $item->caption }} > {{ $subMenu->caption }}
                            </option>
                            @if ($subMenu->subMenus2)
                            @foreach ($subMenu->subMenus2 as $subMenu2)
                            <option value="sub_menus2|{{ $subMenu2->kode_form }}|{{ $subMenu2->id }}">
                                {{ $subMenu->caption }} > {{ $subMenu2->caption }}
                            </option>
                            @endforeach
                            @endif
                            @endforeach
                            @endif --}}
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
                            {{-- @foreach ($selected_menus as $item)
                                <option value="menus|{{ $item->id_eng_ahu }}">
                            {{ $item->name_parameter_security }}
                            </option>
                            @if ($item->subMenus)
                            @foreach ($item->subMenus as $subMenu)
                            <option value="sub_menus|{{ $subMenu->kode_form }}|{{ $subMenu->id }}">
                                {{ $item->caption }} > {{ $subMenu->caption }}
                            </option>
                            @if ($subMenu->subMenus2)
                            @foreach ($subMenu->subMenus2 as $subMenu2)
                            <option value="sub_menus2|{{ $subMenu2->kode_form }}|{{ $subMenu2->id }}">
                                {{ $subMenu->caption }} > {{ $subMenu2->caption }}
                            </option>
                            @endforeach
                            @endif
                            @endforeach
                            @endif
                            @endforeach --}}
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Submit</button>
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