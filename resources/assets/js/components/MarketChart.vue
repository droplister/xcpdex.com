<template>
<div class="row" v-if="results > 0">
  <div class="col">
    <div class="border">
      <highcharts :constructor-type="'stockChart'" :options="chartOptions"></highcharts>
    </div>
  </div>
</div>
</template>

<script>
import {Chart} from 'highcharts-vue'
import Highcharts from 'highcharts'
import stockInit from 'highcharts/modules/stock'
stockInit(Highcharts)

export default {
  props: ['market', 'base_asset', 'quote_asset'],
  components: {
    highcharts: Chart
  },
  data() {
    return {
      results: 0,
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
            text: 'Price (' + this.quote_asset + ')'
          },
          min: 0,
          height: '75%',
          opposite: true
        },{
          title: {
            text: 'Volume'
          },
          min: 0,
          offset: 0,
          top: '80%',
          height: '20%'
        }],
        rangeSelector: {
            selected: 1
        },
        plotOptions: {
          line: {
            animation: false
          }
        },
        navigator: {
          enabled: true
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
        this.results = response.data.history ? response.data.history.length : 0
        if(this.results > 0)
        {
          this.chartOptions.series.push({
            yAxis: 0,
            type: 'candlestick',
            name: this.market.replace('_', '/'),
            data: response.data.history,
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
            name: 'Volume (' + this.base_asset + ')',
            data: response.data.volumes,
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
        }
      })
    }
  }
}
</script>