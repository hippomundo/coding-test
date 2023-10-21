import './bootstrap';
import './bootstrap';
import { createApp } from 'vue';
import TaskCard from './components/TaskCard.vue';

const app = createApp({});

app.component('TaskCard', TaskCard);


app.mount("#app");