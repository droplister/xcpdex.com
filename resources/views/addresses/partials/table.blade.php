<div class="table-responsive">
    <table class="table table-sm table-bordered text-center">
        <tbody>
            <tr>
                <td class="font-weight-bold d-none d-md-block border-right-0 border-bottom-0">
                    <span class="d-block font-weight-normal">
                        Total Orders
                    </span>
                    {{ number_format($total_orders) }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">
                        Last Order
                        @if($last_order)
	                        <a href="https://xchain.io/tx/{{ $last_order->tx_hash }}" target="_blank">
	                            <i class="fa fa-info-circle"></i>
	                        </a>
                        @endif
                    </span>
                    {{ $last_order ? $last_order->confirmed_at->toDateString() : '----------' }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">
                        First Order
                        @if($first_order)
	                        <a href="https://xchain.io/tx/{{ $first_order->tx_hash }}" target="_blank">
	                            <i class="fa fa-info-circle"></i>
	                        </a>
                        @endif
                    </span>
                    {{ $first_order ? $first_order->confirmed_at->toDateString() : '----------' }}
                </td>
            </tr>
            <tr class="bg-light">
                <td colspan="3">
                    Tags: <span class="badge badge-secondary">Pending...</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>