<template>
<div class="w-[300px] bg-sky-950 rounded-lg shadow-lg">
    <div class="p-4">
        <h2 class="text-lg text-zinc-100 font-black mb-3">{{ name }}</h2>
        <task-card v-if="tasks.length > 0" v-for="task in tasks" :task="task" />

        <!-- A card to create a new task -->
        <!-- <div class="w-full bg-white text-gray-900 hover:cursor-pointer shadow-md rounded-lg p-3 pb-8 mb-4 relative"
            @click="kanban.creatingTask = true;">
            Create a new task
        </div> -->

    </div>
</div>
</template>

<script setup>
// get the props
import { ref, onMounted, nextTick } from 'vue'

const name = ref(null)
const tasks = ref([])

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})

const getTasks = async () => {
    try {
        const response = await axios.get('/api/phases/' + props.phase_id);
        tasks.value = response.data.tasks;
        name.value = response.data.name;
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}

onMounted(async () => {
    await getTasks();
    await nextTick();
})

</script>