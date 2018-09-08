<template>
<div class="border">
  <highcharts :constructor-type="'stockChart'" :options="chartOptions"></highcharts>
</div>
</template>

<script>
import {Chart} from 'highcharts-vue'
import Highcharts from 'highcharts'
import stockInit from 'highcharts/modules/stock'
stockInit(Highcharts)

export default {
  props: ['market'],
  components: {
    highcharts: Chart
  },
  data() {
    return {
      chartOptions: {
        chart: {
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
    this.$_chart_update()
  },
  methods: {
    $_chart_update() {
      axios.get('/api/markets/' + this.market + '/chart').then(response => {
        this.chartOptions.series.push({
          type: 'candlestick',
          name: this.market,
          data: response.data.history,
          dataGrouping: {
            units: [
              [
                'week', // unit name
                [1] // allowed multiples
              ], [
                'month',
                [1, 2, 3, 4, 6]
              ]
            ]
          }
        })
      })
    }
  }
}
</script>