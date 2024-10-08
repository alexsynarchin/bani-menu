

require('./bootstrap');
import Vue from "vue";
import VueSmoothScroll from 'vue2-smooth-scroll'
import App from "./App";
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)

import Notifications from 'vue-notification'
Vue.use(Notifications)

import Vuex from "vuex";
import storeState from "./store";
Vue.use(Vuex);
const store = new Vuex.Store(storeState);
Vue.use(VueSmoothScroll)
Vue.component('catalog', require('./components/catalog').default);

new Vue({
    el: '#app',

    store,

    render: h => h(App),
});
Vue.directive('phone', {
    bind(el) {
        el.oninput = function(e) {
            if (!e.isTrusted) {
                return
            }
            if (this.value[0] === '8') {
                this.value = this.value.replace('8', '+7');
            }
            if (this.value.replace(/[^0-9]+/g, '') === '789') {
                this.value = '79';
            }
            const x = this.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            x[1] = '+7';
            this.value = !x[3] ? x[1] + ' (' + x[2] : x[1] + ' (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '')

        }

    }
})
