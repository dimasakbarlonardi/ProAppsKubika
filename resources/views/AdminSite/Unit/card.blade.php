<div class="row">
    @foreach ($units as $unit)
        <div class="col-4 mb-3">
            <div
                class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                <div class="d-flex align-items-start align-items-sm-center">
                    <div class="ms-1 ms-sm-3">
                        <p class="fw-semi-bold mb-3 mb-sm-2">
                            <a class="text-primary" href="../../app/support-desk/tickets-preview.html">{{ $unit->nama_unit }}</a>
                        </p>
                        <div class="row align-items-center gx-0 gy-2">
                            <div class="col-auto me-2">
                                <h6 class="client mb-0">
                                    <a class="text-800 d-flex align-items-center gap-1"
                                        href="../../app/support-desk/contact-details.html"><span class="fas fa-user"
                                            data-fa-transform="shrink-3 up-1"></span><span>Peter
                                            Gill</span></a>
                                </h6>
                            </div>
                            <div class="col-auto lh-1 me-3">
                                <small class="badge rounded badge-soft-info false">Responded</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
