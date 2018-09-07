<template>
<div>
  <div class="table-responsive order-book">
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Price</th>
          <th>{{ baseAsset }}</th>
          <th>{{ quoteAsset }}</th>
          <th>Sum&nbsp;({{ quoteAsset }})</th>
          <th>Source</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(order, index) in orders">
          <td class="text-right" :class="side === 'buy' ? 'text-success' : 'text-danger'">{{ order.price }}</td>
          <td class="text-right">{{ order.quantity }}</td>
          <td class="text-right">{{ order.total }}</td>
          <td class="text-right" :title="baseSubtotal(index) + ' ' + baseAsset">{{ quoteSubtotal(index) }}</td>
          <td><a :href="'https://xcpdex.com/address/' + order.source">{{ order.source }}</a></td>
        </tr>
        <tr v-if="orders.length === 0">
          <td class="text-center" colspan="5">No {{ side }} orders found.</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mt-1 text-muted">
    <div class="col">
      {{ baseSubtotal(orders.length) }} {{ baseAsset }}
    </div>
    <div class="col text-right">
      {{ quoteSubtotal(orders.length) }} {{ quoteAsset }}
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['market', 'side'],
  data () {
    return {
      orders: [],
      baseAsset: '',
      quoteAsset: '',
    }
  },
  mounted: function() {
    var self = this
    axios.get('/api/markets/' + this.market + '/orders').then(response => {
      self.orders = this.side === 'buy' ? response.data.buy_orders : response.data.sell_orders
      self.baseAsset = response.data.base_asset.display_name
      self.quoteAsset = response.data.quote_asset.display_name
    })
  },
  methods: {
    baseSubtotal: function (index) {
      return this.orders.slice(0, index + 1)
        .reduce((sum, order) => sum + parseFloat(order.quantity), 0)
        .toFixed(8)
    },
    quoteSubtotal: function (index) {
      return this.orders.slice(0, index + 1)
        .reduce((sum, order) => sum + parseFloat(order.total), 0)
        .toFixed(8)
    }
  }
}
</script>