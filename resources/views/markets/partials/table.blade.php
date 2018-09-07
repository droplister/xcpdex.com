<div class="table-responsive">
    <table class="table table-sm table-bordered text-center">
        <tbody>
            <tr>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">Last Trade</span>
                    {{ $last_match ? $last_match->confirmed_at->toDateString() : '----------' }}
                </td>
                <td class="font-weight-bold">
                    <span class="d-block font-weight-normal">Last Price <small>{{ $market->quoteAsset->display_name }}</small></span>
                    {{ $last_match ? $last_match->trading_price_normalized : '----------' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>