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
          <th>Buyer</th>
          <th>Seller</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="match in matches">
          <td><a :href="'/market/' + match.market_slug">{{ match.date }}</a></td>
          <td :class="match.type === 'Buy' ? 'text-success' : 'text-danger'">{{ match.type }}</td>
          <td>{{ match.quantity }} <a :href="'/market/' + match.market_slug">{{ match.base_asset }}</a></td>
          <td>{{ match.price }} <a :href="'/market/' + match.market_slug">{{ match.quote_asset }}</a></td>
          <td>{{ match.total }} <a :href="'/market/' + match.market_slug">{{ match.quote_asset }}</a></td>
          <td><a :href="'/address/' + match.buyer">{{ match.buyer }}</a></td>
          <td><a :href="'/address/' + match.seller">{{ match.seller }}</a></td>
        </tr>
        <tr v-if="matches && matches.length === 0">
          <td class="text-center" colspan="7">No order matches.</td>
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
import InfiniteLoading from 'vue-infinite-loading'

export default {
  components: {
    InfiniteLoading
  },
  data () {
    return {
      matches: [],
      page: 1
    }
  },
  methods: {
    infiniteHandler($state) {
      axios.get('/api/order-matches?page=' + this.page).then(response => {
        if (response.data.order_matches.length) {
          this.page = response.data.current_page + 1
          this.matches = this.matches.concat(response.data.order_matches)
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