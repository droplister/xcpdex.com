<div class="table-responsive">
    <table class="table table-sm table-bordered text-center">
        <tbody>
            <tr>
                <td class="font-weight-bold d-none d-md-block border-right-0 border-bottom-0">
                    <span class="d-block font-weight-normal">
                        Issuance
                        <a href="https://xcpfox.com/asset/{{ $market->baseAsset->display_name }}" target="_blank">
                            <i class="fa fa-info-circle"></i>
                        </a>
                    </span>
                    {{ number_format($market->baseAsset->supply_normalized) }}
                </td>
                <td class="font-weight-bold" title="{{ isset($price_data[$market->quoteAsset->display_name]) && $last_match ? number_format($last_match->trading_price_normalized * $price_data[$market->quoteAsset->display_name], 2) . ' USD' : '' }}">
                    <span class="d-block font-weight-normal">
                        Last Price
                        <small class="d-none d-md-inline-block">
                            {{ $market->quoteAsset->display_name }}
                        </small>
                    </span>
                    {{ $last_match ? number_format($last_match->trading_price_normalized, 8) : '----------' }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">
                        Last Trade
                    </span>
                    {{ $last_match ? $last_match->confirmed_at->toDateString() : '----------' }}
                </td>
            </tr>
            <tr class="bg-light">
                <td colspan="3">
                    @if($last_match)
                        Market Cap: <strong>{{ number_format($market->baseAsset->supply_normalized * $last_match->trading_price_normalized) }} <small>{{ $market->quoteAsset->display_name }}</small></strong>
                        @if(isset($price_data[$market->quoteAsset->display_name]))
                            <small>/</small>
                            <strong>${{ number_format($market->baseAsset->supply_normalized * $last_match->trading_price_normalized * $price_data[$market->quoteAsset->display_name]) }} <small>USD</small></strong>
                        @endif
                    @else
                        Market Cap: <strong>---------- <small>{{ $market->quoteAsset->display_name }}</small></strong>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>