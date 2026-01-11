import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();


import { createApp } from 'vue';
import Dashboard from './components/Dashboard.vue';
import '../css/app.css'

const app = createApp(Dashboard);
app.mount('#app');
