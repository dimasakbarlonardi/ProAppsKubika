<div id="request-permit-form" style="display: none">
    <h4 class="mt-5">Request Permit</h4>
    <hr>
    <div class="">
        <div class="p-4">
            <div class="form-check">
                <input class="form-check-input" value="1" id="id_jenis_pekerjaan" type="radio" name="id_jenis_pekerjaan" checked/>
                <label class="form-check-label">Renovasi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" value="4" id="id_jenis_pekerjaan" type="radio" name="id_jenis_pekerjaan"/>
                <label class="form-check-label">Service / Perbaikan</label>
            </div>
        </div>
        <div class="my-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Nama Kontraktor</label>
                    <input type="text" class="form-control" id="nama_kontraktor">
                </div>
                <div class="col-6">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" class="form-control" id="pic">
                </div>
            </div>
        </div>
        <div class="mb-3 p-3">
            <label class="form-label">Alamat Kontraktor</label>
            <textarea class="form-control" id="alamat" cols="20" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">No KTP</label>
                    <input type="text" class="form-control" id="no_ktp" maxlength="16">
                </div>
                <div class="col-6">
                    <label class="form-label">No Telp</label>
                    <input type="text" class="form-control" id="no_telp">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="mb-1">Mulai Pengerjaan</label>
                    <input class="form-control datetimepicker" id="tanggal_mulai" type="text" placeholder="d/m/y H:i"
                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                </div>
                <div class="col-6">
                    <label class="mb-1">Tanggal Akhir Pengerjaan</label>
                    <input class="form-control datetimepicker" id="tanggal_akhir" type="text" placeholder="d/m/y H:i"
                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                </div>
            </div>
        </div>
        <div class="mb-3 p-3">
            <label class="form-label">Keterangan Pekerjaan</label>
            <textarea class="form-control" id="keterangan_pekerjaan" cols="20" rows="5"></textarea>
        </div>
    </div>
    <div id="ticket_permit" class="mt-3">
        <div class="card mt-2">
            <div class="card-body">
                <div class="card-body p-0">
                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                        <div class="col-9 col-md-8 py-2">Personil</div>
                    </div>
                    <div id="detailPersonels">

                    </div>
                    <div class="row gx-card mx-0 border-bottom border-200">
                        <div class="col-9 py-3">
                            <input class="form-control" type="text" id="nama_personil">
                        </div>
                        <div class="col-3 ">
                            <button type="button" class="btn btn-primary mt-3"
                                onclick="onAddPersonel()">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="card-body p-0">
                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                        <div class="col-9 col-md-8 py-2">Nama Alat</div>
                    </div>
                    <div id="detailAlats">

                    </div>
                    <div class="row gx-card mx-0 border-bottom border-200">
                        <div class="col-9 py-3">
                            <input class="form-control" type="text" id="nama_alat">
                            <small class="text-danger">
                                <i>
                                    *Harap masukan nama beserta jumlah banyaknya barang
                                </i>
                            </small>
                        </div>
                        <div class="col-3 ">
                            <button type="button" class="btn btn-primary mt-3" onclick="onAddAlat()">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="card-body p-0">
                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                        <div class="col-9 col-md-8 py-2">Material</div>
                    </div>
                    <div id="detailMaterials">

                    </div>
                    <div class="row gx-card mx-0 border-bottom border-200">
                        <div class="col-9 py-3">
                            <input class="form-control" type="text" id="material">
                            <small class="text-danger">
                                <i>
                                    *Harap masukan nama beserta jumlah banyaknya barang
                                </i>
                            </small>
                        </div>
                        <div class="col-3 ">
                            <button type="button" class="btn btn-primary mt-3"
                                onclick="onAddMaterial()">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    flatpickr("#tanggal_mulai", {
        dateFormat: "Y-m-d H:i",
        enableTime: true,
        minDate: "today",
        altInput: true,
        altFormat: "F j, Y - H:i"
    });
    flatpickr("#tanggal_akhir", {
        dateFormat: "Y-m-d H:i",
        enableTime: true,
        minDate: "today",
        altInput: true,
        altFormat: "F j, Y - H:i"
    });
