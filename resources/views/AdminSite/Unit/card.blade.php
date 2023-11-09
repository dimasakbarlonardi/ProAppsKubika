<div class="row">
    @foreach ($units as $unit)
    <div class="col-sm-6 col-lg-4 mb-4">
        <div class="card border h-100 border-light">
            <div class="card-body">
                <p class="fw-semi-bold mb-3 mb-sm-2">
                    <a class="text-primary" href="{{ route('units.show', $unit->id_unit) }}">{{ $unit->nama_unit }}</a>
                </p>
                <div class="card-title">
                    <a class="text-800 d-flex align-items-center gap-1" href="../../app/support-desk/contact-details.html">
                        <span class="fas fa-city" data-fa-transform="shrink-3 up-1"></span>
                        <span>{{ $unit->tower->nama_tower }}</span>,
                        <span>{{ $unit->floor->nama_lantai }}</span>
                    </a>
                </div>
                <p class="card-text">
                    </h6>
                    Pemilik :
                    {{ $unit->TenantUnit ? $unit->TenantUnit->Owner($unit->id_unit)->nama_tenant : '-' }}
                    <br>
                    Penyewa :
                    {{ $unit->TenantUnit ? ($unit->TenantUnit->Penyewa($unit->id_unit) ? $unit->TenantUnit->Penyewa($unit->id_unit)->Tenant->nama_tenant : '-') : '-' }}
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>