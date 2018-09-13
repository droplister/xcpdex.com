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
                <p>We have a special address that we monitor: <br /> <b><a href="https://xchain.io/address/{{ config('xcpdex.feature_address') }}" target="_blank">{{ config('xcpdex.feature_address') }}</a></b></p>
                <p>Anyone can send XCP to this address and enter the name of the market they want featured in the memo field. For example, "PEPECASH/XCP".</p>
                <p>- The four (4) highest bids get their market featured on the homepage.</p>
                <p>- The four (4) highest bids appear sitewide in the XCPDEX.com sidebar.</p>
                <p>- Each market will remain featured until or unless they get outbid.</p>
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