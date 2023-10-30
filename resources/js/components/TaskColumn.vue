<template>
<div class="w-[300px] bg-sky-950 rounded-lg shadow-lg h-[calc(100vh-200px)] overflow-auto">
    <div class="p-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg text-zinc-100 font-black mb-3">{{ kanban.phases[props.phase_id].name }} ({{ tasks_count }})</h2>
            <div class="flex items-center mb-4">
                <input id="default-checkbox" type="checkbox" @change="moveCards" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <PlusIcon
                @click="createTask()"
                class="mb-3 h-6 w-6 text-white hover:cursor-pointer"
                aria-hidden="true" />
            <TrashIcon
                @click="deletePhase()"
                class="mb-3 h-6 w-6 text-white hover:cursor-pointer"
                aria-hidden="true" />
        </div>
        <task-card v-if="kanban.phases[props.phase_id].tasks.length > 0" v-for="task in kanban.phases[props.phase_id].tasks" :task="task" />

        <!-- A card to create a new task -->
        <div class="w-full flex items-center justify-between bg-white text-gray-900 hover:cursor-pointer shadow-md rounded-lg p-3 relative"
            @click="createTask()">
            <span>Create a new task</span>
            <PlusIcon class="h-6 w-6" aria-hidden="true" />
        </div>

    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { onMounted, ref} from "vue";

const kanban = useKanbanStore()

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
    tasks_count: {
        type: Number,
        default: 0
    }
})


const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}
// move phase code start here
const moveCards = function () {    
    kanban.movingTask = true;
    kanban.movingTaskModal.phase_id = props.phase_id;
}

const deletePhase = async () => {
    const result = confirm('Do you want to delete the column?');
    if(result){
        await kanban.deletePhase(props.phase_id)
    }
}

</script>
