<template>
  <autocomplete
    placeholder=""
    source="/api/markets/search?q="
    input-class="form-control form-control-dark w-100"
    results-property="data"
    results-display="name"
    @selected="goToUrl">
  </autocomplete>
</template>

<script>
import Autocomplete from 'vuejs-auto-complete'

export default {
  components: {
    Autocomplete,
  },
  data () {
    return {
      keyword: '',
      apiResults: null
    }
  },
  methods: {
    goToUrl (obj) {
      this.apiResults = obj
      return window.location.href = '/market/' + this.apiResults.selectedObject.slug
    }
  }
}
</script>
