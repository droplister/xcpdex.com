<template>
<div>
  <div class="table-responsive order-matches" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Date</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Buyer</th>
          <th>Seller</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="match in matches">
          <td>{{ match.date }}</td>
          <td class="text-right">{{ match.price }}</td>
          <td class="text-right">{{ match.quantity }}</td>
          <td class="text-right">{{ match.total }}</td>
          <td>{{ match.buyer }}</td>
          <td>{{ match.seller }}</td>
        </tr>
        <tr v-if="matches.length === 0">
          <td class="text-center" colspan="6">No order matches found.</td>
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
  props: ['market'],
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
      axios.get('/api/markets/' + this.market + '/order-matches?page=' + this.page).then(response => {
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