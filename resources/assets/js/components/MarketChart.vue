<template>
<div class="border">
  <highcharts :constructor-type="'stockChart'" :options="chartOptions"></highcharts>
</div>
</template>

<script>
import {Chart} from 'highcharts-vue'
import Highcharts from 'highcharts'
import smplTheme from './path/to/smpl.js';
import stockInit from 'highcharts/modules/stock'
stockInit(Highcharts)

Highcharts.theme = smplTheme;
Highcharts.setOptions(Highcharts.theme);

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
        rangeSelector: {
            selected: 5,
            buttons: [{
                type: 'hour',
                count: 6,
                text: '6h'
            },{
                type: 'day',
                count: 1,
                text: '1d'
            }, {
                type: 'week',
                count: 1,
                text: '7d'
            }, {
                type: 'month',
                count: 1,
                text: '1m'
            }, {
                type: 'month',
                count: 3,
                text: '3m'
            }, {
                type: 'year',
                count: 1,
                text: '1y'
            }, {
                type: 'ytd',
                text: 'YTD'
            }, {
                type: 'all',
                text: 'All'
            }]
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