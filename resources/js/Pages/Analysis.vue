<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive, onMounted } from 'vue';
import Chart from '@/Components/Chart.vue'
import ResultTable from '@/Components/ResultTable.vue';


onMounted(() => {
    form.startDate = getToday()
    form.endDate = getToday()
})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay'
})

const data = reactive({})

const getToday = () => {
    const today = new Date()
    const yyyy = today.getFullYear()
    const mm = ('0' + (today.getMonth()+1)).slice(-2); const dd = ('0' + today.getDate()).slice(-2)
    return yyyy + '-' + mm + '-' + dd;
}

const getData = async () => {
    try{
        await axios.get('/api/analysis/', { params: {
            startDate: form.startDate,
            endDate: form.endDate,
            type: form.type
        } })
        .then( res => {
            data.data = res.data.data
            data.labels = res.data.labels
            data.totals = res.data.totals
            data.type = res.data.type
        })
    } catch (e){
        console.log(e.message)
    }
}

</script>

<template>
    <div>
        <Head title="データ分析" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    データ分析
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form @submit.prevent="getData">
                                分析方法<br>
                                <input type="radio" v-model="form.type" value="perDay" checked class="mr-2">日別
                                <input type="radio" v-model="form.type" value="perMonth" class="mr-2">月別
                                <input type="radio" v-model="form.type" value="perYear" class="mr-2">年別<br>
                                <input type="radio" v-model="form.type" value="decile" class="mr-2">デシル分析<br>
                                Fomr: <input type="date" name="startDate" v-model="form.startDate">
                                To: <input type="date" name="endDate" v-model="form.endDate"><br>
                                <button class="mt-4 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 text-lg">分析する</button>
                            </form>
                            
                            <div v-if="data.data">
                                <Chart :data="data" />
                                <ResultTable :data="data" />
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
