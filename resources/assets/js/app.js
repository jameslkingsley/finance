require('./bootstrap');

window.formatAsCurrency = value => {
    if (value === null) return null;

    let langage = (navigator.language || navigator.browserLanguage).split(
        '-'
    )[0];

    return value.toLocaleString(langage, {
        style: 'currency',
        currency: 'gbp'
    });
};

Vue.filter('currency', window.formatAsCurrency);

Vue.filter('date', value => {
    return moment(value).format('DD/MM/YY');
});

Vue.component('grid', require('./components/Grid.vue'));
Vue.component('mobile', require('./components/Mobile.vue'));
Vue.component('bg-image', require('./components/Image.vue'));
Vue.component('f-week', require('./components/Week.vue'));
Vue.component('f-purchases', require('./components/Purchases.vue'));
Vue.component('f-expenses', require('./components/Expenses.vue'));
Vue.component('f-summary', require('./components/Summary.vue'));
Vue.component('f-analysis', require('./components/Analysis.vue'));

const app = new Vue({
    el: '#app'
});
