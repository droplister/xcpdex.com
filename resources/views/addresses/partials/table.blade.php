<div class="table-responsive">
    <table class="table table-sm table-bordered text-center">
        <tbody>
            <tr>
                <td class="font-weight-bold d-none d-md-block border-right-0 border-bottom-0">
                    <span class="d-block font-weight-normal">
                        Total Trades
                    </span>
                    {{ number_format($total_trades) }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">
                        Last Trade
                        @if($last_trade)
	                        <a href="https://xcpfox.com/tx/{{ $last_trade->tx_hash }}">
	                            <i class="fa fa-info-circle"></i>
	                        </a>
                        @endif
                    </span>
                    {{ $last_trade ? $last_trade->confirmed_at->toDateString() : '----------' }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">
                        First Trade
                        @if($first_trade)
	                        <a href="https://xcpfox.com/tx/{{ $first_trade->tx_hash }}">
	                            <i class="fa fa-info-circle"></i>
	                        </a>
                        @endif
                    </span>
                    {{ $first_trade ? $first_trade->confirmed_at->toDateString() : '----------' }}
                </td>
            </tr>
            <tr class="bg-light">
                <td colspan="3">
					<small >
						<a href="https://xcpfox.com/address/{{ $address->address }}" target="_blank">XCP FOX</a> &nbsp;
						<a href="https://xchain.io/address/{{ $address->address }}" target="_blank">XCHAIN</a> &nbsp;
						<a href="https://digirare.com/address/{{ $address->address }}" target="_blank">DIGIRARE</a>
					</small>
                </td>
            </tr>
        </tbody>
    </table>
</div>