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
                <el-button size="small" plain style="float:right; margin-left:5px">FILTER</el-button>
                <el-date-picker
                    v-model="value2"
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
                            <br><h6 style="float:left">Male</h6>
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
                            <br><h6 style="float:left">Male</h6>
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
                            <br><h6 style="float:left">Male</h6>
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
                        <!-- <el-col>
                            <br><h6 style="float:left">Male</h6>
                        </el-col> -->
                        <el-col>
                            <canvas id="myChart" width="150" height="71"></canvas>
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
                        <!-- <el-col>
                            <br><h6 style="float:left">Male</h6>
                        </el-col> -->
                        <el-col>
                            <canvas id="myChart2" width="10" height="10"></canvas>
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
Chart.register(...registerables);

export default {
    data() {
        const item = {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
        };
        return {
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
            value2: ''
        }
    },
    async mounted() {
        this.$store.commit('SET_LOADING_COMPONENT', false)

        const end = new Date();
        const start = new Date();
        start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
        this.value2 = [start.toISOString().substr(0,10), end.toISOString().substr(0,10)];

        const ctx = await document.getElementById('myChart').getContext('2d');
        const ctx2 = await document.getElementById('myChart2').getContext('2d');

        await new Chart(ctx, {
            type: 'bar',
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
        });

        await new Chart(ctx2, {
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
        });

    },
    created() {
    }
}
</script>

<style>

</style>