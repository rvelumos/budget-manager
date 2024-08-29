import './bootstrap';

import { createApp } from 'vue';
import ChartComponent from './components/ChartComponent.vue';

const app = createApp({});

app.component('chart-component', ChartComponent);

app.mount('#app');
