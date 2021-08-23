<template>
<div v-if="show">
    <div class="row">
        <div class="col-md-12">
            <div class="card flex-row mt-3 mb-2 box-shadow">
                <img class="card-img-right flex-auto" :alt="this.asset" style="width: 100px;" :src="card_img_url">
                <div class="card-body d-flex flex-column align-items-start">
                    <a :href="collection_url">{{ collection }}</a>
                    <h4 class="card-title">{{ card }} <small class="lead">{{ meta }}</small></h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a :href="card_url" type="button" class="btn btn-sm btn-outline-secondary mr-3">
                              <i aria-hidden="true" class="fa fa-diamond text-highlight" style="color:#00ff21!important"></i>
                              DIGIRARE
                            </a>
                        </div>
                        <small class="text-muted">{{ date }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
  props: ['asset'],
  data () {
    return {
      show: false,
      card: '',
      card_url: '',
      card_img_url: '',
      collection: '',
      collection_url: '',
      meta: '',
      date: '',
    }
  },
  mounted: function() {
    axios.get('http://digirare.com/api/widget/' + this.asset).then(response => {
      this.show = true
      this.card = response.data.name
      this.card_url = 'https://digirare.com/cards/' + response.data.name
      this.card_img_url = 'http://digirare.com' + response.data.image
      this.collection = response.data.collections[0].name
      this.collection_url = 'https://digirare.com/browse?collection=' + response.data.collections[0].slug
      this.meta = response.data.collections[0].slug === 'rare-pepe' ? response.data.meta.series : ''
      this.date = response.data.date
    }).catch(err => {
      this.show = false
    });
  }
}
</script>
