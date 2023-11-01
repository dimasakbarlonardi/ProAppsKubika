<div id="reservation_form" style="display: none">
    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <label class="mb-1">Tanggal request reservasi</label>
                <input class="form-control datetimepicker" name="tgl_request_reservation" id="startDateReservation"
                    type="text" placeholder="d/m/y" data-options='{"dateFormat":"Y-m-d","disableMobile":true}' />
            </div>
            <div class="col-6">
                <label class="mb-1">Durasi Acara</label>
                <div class="input-group">
                    <input class="form-control" id="durasi_acara" name="durasi_acara" type="number">
                    <select class="form-control" name="satuan_durasi_acara" readonly>
                        <option selected value="Jam">
                            <span class="input-group-text">Jam</span>
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <label class="mb-1">Waktu mulai acara</label>
                <input class="form-control datetimepicker" name="waktu_mulai" id="timeStartEvent" type="text"
                    placeholder="Hour : Minute"
                    data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
            </div>
            <div class="col-6">
                <label class="mb-1">Waktu acara berakhir</label>
                <input class="form-control" name="waktu_akhir" readonly type="text" placeholder="Hour : Minute"
                    id="timeEndEvent" />
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <label class="mb-1">Ruang reservasi</label>
                <select class="form-control" name="id_ruang_reservation" id="id_ruang_reservation">
                    <option value="" selected disable>--- Ruang reservasi ---</option>
                    @foreach ($ruangRsv as $ruang)
                        <option value="{{ $ruang->id_ruang_reservation }}">
                            {{ $ruang->ruang_reservation }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="mb-1">Jenis acara</label>
                <select class="form-control" name="id_jenis_acara" id="id_jenis_acara">
                    <option value="" selected disable>--- Pilih jenis acara ---</option>
                    @foreach ($jenisAcara as $acara)
                        <option value="{{ $acara->id_jenis_acara }}">{{ $acara->jenis_acara }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label class="mb-1">Keterangan</label>
        <textarea class="form-control" name="keterangan" id="keterangan_reservation"></textarea>
    </div>
</div>

<script>
    flatpickr("#startDateReservation", {
        dateFormat: "Y-m-d",
        minDate: "today",
        altInput: true,
        altFormat: "F j, Y"
    });

    flatpickr("#timeStartEvent", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });

    $('#timeStartEvent').on('change', function() {
        var durasiAcara = $('#durasi_acara').val();
        var requestDate = $('#startDateReservation').val();
        var startEvent = $(this).val();

        setEndEvent(requestDate, startEvent, durasiAcara)
    })

    $('#durasi_acara').on('change', function() {
        var requestDate = $('#startDateReservation').val();
        var startEvent = $('#timeStartEvent').val();
        var durasiAcara = $(this).val();

        setEndEvent(requestDate, startEvent, durasiAcara)
    })

    function setEndEvent(requestDate, startEvent, durasiAcara) {
        var setDate = new Date(requestDate + ' ' + startEvent);

        newDate = setDate.setHours(setDate.getHours() + parseInt(durasiAcara));
        newDate = new Date(newDate)

        var endEvent = newDate.getHours() + ':' + (newDate.getMinutes() < 10 ? '0' : '') + newDate.getMinutes();

        $('#timeEndEvent').val(endEvent);
    }

    function reservationValue() {
        startDateReservation = $('#startDateReservation').val();
        durasi_acara = $('#durasi_acara').val();
        timeStartEvent = $('#timeStartEvent').val();
        timeEndEvent = $('#timeEndEvent').val();
        id_ruang_reservation = $('#id_ruang_reservation').val();
        id_jenis_acara = $('#id_jenis_acara').val();
        keterangan_reservation = $('#keterangan_reservation').val();
        is_deposit = $('#is_deposit').val();
        jumlah_deposit = $('#jumlah_deposit').val();

        var value = {
            'startDateReservation': $('#startDateReservation').val(),
            'durasi_acara': $('#durasi_acara').val(),
            'timeStartEvent': $('#timeStartEvent').val(),
            'timeEndEvent': $('#timeEndEvent').val(),
            'id_ruang_reservation': $('#id_ruang_reservation').val(),
            'id_jenis_acara': $('#id_jenis_acara').val(),
            'keterangan_reservation': $('#keterangan_reservation').val(),
        }

        if (!startDateReservation || !durasi_acara ||
            !timeStartEvent || !timeEndEvent ||
            !id_ruang_reservation || !id_jenis_acara) {
            return;
        } else {
            return value;
        }

    }
</script>
