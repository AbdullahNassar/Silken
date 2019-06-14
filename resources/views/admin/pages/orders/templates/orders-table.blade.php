<div class="table-responsive">
    <table id="example" class="table table-bordered table-striped table-responsive text-center">
        <thead>
            <tr>
                <th id="ID">
                    <input id="chk-all" type="checkbox">
                </th>
                <th>Code</th>
                <th>Total</th>
                <th># Of Product</th>
                <th>Date</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr
                @if ($order->isStatus('pending'))
                    class="warning"
                @elseif ($order->isStatus('approved'))
                    class="success"
                @else
                    class="danger"
                @endif
                >
                <td class="ID">
                    <input name="ids[]" class="chk-box" value="{{ $order->id}}" type="checkbox">
                </td>
                <td>{{ $order->code }}</td>
                <td>{{ num_format($order->total) }} (SAR)</td>
                <td>{{ $order->products()->count() }} item(s)</td>
                <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                <td>
                    <span class="label label-{{ $order->isPaid()? 'success' : 'danger'}}">
                        <i class="fa fa-{{ $order->isPaid()? 'check' : 'times'}}"></i>
                        {{ $order->isPaid()? 'Paid' : 'Not Confirmed'}}
                    </span>
                </td>
                <td>
                    @if ($order->isStatus('pending'))
                        <a href="#" data-url="{{ route('admin.orders.approve', ['order_id' => $order->id]) }}" class="btn btn-sm btn-flat ajax-submit">
                            <i class="fa fa-eye"></i>
                            Approve
                        </a>
                        <a href="#" data-url="{{ route('admin.orders.cancel', ['order_id' => $order->id]) }}" class="btn btn-sm btn-flat ajax-submit">
                            <i class="fa fa-eye-slash"></i>
                            Cancel
                        </a>
                    @elseif ($order->isStatus('approved'))
                        <a href="#" data-url="{{ route('admin.orders.cancel', ['order_id' => $order->id]) }}" class="btn btn-sm btn-flat ajax-submit">
                            <i class="fa fa-eye-slash"></i>
                            Cancel
                        </a>
                    @else
                        <a href="#" data-url="{{ route('admin.orders.approve', ['order_id' => $order->id]) }}" class="action-btn ajax-submit">
                            <i class="fa fa-eye"></i>
                            Approve
                        </a>
                    @endif
                    <a href="{{ route('site.orders.summary', ['hash' => $order->hash]) }}" class="btn btn-sm btn-flat">
                        <i class="fa fa-file-text"></i>
                        invoice
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="alert alert-info text-center"> No Orders.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $orders->links() }}
