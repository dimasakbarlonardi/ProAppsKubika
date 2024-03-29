 <div class="card-body p-0 pb-3">
     <div class="d-flex row mb-4">
         <div class="col">
             <div class="justify-content-start my-3">
                 <h5>Total selected : <span id="totalSelected">0</span></h5>
             </div>
         </div>
         <div class="col-4" id="bulk-action-menu">
             <div class="justify-content-end my-3">
                 <div class="d-none ms-3" id="bulk-select-actions">
                     <div class="d-flex">
                         <select class="form-select form-select-sm" aria-label="Bulk actions" id="valueAction">
                             @if (Request::session()->get('work_relation_id') == $approve->approval_1 && $user->Karyawan->is_can_approve != null)
                                 <option class="can-select" value="approve" selected="selected">
                                     Approve</option>
                             @elseif (Request::session()->get('work_relation_id') == $approve->approval_2)
                                 <option class="can-select" value="calculate">Calculate Invoice
                                 </option>
                                 <option class="can-select" value="send">Send Invoice</option>
                             @else
                                 <option disabled selected>No Action</option>
                             @endif
                         </select>
                         <button class="btn btn-falcon-success btn-sm ms-2" type="button" id="applyBulk">Apply</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="table-responsive scrollbar">
         <table class="table mb-0" id="tableData">
             <thead class="text-black bg-200">
                 <tr>
                     <th class="align-middle white-space-nowrap">
                         <div class="form-check mb-0">
                             <input class="form-check-input" type="checkbox"
                                 data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' />
                         </div>
                     </th>
                     <th class="align-middle">Unit</th>
                     <th class="align-middle">Water </th>
                     <th class="align-middle">Electric</th>
                     <th class="align-middle">Period</th>
                     <th class="align-middle">Status</th>
                     <th class="align-middle"></th>
                 </tr>
             </thead>
             <tbody id="bulk-select-body">
                 @foreach ($waterUSS as $key => $item)
                     <tr>
                         <th class="align-middle white-space-nowrap">
                             <div class="form-check mb-0">
                                 <input class="form-check-input" name="bulk-elect" type="checkbox"
                                     id="{{ $item->id }}" data-bulk-select-row="data-bulk-select-row" />
                             </div>
                         </th>
                         <th class="align-middle">{{ $item->Unit->nama_unit }}</th>
                         <th class="align-middle">
                             Previous - <b>{{ $item->nomor_air_awal }}</b> <br>
                             Current - <b>{{ $item->nomor_air_akhir }}</b> <br>
                             Usage - <b>{{ $item->usage }}</b> <br>
                             @if ($item->is_updated)
                                 <small class="text-danger">*Updated data, waiting BM to
                                     approve</small>
                             @endif
                         </th>
                         <th class="align-middle">
                             @if ($item->ElecUUSrelation())
                                 Previous - <b>{{ $item->ElecUUSrelation()->nomor_listrik_awal }}</b>
                                 <br>
                                 Current - <b>{{ $item->ElecUUSrelation()->nomor_listrik_akhir }}</b>
                                 <br>
                                 Usage - <b>{{ $item->ElecUUSrelation()->usage }}</b> <br>
                             @else
                                 <h6>
                                     <span class="badge bg-danger">Not yet inserted</span>
                                 </h6>
                             @endif
                         </th>
                         <th class="align-middle">{{ $item->periode_bulan }} -
                             {{ $item->periode_tahun }}</th>
                         <th class="align-middle">
                             @if (!$item->is_approve)
                                 <h6>
                                     <span class="badge bg-warning">Pending</span>
                                 </h6>
                             @endif
                             @if ($item->is_approve && !$item->no_refrensi)
                                 <h6>
                                     <span class="badge bg-success">Approved</span>
                                 </h6>
                                 <br>
                                 @if ($item->ElecUUSrelation() ? !$item->ElecUUSrelation()->is_approve : false)
                                     <small>
                                         *Menunggu tagihan air untuk di approve
                                     </small>
                                 @endif
                             @endif
                             @if ($item->MonthlyUtility)
                                 <h6>
                                     <a class="badge bg-info"
                                         href="{{ route('showInvoices', $item->MonthlyUtility->MonthlyTenant->CashReceipt->id) }}">
                                         <span class="fas fa-receipt fs--2 me-1"></span>
                                         Invoice
                                     </a>
                                 </h6>
                             @endif
                         </th>
                         @if ($user->id_role_hdr == $approve->approval_1 && $user->Karyawan->is_can_approve != null && !$item->is_approve)
                             <td class="align-middle text-center">
                                 <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal"
                                     data-bs-target="#edit-modal{{ $item->id }}">Edit
                                 </button>
                             </td>
                         @elseif($user->id_user == $approve->approval_3 && $item->is_updated)
                             <td class="align-middle text-center">
                                 <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                     data-bs-target="#approve-modal{{ $item->id }}">Approve
                                 </button>
                             </td>
                         @endif
                         @if ($item->MonthlyUtility)
                             @if (!$item->MonthlyUtility->MonthlyTenant->tgl_jt_invoice)
                                 <td class="align-middle text-center">
                                     <span class="badge bg-info">
                                         <span class="fas fa-check fs--2 me-1"></span>
                                         Waiting to send
                                     </span>
                                 </td>
                             @else
                                 <td class="align-middle text-center">
                                     <h6>
                                         <span class="badge bg-success">
                                             <span class="fas fa-check fs--2 me-1"></span>
                                             Sended
                                         </span>
                                     </h6>
                                 </td>
                             @endif
                         @endif
                     </tr>

                     <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1" role="dialog"
                         aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                             <div class="modal-content position-relative">
                                 <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                                     <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                         data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <form method="post" action="{{ route('updateWater', $item->id) }}">
                                     @csrf
                                     <div class="modal-body p-0">
                                         <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                                             <h4 class="mb-1" id="modalExampleDemoLabel">Edit
                                                 Record
                                             </h4>
                                         </div>
                                         <div class="p-4 pb-0">
                                             <div class="mb-3">
                                                 <div class="row">
                                                     <div class="col-6">
                                                         <label class="col-form-label"
                                                             for="recipient-name">Previous:</label>
                                                         <input class="form-control" name="nomor_air_awal"
                                                             value="{{ $item->nomor_air_awal }}" type="integer" />
                                                     </div>
                                                     <div class="col-6">
                                                         <label class="col-form-label"
                                                             for="recipient-name">Current:</label>
                                                         <input class="form-control" name="nomor_air_akhir"
                                                             value="{{ $item->nomor_air_akhir }}" type="integer" />
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="mb-3">
                                                 <label class="col-form-label" for="message-text">Notes:</label>
                                                 <textarea class="form-control" name="catatan" rows="8" id="message-text"></textarea>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="modal-footer">
                                         <button class="btn btn-secondary" type="button"
                                             data-bs-dismiss="modal">Close</button>
                                         <button class="btn btn-primary" type="submit"
                                             onclick="return confirm('are you sure?')">Edit Data
                                         </button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>

                     <div class="modal fade" id="approve-modal{{ $item->id }}" tabindex="-1" role="dialog"
                         aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                             <div class="modal-content position-relative">
                                 <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                                     <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                         data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <form method="post" action="{{ route('approveUpdateWater', $item->id) }}">
                                     @csrf
                                     <div class="modal-body p-0">
                                         <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                                             <h4 class="mb-1" id="modalExampleDemoLabel">Approve
                                                 Record
                                             </h4>
                                         </div>
                                         <div class="p-4 pb-0">
                                             <div class="mb-3">
                                                 <div class="row">
                                                     <div class="col-6">
                                                         <label class="col-form-label" for="recipient-name">Old
                                                             previous:</label>
                                                         <input class="form-control"
                                                             value="{{ $item->old_nomor_air_awal }}" disabled />
                                                     </div>
                                                     <div class="col-6">
                                                         <label class="col-form-label" for="recipient-name">Old
                                                             current:</label>
                                                         <input class="form-control"
                                                             value="{{ $item->old_nomor_air_akhir }}" disabled />
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="mb-3">
                                                 <div class="row text-center">
                                                     <div class="col-6">
                                                         <h4>
                                                             <span class="text-success">
                                                                 <i class="fas fa-chevron-down"></i>
                                                             </span>
                                                         </h4>
                                                     </div>
                                                     <div class="col-6">
                                                         <h4>
                                                             <span class="text-success">
                                                                 <i class="fas fa-chevron-down"></i>
                                                             </span>
                                                         </h4>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="mb-3">
                                                 <div class="row">
                                                     <div class="col-6">
                                                         <label class="col-form-label" for="recipient-name"> New
                                                             previous:</label>
                                                         <input class="form-control"
                                                             value="{{ $item->nomor_air_awal }}" disabled />
                                                     </div>
                                                     <div class="col-6">
                                                         <label class="col-form-label" for="recipient-name">New
                                                             current:</label>
                                                         <input class="form-control"
                                                             value="{{ $item->nomor_air_akhir }}" disabled />
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="mb-3">
                                                 <label class="col-form-label" for="message-text">Notes:</label>
                                                 <textarea class="form-control" name="catatan" rows="8" id="message-text" disabled>{{ $item->catatan }}</textarea>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="modal-footer">
                                         <button class="btn btn-secondary" type="button"
                                             data-bs-dismiss="modal">Close</button>
                                         <button class="btn btn-primary" type="submit"
                                             onclick="return confirm('are you sure?')">Approve
                                         </button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
