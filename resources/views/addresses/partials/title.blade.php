<h1>
    Address
    <small class="lead d-none d-sm-inline">
        {{ $data['balance'] }} BTC <span style="font-size: 70%;font-weight: 400">({{ $data['txs'] }})</span>
    </small>
</h1>
<p class="lead">
    <a href="https://xchain.io/address/{{ $address->address }}" target="_blank">{{ $address->address }}</a>
</p>