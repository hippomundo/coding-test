import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'

import Alpine from 'alpinejs';
import TaskCard from './components/TaskCard.vue';
import TaskColumn from './components/TaskColumn.vue';
import KanbanBoard from './components/KanbanBoard.vue';
import GenericModal from './components/modals/GenericModal.vue';

const pinia = createPinia()
const app = createApp({});
app.use(pinia);

app.component('TaskCard', TaskCard);
app.component('TaskColumn', TaskColumn);
app.component('KanbanBoard', KanbanBoard);
app.component('GenericModal', GenericModal);

app.mount("#app");


window.Alpine = Alpine;

Alpine.start();
