<template>
<div>
  <div class="table-responsive asset-markets" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Ticker</th>
          <th><a :href="'/markets/' + this.quote_asset + '?sort_by=market_cap'" class="text-dark">Market Cap</a></th>
          <th>Last Price</th>
          <th><a :href="'/markets/' + this.quote_asset + '?sort_by=volume'" class="text-dark">Volume</a> <small>90d</small></th>
          <th>Issuance</th>
          <th><a :href="'/markets/' + this.quote_asset + '?sort_by=open_orders_count'" class="text-dark">Open Orders</a></th>
          <th><a :href="'/markets/' + this.quote_asset + '?sort_by=orders_count'" class="text-dark">Total Orders</a></th>
          <th><a :href="'/markets/' + this.quote_asset + '?sort_by=order_matches_count'" class="text-dark">Total Trades</a></th>
          <th>Last Trade</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="market in markets">
          <td><a :href="'/market/' + market.slug">{{ market.base_asset }}</a></td>
          <td class="text-right">{{ market.market_cap }} <a :href="'/market/' + market.slug">{{ market.quote_asset }}</a></td>
          <td class="text-right">{{ market.price }} <a :href="'/market/' + market.slug">{{ market.quote_asset }}</a></td>
          <td class="text-right">{{ market.volume }} <a :href="'/market/' + market.slug">{{ market.quote_asset }}</a></td>
          <td class="text-right">{{ market.supply }}</td>
          <td class="text-right">{{ market.open_orders_count }}</td>
          <td class="text-right">{{ market.orders_count }}</td>
          <td class="text-right">{{ market.order_matches_count }}</td>
          <td class="text-right">{{ market.last_trade_date }}</td>
        </tr>
        <tr v-if="markets && markets.length === 0">
          <td class="text-center" colspan="9">No markets.</td>
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
  props: ['quote_asset', 'sort_by'],
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
      axios.get('https://xcpdex.com/api/markets?quote_asset=' + this.quote_asset + '&sort_by=' + this.sort_by + '&page=' + this.page).then(response => {
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