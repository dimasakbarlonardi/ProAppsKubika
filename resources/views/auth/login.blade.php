@extends('auth.layout')

@section('content')
    <div class="col-md-7 d-flex flex-center">
        <div class="p-4 p-md-5 flex-grow-1">
            <div class="row flex-between-center">
                <div class="col-auto mb-5">
                    <h3 class="text-primary">Login</h3>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="card-email">Email
                        address
                    </label>
                    <input class="form-control" id="card-email" type="email" name="email" />
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="card-password">Password</label>
                    </div>
                    <input class="form-control" id="card-password" type="password" name="password" />
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
                    <button class="btn btn-primary d-block w-100 mt-3" type="submit">Log
                        in</button>
                </div>
            </form>
        </div>
    </div>
@endsection
