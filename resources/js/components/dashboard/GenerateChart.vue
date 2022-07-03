<template>
    <!-- <div> -->
        <canvas :v-bind="$attrs" ref="canvas" :id="randomId()" />
    <!-- </div> -->
</template>

<script>
// import { Chart, registerables } from 'chart.js'
// Chart.register(...registerables);
export default {
    props: {
        chartData: {
            type: Object,
            default: {},
        },
        chartAttributes: {
            type: Object,
            default: {}
        }
    },
    methods:{
        randomId(){
            return Math.random().toString().split('.').at(-1)
        }
    },
    mounted() {
        this.$nextTick(()=>{
        console.log("ddddddd", this.chartAttributes)
        const {Chart, registerables} = this.chartAttributes
        Chart.register(...registerables);
        new Chart(this.$refs.canvas.id, this.chartData);})
    }
}
</script>