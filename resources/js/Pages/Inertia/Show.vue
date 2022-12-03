<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    id: String,
    blog: Object
})

const deleteBlog = (id) => {
    Inertia.delete(`/inertia/delete/${id}`, {
        onBefore: () => confirm('削除してもよろしいでしょうか？')
    })
}
</script>
    
<template>
    <div>
        <p>件名: {{ blog.title }}</p>
        <p>本文: {{ blog.content }}</p>
        <button @click="deleteBlog(blog.id)">削除</button>
    </div>
    
</template>


<style>

</style>