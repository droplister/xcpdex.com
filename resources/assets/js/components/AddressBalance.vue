<template>
<span>
  <small class="lead d-none d-sm-inline">
    {{ balance }} BTC <span style="font-size: 70%">({{ txs }})</span>
  </small>
</span>
</template>

<script>
export default {
  props: ['address'],
  data () {
    return {
      balance: '0.00000000',
      txs: 'loading...',
    }
  },
  mounted: function() {
    axios.get('https://api.blockcypher.com/v1/btc/main/addrs/' + this.address + '/balance').then(response => {
      this.balance = (response.balance / 100000000).toFixed(8)
      this.txs = (response.final_n_tx) + ' txs'
    })
  }
}
</script>
