<template>
<div>
  <div class="table-responsive asset-markets" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Block #</th>
          <th>Orders</th>
          <th>Order Matches</th>
          <th>Cancellations</th>
          <th>Confirmed At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="block in blocks">
          <td><a :href="'https://xcpfox.com/block/' + block.block_index" target="_blank">{{ block.block_index }}</a></td>
          <td>{{ block.orders_count }}</td>
          <td>{{ block.order_matches_count }}</td>
          <td>{{ block.cancels_count }}</td>
          <td>{{ block.date }}</td>
        </tr>
        <tr v-if="blocks && blocks.length === 0">
          <td class="text-center" colspan="5">No blocks found.</td>
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
      blocks: [],
      page: 1
    }
  },
  methods: {
    infiniteHandler($state) {
      axios.get('/api/blocks?page=' + this.page).then(response => {
        if (response.data.blocks.length) {
          this.page = response.data.current_page + 1
          this.blocks = this.blocks.concat(response.data.blocks)
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