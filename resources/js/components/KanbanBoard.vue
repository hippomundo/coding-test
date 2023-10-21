<template>
    <div class="max-w-7xl mx-auto flex flex-col overflow-auto sm:px-6 lg:px-8">
        <div class="w-full mb-6 flex">
            <button @click="showAddTaskModal = true" class="bg-green-700 text-zinc-100 font-bold px-4 py-2 rounded-lg shadow-lg">Add Task</button>
            <div class="flex flex-col">
                <div class="ml-6">
                    Hovered Task: {{ kanban.hoveredName }}
                </div>
                <div class="ml-6">
                    Selected Task: {{ kanban.selectedTask?.name || 'None' }}
                </div>
            </div>
            <Teleport to="body">
                <generic-modal :show="showAddTaskModal" @close="showAddTaskModal = false">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                            <CheckIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            Testing 123....
                            <!-- <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">{{ task.name }}</DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Assigned to {{ task.user.name }}</p>
                            </div> -->
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button"
                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            @click="showAddTaskModal = false">Close</button>
                    </div>
                </generic-modal>
            </Teleport>
        </div>
        <div id="kanban-container" class="flex flex-grow overflow-auto scrollbar-hide shadow-lg">
            <div class="text-gray-900">
                <div class="flex overflow-x-auto space-x-4">
                    <task-column v-for="col in cols" :name="col.name" :tasks="col.tasks"></task-column>
                </div>
            </div>
        </div>


        <!-- Modal to edit the selected card -->
        <Teleport to="body">
            <generic-modal v-if="kanban.hasSelectedTask()" @close="kanban.unselectTask()">
                <div>
                    <div class="mt-3 sm:mt-5">
                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">{{ kanban.selectedTask.name }}</DialogTitle>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">In column {{ kanban.phases[kanban.selectedTask.phase_id-1].name }}</p>
                            <p class="text-sm text-gray-500">Assigned to {{ kanban.selectedTask.user.name }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button type="button"
                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        @click="kanban.unselectTask()">Close</button>
                </div>
            </generic-modal>
        </Teleport>

        
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { CheckIcon } from '@heroicons/vue/24/outline'
import { useKanbanStore } from '../stores/kanban'
import { DialogTitle } from '@headlessui/vue'

const cols = ref([])
const showAddTaskModal = ref(false)
const kanban = useKanbanStore()

// Define these functions outside of onMounted so they're in the component's scope
let pos = { top: 0, left: 0, x: 0, y: 0 };
let ele;

const mouseDownHandler = function (e) {
    ele.style.cursor = 'grabbing';
    ele.style.userSelect = 'none';

    pos = {
        left: ele.scrollLeft,
        top: ele.scrollTop,
        x: e.clientX,
        y: e.clientY,
    };

    document.addEventListener('mousemove', mouseMoveHandler);
    document.addEventListener('mouseup', mouseUpHandler);
};

const mouseMoveHandler = function (e) {
    const dx = e.clientX - pos.x;
    const dy = e.clientY - pos.y;

    ele.scrollTop = pos.top - dy;
    ele.scrollLeft = pos.left - dx;
};

const mouseUpHandler = function () {
    ele.style.cursor = 'grab';
    ele.style.removeProperty('user-select');

    document.removeEventListener('mousemove', mouseMoveHandler);
    document.removeEventListener('mouseup', mouseUpHandler);
};

onMounted(async () => {
    
    try {
        const response = await axios.get('/api/tasks');
        cols.value = response.data;
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }

    await nextTick();

    kanban.phases = cols.value;
    ele = document.getElementById('kanban-container');
    if (ele) {
        ele.style.cursor = 'grab';
        ele.addEventListener('mousedown', mouseDownHandler);
    }

})

onUnmounted(() => {
    if (ele) {
        // Clean up the event listener when the component is unmounted.
        ele.removeEventListener('mousedown', mouseDownHandler);
    }
})
</script>

<style scoped>
/* For Webkit-based browsers (Chrome, Safari and Opera) */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* For IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>