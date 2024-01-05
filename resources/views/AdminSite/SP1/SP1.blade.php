@extends('Tenant.stand-alone-index')

@section('content')
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <div class="content mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center text-center mb-3">
                            <div class="col-sm-6 text-sm-start">
                                <img src="{{ asset($company->company_logo) }}" alt="invoice" width="150" />
                            </div>
                            <div class="col text-sm-end mt-3 mt-sm-0">
                                <h2 class="mb-3">{{ $notif->notif_message }}</h2>
                                <h5>{{ $company->company_name }}</h5>
                                <p class="fs--1 mb-0">
                                    {!! $company->company_address !!}
                                </p>
                            </div>
                            <div class="col-12">
                                <hr />
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-500">Kepada Yth, </h6>
                                <h6>{{ $ar->Unit->nama_unit }}, {{ $ar->Unit->Tower->nama_tower }}</h6>
                                <h5>{{ $ar->Unit->Owner()->Tenant->nama_tenant }}</h5>
                            </div>
                        </div>

                        @if (!$company->is_split_ar)
                            @include('AdminSite.SP1.nonsplit')
                        @else
                            @include('AdminSite.SP1.splitted')
                        @endif

                        <div class="p-4 text-justify">
                            Untuk itu kami harap bapak/Ibu dapat segera melunasi kewajiban tersebut melalui aplikasi ProApps
                            dengan meng-klik link <b><a href="#">Payment</a></b> .
                            Dengan hormat kami mohon agar Bapak/Ibu dapat memperhatikan tata tertib kewajiban pembayaran
                            pada house rules {{ $company->company_name }}, sebagai berikut:
                            <ol>
                                <li class="my-2">
                                    Keterlambatan pembayaran dihitung sejak tanggal jatuh tempo pembayaran tagihan dan akan
                                    dikenakan denda sebesar
                                    <b>{{ $denda->denda_flat_procetage ? RupiahNumber($denda->denda_flat_procetage) . '%' : Rupiah($denda->denda_flat_amount) }}</b>
                                    dari seluruh tagihan kumulatif per
                                    bulan.
                                </li>
                                <li class="my-2">
                                    Apabila lewat dari tanggal jatuh tempo tagihan belum ada pembayaran maka kami akan
                                    memberikan
                                    peringatan sebanyak 4 (empat) kali peringatan, masing-masing peringatan dengan tenggang
                                    waktu seperti berikut : <br>
                                    <table>
                                        <thead>
                                            <th>Item</th>
                                            <th>Tenggat hari kalender</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($reminders as $reminder)
                                                @if ($reminder->id_reminder_letter != 1)
                                                    <tr>
                                                        <td>
                                                            {{ $reminder->reminder_letter }}
                                                        </td>
                                                        <td>
                                                            {{ $reminder->durasi_reminder_letter }} Hari setelah jatuh tempo
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </li>
                                <li class="my-2">
                                    Bila sampai dengan Surat Peringatan ketiga tagihan belum dibayar maka akan dikeluarkan
                                    Surat
                                    Pemberitahuan terakhir mengenai penghentian sementara supply listrik dan air dan untuk
                                    mengaktifkan kembali supply listrik dan air maka pembayaran total tagihan berjalan,
                                    denda dan
                                    biaya penyambungan kembali sebesar
                                    @if (!$company->is_split_ar)
                                        {{-- @include('AdminSite.SP1.nonsplit') --}}
                                    @else
                                        <b>{{ Rupiah($ar->PreviousMonthBillSP($ar->biaya_lain)->reverse()->values()[0]->CashReceipts->sum('sub_total')) }}</b>
                                    @endif
                                    harus sudah dilunasi.
                                </li>
                            </ol>
                            Untuk informasi lebih lanjut mengenai tagihan di atas dapat menghubungi Building Management
                            melalui telepon … pada jam operasional atau melalui Menu Request Tenant pada Aplikasi ProApps.

                            Demikian kami sampaikan atas perhatian dan kerjasamanya kami ucapkan terima kasih.
                        </div>
                        <div class="p-2">
                            <img src="{{ url('/assets/img/icons/spot-illustrations/proapps.png') }}" alt="" width="80">
                            <span class="small text-muted">*Surat Pemberitahuan ini diterbitkan secara digital</span>
                        </div>
                        {{-- <div class="row justify-content-end">
                            <div class="col-auto">
                                <table class="table table-sm table-borderless fs--1">
                                    <tr class="">
                                        <p class="text-center">Hormat kami,</p>
                                    </tr>
                                    <tr height="100px">

                                    </tr>
                                    <tr class="border-top border-top-2">
                                        <th>Building Management</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <b>({{ $company->company_name }})</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <footer class="footer">
                    <div class="row g-0 justify-content-between fs--1 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">
                                &copy; Copyright 2023, Indoland Group
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </main>
@endsection
