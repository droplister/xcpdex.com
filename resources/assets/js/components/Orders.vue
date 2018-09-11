<template>
<div>
  <div class="table-responsive order-matches" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Date</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Total</th>
          <th>Source</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders">
          <td><a :href="'https://xcpfox.com/tx/' + order.tx_hash" target="_blank">{{ order.date }}</a></td>
          <td>{{ order.quantity }} <a :href="'/market/' + order.market_slug">{{ order.base_asset }}</a></td>
          <td>{{ order.price }} <a :href="'/market/' + order.market_slug">{{ order.quote_asset }}</a></td>
          <td>{{ order.total }} <a :href="'/market/' + order.market_slug">{{ order.quote_asset }}</a></td>
          <td><a :href="'https://xcpfox.com/address/' + order.source" target="_blank">{{ order.source }}</a></td>
        </tr>
        <tr v-if="orders && orders.length === 0">
          <td class="text-center" colspan="5">No order found.</td>
        </tr>
        <infinite-loading force-use-infinite-wrapper="true" @infinite="infiniteHandler">
          <span slot="no-more"></span>
          <span slot="no-results"></span>
        </infinite-loading>
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';

export default {
  props: ['status'],
  components: {
    InfiniteLoading
  },
  data () {
    return {
      orders: [],
      page: 1
    }
  },
  methods: {
    infiniteHandler($state) {
      axios.get('/api/orders?page=' + this.page + '&status=' + this.status).then(response => {
        if (response.data.orders.length) {
          this.page = response.data.current_page + 1
          this.orders = this.orders.concat(response.data.orders)
          $state.loaded()
          if (response.data.current_page === response.data.last_page) {
            $state.complete()
          }
        } else {
          $state.complete()
        }
      })
    }
  }
}
</script>