<script setup>

defineProps({
    item: Object
})
</script>

<template>
    <div>
        {{ item.name }}
        {{ item.memo }}
        {{ item.price }}
    </div>
</template>


<style scoped>

</style>
