<template>
    <div>
        <h2>{{ title }} (Current Month)</h2>
        <canvas :id="chartId"></canvas>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import Chart from 'chart.js/auto';

export default {
    props: {
        type: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        chartId: {
            type: String,
            required: true
        }
    },
    setup(props) {
        const dataItems = ref([]);

        const fetchData = async () => {
            const response = await axios.get(`/api/${props.type}/current-month`);
            dataItems.value = response.data;
            renderChart();
        };

        const renderChart = () => {
            const ctx = document.getElementById(props.chartId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: dataItems.value.map(item => item.category_name),
                    datasets: [{
                        data: dataItems.value.map(item => item.amount),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'],
                    }]
                }
            });
        };

        onMounted(fetchData);

        return { dataItems };
    }
};
</script>
