require('./bootstrap');

Vue.component('grid', require('./components/Grid.vue'));
Vue.component('grid-child', require('./components/GridChild.vue'));
Vue.component('mobile', require('./components/Mobile.vue'));
Vue.component('bg-image', require('./components/Image.vue'));
Vue.component('f-modal', require('./components/Modal.vue'));
Vue.component('f-week', require('./components/Week.vue'));
Vue.component('f-purchases', require('./components/Purchases.vue'));
Vue.component('f-expenses', require('./components/Expenses.vue'));
Vue.component('f-summary', require('./components/Summary.vue'));
Vue.component('f-funds', require('./components/Funds.vue'));
Vue.component('f-income', require('./components/Income.vue'));
Vue.component('f-analysis', require('./components/Analysis.vue'));

Vue.component('f-user-settings', require('./components/user/settings/Index.vue'));
Vue.component('f-user-settings-profile', require('./components/user/settings/Profile.vue'));
Vue.component('f-user-settings-income', require('./components/user/settings/income/Index.vue'));
Vue.component('f-user-settings-income-salary', require('./components/user/settings/income/Salary.vue'));
Vue.component('f-user-settings-income-wages', require('./components/user/settings/income/Wages.vue'));

const app = new Vue({
    el: '#app'
});
