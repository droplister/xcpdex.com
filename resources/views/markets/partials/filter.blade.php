<ul class="nav nav-tabs">
    @foreach($markets as $market)
    <li class="nav-item">
        <a class="nav-link{{ $market->xcp_core_quote_asset === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => $market->xcp_core_quote_asset]) }}">
            {{ $market->xcp_core_quote_asset }}
        </a>
    </li>
    @endforeach
</ul>