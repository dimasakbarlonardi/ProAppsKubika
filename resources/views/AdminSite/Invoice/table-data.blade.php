<table class="table mb-0" id="tableData">
    <thead class="text-black bg-200">
        <tr>
            <th class="align-middle">No Invoice</th>
            <th class="align-middle">Unit</th>
            <th class="align-middle">Trasaction Type</th>
            <th class="align-middle">Status</th>
            <th class="align-middle text-center">Action</th>
        </tr>
    </thead>
    <tbody id="bulk-select-body">
        @foreach ($transactions as $key => $item)
            <tr>
                <td class="align-middle">
                    {{ $item->no_invoice }}
                </td>
                <td class="align-middle">
                    @if ($item->Ticket)
                        {{ $item->Ticket->Unit->nama_unit }}
                    @endif
                    @if ($item->MonthlyARTenant)
                        Unit {{ $item->MonthlyARTenant->Unit->nama_unit }}
                    @endif
                </td>
                <td class="align-middle">
                    {{ $item->transaction_type }}
                </td>
                <td class="align-middle">
                    {{ $item->transaction_status }}
                </td>
                <td class="text-center">
                    <a href="{{ route('showInvoices', $item->id) }}" class="btn btn-outline-info btn-sm">View</a>
                    @if (
                        $item->transaction_type == 'MonthlyTenant' ||
                            $item->transaction_type == 'MonthlyIPLTenant' ||
                            $item->transaction_type == 'MonthlyUtilityTenant' ||
                            $item->transaction_type == 'MonthlyOtherBillTenant')
                        <a href="{{ route('installment', $item->id) }}"
                            class="btn btn-outline-success btn-sm">Installment
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
