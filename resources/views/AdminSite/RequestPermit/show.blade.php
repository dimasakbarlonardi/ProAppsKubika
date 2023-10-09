@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row g-3">
        <div class="col-9">
            <div class="card">
                <div class="card-header d-flex flex-between-center">
                    <button class="btn btn-falcon-default btn-sm" type="button">
                        <span class="fas fa-arrow-left"></span>
                    </button>
                </div>
            </div>
            <div class="card mt-3" id="ticket_detail">
                <div class="card-body">
                    <div class="request" id="ticket_head">
                        <div class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle" src="{{ $rp->Ticket->Tenant->profile_picture }}"
                                        alt="{{ $rp->Ticket->Tenant->profile_picture }}" />
                                </div>
                                <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                        href="#">{{ $rp->Ticket->Tenant->nama_tenant }}</a>
                                    <a class="mb-0 fs--1 d-block text-500"
                                        href="mailto:{{ $rp->Ticket->Tenant->email_tenant }}">{{ $rp->Ticket->Tenant->email_tenant }}</a>
                                </p>
                            </div>
                            <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">
                                {{ HumanDate($rp->created_at) }}
                                <span class="mx-1">|</span><span class="fst-italic">{{ HumanTime($rp->created_at) }}
                                    ({{ TimeAgo($rp->created_at) }})</span>
                            </p>
                        </div>
                    </div>
                    <div class="pt-4">
                        <h6 class="mb-3 fw-semi-bold text-1000" id="ticket_detail_heading">{{ $rp->Ticket->judul_request }}
                        </h6>
                        <div id="ticket_detail_desc">
                            {!! $rp->Ticket->deskripsi_request !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3" id="permit_detail">
                <div class="card-header">
                    <h6 class="mb-0">Detail Request Permit</h6>
                </div>
                <div class="px-5">
                    <div class="my-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Kontraktor</label>
                                <input type="text" class="form-control" id="nama_kontraktor"
                                    value="{{ $rp->nama_kontraktor }}" disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Penanggung Jawab</label>
                                <input type="text" class="form-control" id="pic" value="{{ $rp->pic }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" cols="20" rows="5" disabled>{{ $rp->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">No KTP</label>
                                <input type="text" class="form-control" id="no_ktp" value="{{ $rp->no_ktp }}"
                                    disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label">No Telp</label>
                                <input type="text" class="form-control" id="no_telp" value="{{ $rp->no_telp }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="mb-1">Mulai Pengerjaan</label>
                                <input class="form-control" value="{{ HumanDateTime($rp->tgl_mulai) }}" disabled />
                            </div>
                            <div class="col-6">
                                <label class="mb-1">Tanggal Akhir Pengerjaan</label>
                                <input class="form-control" value="{{ HumanDateTime($rp->tgl_akhir) }}" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan Pekerjaan</label>
                        <textarea class="form-control" id="alamat" cols="20" rows="5" disabled>{{ $rp->keterangan_pekerjaan }}</textarea>
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
                                        @foreach ($personels as $personel)
                                            <input class="form-control mb-3" type="text"
                                                value="{{ $personel->nama_personil }}" id="nama_personil" disabled>
                                        @endforeach
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
                                <div class="row gx-card mx-0 border-bottom border-200">
                                    <div class="col-9 py-3">
                                        @foreach ($alats as $alat)
                                            <input class="form-control mb-3" type="text"
                                                value="{{ $alat->nama_alat }}" id="nama_alat" disabled>
                                        @endforeach
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
                                <div class="row gx-card mx-0 border-bottom border-200">
                                    <div class="col-9 py-3">
                                        @foreach ($materials as $material)
                                            <input class="form-control mb-3" type="text"
                                                value="{{ $material->material }}" id="nama_material" disabled>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="row g-3 position-sticky top-0">
                <div class="col-md-6 col-xl-12 rounded-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Properties</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 mt-n2"><label class="mb-1">Ticket</label>
                                <input class="form-control" type="text" id="material"
                                    value="{{ $rp->Ticket->no_tiket }}" disabled>
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Jenis Pekerjaan</label>
                                <input class="form-control" type="text" id="material"
                                    value="{{ $rp->JenisPekerjaan->jenis_pekerjaan }}" disabled>
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Status</label>
                                <input class="form-control" type="text" id="material"
                                    value="{{ $rp->status_request }}" disabled>
                            </div>
                        </div>
                        @if ($rp->status_request == 'APPROVED' && $rp->sign_approval_1)
                            <div class="card-footer border-top border-200 py-x1">
                                <a href="{{ route('work-permits.create') }}" class="btn btn-primary w-100">Buat Work Permit</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
    <script>
        var personels = [];
        var idPersonel = 0;
        var alats = [];
        var idAlat = 0;
        var materials = [];
        var idMaterial = 0;

        function submitWorkPermit() {
            var no_tiket = $('#select_ticket').val();
            var id_jenis_pekerjaan = $('#id_jenis_pekerjaan').val();
            var keterangan_pekerjaan = $('#keterangan_pekerjaan').val();
            var nama_kontraktor = $('#nama_kontraktor').val();
            var pic = $('#pic').val();
            var alamat = $('#alamat').val();
            var no_ktp = $('#no_ktp').val();
            var no_telp = $('#no_telp').val();
            var tgl_mulai = $('#tanggal_mulai').val();
            var tgl_akhir = $('#tanggal_akhir').val();

            $.ajax({
                url: '/admin/request-permits',
                type: 'POST',
                data: {
                    personels,
                    alats,
                    materials,
                    no_tiket,
                    id_jenis_pekerjaan,
                    keterangan_pekerjaan,
                    nama_kontraktor,
                    pic,
                    alamat,
                    no_ktp,
                    no_telp,
                    tgl_mulai,
                    tgl_akhir
                },
                success: function(data) {
                    if (data.status === 'ok') {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil membuat Request Permit!',
                            'success'
                        ).then(() => window.history.go(-1))
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Gagal membuat Request Permit!',
                            'failed'
                        )
                    }
                }
            })
        }

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
    </script>
@endsection
