<template>
<div>
  <h1 class="mb-3">Markets</h1>
  <div class="table-responsive asset-markets" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Ticker</th>
          <th>Price</th>
          <th>Volume</th>
          <th>Change</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="market in markets">
          <td><a :href="'/market/' + market.slug" target="_blank">{{ market.base_asset }}</a></td>
          <td class="text-right">{{ market.price }}</td>
          <td class="text-right">{{ market.volume }}</td>
          <td class="text-right">{{ market.change }}</td>
        </tr>
        <tr v-if="matches && matches.length === 0">
          <td class="text-center" colspan="4">No markets found.</td>
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
  props: ['quote_asset'],
  components: {
    InfiniteLoading
  },
  data () {
    return {
      markets: [],
      page: 1
    }
  },
  methods: {
    infiniteHandler($state) {
      axios.get('/api/markets?quote_asset=' + this.quote_asset + '&page=' + this.page).then(response => {
        if (response.data.markets.length) {
          this.page = response.data.current_page + 1
          this.markets = this.markets.concat(response.data.markets)
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