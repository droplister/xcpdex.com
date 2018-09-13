<div class="modal fade" id="howToModal" tabindex="-1" role="dialog" aria-labelledby="howToModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Get Featured</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>On XCPDEX.com, anyone can feature any market. The way it works is simple...</p>
                <p>We run an on-going ad auction:</p>
                <p>The two (2) highest bids get their market featured on the homepage.</p>
                <p>The four (4) highest bids appear sitewide in the XCPDEX.com sidebar.</p>
                <p>We have a special address that we monitor: <br /> <b><a href="https://xchain.io/address/{{ config('xcpdex.feature_address') }}" target="_blank">{{ config('xcpdex.feature_address') }}</a></b></p>
                <p>Send your bid to this address (XCP ONLY) and include the name of the market you want featured in the memo field. As an example, you would enter either "XCP_BTC" or "XCP/BTC".</p>
                <p>The current high bids are as follows:</p>
                <p>
                @foreach($features as $featured)
                    <b>#{{ $loop->iteration }} Spot</b> &nbsp; {{ $featured->bid_normalized }} XCP @if(! $loop->last) <br /> @endif
                @endforeach
                </p>
                <p><em>Our system waits two (2) confirmations before counting new bids. No refunds for failed bids!</em></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>