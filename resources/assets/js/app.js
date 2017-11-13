require('./bootstrap');

Vue.component('f-week', require('./components/Week.vue'));

const app = new Vue({
    el: '#app'
});
