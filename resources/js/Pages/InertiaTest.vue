<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue'

const newTitle = ref('')
const newContent = ref('')
</script>

<template>
    <div>
        Inertiaテストです<br>
        <a href="/">aタグ経由です</a><br>
        <Link href="/">Link経由です</Link><br>
        <Link :href="route('inertia.index')">名前付きルートの確認です</Link>
        <Link :href="route('inertia.show', { id: 1})">show</Link>

        <div class="mb-8"></div>
        <input type="text" name="title" v-model="newTitle">{{ newTitle }}<br>
        <input type="text" name="content" v-model="newContent">{{ newContent }}<br>
        <Link as="button" method="post" :href="route('inertia.store')" :data="{title: newTitle, content: newContent}">保存テスト</Link>
    </div>
  
</template>


<style>

</style>