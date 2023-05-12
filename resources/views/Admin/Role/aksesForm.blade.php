@extends('layouts.master')

@section('header')
   Role
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="form-group">
                            <h4 class="m-t-0 header-title">
                                <b>Data Permission</b>
                            </h4>
                            {{ Form::open() }}
                            <div class="row d-flex justify-content-between">
                                <div class="col-5">
                                    <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                                        {{-- @foreach($data->permissions as $d)
                                            <option value="{{$d->id}}">{{$d->name}} - {{$d->caption}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>

                                <div class="col-1 text-center">
                                    <button type="button" id="search_rightAll" class="btn btn-primary mb-2"> < </button>
                                    <button type="button" id="search_rightSelected" class="btn btn-primary mb-2"> << </button>
                                    <button type="button" id="search_leftSelected" class="btn btn-primary mb-2"> > </button>
                                    <button type="button" id="search_leftAll" class="btn btn-primary mb-2"> >> </button>
                                </div>

                                <div class="col-5">
                                    <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple">
                                        {{-- @foreach($permissions as $nd)
                                            <option value="{{$nd->id}}">{{$nd->name}} - {{$nd->caption}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <button id="btn-add" type="submit" class="btn btn-info btn-block d-lg pull-left mt-3">
                                        <i class="fa fa-check"></i>Save
                                    </button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/crlcu_multiselect.min.js') }}"></script>
    <script>
        console.log('asd')
    </script>
    <script>
        $('document').ready(function(){
            $('#search').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Selected Permission" />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Search Permission" />',
                },
                fireSearch: function(value) {
                    return value.length >= 3;
                }
            });


            $('.govisform').on('submit', function(event){
                event.preventDefault();
                this.submit();
                // var checked = $('input[type=checkbox]:checked').length;
                // if(checked > 0 ){
                //     this.submit();
                // }else{
                //     swal({
                //         type: "error",
                //         title: "Delete Permission",
                //         text: "Please Select permission first before submitting",
                //         timer: 3000,
                //     });
                // }
            });
        });
    </script>
@endsection
