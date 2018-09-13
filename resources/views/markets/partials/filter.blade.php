<ul class="nav nav-tabs d-none d-md-flex">
    @foreach($markets as $market)
    <li class="nav-item">
        <a class="nav-link{{ $market->quoteAsset->display_name === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => $market->quoteAsset->display_name]) }}">
            {{ $market->quoteAsset->display_name }}
        </a>
    </li>
    @endforeach
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
        @foreach($markets as $market)
            <a class="dropdown-item{{ $market->quoteAsset->display_name === $quote_asset ? ' active' : '' }}" href="{{ route('markets.index', ['quote_asset' => $market->quoteAsset->display_name]) }}">
                {{ $market->quoteAsset->display_name }}
            </a>
        @endforeach
        </div>
    </li>
</ul>