import './bootstrap';


import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import SideMenu from './Components/SideMenu.vue'
import { createPinia } from 'pinia';
const pinia = createPinia();

const app = createApp(App);
app.use(pinia);
app.component('SideMenu', SideMenu);
app.use(router);
app.mount('#app-vue');