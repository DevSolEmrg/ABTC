<template>
    <el-drawer
        :title="selectedPatient.name.toUpperCase()"
        :visible.sync="visible"
        direction="rtl"
        :size="`${size}%`"
        :wrapperClosable="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :modal="true"
        :before-close="closeDrawer"
    >
        <div style="margin: 0px 10px">
            <el-card shadow="never" :body-style="{ padding: '0px' }">
                <div slot="header">
                    <div class="row">
                        <div class="col-8 px-1">
                            <el-input v-model="search" size="mini" prefix-icon="el-icon-search" placeholder="Type to search" clearable>
                                <template slot="append"> {{ data.length }} Record</template>
                            </el-input>
                        </div>
                        <div class="col-4 px-1">
                            <el-button-group style="float: right;">
                                <el-button type="primary" size="mini"  >ADD</el-button>
                                
                            </el-button-group>
                        </div>
                    </div>
                </div>

                <el-table :data="ListData" border>
                    <el-table-column property="date" label="Date" width="100"></el-table-column>
                    <el-table-column property="place" label="Place" min-width="300"></el-table-column>
                    
                    <el-table-column property="remarks" label="Remarks" min-width="300"></el-table-column>

                    <el-table-column type="expand" label="View More" width="100">
                        <template slot-scope="props">
                            <p><strong>Type of Animal:</strong> {{ props.row.type_of_animal }}</p>
                            <p><strong>Type:</strong> {{ props.row.type }}</p>
                            <p><strong>Body Parts:</strong> {{ props.row.body_parts }}</p>
                            <p><strong>Outcome:</strong> {{ props.row.outcome }}</p>
                            <p><strong>Biting Animal Status:</strong> {{ props.row.biting_animal_status }}</p>
                        </template>
                    </el-table-column>

                    <!-- <el-table-column property="type_of_animal" label="Type of Animal" width="120"></el-table-column>
                    <el-table-column property="type" label="Type" width="60"></el-table-column>
                    <el-table-column property="body_parts" label="Body Parts" width="100"></el-table-column>
                    <el-table-column property="outcome" label="Outcome" width="90"></el-table-column>
                    <el-table-column property="biting_animal_status" label="Biting Animal Status" width="160"></el-table-column> -->

                    
                    <el-table-column label="Action" align="center" fixed="right" width="135">
                        <el-button @click="innerDrawer = true">Click me!</el-button>
                    </el-table-column>
                    <template slot="empty" slot-scope="scope">
                        {{ search ? `Your search for "${ search }" found no results.` : 'No Data'}}
                    </template>
                </el-table>

                <div style="text-align: center; overflow-x:auto">
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        @current-change="handleCurrentChange"
                        :page-size="pageSize"
                        :total="total"
                        hide-on-single-page>
                    </el-pagination>
                </div>
            </el-card>

            <div style="text-align: left; overflow-x:auto">  
                <span style="font-size:12px; color:grey">
                    Last Reload: {{ lastReload }}
                    <el-tooltip effect="light" content="Reload Data" placement="top" :enterable="false">
                        <el-button  size="mini" circle style="border:none; background-color:rgba(0,0,0,0)">
                            <i class="el-icon-refresh"/>
                        </el-button>
                    </el-tooltip>
                </span>
            </div>

        </div>

        <el-drawer
            title="I'm inner Drawer"
            :append-to-body="true"
            :visible.sync="innerDrawer"
            :size="`${size-1}%`"
        >
            <p>_(:зゝ∠)_</p>
        </el-drawer>
    </el-drawer>
</template>

<script>
import { drawerSize } from '../../constants'
export default {
    props: ['visible', 'selectedPatient'],
    data() {
        return {
            size: 60,
            gridData: [
                {
                    date: '2016-05-02',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }, {
                    date: '2016-05-04',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }, {
                    date: '2016-05-01',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }, {
                    date: '2016-05-03',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }
            ],
            innerDrawer: false,
            page: 1,
	    	pageSize: 5,
            loading: true,
            search: "",
            lastReload: new Date().toLocaleString()
        }
    },
    computed: {
        data() {
            return JSON.parse(JSON.stringify(this.selectedPatient.history))
        },
        searching() {
            if (!this.search) {
                this.total = this.data.length;
                return this.data;
            }
            this.page = 1;
            return this.data.filter(
                data => data.date.toLowerCase().includes(this.search.toLowerCase()) || data.place.toLowerCase().includes(this.search.toLowerCase()));
        },
        ListData() {
            this.total = this.searching.length;
            return this.searching.slice(
                this.pageSize * this.page - this.pageSize,
                this.pageSize * this.page
            );
        }
    },
    methods: {
        closeDrawer() {
            this.$emit('close', false)
        },
        rezize() {
            this.size = drawerSize(window.innerWidth)
        },
        handleCurrentChange(val) {
			this.page = val;
		},
    },
    created() {
        window.onresize = function() { this.rezize() }.bind(this)
    },
    mounted() {
        this.rezize()
        this.gridData = JSON.parse(JSON.stringify(this.selectedPatient.history))
    }
}
</script>

<style>

</style>