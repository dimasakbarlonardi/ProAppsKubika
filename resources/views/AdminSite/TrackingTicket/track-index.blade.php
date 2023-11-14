@foreach ($data as $i => $item)
    @php
        $i += 1;
    @endphp
    @if ($item->is_done)
        <div class="timeline-item timeline-item-{{ $i % 2 == 0 ? 'end' : 'start' }} mb-3">
            <div class="timeline-icon icon-item icon-item-lg text-primary border-300">
                <span class="fs-1 fas fa-envelope"></span>
            </div>
            <div class="row">
                <div class="col-lg-6 timeline-item-time">
                    <div>
                        <h6 class="mb-0 text-700">
                            {{ HumanYear($item->status_time) }}
                        </h6>
                        <p class="fs--2 text-500 font-sans-serif">
                            {{ HumanDateOnly($item->status_time) }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="timeline-item-content arrow-bg-white">
                        <div class="timeline-item-card bg-white dark__bg-1100">
                            <h5 class="mb-2">
                                {{ $item->title }}
                            </h5>
                            <p class="fs--1 border-bottom mb-3 pb-3 text-600">
                                ({{ $item->user }})
                            </p>
                            <div class="d-flex flex-wrap pt-2">
                                <h6 class="mb-0 text-600 lh-base">
                                    <span class="far fa-clock me-1"></span>
                                    {{ HumanTime($item->status_time) }}
                                </h6>
                                <div class="d-flex align-items-center ms-auto me-2 me-sm-x1 me-xl-2 me-xxl-x1">
                                    <div class="dot me-0 me-sm-2 me-xl-0 me-xxl-2 bg-{{ $item->is_done ? 'success' : 'secondary' }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urgent">
                                    </div>
                                </div>
                                <small
                                    class="badge rounded badge-subtle-{{ $item->is_done ? 'success' : 'secondary' }} false">
                                    {{ $item->is_done ? 'Done' : 'Pending' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
