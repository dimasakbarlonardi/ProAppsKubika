@extends('auth.layout')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@section('content')
<div class="col-md-7 d-flex flex-center">
    <div class="p-4 p-md-5 flex-grow-1">
        <!-- <div class="row flex-between-center"> -->
        <div class="image mb-3"><img class="logo-colored" src="{{ asset('/assets/img/logo_colored.png') }}" /></div>
        <div class="col-auto mb-5">
            <h3 class="text-primary">Masuk Dashboard</h3>
            <div class="label">
                <p class="text-wrapper">Silahkan masuk menggunakan akun anda</p>
            </div>
        </div>
        <!-- </div> -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="card-email">Email
                    address
                </label>
                <input class="form-control" id="card-email" type="email" name="email" />
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input class="form-control" id="password-input" type="password" name="password" required>
                    <button id="toggle-password" type="button" class="btn btn-falcon-default">
                        <span class="far fa-eye" id="eye-icon"></span>
                    </button>

                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="card-password">Select Site</label>
                </div>
                <select name="id_site" id="" class="form-control">
                    <option value="004212">Park Royale</option>
                    <option value="008914">Central Point</option>
                </select>
            </div>
            <div class="my-5">
                <a class="text-black" href="{{ route('password.request') }}">Forgot Password ?</a>
            </div>

            <div class="my-5">
                <button class="btn btn-primary d-block w-100 mt-3" type="submit">Log
                    in</button>
            </div>
        </form>
    </div>
</div>
@endsection


@section('script')
<script>
    const passwordInput = document.getElementById('password-input');
    const togglePasswordButton = document.getElementById('toggle-password');
    const eyeIcon = document.getElementById('eye-icon');

    togglePasswordButton.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('far', 'fa-eye');
            eyeIcon.classList.add('far', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('far', 'fa-eye-slash');
            eyeIcon.classList.add('far', 'fa-eye');
        }
    });
</script>


@endsection