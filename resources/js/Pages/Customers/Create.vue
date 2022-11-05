<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive } from 'vue';
import InputError from '@/Components/InputError.vue';
import { Core as YubinBangoCore } from "yubinbango-core2";

const form = reactive({
    name: null,
    kana: null,
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: null,
    memo: null
})

const storeCustomer = () => {
    Inertia.post('/customers', form)
}

const feachAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
        form.address = value.region + value.locality + value.street
    })
}

defineProps({
    errors: Object
})
</script>

<template>
    <div>
        <Head title="顧客登録" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    顧客登録
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <section class="text-gray-600 body-font relative">
                                <form @submit.prevent="storeCustomer">
                                    <div class="container px-5 py-8 mx-auto">
                                        <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                            <div class="flex flex-wrap -m-2">

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                                                        <input type="text" v-model="form.name" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <InputError :message="errors.name" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="kana" class="leading-7 text-sm text-gray-600">顧客名カナ</label>
                                                        <input type="text" v-model="form.kana" id="kana" name="kana" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <InputError :message="errors.kana" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                                        <input type="text" v-model="form.tel" id="tel" name="tel" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <InputError :message="errors.tel" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                                        <input type="email" v-model="form.email" id="email" name="email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <InputError :message="errors.email" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                                        <input type="number" @change="feachAddress" v-model="form.postcode" id="postcode" name="postcode" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <InputError :message="errors.postcode" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                                        <input type="text" v-model="form.address" id="address" name="address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <InputError :message="errors.address" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                                                        <input type="date" v-model="form.birthday" id="birthday" name="birthday" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <InputError :message="errors.birthday" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label class="leading-7 text-sm text-gray-600">性別</label>
                                                        <label for="gender0" class="ml-2 mr-4">男性</label>
                                                        <input type="radio" v-model="form.gender" id="gender0" value="0" name="gender">
                                                        <label for="gender1" class="ml-2 mr-4">女性</label>
                                                        <input type="radio" v-model="form.gender" id="gender1" value="1" name="gender">
                                                        <label for="gender2" class="ml-2 mr-4">その他</label>
                                                        <input type="radio" v-model="form.gender" id="gender2" value="2" name="gender">
                                                        <InputError :message="errors.gender" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                        <textarea v-model="form.memo" id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                        <InputError :message="errors.memo" />
                                                    </div>
                                                </div>

                                                <div class="p-2 w-full">
                                                    <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">顧客登録</button>
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
