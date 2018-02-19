window._ = require('lodash');

window.ajax = require('axios');
window.ajax.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.ajax.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.opt = window.optional = object => {
    object = object || {};
    return new Proxy(object || {}, {
        get(target, name) {
            return name in target ? target[name] : null;
        }
    });
};

window.Vue = require('vue');

import VTooltip from 'v-tooltip';
Vue.use(VTooltip);

window.formatAsCurrency = value => {
    if (value === null) return null;

    let langage = (navigator.language || navigator.browserLanguage).split('-')[0];

    return (value / 100).toLocaleString(langage, {
        style: 'currency',
        currency: 'gbp'
    });
};

Vue.filter('currency', window.formatAsCurrency);

Vue.filter('date', value => {
    return moment(value).format('DD/MM/YY');
});

import Form from './form';
window.Form = Form;

import colorFromPercentage from './color';
window.colorFromPercentage = colorFromPercentage;

require('./event');

window.moment = require('moment');
