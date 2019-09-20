require('./global.functions');
global.$ = require('jquery');
global.Vue = require('vue/dist/vue.common');
require('vue-the-mask/dist/vue-the-mask');
require('./login');
global.LazyLoad = require('lazyload/lazyload.min.js');

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask);