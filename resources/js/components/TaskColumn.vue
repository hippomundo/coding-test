<template>
<div class="w-[300px] bg-sky-950 rounded-lg shadow-lg">
    <div class="p-4">
        <h2 class="text-lg text-zinc-100 font-black mb-3">{{ name }}</h2>
        <task-card v-for="task in tasks" :task="task" />
    </div>
</div>
</template>

<script setup>
// get the props
import { ref } from 'vue'

const coltasks = ref([])

const props = defineProps({
    tasks: {
        type: Array,
        required: true
    },
    name: {
        type: String,
        required: true
    }
})

</script>