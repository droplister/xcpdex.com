<div class="table-responsive">
    <table class="table table-sm table-bordered text-center">
        <tbody>
            <tr>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">{{ $market->baseAsset->display_name }} <small>Supply</small></span>
                    {{ number_format($market->baseAsset->supply_normalized) }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">Last Trade</span>
                    {{ $last_match ? $last_match->confirmed_at->toDateString() : '----------' }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">Last Price <small>{{ $market->quoteAsset->display_name }}</small></span>
                    {{ $last_match ? $last_match->trading_price_normalized : '----------' }}
                </td>
            </tr>
            <tr class="bg-light">
                <td colspan="3">
                    @if($last_match)
                        Market Cap: <strong>{{ number_format($market->baseAsset->supply_normalized * $last_match->trading_price_normalized) }} <small>{{ $market->quoteAsset->display_name }}</small></strong>
                    @else
                        Market Cap: <strong>---------- <small>{{ $market->quoteAsset->display_name }}</small></strong>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>