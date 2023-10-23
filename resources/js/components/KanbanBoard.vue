<template>
    <div class="max-w-7xl flex-1 mx-auto flex flex-col overflow-auto sm:px-6 lg:px-8">
        <div class="w-full mb-6 flex">
            <Teleport to="body">
                <generic-modal :show="kanban.creatingTask" @close="kanban.creatingTask = false" key="createTaskModal">
                    <div>
                        <div class="mt-3 sm:mt-2">
                            <DialogTitle as="h3" class="mb-6 text-base font-semibold leading-6 text-gray-900">Create a new task</DialogTitle>
                            <div>
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Task description</label>
                                <div class="relative mt-2">
                                    <input type="text" v-model="kanban.creatingTaskProps.name" id="name"
                                        class="peer block w-full border-0 bg-gray-50 py-1.5 text-gray-900 focus:ring-0 sm:text-sm sm:leading-6"
                                        placeholder="Make it productive, but also fun!" />
                                    <p v-if="hasError('name')" 
                                        class="mt-2 text-sm text-red-600" 
                                        id="name-error">
                                            {{ getError('name') }}
                                    </p>
                                    <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2 peer-focus:border-blue-600"
                                        aria-hidden="true" />
                                </div>
                            </div>

                            <Listbox as="div" v-model="kanban.creatingTaskProps.user_id" class="mt-8">
                                <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">Assigned to</ListboxLabel>
                                <div class="relative mt-2">
                                    <ListboxButton
                                        class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm sm:leading-6">
                                        <span class="flex items-center">
                                            <img :src="getAvatar(kanban.users[kanban.creatingTaskProps.user_id || kanban.self.id])" 
                                                 alt="" 
                                                 class="h-5 w-5 flex-shrink-0 rounded-full" 
                                            />
                                            <span class="ml-3 block truncate">{{ kanban.users[kanban.creatingTaskProps.user_id || kanban.self.id].name }}</span>
                                        </span>
                                        <span
                                            class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                        </span>
                                    </ListboxButton>

                                    <transition leave-active-class="transition ease-in duration-100"
                                        leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <ListboxOptions
                                            class="absolute z-20 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                            <ListboxOption as="template" v-for="person in kanban.users" :key="person.id"
                                                :value="person.id" v-slot="{ active, selected }">
                                                <li :class="[active ? 'bg-blue-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                    <div class="flex items-center">
                                                        <img :src="getAvatar(person)" alt="{{ person.name }}"
                                                            class="h-5 w-5 flex-shrink-0 rounded-full" />
                                                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">{{ person.name }}</span>
                                                    </div>

                                                    <span v-if="selected"
                                                        :class="[active ? 'text-white' : 'text-blue-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </li>
                                            </ListboxOption>
                                        </ListboxOptions>
                                    </transition>
                                </div>
                            </Listbox>

                            <div class="mt-8">
                                <label for="taskPhase" class="block text-sm font-medium leading-6 text-gray-900">Phase</label>
                                <select v-model="kanban.creatingTaskProps.phase_id" id="taskPhase" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    <option v-for="phase in kanban.phases" :key="phase.id" :value="phase.id">{{ phase.name }}</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-5 sm:mt-6">
                            <button type="button"
                                class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                                @click="addCard()">Add the card!</button>
                        </div>
                    </div>
                </generic-modal>
            </Teleport>
        </div>

        <div id="kanban-container" class="flex-1 flex overflow-auto scrollbar-hide shadow-lg">
            <div class="text-gray-900">
                <div class="h-full flex overflow-x-auto overflow-y-auto space-x-4">
                    <task-column v-for="col in kanban.phases" :phase_id="col.id"></task-column>
                </div>
            </div>
        </div>

        <!-- Modal to edit the selected card -->
        <Teleport to="body">
            <generic-modal v-if="kanban.hasSelectedTask()" @close="kanban.unselectTask()">
                <div class="relative">
                    <TrashIcon class="w-6 h-6 absolute top-0 right-0 hover:cursor-pointer" @click="deleteCard(kanban.selectedTask.id)" />
                    <div class="flex justify-center">
                        <img class="w-16 h-16 shadow-lg rounded-full border-2 border-blue-800"
                            :src="getAvatar(kanban.selectedTask.user)" :alt="kanban.selectedTask.user.name" />
                    </div>
                    <div class="mt-3 sm:mt-5">
                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">{{ kanban.selectedTask.name }}</DialogTitle>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">In column {{ kanban.phases[kanban.selectedTask.phase_id].name
                            }}</p>
                            <p class="text-sm text-gray-500">Assigned to {{ kanban.selectedTask.user.name }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button type="button"
                        class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                        @click="kanban.unselectTask()">Close</button>
                </div>
            </generic-modal>
        </Teleport>
        
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { useKanbanStore } from '../stores/kanban'
import { DialogTitle, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { sha256 } from 'js-sha256';


const kanban = useKanbanStore()
const selected = ref(null)
const errors = ref(null)

const getAvatar = function (user) {
    if (user.profile_picture_url !== null) {
        return user.profile_picture_url;
    } else {
        return ("https://www.gravatar.com/avatar/" + sha256(String(user.email).trim().toLowerCase()) + "?size=400");
    }
}

const getError = function (field) {
    if (errors.value && errors.value[field]) {
        return errors.value[field][0].message;
    }
    return null;
}

const hasError = function (field) {
    if (errors.value && errors.value[field]) {
        return true;
    }
    return false;
}

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

const refreshTasks = async () => {
    try {
        const response = await axios.get('/api/tasks');
        const originalTasks = response.data;
        kanban.phases = originalTasks.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}

const refreshUsers = async () => {
    try {
        const response = await axios.get('/api/users');
        const originalUsers = response.data;
        // rekey originalUsers to use the id property in the objects as the array key
        kanban.users = originalUsers.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the users!', error);
    }
}

const getSelf = async () => {
    try {
        const response = await axios.get('/api/user');
        kanban.self = response.data;
        if (kanban.creatingTaskProps.user_id === null) {
            kanban.creatingTaskProps.user_id = kanban.self.id;
        }
        if (kanban.self.profile_picture_url === null) {
            kanban.self.profile_picture_url = getAvatar(kanban.self)
        }
    } catch (error) {
        console.error('There was an error fetching the logged in user!', error);
    }
}

const addCard = async () => {
    try {
        const response = await axios.post('/api/tasks', kanban.creatingTaskProps);
        kanban.creatingTask = false;
        kanban.creatingTaskProps = {
            name: null,
            phase_id: null,
            user_id: null
        };
        await refreshTasks();
    } catch (error) {
        if (error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
    }
}

const deleteCard = async (id) => {
    try {
        const response = await axios.delete('/api/tasks/' + id);
        await refreshTasks();
        kanban.unselectTask();
    } catch (error) {
        console.error('There was an error deleting the task!', error);
    }
}

onMounted(async () => {

    await refreshTasks();
    await refreshUsers();
    await getSelf();

    await nextTick();

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

<style scoped>/* For Webkit-based browsers (Chrome, Safari and Opera) */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* For IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}</style>