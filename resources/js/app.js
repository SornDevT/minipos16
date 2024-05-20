import './bootstrap';


import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import SideMenu from './Components/SideMenu.vue'

const app = createApp(App);
app.component('SideMenu', SideMenu);
app.use(router);
app.mount('#app-vue');