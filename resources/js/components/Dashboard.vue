<template>
    <div>
        <el-row :gutter="12">
            <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" style="margin-bottom:20px">
                <!-- <el-select multiple placeholder="Select one or more" style="float:right" size="small" filterable clearable>
                    <el-option v-for="type in enumValues.site_of_infection_history" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
                    <el-option label="2022" value="saf" />
                    <el-option label="2021" value="saf" />
                    <el-option label="2020" value="saf" />
                </el-select> -->
                <!-- <span style="float:left"> Summary </span> -->
                <el-button size="small" plain style="float:right; margin-left:5px" @click="filterData()">FILTER</el-button>
                <el-button size="small" plain style="float:right; margin-left:5px" @click="filterData()">RESET</el-button>
                <el-date-picker
                    v-model="date_range"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="To"
                    start-placeholder="Start date"
                    end-placeholder="End date"
                    style="float:right;width:380px"
                    size="small"
                    timezone="UTC"
                    value-format="yyyy-MM-dd"
                    :picker-options="pickerOptions">
                </el-date-picker>
            </el-col>
        </el-row>
        <el-row :gutter="12">
            <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8" style="margin-bottom:20px">
                <el-card shadow="hover">
                    <h2 style="position: relative; z-index: 99;float:left;">325,325</h2>
                    <!-- <span class="mdi mdi-dots-vertical" style="float:right;top:0"></span> -->
                    <el-dropdown trigger="click" style="position: relative;z-index: 99;float: right;">
                        <span class="el-dropdown-link">
                            <i class="mdi mdi-dots-vertical"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item icon="el-icon-plus">Action 1</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus">Action 2</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus-outline">Action 3</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-check">Action 4</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-check">Action 5</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                    <el-row>
                        <el-col>
                            <br><h6 style="float:left">Severe exposure</h6>
                        </el-col>
                    </el-row>

                    <!-- <div slot="header" class="clearfix">
                        <span>Card name</span>
                        <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
                    </div> -->
                </el-card>
            </el-col>
            <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8" style="margin-bottom:20px">
                <el-card shadow="hover">
                    <h2 style="position: relative; z-index: 99;float:left;">325,325</h2>
                    <!-- <span class="mdi mdi-dots-vertical" style="float:right;top:0"></span> -->
                    <el-dropdown trigger="click" style="position: relative;z-index: 99;float: right;">
                        <span class="el-dropdown-link">
                            <i class="mdi mdi-dots-vertical"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item icon="el-icon-plus">Action 1</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus">Action 2</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus-outline">Action 3</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-check">Action 4</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-check">Action 5</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                    <el-row>
                        <el-col>
                            <br><h6 style="float:left">Minor exposure</h6>
                        </el-col>
                    </el-row>

                    <!-- <div slot="header" class="clearfix">
                        <span>Card name</span>
                        <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
                    </div> -->
                </el-card>
            </el-col>
            <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8" style="margin-bottom:20px">
                <el-card shadow="hover">
                    <h2 style="position: relative; z-index: 99;float:left;">325,325</h2>
                    <!-- <span class="mdi mdi-dots-vertical" style="float:right;top:0"></span> -->
                    <el-dropdown trigger="click" style="position: relative;z-index: 99;float: right;">
                        <span class="el-dropdown-link">
                            <i class="mdi mdi-dots-vertical"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item icon="el-icon-plus">Action 1</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus">Action 2</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus-outline">Action 3</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-check">Action 4</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-check">Action 5</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                    <el-row>
                        <el-col>
                            <br><h6 style="float:left">No exposure</h6>
                        </el-col>
                    </el-row>

                    <!-- <div slot="header" class="clearfix">
                        <span>Card name</span>
                        <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
                    </div> -->
                </el-card>
            </el-col>
        </el-row>

        <el-row :gutter="12">
            <el-col :xs="24" :sm="24" :md="16" :lg="16" :xl="16" style="margin-bottom:20px">
                <el-card shadow="hover">
                    <h5 style="position: relative; z-index: 99;float:left;">Observations</h5>
                    <!-- <span class="mdi mdi-dots-vertical" style="float:right;top:0"></span> -->



                    <el-dropdown trigger="click" style="position: relative;z-index: 99;float: right;">
                        <span class="el-dropdown-link">
                            By Age <i class="el-icon-arrow-down el-icon--right"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item style="text-align:right" v-for="(item, i) in options" :key="i" :icon="`${item.label == 'Age' ? 'el-icon-check' : ''}`">{{ item.label }}</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>

                    <!-- <el-select v-model="value" placeholder="Select" style="float: right;z-index: 99;" size="mini">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select> -->

                    <el-row>
                        <!-- <el-col>
                            <br><h6 style="float:left">Male</h6>
                        </el-col> -->
                        <el-col>
                            <!-- <canvas id="myChart" width="150" height="71"></canvas> -->
                            <GenerateChart v-if="Object.entries(chartData).length" width="150" height="71" :chartAttributes="{ Chart, registerables }" :chartData="chartData"/>
                        </el-col>
                    </el-row>

                    <!-- <div slot="header" class="clearfix">
                        <span>Card name</span>
                        <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
                    </div> -->
                </el-card>
            </el-col>
            <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8" style="margin-bottom:20px">
                <el-card shadow="hover">
                    <h5 style="position: relative; z-index: 99;float:left;">Severity of Rabies Exposure</h5>
                    <!-- <span class="mdi mdi-dots-vertical" style="float:right;top:0"></span> -->
                    <!-- <el-dropdown trigger="click" style="position: relative;z-index: 99;float: right;">
                        <span class="el-dropdown-link">
                            <i class="mdi mdi-dots-vertical"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item icon="el-icon-plus">Action 1</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus">Action 2</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus-outline">Action 3</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-check">Action 4</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-check">Action 5</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown> -->

                    <el-dropdown trigger="click" style="position: relative;z-index: 99;float: right;">
                        <span class="el-dropdown-link">
                            By Severity <i class="el-icon-arrow-down el-icon--right"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item style="text-align:right" v-for="(item, i) in options1" :key="i" :icon="`${item.label == 'Severity' ? 'el-icon-check' : ''}`">{{ item.label }}</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>


                    <el-row>
                        <!-- <el-col>
                            <br><h6 style="float:left">Male</h6>
                        </el-col> -->
                        <el-col>
                            <!-- <canvas id="myChart2" width="10" height="10"></canvas> -->
                            <GenerateChart v-if="Object.entries(chartData2).length" width="10" height="10" :chartAttributes="{ Chart, registerables }" :chartData="chartData2"/>
                        </el-col>
                    </el-row>

                    <!-- <div slot="header" class="clearfix">
                        <span>Card name</span>
                        <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
                    </div> -->
                </el-card>
            </el-col>
        </el-row>

        <!-- <el-table :data="tableData">
            <el-table-column prop="date" label="Date" width="140">
            </el-table-column>
            <el-table-column prop="name" label="Name" width="120">
            </el-table-column>
            <el-table-column prop="address" label="Address">
            </el-table-column>
        </el-table> -->
    </div>
