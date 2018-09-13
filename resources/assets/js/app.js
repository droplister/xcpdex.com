
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('auto-suggest', require('./components/AutoSuggest.vue'));
Vue.component('chart', require('./components/Chart.vue'));
Vue.component('chart-price', require('./components/ChartPrice.vue'));
Vue.component('mempool', require('./components/Mempool.vue'));
Vue.component('blocks', require('./components/Blocks.vue'));
Vue.component('orders', require('./components/Orders.vue'));
Vue.component('order-matches', require('./components/OrderMatches.vue'));
Vue.component('markets', require('./components/Markets.vue'));
Vue.component('market-chart', require('./components/MarketChart.vue'));
Vue.component('market-depth', require('./components/MarketDepth.vue'));
Vue.component('market-orders', require('./components/MarketOrders.vue'));
Vue.component('market-order-matches', require('./components/MarketOrderMatches.vue'));

const app = new Vue({
    el: '#app'
});
