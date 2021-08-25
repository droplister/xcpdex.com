<template>
<div>
  <div class="table-responsive asset-markets" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Ticker</th>
          <th><a :href="'/markets/' + this.quote_asset + '?sort_by=market_cap'" class="text-dark" :style="inputStyles('market_cap')">Market Cap</a></th>
          <th>Last Price</th>
          <th><a :href="'/markets/' + this.quote_asset + '?sort_by=volume'" class="text-dark">Volume</a> <small>90d</small></th>
          <th class="text-center"><a :href="'/markets/' + this.quote_asset + '?sort_by=get_orders_count'" class="text-dark" :style="inputStyles('get_orders_count')>Buy Orders</a></th>
          <th class="text-center"><a :href="'/markets/' + this.quote_asset + '?sort_by=give_orders_count'" class="text-dark" :style="inputStyles('give_orders_count')>Sell Orders</a></th>
          <th class="text-center"><a :href="'/markets/' + this.quote_asset + '?sort_by=order_matches_count'" class="text-dark" :style="inputStyles('order_matches_count')>Total Trades</a></th>
          <th>Last Trade</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="market in markets">
          <td><a :href="'/market/' + market.slug">{{ market.base_asset }}</a></td>
          <td class="text-right">{{ market.market_cap }} <a :href="'/market/' + market.slug">{{ market.quote_asset }}</a></td>
          <td class="text-right">{{ market.price }} <a :href="'/market/' + market.slug">{{ market.quote_asset }}</a></td>
          <td class="text-right">{{ market.volume }} <a :href="'/market/' + market.slug">{{ market.quote_asset }}</a></td>
          <td class="text-center">{{ market.get_orders_count }}</td>
          <td class="text-center">{{ market.give_orders_count }}</td>
          <td class="text-center">{{ market.order_matches_count }}</td>
          <td>{{ market.last_trade_date }}</td>
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
  computed: {
    inputStyles(sortBy) {
      if (this.sort_by === sortBy) {
        return {
          text-decoration: 'underline'
        }
      } else {
        return {};
      }
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