</script>
<script>
    var personels = [];
    var idPersonel = 0;
    var alats = [];
    var idAlat = 0;
    var materials = [];
    var idMaterial = 0;

    function onAddPersonel() {
        var lastID = 0;
        var namaPersonel = $('#nama_personil').val();

        lastID += 1;

        let personel = {
            'id': lastID,
            nama_personil: namaPersonel,
        }


        if (namaPersonel !== '') {
            personels.push(personel);

            $('#nama_personil').val('');
            detailPersonels();
        }
    }

    function detailPersonels() {
        $('#detailPersonels').html('');
        personels.map((item, i) => {
            $('#detailPersonels').append(
                `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                    <div class='col-8 py-3'>
                        <div class='d-flex align-items-center'>
                            <div class='flex-1'>
                                <h5 class='fs-0'>
                                    <span class='text-900' href=''>
                                        ${item.nama_personil}
                                    </span>
                                </h5>
                                <div class='fs--2 fs-md--1'>
                                    <a class='text-danger' onclick='onRemovePersonel(${i})'>Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            )
        })
    }

    function onRemovePersonel(id) {
        idPersonel -= 1;

        personels.splice(id, 1)
        detailPersonels()
    }

    function onAddAlat() {
        var lastID = 0;
        var namaAlat = $('#nama_alat').val();

        lastID += 1;

        let alat = {
            'id': lastID,
            nama_alat: namaAlat,
        }


        if (namaAlat !== '') {
            alats.push(alat);

            $('#nama_alat').val('');
            detailAlats();
        }
    }

    function detailAlats() {
        $('#detailAlats').html('');
        alats.map((item, i) => {
            $('#detailAlats').append(
                `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                    <div class='col-8 py-3'>
                        <div class='d-flex align-items-center'>
                            <div class='flex-1'><h5 class='fs-0'>
                                <h5 class='fs-0'>
                                    <span class='text-900' href=''>
                                        ${item.nama_alat}
                                    </span>
                                </h5>
                                <div class='fs--2 fs-md--1'>
                                    <a class='text-danger' onclick='onRemoveAlat(${i})'>Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            )
        })
    }

    function onRemoveAlat(id) {
        idAlat -= 1;

        alats.splice(id, 1)
        detailAlats()
    }

    function onAddMaterial() {
        var lastID = 0;
        var namaMaterial = $('#material').val();

        lastID += 1;

        let material = {
            'id': lastID,
            material: namaMaterial,
        }


        if (namaMaterial !== '') {
            materials.push(material);

            $('#material').val('');
            detailMaterials();
        }
    }

    function detailMaterials() {
        $('#detailMaterials').html('');
        materials.map((item, i) => {
            $('#detailMaterials').append(
                `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                    <div class='col-8 py-3'>
                        <div class='d-flex align-items-center'>
                            <div class='flex-1'><h5 class='fs-0'>
                                <h5 class='fs-0'>
                                    <span class='text-900' href=''>
                                        ${item.material}
                                    </span>
                                </h5>
                                <div class='fs--2 fs-md--1'>
                                    <a class='text-danger' onclick='onRemoveMaterial(${i})'>Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            )
        })
    }

    function onRemoveMaterial(id) {
        idMaterial -= 1;

        materials.splice(id, 1)
        detailMaterials()
    }

    function valueRequestPermit() {
        var nama_kontraktor = $('#nama_kontraktor').val();
        var pic = $('#pic').val();
        var alamat = $('#alamat').val();
        var keterangan_pekerjaan = $('#keterangan_pekerjaan').val();
        var no_ktp = $('#no_ktp').val();
        var no_telp = $('#no_telp').val();
        var tgl_mulai = $('#tanggal_mulai').val();
        var tgl_akhir = $('#tanggal_akhir').val();
        var id_jenis_pekerjaan = $('#id_jenis_pekerjaan').val();

        var value = {
            'nama_kontraktor': nama_kontraktor,
            'pic': pic,
            'alamat': alamat,
            'keterangan_pekerjaan': keterangan_pekerjaan,
            'no_ktp': no_ktp,
            'no_telp': no_telp,
            'tgl_mulai': tgl_mulai,
            'tgl_akhir': tgl_akhir,
            'id_jenis_pekerjaan': id_jenis_pekerjaan,
        }

        if (!nama_kontraktor || !pic ||
            !alamat || !no_ktp ||
            !no_telp || !tgl_mulai || !tgl_akhir) {
            return;
        } else {
            return value;
        }
    }
</script>
