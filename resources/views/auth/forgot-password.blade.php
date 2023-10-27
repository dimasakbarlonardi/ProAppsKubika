@extends('auth.layout')

@section('content')
<div class="col-md-7 d-flex flex-center">
    <div class="p-4 p-md-5 flex-grow-1">
        <!-- <div class="row flex-between-center"> -->
        <div class="image mb-3"><img class="logo-colored" src="{{ asset('/assets/img/logo_colored.png') }}" /></div>
        <div class="col-auto mb-5">
            <h3 class="text-primary">Reset Password</h3>
            <div class="label">
                <p class="text-wrapper">Please fill in your E-Mail</p>
            </div>
        </div>
        <!-- </div> -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="card-email">Email
                    address
                </label>
                <input class="form-control" id="card-email" type="email" name="email" value="" required />
            </div>
            <div class="my-5">
                <button class="btn btn-primary d-block w-100 mt-3" type="submit">Password Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection

