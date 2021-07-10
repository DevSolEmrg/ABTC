<template>
<el-row :gutter="24">
    <el-col :span="24">
        <el-card shadow="never" :body-style="{ padding: '0px' }">
            <div slot="header">
                <!-- <span>Card name</span> -->
                <!-- <el-button style="float: right; padding: 3px 0" type="text">&nbsp;ADD</el-button>
                <el-button style="float: right; padding: 3px 0" type="text">EXCEL |</el-button> -->
                
                <div class="row">
                    <div class="col-5 px-1">
                        <el-input v-model="search" size="mini" prefix-icon="el-icon-search" placeholder="Type to search" clearable>
                            <template slot="append"> 120 Record</template>
                        </el-input>
                    </div>
                    <div class="col-7 px-1">
                        <el-button-group style="float: right;">
                            <!-- <el-button type="primary" size="mini"   plain>EXCEL</el-button> -->
                            <!-- <el-button type="primary" size="mini" circle><i class="el-icon-refresh"/></el-button> -->
                            <el-button type="primary" size="mini" @click="addPatient">ADD</el-button>
                            <el-dropdown>
                                <el-button type="primary"  size="mini"   >
                                    EXCEL<i class="el-icon-arrow-down el-icon--right"></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item><i class="mdi mdi-cloud-upload"></i> Import</el-dropdown-item>
                                    <el-dropdown-item><i class="mdi mdi-cloud-download"></i> Export</el-dropdown-item>
                                </el-dropdown-menu>
                        </el-dropdown>    
                        </el-button-group>
                    </div>
                </div>
            </div>

            <el-table  v-loading="loading" :data="ListData" border>
                <el-table-column prop="name" label="Name" width="220">
                </el-table-column>
                <el-table-column prop="address" label="Address">
                </el-table-column>
                <el-table-column prop="id" label="#Exposure" width="100">
                </el-table-column>
                <el-table-column prop="date" label="Last Exposure" width="120">
                </el-table-column>
                <el-table-column width="135" align="center" fixed="right" label="Action">
                    <!-- <template slot="header" slot-scope="scope">
                        <el-input v-model="search" size="mini" placeholder="Type to search"/>
                    </template> -->
                    <template slot-scope="scope">
                        <!--<el-tooltip class="item" effect="light" content="View" placement="top">
                            <el-button size="mini" type="info" icon="el-icon-info" circle @click="handleView(scope.$index, scope.row)"></el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="light" content="Edit" placement="top">
                            <el-button size="mini" type="primary" icon="el-icon-edit" circle @click="handleEdit(scope.$index, scope.row)"></el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="light" content="Delete" placement="top">
                            <el-button size="mini" type="danger" icon="el-icon-delete" circle @click="handleDelete(scope.$index, scope.row)"></el-button>
                        </el-tooltip>-->
                        <el-button-group>
                            <el-tooltip class="item" effect="light" content="Add New Exposure" placement="top" :enterable="false">
                                <el-button type="primary" size="mini" icon="mdi mdi-plus-thick" circle plain></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="light" content="View" placement="top" :enterable="false">
                                <el-button type="primary" size="mini" icon="mdi mdi-more" circle plain></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="light" content="Edit" placement="top" :enterable="false">
                                <el-button type="success" size="mini" icon="mdi mdi-lead-pencil" circle plain></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="light" content="Delete" placement="top" :enterable="false">
                                <el-button type="danger" size="mini" icon="mdi mdi-delete" circle plain></el-button>
                            </el-tooltip>
                        </el-button-group>
                    </template>
                </el-table-column>
                <template slot="empty" slot-scope="scope">
                    No Data
                </template>
            </el-table>
            
            <div style="text-align: center; overflow-x:auto">
                <el-pagination
                    background
                    layout="prev, pager, next"
                    @current-change="handleCurrentChange"
                    :page-size="pageSize"
                    :total="data.length"
                    hide-on-single-page>
                </el-pagination>
            </div>
            

        </el-card>
        <div style="text-align: left; overflow-x:auto">  
            <span style="font-size:12px; color:grey">
                Last Reload: 07/04/2021 1:28pm
                <el-tooltip effect="light" content="Reload Data" placement="top" :enterable="false">
                    <el-button  size="mini" circle style="border:none; background-color:rgba(0,0,0,0)">
                        <i class="el-icon-refresh"/>
                    </el-button>
                </el-tooltip>
            </span>
        </div>
    </el-col>
</el-row>
    
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        const item = {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
        };
        return {
            //data: Array(523).fill(item),
            data: JSON.parse(JSON.stringify(this.$store.state.patients.patients)),
            page: 1,
	    	pageSize: 10,
            loading: true,
            search: "",
        }
    },
    methods: {
        ...mapActions(['getPatients', 'managePatients']),
        handleView(index, row) {
        },
        handleEdit(index, row) {
        },
        handleDelete(index, row) {
		},
        handleCurrentChange(val) {
			this.page = val;
		},
        addPatient() {
            this.managePatients({id: 2, data: ['data1']});
        }
    },
    computed: {
        ...mapGetters(['patients', 'auth']),
        ListData() {
            if(this.search == null) return this.data;
            this.filtered = this.data.filter(data => !this.search || data.name.toLowerCase().includes(this.search.toLowerCase()) || data.address.toLowerCase().includes(this.search.toLowerCase()));
            this.total = this.filtered.length;
            return this.filtered.slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page);
        }
    },
    mounted() {
        this.loading = false
        this.getPatients();
        //this.data = this.patients
        //console.log(this.$store.state.patients.patients)
    },
    // beforeCreate() {
    //     this.data = this.$store.state.patients.patients
    // }
}
</script>

<style>

</style>