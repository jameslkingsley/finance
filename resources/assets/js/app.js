require('./bootstrap');

Vue.filter('currency', value => {
    if (value === null) return null;

    let langage = (navigator.language || navigator.browserLanguage).split('-')[0];

    return value.toLocaleString(langage, {
        style: 'currency',
        currency: 'gbp'
    });
});

Vue.component('f-week', require('./components/Week.vue'));
Vue.component('f-purchases', require('./components/Purchases.vue'));
Vue.component('f-summary', require('./components/Summary.vue'));

const app = new Vue({
    el: '#app'
});
