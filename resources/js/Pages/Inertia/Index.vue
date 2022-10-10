<script setup>
import { Link } from '@inertiajs/inertia-vue3'
defineProps({
    blogs: Array
})
</script>
    
<template>
    <div>
        <div v-if="$page.props.flash.message" class="bg-blue-300">{{ $page.props.flash.message }}</div>

        <ul v-for="blog in blogs" :key="blog.id">
            <li>
                <Link :href="route('inertia.show', { id: blog.id })" class="text-blue-300">件名 : {{ blog.title }}</Link>
                本文 : {{ blog.content }}
            </li>
        </ul>
    </div>
</template>


<style>

</style>