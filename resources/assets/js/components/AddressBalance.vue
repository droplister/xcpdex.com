<template>
<span>
  <small class="lead d-none d-sm-inline">{{ balance }} BTC ({{ transactions }} txs)</small>
</span>
</template>

<script>
export default {
  props: ['address'],
  data () {
    return {
      balance: 0.00000000,
      transactions: 0,
    }
  },
  mounted: function() {
    axios.get('https://blockstream.info/api/address/' + this.address).then(response => {
      this.balance = response.data.chain_stats.funded_txo_sum - response.data.chain_stats.spent_txo_sum
      this.transactions = response.data.chain_stats.tx_count
    })
  }
}
</script>
