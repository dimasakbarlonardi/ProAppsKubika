<div id="gigo_form" style="display: none">
    <div class="my-3">
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Driver</label>
                    <input type="text" class="form-control" id="nama_pembawa">
                </div>
                <div class="col-6">
                    <label class="form-label">No Car Plate</label>
                    <input type="text" class="form-control" id="no_pol_pembawa">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Gigo Time</label>
                    <input class="form-control datetimepicker" required value="" name="date_request_gigo"
                        id="date_request_gigo" type="text" placeholder="d/m/y H:i"
                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                </div>
                <div class="col-6">
                    <label class="form-label">Gigo Type</label>
                    <select name="gigo_type" class="form-control" id="gigo_type">
                        <option value="In">In</option>
                        <option value="Out">Out</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="detail_gigo" class="mt-3">
        <div class="card mt-2">
            <div class="card-body">
                <div class="card-body p-0">
                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                        <div class="col-9 col-md-8 py-2">List Items</div>
                    </div>

                    <div id="detailGoods">
                    </div>

                    <hr>
                    <div class="row gx-card mx-0">
                        <div class="col-8 py-3">
                            <label class="mb-1">Nama barang</label>
                            <input class="form-control" type="text" id="input_nama_barang">
                        </div>
                        <div class="col-4 mt-3">
                            <label class="mb-1">Jumlah barang</label>
                            <input class="form-control" type="number" id="input_jumlah_barang">
                        </div>
                        <div class="col-12 gx-card mx-0 mb-3">
                            <label class="mb-1">Keterangan</label>
                            <input class="form-control" type="text" id="input_keterangan">
                        </div>
                    </div>
                    <div class="text-end mr-5">
                        <button type="button" class="btn btn-primary mt-3" onclick="onAddBarang()">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    flatpickr("#date_request_gigo", {
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        enableTime: true,
        altInput: true,
        altFormat: "F j, Y - H:i"
    });

    var lastID = 0;
    var goods = [];
    var idGood = 0;

    function onAddBarang() {
        var namaBarang = $('#input_nama_barang').val();
        var jumlahBarang = parseInt($('#input_jumlah_barang').val());
        var keterangan = $('#input_keterangan').val();

        if (!namaBarang || !jumlahBarang) {
            Swal.fire(
                'Failed!',
                'Please fill all field',
                'error'
            )
        } else {
            lastID += 1;

            if (namaBarang !== '' && jumlahBarang !== null) {
                $('#nama_barang').val('');
                $('#jumlah_barang').val('');
                $('#keterangan').val('');

                let good = {
                    'id': lastID,
                    'nama_barang': namaBarang,
                    'jumlah_barang': jumlahBarang,
                    'keterangan': keterangan ? keterangan : '-',
                }
                goods.push(good);
                detailGoods();
                $('#input_nama_barang').val('');
                $('#input_jumlah_barang').val('');
                $('#input_keterangan').val('');
            }
        }
    }

    function onRemoveGood(id) {
        console.log(id);
        idGood -= 1;
        goods.splice(id, 1);
        detailGoods();
    }

    function detailGoods() {
        $('#detailGoods').html('');
        goods.map((item, i) => {
            $('#detailGoods').append(
                `<div class='row gx-card mx-0 align-items-center border-bottom border-200' id="good${item.id}">
                    <div class='col-8 py-3'>
                        <div class='d-flex align-items-center'>
                            <div class='flex-1'>
                                <table>
                                    <tr>
                                        <td><b>Nama barang</b></td>
                                        <td class="mr-5">&ensp;:&ensp;</td>
                                        <td>${item.nama_barang}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Jumlah barang</b></td>
                                        <td class="mr-5">&ensp;:&ensp;</td>
                                        <td>${item.jumlah_barang}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Keterangan barang</b></td>
                                        <td class="mr-5">&ensp;:&ensp;</td>
                                        <td>${item.keterangan}</td>
                                    </tr>
                                </table>
                                <div class='fs--2 fs-md--1'>
                                    <a class='text-danger' onclick='onRemoveGood(${i})'>Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            )
        })
    }

    function gigoValue() {
        dateRequestGigo = $('#date_request_gigo').val();
        noPolPembawa = $('#no_pol_pembawa').val();
        namaPembawa = $('#nama_pembawa').val();
        gigoType = $('#gigo_type').val();

        var value = {
            'dateRequestGigo': dateRequestGigo,
            'noPolPembawa': noPolPembawa,
            'namaPembawa': namaPembawa,
            'gigoType': gigoType,
        }

        if (!dateRequestGigo || !noPolPembawa ||
            !namaPembawa || !gigoType) {
            return;
        } else {
            return value;
        }
    }
</script>
