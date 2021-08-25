<ul class="nav nav-tabs d-none d-md-flex">
    <li class="nav-item">
        <a class="nav-link{{ 'XCP' === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => 'XCP']) }}">
            XCP
        </a>
    </li>
    @foreach($markets as $market)
        @if($market->count > 2)
            <li class="nav-item">
                <a class="nav-link{{ $market->quoteAsset->display_name === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => $market->quoteAsset->display_name]) }}">
                    {{ $market->quoteAsset->display_name }}
                </a>
            </li>
        @endif
    @endforeach
    @if(!in_array($quote_asset, $markets->pluck('quote_asset_display_name')->toArray()))
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('markets.index', ['quote_asset' => $quote_asset]) }}">
                {{ $quote_asset }}
            </a>
        </li>
    @endif
</ul>
<ul class="nav nav-tabs d-md-none">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('markets.index', ['quote_asset' => $quote_asset]) }}">
            {{ $quote_asset }}
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            Markets
        </a>
        <div class="dropdown-menu">
        <a class="dropdown-item{{ 'XCP' === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => 'XCP']) }}">
            XCP
        </a>
        @foreach($markets as $market)
            @if($market->count > 2)
                <a class="dropdown-item{{ $market->quoteAsset->display_name === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => $market->quoteAsset->display_name]) }}">
                    {{ $market->quoteAsset->display_name }}
                </a>
            @endif
        @endforeach
        @if(!in_array($quote_asset, $markets->pluck('quote_asset_display_name')->toArray()))
            <a class="dropdown-item active" href="{{ route('markets.index', ['quote_asset' => $quote_asset]) }}">
                {{ $quote_asset }}
            </a>
        @endif
        </div>
    </li>
</ul>