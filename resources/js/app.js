import './bootstrap';


import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import SideMenu from './Components/SideMenu.vue'
import { createPinia } from 'pinia';
const pinia = createPinia();

import Pagination from './Components/Pagination.vue'
import Cleave from 'vue-cleave-component';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar';
import 'vue3-perfect-scrollbar/style.css';

import dashgrap from './Components/DashGrap.vue'

const app = createApp(App);
app.use(VueSweetalert2);
app.use(Cleave);
app.use(pinia);
app.component('dashgrap',dashgrap);
app.component('SideMenu', SideMenu);
app.component('Pagination',Pagination);
app.use(PerfectScrollbarPlugin);
app.use(router);
app.mount('#app-vue');