<script setup>
import { Inertia } from '@inertiajs/inertia';
import { reactive } from 'vue';

const form = reactive({
    title: null,
    content: null
})
const submit = () => {
    Inertia.post('/inertia/store', form)
}

defineProps({
    errors: Object
})
</script>
    
<template>
    <div>
        <form @submit.prevent="submit">
            <input type="text" id="title" v-model="form.title" /><br>
            <div v-if="errors.title">{{ errors.title }}</div>
            <input type="text" id="content" v-model="form.content" /><br>
            <div v-if="errors.content">{{ errors.content }}</div>
            <button>Submit</button>
        </form>
    </div>
</template>


<style>

</style>