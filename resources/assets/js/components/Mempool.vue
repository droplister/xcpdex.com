<template>
<div>
  <div class="table-responsive asset-markets" infinite-wrapper>
    <table class="table table-striped table-sm">
      <thead class="text-left">
        <tr>
          <th>Date</th>
          <th>Source</th>
          <th>Bindings</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="tx in mempool">
          <td>{{ tx.date }}</td>
          <td>{{ tx.data.source }}</td>
          <td>{{ tx.data }}</td>
        </tr>
        <infinite-loading force-use-infinite-wrapper="true" @infinite="infiniteHandler">
          <span slot="no-more"></span>
          <span slot="no-results">
            <tr v-if="mempool && mempool.length === 0">
              <td class="text-center" colspan="3">No unconfirmed TXs.</td>
            </tr>
          </span>
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
      mempool: [],
      page: 1
    }
  },
  methods: {
    infiniteHandler($state) {
      axios.get('/api/mempool?page=' + this.page).then(response => {
        if (response.data.mempool.length) {
          this.page = response.data.current_page + 1
          this.mempool = this.mempool.concat(response.data.mempool)
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