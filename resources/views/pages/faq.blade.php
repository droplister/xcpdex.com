@extends('layouts.app')

@section('title', 'F.A.Q.')

@section('content')
<h1 class="mb-3">F.A.Q.</h1>
<p>XCP is the native token of Counterparty. It is a technical necessity for adding advanced features to Counterparty, which by nature require a protocol aware currency. Bitcoin can only be aware of BTC, while Counterparty can be aware of both BTC and XCP itself. This makes it possible to escrow funds, trade in a decentralized manner, and harness the full potential of programmable money.</p>
<p><em>Note: It is a common misconception that XCP is a competitor to Bitcoin, when in fact it cannot exist without it. And even though XCP is not a traditional currency, it serves a steady and critical purpose within the Counterparty ecosystem.</em></p>
<h3><a id="How_was_XCP_launched_7"></a>How was XCP launched?</h3>
<p>The supply of XCP was created in a process called ‘proof-of-burn’ that lasted from January 2nd to February 3rd 2014 (5000 Bitcoin blocks). During this period, anyone was able to exchange bitcoins for XCP automatically on a protocol level under the following conditions:</p>
<ul>
<li>
<p>Users sent their BTC to a verifiably unspendable Bitcoin address with no known private key. (<a href="https://xchain.io/burns">1CounterpartyXXXXXXXXXXXXXXXUWLpVr</a>)</p>
</li>
<li>
<p>Each BTC was automatically exchanged for a number of XCP between 1000 and 1500, with more being rewarded the earlier the burn took place.</p>
</li>
<li>
<p>The reward bonus decreased linearily with the block index.</p>
</li>
<li>
<p>Each address was limited to 1 BTC.</p>
</li>
</ul>
<p>Since the BTC on the burn address will never be spendable again, they are considered destroyed or ‘burned’. The main advantage of using this process is to create an equal opportunity for all users, including the founders of the project. The result is that nobody started out with a pre-existing supply of XCP. This method is relatively rare in the crypto space, because it does not provide the founders with starting capital. This, however, means that it is a truly decentralized platform similar to Bitcoin’s proof-of-work system.</p>
<p><strong>A truly decentralized system without a crowdfunder has various advantages:</strong></p>
<ul>
<li>Avoids issues with regulatory uncertainty and legal liability because there is no direct profit model, nor a central authority.</li>
<li>Incentivises developers and users equally.</li>
<li>Funds are never in the control of any 3rd party.</li>
<li>Full transparency</li>
<li>Zero pre-mine</li>
</ul>
<h3><a id="Is_XCP_an_altcoin_or_competitor_to_Bitcoin_29"></a>Is XCP an alt-coin or competitor to Bitcoin?</h3>
<p>No. XCP cannot exist without Bitcoin, as Counterparty extends the basic features of Bitcoin with proof-of-publication, oracle betting, decentralized exchange, automatic escrow, order matching, and smart contracts.</p>
<h3><a id="Can_more_XCP_be_created_33"></a>Can more XCP be created?</h3>
<p>No. The supply of XCP is fixed, and decreasing because of fees being burned.</p>
<h3><a id="What_is_XCP_used_for_37"></a>What is XCP used for?</h3>
<p>XCP is the fuel for smart contracts. When smart contracts are running, fuel is used for each execution step. Appropriately enough, this fuel is <strong>burned</strong> (destroyed). This means that the supply of XCP is continously decreasing. However, the cost of fuel adjusts proportionally as the supply of XCP goes down, so that it cannot reach 0.</p>
<p>XCP is always the easiest token to trade against, as it is represented across all exchanges that support Counterparty. It is also used for anti-spam fees when registering named tokens, and when making distribution payments to token holders. The betting system also uses XCP.</p>
@endsection
