<h1>{{ $market->baseAsset->display_name }}<small class="lead d-none d-sm-inline"> / <a href="{{ route('markets.index', ['quote_asset' => $market->quoteAsset->display_name]) }}">{{ $market->quoteAsset->display_name }}</a></small></h1>
<p class="lead">
    <span class="d-none d-sm-inline">
        {{ $market->baseAsset->display_name }}
    </span>
    Price Chart, Order Book &amp; Match History.
</p>