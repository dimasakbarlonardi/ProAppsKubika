@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto my-2">
                    <a href="{{ route('announcements.index') }}" class="btn btn-falcon-default btn-sm" type="button">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('announcements.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Announcement Title</label>
                            <input type="text" name="notif_title" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3 p-3">
                    <label class="form-label">Announcement Content</label>
                    <textarea class="form-control" name="notif_message" id="notif_message" cols="30" rows="10"></textarea>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Announcement Banner</label>
                            <input type="file" name="photo" id="input-photo" class="form-control">
                            <img id="new-banner" class="mt-3" />
                        </div>
                        <div class="col-6">
                            <label class="form-label">Announcement File</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a class="text-white btn btn-warning" style="margin-right: 10px"
                        href="{{ route('announcements.index') }}">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.tiny.cloud/1/mugoo4p5wbijt8fzvzj0042pz1zw9brcq34tenfqnw6wsro6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#notif_message', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });

        $('#input-photo').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#new-banner').attr({
                        'src': event.target.result,
                        'class': 'col-12 mt-4 img-thumbnail',
                    });
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