</template>

<script>

import { Chart, registerables } from 'chart.js'
import { mapGetters } from 'vuex';
Chart.register(...registerables);
import GenerateChart from './dashboard/GenerateChart'

export default {
    components: {
        GenerateChart
    },
    data() {

        const item = {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
        };
        return {Chart: null,
        registerables: null,
            tableData: Array(23).fill(item),
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                },
                shortcuts: [{
                    text: 'Last week',
                    onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                    picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: 'Last month',
                    onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                    picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: 'Last 3 months',
                    onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                    picker.$emit('pick', [start, end]);
                    }
                }]
            },
            date_range: '',

            options: [
                {
                    value: 'Option1',
                    label: 'Age'
                },
                {
                    value: 'Option2',
                    label: 'Gender'
                },
                {
                    value: 'Option3',
                    label: 'Bitten Location'
                },
                {
                    value: 'Option4',
                    label: 'Ownership of the Dog'
                },
                {
                    value: 'Option5',
                    label: 'Barangay'
                },
                {
                    value: 'Option6',
                    label: 'Year'
                }
            ],

            options1: [
                {
                    value: 'Option1',
                    label: 'Severity'
                },
                {
                    value: 'Option2',
                    label: 'Most Popular Animal'
                },
                {
                    value: 'Option3',
                    label: 'Outcome'
                },
            ],

            value: '',
            chart1_categ: '',
            chart2_categ: '',
            chartData: {
                type: 'bar',
                data: {
                    labels: ["<  5","5 - 14","15 - 24","25 - 34","35 - 44","45 - 54","55 - 64","65 - >"],
                    datasets: [
                        {
                            label: 'Severe Exposure',
                            backgroundColor: "#008d93",
                            data: [12, 59, 5, 56, 58,12, 59, 65],
                        },
                        {
                            label: 'Minor Exposure',
                            backgroundColor: "#45c490",
                            data: [17, 69, 8, 59, 68,22, 79, 85],
                        }
                    ],
                },
                options: {
                    tooltips: {
                        displayColors: true,
                        callbacks:{
                            mode: 'x',
                        },
                    },
                    scales: {
                        xAxes: {
                            stacked: true,
                            gridLines: {
                                display: false,
                            }
                        },
                        yAxes: {
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                            },
                            type: 'linear',
                        }
                    },
                    legend: { position: 'bottom' },
                }
            },
            chartData2 : {
                type: 'pie',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        }
    },
    computed: {
        ...mapGetters(['date_filter', 'chart_category'])
    },
    methods: {
        filterData() {
            this.$store.commit('SET_DATE_FILTER', this.date_range)
            this.getData()
        },
        async getData() {
            this.date_range = Object.values(this.date_filter)
            this.chart1_categ = JSON.parse(JSON.stringify(this.chart_category.chart1))
            this.chart2_categ = JSON.parse(JSON.stringify(this.chart_category.chart2))
            await axios.get(
                `dashboard_data` +
                `?from=${this.date_filter.from}` +
                `&to=${this.date_filter.to}` +
                `&chart1_categ=${this.chart1_categ}` +
                `&chart2_categ=${this.chart2_categ}`
            ).then((res)=>{
                console.log("res", res.data, this.date_filter, this.chart_category)

                let new_data = JSON.parse(JSON.stringify(this.chartData))
                this.chartData = []
                this.$nextTick(()=>{

                    new_data.data.datasets[1].label = "updated label"
                    new_data.data.datasets[1].data = [77, 69, 89, 59, 68,92, 79, 50]

                    this.chartData = new_data
                })

                // this.chart1_categ = JSON.parse(JSON.stringify(this.chart_category.chart1))
                // this.chart2_categ = JSON.parse(JSON.stringify(this.chart_category.chart2))
            })
            this.$store.commit('SET_LOADING_COMPONENT', false)
        }
    },
    created() {

    },
    async mounted() {
        this.Chart = Chart
        this.registerables = registerables

        await this.getData()

        // this.date_range = Object.values(this.date_filter)
        // this.chart1_categ = JSON.parse(JSON.stringify(this.chart_category.chart1))
        // this.chart2_categ = JSON.parse(JSON.stringify(this.chart_category.chart2))
        // await axios.get(
        //     `dashboard_data` +
        //     `?from=${this.date_filter.from}` +
        //     `&to=${this.date_filter.to}` +
        //     `&chart1_categ=${this.chart1_categ}` +
        //     `&chart2_categ=${this.chart2_categ}`
        // ).then((res)=>{
        //     console.log("res", res.data, this.date_filter, this.chart_category)

        //     // this.chart1_categ = JSON.parse(JSON.stringify(this.chart_category.chart1))
        //     // this.chart2_categ = JSON.parse(JSON.stringify(this.chart_category.chart2))
        // })
        // this.$store.commit('SET_LOADING_COMPONENT', false)

        // // const end = new Date();
        // // const start = new Date();
        // // start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
        // // this.date_range = [start.toISOString().substr(0,10), end.toISOString().substr(0,10)];

        // const ctx = await document.getElementById('myChart').getContext('2d');
        // const ctx2 = await document.getElementById('myChart2').getContext('2d');

        // await new Chart(ctx, {
        //     type: 'bar',
        //     // data: {
        //     //     labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        //     //     datasets: [{
        //     //         label: '# of Votes',
        //     //         data: [12, 19, 3, 5, 2, 3],
        //     //         backgroundColor: [
        //     //             'rgba(255, 99, 132, 0.2)',
        //     //             'rgba(54, 162, 235, 0.2)',
        //     //             'rgba(255, 206, 86, 0.2)',
        //     //             'rgba(75, 192, 192, 0.2)',
        //     //             'rgba(153, 102, 255, 0.2)',
        //     //             'rgba(255, 159, 64, 0.2)'
        //     //         ],
        //     //         borderColor: [
        //     //             'rgba(255, 99, 132, 1)',
        //     //             'rgba(54, 162, 235, 1)',
        //     //             'rgba(255, 206, 86, 1)',
        //     //             'rgba(75, 192, 192, 1)',
        //     //             'rgba(153, 102, 255, 1)',
        //     //             'rgba(255, 159, 64, 1)'
        //     //         ],
        //     //         borderWidth: 1
        //     //     }]
        //     // },
        //     // options: {
        //     //     scales: {
        //     //         y: {
        //     //             beginAtZero: true
        //     //         }
        //     //     }
        //     // }

        //     data: {
        //         labels: ["<  5","5 - 14","15 - 24","25 - 34","35 - 44","45 - 54","55 - 64","65 - >"],
        //         datasets: [
        //             // {
        //             //     label: 'Employee',
        //             //     backgroundColor: "#caf270",
        //             //     data: [12, 59, 5, 56, 58,12, 59, 87],
        //             // },
        //             {
        //                 label: 'Severe Exposure',
        //                 backgroundColor: "#008d93",
        //                 data: [12, 59, 5, 56, 58,12, 59, 65],
        //             },
        //             {
        //                 label: 'Minor Exposure',
        //                 backgroundColor: "#45c490",
        //                 data: [17, 69, 8, 59, 68,22, 79, 85],
        //             }

        //         //     , {
        //         //         label: 'Political parties',
        //         //         backgroundColor: "#2e5468",
        //         //         data: [12, 59, 5, 56, 58, 12, 59, 12],
        //         // }
        //         ],
        //     },
        //     options: {
        //         tooltips: {
        //         displayColors: true,
        //         callbacks:{
        //             mode: 'x',
        //         },
        //         },
        //         scales: {
        //         xAxes: {
        //             stacked: true,
        //             gridLines: {
        //                 display: false,
        //             }
        //         },
        //         yAxes: {
        //             stacked: true,
        //             ticks: {
        //                 beginAtZero: true,
        //             },
        //             type: 'linear',
        //         }
        //         },
        //         // responsive: true,
        //         // maintainAspectRatio: false,
        //         legend: { position: 'bottom' },
        //     }
        // });

        // await new Chart(ctx2, {
        //     type: 'pie',
        //     data: {
        //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        //         datasets: [{
        //             label: '# of Votes',
        //             data: [12, 19, 3, 5, 2, 3],
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 0.2)',
        //                 'rgba(54, 162, 235, 0.2)',
        //                 'rgba(255, 206, 86, 0.2)',
        //                 'rgba(75, 192, 192, 0.2)',
        //                 'rgba(153, 102, 255, 0.2)',
        //                 'rgba(255, 159, 64, 0.2)'
        //             ],
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(153, 102, 255, 1)',
        //                 'rgba(255, 159, 64, 1)'
        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

    },
    created() {
    }
}
</script>

<style>

</style>