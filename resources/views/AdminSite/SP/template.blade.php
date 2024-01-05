@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit User</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('update-company-setting') }}" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3 btn-reveal-trigger">
                    <div class="card-header position-relative min-vh-25 mb-8">
                        <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                                <img id="newavatar" src=""
                                    width="200" alt="Upload Foto">
                                <input class="d-none" name="company_logo" id="input-file" type="file">
                                <label class="mb-0 overlay-icon d-flex flex-center" for="input-file">
                                    <span class="bg-holder overlay overlay-0"></span>
                                    <span class="z-1 text-white dark__text-white text-center fs--1">
                                        <svg class="svg-inline--fa fa-camera fa-w-16" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="camera" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z">
                                            </path>
                                        </svg>
                                        <span class="d-block">Update</span></span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="company_name"
                        value="" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Company Address</label>
                    <textarea name="company_address" class="form-control" id="company_address" cols="30" rows="10"></textarea>
                </div>
                <div class="mt-5">
                    <div class="row">
                        <div class="col-6">
                            <hr>
                            <div class="row d-flex align-items-center">
                                <div class="col-auto">
                                    <h4>Split Invoice</h4>
                                    <small>Split invoice Service Charge & Utility</small>
                                </div>
                                <div class="col-auto">
                                    <div class="form-check form-switch align-middle">
                                        <input class="form-check-input" onclick="changeSplitAR()" type="checkbox"
                                             />
                                        <label class="align-middle"
                                            for=""></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="mt-5 modal-footer">
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    <button type="button" class="btn btn-warning" style="display: none"
                        id="button-cancel">Cancel</button>
                    <button type="button" class="btn btn-primary" id="button-edit">Edit</button>
                    <button type="submit" class="btn btn-success ml-3" style="display: none"
                        id="button-update">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#company_address', // Replace this CSS selector to match the placeholder element for TinyMCE
            menubar: false,
            toolbar: false,
            height: "180",
        });

        function changeSplitAR() {
            $.ajax({
                url: `/admin/system/split-ar`,
                type: 'POST',
                success: function(data) {
                    console.log(data)
                    if (data.status === 'ok') {
                        window.location.reload()
                    }
                }
            })

        }

        $('#input-file').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#newavatar').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $('document').ready(function() {
            $('#button-edit').on('click', function() {
                $('.form-control').removeAttr('disabled');
                $('#button-edit').css('display', 'none')
                $('#button-update').css('display', 'inline')

                $('#button-back').css('display', 'none')
                $('#button-cancel').css('display', 'inline')
            })

            $('#button-cancel').on('click', function() {
                $('.form-control').prop('disabled', true);
                $('#button-edit').css('display', 'inline')
                $('#button-update').css('display', 'none')

                $('#button-back').css('display', 'inline')
                $('#button-cancel').css('display', 'none')
            })
        })
    </script>
@endsection
