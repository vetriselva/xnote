import './bootstrap';
import Alpine from 'alpinejs';

const isProd = window.location.hostname === "sd.d4e.in";

if (isProd) {
    axios.defaults.baseURL = "/public";
}

window.Alpine = Alpine;
Alpine.start();


import { createApp } from 'vue';
import Dashboard from './components/Dashboard.vue';
import '../css/app.css'

const app = createApp(Dashboard);
app.mount('#app');
