require('./bootstrap');

import Vue from 'vue';

import {InertiaApp} from '@inertiajs/inertia-vue';
import {InertiaForm} from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import Vuelidate from 'vuelidate';

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);

Vue.use(Vuelidate);

import {Notification} from "element-ui";

Vue.prototype.$notify = Notification;


const app = document.getElementById('app');

let initialPage = app ? JSON.parse(app.dataset.page) : {}

try {
    new Vue({
        render: (h) =>
            h(InertiaApp, {
                props: {
                    initialPage: initialPage || '/projects',
                    resolveComponent: (name) => import(`./Pages/${name}`).then(module => module.default),
                },
            }),
    }).$mount(app);

} catch (e) {

}
