<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    items: Array
})

const deleteItem = (id) => {
    Inertia.delete(route('items.destroy', { item: id }), {
        onBefore: () => confirm('本当に削除してもよろしいでしょうか？')
    })
}
</script>
    
<template>
    <div>
        <Head title="商品一覧" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    商品一覧
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <section class="text-gray-600 body-font">
                                <div class="container px-5 py-8 mx-auto">
                                    <FlashMessage />
                                    <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                                        <Link as="button" :href="route('items.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">商品登録</Link>
                                    </div>
                                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                        <table class="table-auto w-full text-left whitespace-no-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">id</th>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メモ</th>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                                                    <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">ステータス</th>
                                                    <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                                    <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="item in items" :key="item.id">
                                                <tr>
                                                    <td class="px-4 py-3"><Link :href="route('items.show', { item: item.id })" class="text-blue-400">{{ item.id }}</Link></td>
                                                    <td class="px-4 py-3">{{ item.name }}</td>
                                                    <td class="px-4 py-3">{{ item.memo }}</td>
                                                    <td class="px-4 py-3 text-lg text-gray-900">{{ item.price }}</td>
                                                    <td v-if="item.is_selling" class="px-4 py-3">販売中</td>
                                                    <td v-else class="px-4 py-3">停止中</td>
                                                    <td class="px-4 py-3">
                                                        <Link as="button" :href="route('items.edit', { item: item.id })" class="flex ml-auto text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded">編集</Link>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <button @click="deleteItem(item.id)" class="flex ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">削除</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
    