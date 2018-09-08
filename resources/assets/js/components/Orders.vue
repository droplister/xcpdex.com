<template>
<div>
  <h1 class="mb-3">Orders</h1>
  <div class="table-responsive order-matches" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Date</th>
          <th>Market</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Total</th>
          <th>Source</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders">
          <td>{{ order.date }}</td>
          <td>{{ order.market }}</td>
          <td>{{ order.quantity }}</td>
          <td>{{ order.price }}</td>
          <td>{{ order.total }}</td>
          <td>{{ order.source }}</td>
        </tr>
        <tr v-if="orders && orders.length === 0">
          <td class="text-center" colspan="6">No order found.</td>
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
      axios.get('/api/orders?page=' + this.page).then(response => {
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