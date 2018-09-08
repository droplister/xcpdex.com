<template>
<div class="row" v-if="chartOptions.series.length > 0">
  <div class="col">
    <h3 class="mt-3 mb-3">Book Depth</h3>
    <div class="border">
      <highcharts :options="chartOptions"></highcharts>
    </div>
  </div>
</div>
</template>

<script>
import {Chart} from 'highcharts-vue'

export default {
  props: ['market'],
  components: {
    highcharts: Chart
  },
  data() {
    return {
      chartOptions: {
        chart: {
          type: 'area',
          zoomType: 'x',
          panning: true,
          panKey: 'shift',
          events: {
            load() {
              setTimeout(this.reflow.bind(this))
            }
          }
        },
        title: {
          text: ''
        },
        tooltip: {
          shared: true
        },
        labels: {
          enabled: false
        },
        credits: {
          enabled: false
        },
        series: []
      }
    }
  },
  mounted() {
    this.$_depth_chart_update()
  },
  methods: {
    $_depth_chart_update() {
      axios.get('/api/markets/' + this.market + '/depth').then(response => {
        this.chartOptions.series.push({
          name: 'Buys',
          data: this.$_depth_accumulator(response.data.buy_orders),
        })
        this.chartOptions.series.push({
          name: 'Sells',
          data: this.$_depth_accumulator(response.data.sell_orders),
        })
      })
    },
    $_depth_accumulator(data) {
      var accumulation = new Array()
      var runningTotal = 0
      var i = 0
      for (i = 0; i < data.length; i++) {
        runningTotal += parseFloat(data[i][1])
        accumulation.push([data[i][0], runningTotal])
      }
      return accumulation
    }
  }
}
</script>