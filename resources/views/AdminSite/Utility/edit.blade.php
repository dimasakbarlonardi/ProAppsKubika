@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('utilitys.index')}}" class="text-white"> List Utility</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Utility</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('utilitys.update', $utility->id_utility) }}">
                @method('PUT')
                @csrf   
                <div class="mb-3">
                <div class="row">
                    <div class="col-6 ">
                    <label class="form-label">Nama Utility</label>
                    <input type="text" name="nama_utility" value="{{ $utility->nama_utility}}" class="form-control">
                </div>
                </div>
                <div class="row mt-4">
                <h6> ISI BIAYA <hr></h6>
                <div class="col-6 mt-3 ">
                    <label class="form-label">Biaya Admin</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" name="biaya_admin" value="{{ $utility->biaya_admin}}" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
                </div>
                <div class="col-6 mt-3 ">
                    <label class="form-label">Biaya Abodemen</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" name="biaya_abodemen" value="{{ $utility->biaya_abodemen}}" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
                </div>
                <div class="col-6 mt-3 ">
                    <label class="form-label">Biaya Tetap</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" name="biaya_tetap" value="{{ $utility->biaya_tetap}}" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
                </div>
                <div class="col-6 mt-3 ">
                    <label class="form-label">Biaya M3</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" name="biaya_m3" value="{{ $utility->biaya_m3}}" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
                </div>
                <div class="col-6 mt-3 ">
                    <label class="form-label">Biaya PJU</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" name="biaya_pju" value="{{ $utility->biaya_pju}}" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
                </div>
                <div class="col-6 mt-3 ">
                    <label class="form-label">Biaya PPJ</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" name="biaya_ppj" value="{{ $utility->biaya_ppj}}" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">Rupiah</span></div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button class="btn btn-danger"><a class="text-white" href="{{ route('utilitys.index')}}">Cancel</a></button>
        </div>
    </div>
            </form>
        </div>
    </div>
@endsection
