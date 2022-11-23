<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { onMounted, reactive, ref, computed } from 'vue';
import dayjs from 'dayjs'

const props = defineProps({
    'items': Array,
    'order': Array,
})

onMounted(() => {
    props.items.forEach( item => { // 配列を1つずつ処理
        itemList.value.push({ // 配列に1つずつ追加
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.quantity
        })
    })
})

const getToday = () => {
    const today = new Date()
    const yyyy = today.getFullYear()
    const mm = ('0' + (today.getMonth()+1)).slice(-2); const dd = ('0' + today.getDate()).slice(-2)
    return yyyy + '-' + mm + '-' + dd;
}

const itemList = ref([])

const form = reactive({
    id: props.order.id,
    date: dayjs(props.order.created_at).format("YYYY-MM-DD"),
    customer_id: props.order.customer_id,
    status: props.order.status,
    items: []
})

const totalPrice = computed(() => {
    let total = 0
    itemList.value.forEach( item => {
        total += item.price * item.quantity 
    })
    return total 
})

const updatePurchase = (id) => {
    itemList.value.forEach(item => {
        // 0より大きいものだけ追加
        if (item.quantity > 0) {
            form.items.push({
                id: item.id,
                quantity: item.quantity
            })
        }
    })
    Inertia.put(route('purchases.update', { purchase: id }), form)
}

const quantity = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"] // option用


</script>

<template>
    <div>
        <Head title="購入履歴 編集画面"></Head>
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    購入履歴 編集画面
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <section class="text-gray-600 body-font relative">
                                <form @submit.prevent="updatePurchase(form.id)">
                                    <div class="container px-5 py-8 mx-auto">
                                        <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                            <div class="flex flex-wrap -m-2">

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                                        <input disabled type="date" :value="form.date" id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="customer" class="leading-7 text-sm text-gray-600">会員名</label>
                                                        <input disabled type="text" :value="props.order.customer_name" id="customer" name="customer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                                        <thead>
                                                            <tr>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">id</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">金額</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">数量</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">小計</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody v-for="item in itemList" :key="item.id">
                                                            <tr>
                                                                <td class="px-4 py-3">{{ item.id }}</td>
                                                                <td class="px-4 py-3">{{ item.name }}</td>
                                                                <td class="px-4 py-3">{{ item.price }}</td>
                                                                <td class="px-4 py-3 text-lg text-gray-900">
                                                                    <select name="quantity" v-model="item.quantity">
                                                                        <option v-for="q in quantity" :value="q" :key="q">{{ q }}</option>
                                                                    </select> 
                                                                </td>
                                                                <td class="px-4 py-3">{{ item.price * item.quantity }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div>
                                                        <label for="date" class="leading-7 text-sm text-gray-600">合計金額</label>
                                                        <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                            {{ totalPrice }}円
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="status" class="leading-7 text-sm text-gray-600">ステータス</label>
                                                        <input type="radio" v-model="form.status" value="1" id="status" name="status">未キャンセル
                                                        <input type="radio" v-model="form.status" value="0" id="status" name="status">キャンセルする
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 text-lg">更新する</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
