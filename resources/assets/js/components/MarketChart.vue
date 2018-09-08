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
        yAxis: [{
          title: {
            text: 'Price'
          },
          labels: {
            formatter: function () {
              return '$' + this.value
            }
          },
          height: '75%',
          opposite: true,
        },{
          title: {
            text: 'Volume'
          },
          top: '80%',
          height: '20%',
          offset: 0,
        }],
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
          yAxis: 0,
          type: 'candlestick',
          name: this.market,
          data: response.data.history
           dataGrouping: {
             units: [
               [
                 'day', // unit name
                 [1] // allowed multiples
               ], [
                 'week',
                 [1]
               ], [
                 'month',
                 [1, 2, 3, 4, 6]
               ]
            ]
          }
        })
        this.chartOptions.series.push({
          yAxis: 1,
          type: 'column',
          name: 'Volume',
          data: response.data.volumes
        })
      })
    }
  }
}
</script>