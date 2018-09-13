<template>
  <div>
    <highcharts :options="chartOptions"></highcharts>
  </div>
</template>

<script>
import {Chart} from 'highcharts-vue'

export default{
  props: ['source', 'title'],
  components: {
    highcharts: Chart
  },
  data(){
    return{
      chartOptions: {
        chart: {
          events: {
            load() {
              setTimeout(this.reflow.bind(this))
            }
          }
        },
        title: {
          text: this.title
        },
        xAxis: {
          type: 'datetime'
        },
        yAxis: [{
          title: {
            text: 'Price (USD)'
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
            text: 'Market Cap'
          },
          height: '75%',
        },{
          title: {
            text: 'Volume'
          },
          top: '80%',
          height: '20%',
          offset: 0,
        }],
        navigator: {
          enabled: true
        },
        tooltip: {
          shared: true
        },
        credits: {
          enabled: false
        },
        exporting: {
          width: 800
        },
        responsive: {
          rules: [{
            condition: {
              maxWidth: 500
            },
            chartOptions: {
              chart: {
                height: 300,
              },
              yAxis: [{
                title: {
                  text: ''
                }
              },{
                title: {
                  text: ''
                }
              },{
                title: {
                  text: ''
                }
              }]
            }
          }]
        },
        series: []
      }
    }
  },
  mounted() {
    this.$_chart_price_update()
  },
  methods: {
    $_chart_price_update() {
      var api = this.source
      var self = this
      $.get(api, function (data) {
        self.chartOptions.series.push({
          type: 'line',
          name: 'Price (USD)',
          yAxis: 0,
          zIndex: 1,
          color: '#009e73',
          data: data.price
        })
        self.chartOptions.series.push({
          type: 'line',
          name: 'Market Cap',
          yAxis: 1,
          zIndex: 0,
          color: '#7cb5ec',
          data: data.market_cap
        })
        self.chartOptions.series.push({
          type: 'column',
          name: 'Volume',
          yAxis: 2,
          color: '#777777',
          data: data.volume
        })
      })
    }
  }
}
</script>