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
                    {{ $item->Ticket->Unit }}
                </td>
                <td class="align-middle">
                    {{ $item->transaction_type }}
                </td>
                <td class="align-middle">
                    {{ $item->transaction_status }}
                </td>
                <td class="text-center">
                    <a href="{{ route('showInvoices', $item->id) }}" class="btn btn-outline-info btn-sm">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
