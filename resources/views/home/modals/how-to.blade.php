<div class="modal fade" id="howToModal" tabindex="-1" role="dialog" aria-labelledby="howToModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pin a Market</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Wondering why {{ $featured->market->name }} is pinned?</p>
                <p>Pins are shown as a result of an ongoing auction that allows the highest bidder to feature a market of their choosing.</p>
                <p><b>How it works:</b></p>
                <p>This website monitors: <b><a href="https://xchain.io/address/{{ config('xcpdex.feature_address') }}" target="_blank">{{ config('xcpdex.feature_address') }}</a></b></p>
                <p>1) Send an amount of XCP that's higher than the current high bid.</p>
                <p>2) Include the market to pin as a memo, ex: "PEPECASH/XCP".</p>
                <p>3) That market will be pinned on popular pages until outbid.</p>
                <p><b>Bidding history:</b></p>
                <p>
                @foreach($features as $feature)
                    <a href="https://xchain.io/tx/{{ $feature->xcp_core_tx_index }}" target="_blank">{{ $feature->bid_normalized }} XCP</a> @if($loop->first) <small><em>High Bid</em></small> @endif @if(! $loop->last) <br /> @endif
                @endforeach
                </p>
                <p><em>Notice: Our system waits two (2) confirmations before counting new bids. No refunds for failed bids! We reserve the right to moderate and remove pins for any reason at any time without refund.</em></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>