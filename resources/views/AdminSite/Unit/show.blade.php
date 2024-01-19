@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('units.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Detail Unit</div>
            </div>
        </div>
    </div>
    <div class="p-3 p-md-5">
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tower</label>
                    <input type="text" value="{{ $units->tower->nama_tower }}" class="form-control" readonly />
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lantai</label>
                    <input type="text" value="{{ $units->floor->nama_lantai }}" class="form-control" readonly />
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Unit Name</label>
                    <input type="text" value="{{ $units->nama_unit }}" class="form-control" readonly />
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Luas Unit</label>
                    <input type="text" value="{{ $units->luas_unit }}" class="form-control" readonly />
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Meter Air</label>
                    <input type="text" value="{{ $units->no_meter_air }}" class="form-control" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">No Meter Listrik</label>
                    <input type="text" value="{{ $units->no_meter_listrik }}" class="form-control" required />
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Meter Air Awal</label>
                    <input type="text" value="{{ $units->meter_air_awal }}" class="form-control" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Meter Listrik Awal</label>
                    <input type="text" value="{{ $units->meter_listrik_awal }}" class="form-control" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" value="{{ $units->keterangan }}" class="form-control" />
                </div>

            </div>
            <div class="d-md-flex  align-items-center justify-content-center text-center mt-3 mt-md-5">
                <div class="col-12 col-md-auto mb-3">
                    <label class="form-label">Barcode Meter Air</label>
                    <div id="barcodeWater" class="p-1 bg-red-50">
                        <img src="{{ url($units->barcode_meter_air) }}" alt="barcode" width="250" class="img-fluid">
                        <h5 id="barcodeWaterName">W-{{ $units->nama_unit }}</h5>
                    </div>
                    <a class="btn btn-success btn-sm mt-3" id="downloadWaterBarcode">Download</a>
                </div>
                <div class="col-auto mx-3 mx-md-5">
                    <h4 class="my-3">-</h4>
                </div>
                <div class="col-12 col-md-auto mb-3">
                    <label class="form-label">Barcode Meter Listrik</label>
                    <div id="barcodeElectric" class="p-1 bg-red">
                        <img src="{{ url($units->barcode_meter_listrik) }}" alt="barcode" width="250" class="img-fluid">
                        <h5 id="barcodeElectricName">E-{{ $units->nama_unit }}</h5>
                    </div>
                    <a class="btn btn-success btn-sm mt-3" id="downloadElectricBarcode">Download</a>
                </div>
            </div>

        </div>
        <div class="mt-3 mt-md-5">
            <a class="btn btn-sm btn-warning" href="{{ route('units.edit', $units->id_unit) }}">Edit</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

<script type="text/javascript">
    var elementElectric = $("#barcodeElectric");
    var elementWater = $("#barcodeWater");

    $(document).ready(function() {
        electricElementToImage();
        waterElementToImage()
    });

    function electricElementToImage() {
        let fileName = $('#barcodeElectricName').html()

        html2canvas(elementElectric, {
            useCORS: true,
            onrendered: function(canvas) {
                var imageData = canvas.toDataURL("image/jpg");
                var newData = imageData.replace(/^data:image\/jpg/,
                    "data:application/octet-stream");
                $("#downloadElectricBarcode").attr("download", fileName + ".jpg").attr("href", newData);
            }
        });
    }

    function waterElementToImage() {
        let fileName = $('#barcodeWaterName').html()

        html2canvas(elementWater, {
            useCORS: true,
            onrendered: function(canvas) {
                var imageData = canvas.toDataURL("image/jpg");
                var newData = imageData.replace(/^data:image\/jpg/,
                    "data:application/octet-stream");
                $("#downloadWaterBarcode").attr("download", fileName + ".jpg").attr("href", newData);
            }
        });
    }
</script>
@endsection