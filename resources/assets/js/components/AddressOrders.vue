<template>
<div>
  <div class="table-responsive asset-markets" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Date</th>
          <th>Side</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders">
          <td><a :href="'https://xchain.io/tx/' + order.tx_hash" target="_blank">{{ order.date }}</a></td>
          <td :class="order.type === 'Buy' ? 'text-success' : 'text-danger'">{{ order.type }}</td>
          <td>{{ order.quantity }} <a :href="'/market/' + order.market_slug">{{ order.base_asset }}</a></td>
          <td>{{ order.price }} <a :href="'/market/' + order.market_slug">{{ order.quote_asset }}</a></td>
          <td>{{ order.total }} <a :href="'/market/' + order.market_slug">{{ order.quote_asset }}</a></td>
          <td>{{ order.status }}</td>
        </tr>
        <tr v-if="orders && orders.length === 0">
          <td class="text-center" colspan="6">No orders.</td>
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
  props: ['address'],
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
      axios.get('/api/orders/' + this.address + '?page=' + this.page).then(response => {
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