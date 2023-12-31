<div class="card-body">
    <div class="mb-3">
        <label class="mb-1">Towers</label>
        <select class="form-control" name="id_tower">
            <option value="">All</option>
            @foreach ($towers as $tower)
                <option {{ Request::input('id_tower') == $tower->id_tower ? 'selected' : '' }}
                    value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="mb-1">Status</label>
        <select class="form-control" name="select_status">
            <option value="">All</option>
            <option {{ Request::input('select_status') == '0' ? 'selected' : '' }} value="0">Pending
            </option>
            <option {{ Request::input('select_status') == '1' ? 'selected' : '' }} value="1">Approved
            </option>
        </select>
    </div>
    <div class="mb-4">
        <label class="mb-1">Periode</label>
        <div class="row">
            <div class="col-6">
                <select class="form-control" name="select_period">
                    <option {{ Request::input('select_period') == '01' ? 'selected' : '' }} value="01">January</option>
                    <option {{ Request::input('select_period') == '02' ? 'selected' : '' }} value="02">February</option>
                    <option {{ Request::input('select_period') == '03' ? 'selected' : '' }} value="03">March</option>
                    <option {{ Request::input('select_period') == '04' ? 'selected' : '' }} value="04">April</option>
                    <option {{ Request::input('select_period') == '05' ? 'selected' : '' }} value="05">May</option>
                    <option {{ Request::input('select_period') == '06' ? 'selected' : '' }} value="06">June</option>
                    <option {{ Request::input('select_period') == '07' ? 'selected' : '' }} value="07">July</option>
                    <option {{ Request::input('select_period') == '08' ? 'selected' : '' }} value="08">August</option>
                    <option {{ Request::input('select_period') == '09' ? 'selected' : '' }} value="09">September</option>
                    <option {{ Request::input('select_period') == '10' ? 'selected' : '' }} value="10">October</option>
                    <option {{ Request::input('select_period') == '11' ? 'selected' : '' }} value="11">November</option>
                    <option {{ Request::input('select_period') == '12' ? 'selected' : '' }} value="12">December</option>
                </select>
            </div>
            <div class="col-6">
                <select class="form-control" name="select_year">
                    <option {{ Request::input('select_year') == '2024' ? 'selected' : '' }} value="2024">2024</option>
                    <option {{ Request::input('select_year') == '2023' ? 'selected' : '' }} value="2023">2023</option>
                    <option {{ Request::input('select_year') == '2022' ? 'selected' : '' }} value="2022">2022</option>
                    <option {{ Request::input('select_year') == '2021' ? 'selected' : '' }} value="2021">2021</option>
                    <option {{ Request::input('select_year') == '2020' ? 'selected' : '' }} value="2020">2020</option>
                    <option {{ Request::input('select_year') == '2019' ? 'selected' : '' }} value="2019">2019</option>
                </select>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn w-100 btn-success">Apply</button>
    </div>
    <a href="{{ route('usr-electric') }}" class="btn w-100 btn-danger">Reset</a>
</div>
