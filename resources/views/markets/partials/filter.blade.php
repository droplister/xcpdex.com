<ul class="nav nav-tabs">
    @foreach($markets as $market)
    <li class="nav-item">
        <a class="nav-link{{ $market->quoteAsset->display_name === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => $market->quoteAsset->display_name]) }}">
            {{ $market->quoteAsset->display_name }}
        </a>
    </li>
    @endforeach
</ul>