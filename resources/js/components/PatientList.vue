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
                        <el-input v-model="search" size="mini" placeholder="Type to search" @keyup.enter.native="!!search?searchFunction():resetFunction()">
                            <!-- <template slot="append"> {{ search?`${ListData.length}/${data.length}`:data.length }} Record</template> -->
                            <template slot="prepend"> {{ patients.total }} Record</template>
                            <template slot="append">
                                <el-button v-if="!!search" style="border-radius:0px 0px 0px 0px" class="reset-button" size="mini" @click="resetFunction()">RESET</el-button>
                                <el-button style="border-radius:0px 3px 3px 0px" :class="!search?'':'search-button'" size="mini" @click="searchFunction()" :disabled="!search">SEARCH</el-button>
                            </template>
                        </el-input>
                    </div>
                    <div class="col-7 px-1">
                        <el-button-group style="float: right;">
                            <!-- <el-button type="primary" size="mini"   plain>EXCEL</el-button> -->
                            <!-- <el-button type="primary" size="mini" circle><i class="el-icon-refresh"/></el-button> -->
                            <el-button type="primary" size="mini" @click="addPatient">ADD</el-button>
                            <el-dropdown @command="handleCommand">
                                <el-button type="primary"  size="mini"   >
                                    EXCEL<i class="el-icon-arrow-down el-icon--right"></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item command="import"><i class="mdi mdi-cloud-upload"></i> Import</el-dropdown-item>
                                    <el-dropdown-item command="export"><i class="mdi mdi-cloud-download"></i> Export</el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </el-button-group>
                    </div>
                </div>
            </div>

            <el-table  v-loading="loading" :data="ListData" border>
                <el-table-column prop="name" label="Fullname" width="200" fixed="left" />
                <el-table-column prop="gender" label="Gender" width="75" />
                <el-table-column prop="civil_status" label="Civil Status" width="100" />
                <el-table-column prop="birth_date" label="Birth Date" width="100" />
                <el-table-column label="Age" width="48">
                    <template slot-scope="scope"> {{ calculateAge(scope.row) }} </template>
                </el-table-column>
                <el-table-column prop="address" label="Address" min-width="300" />
                <el-table-column prop="contact_number" label="Contact" width="110" />
                <el-table-column label="Expos." width="70">
                    <template slot-scope="scope"> {{ reduceFalseValue(scope.row.history_count) }} </template>
                </el-table-column>
                <el-table-column label="Last Exposure" width="155" align="center">
                    <template slot-scope="scope"> {{ reduceFalseValue(scope.row.last_history) }} </template>
                </el-table-column>
                <!-- <el-table-column prop="history_count" label="#Exposure" width="100" />
                <el-table-column prop="last_history.date" label="Last Exposure" width="120" /> -->
                <el-table-column width="135" align="center" label="Action">
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
                                <el-button type="primary" size="mini" icon="mdi mdi-plus-thick" circle plain @click="handleAddNewExposure(scope.$index, scope.row)"></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="light" content="View History" placement="top" :enterable="false">
                                <el-button type="primary" size="mini" icon="mdi mdi-more" circle plain @click="handleView(scope.$index, scope.row)"></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="light" content="Edit" placement="top" :enterable="false">
                                <el-button type="success" size="mini" icon="mdi mdi-lead-pencil" circle plain @click="handleEdit(scope.$index, scope.row)"></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="light" content="Delete" placement="top" :enterable="false">
                                <el-button type="danger" size="mini" icon="mdi mdi-delete" circle plain @click="handleDelete(scope.$index, scope.row)"></el-button>
                            </el-tooltip>
                        </el-button-group>
                    </template>
                </el-table-column>
                <template slot="empty" slot-scope="scope">
                    <!-- {{ search ? `Your search for "${ search }" found no results.` : 'No Data'}} -->
                    {{ search ? `No Data Found` : 'No Data'}}
                </template>
            </el-table>

            <div style="text-align: center; overflow-x:auto">
                <!-- <el-pagination
                    background
                    layout="prev, pager, next"
                    @current-change="handleCurrentChange"
                    :page-size="pageSize"
                    :total="total"
                    hide-on-single-page>
                </el-pagination> -->
                <span v-if="data.length" size="mini" style="float:left;margin-top:5px;padding-left:10px; font-size:13px; color:#909399">Showing {{ patients.from.toLocaleString() + ' to ' + patients.to.toLocaleString() + ' of ' + patients.total.toLocaleString() }} entries</span>
                <PaginationComponent
                    v-if="data.length"
                    store="patients"
                    collection="patients"
                    state-action="getPatients"
                    mutation="SET_CURRENT_PAGE_PATIENT"
                    @input="$store.commit('SET_LOADING_COMPONENT', true)"
                />
            </div>

        </el-card>
        <div style="text-align: left; overflow-x:auto">
            <span style="font-size:12px; color:grey">
                Last Reload: {{ lastReload }}
                <el-tooltip effect="light" content="Reload Data" placement="top" :enterable="false">
                    <el-button  size="medium" circle style="border:none; background-color:rgba(0,0,0,0);padding:4px;color:red" @click="reloadData" :loading="loading_component">
                        <i class="el-icon-refresh" v-if="!loading_component"/>
                    </el-button>
                </el-tooltip>
            </span>
        </div>
    </el-col>
    <el-col :span="24">
        <patient-history-list v-if="managePatientHistory" :visible="managePatientHistory" @close="managePatientHistory=$event" :selected-patient="selectedPatient" />
        <!-- <el-drawer
            title="I have a nested table inside!"
            :visible.sync="table"
            direction="rtl"
            size="60%"
        >
            <el-table :data="gridData">
                <el-table-column property="date" label="Date" width="150"></el-table-column>
                <el-table-column property="name" label="Name" width="200"></el-table-column>
                <el-table-column property="address" label="Address"></el-table-column>
                <el-table-column label="Action" align="center">
                    <el-button @click="innerDrawer = true">Click me!</el-button>
                </el-table-column>
            </el-table>
            <el-drawer
                title="I'm inner Drawer"
                :append-to-body="true"
                :visible.sync="innerDrawer"
                size="59%"
            >
                <p>_(:зゝ∠)_</p>
            </el-drawer>
        </el-drawer> -->
    </el-col>
    <el-col :span="24">
        <patient-add-update v-if="managePatientDialog" :dialog-visible="managePatientDialog" :dialog-title="dialogTitle" @close-dialog="managePatientDialog=$event" :selected-data="selectedData" />
        <!-- <el-dialog
            title="Add Patient"
            :visible.sync="dialogVisible"
            width="30%"
        >
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="ruleForm.name"></el-input>
                </el-form-item>
                <el-form-item label="Gender" prop="region">
                    <el-select v-model="ruleForm.region" placeholder="Activity zone">
                    <el-option label="Zone one" value="shanghai"></el-option>
                    <el-option label="Zone two" value="beijing"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Birth Date" required>
                    <el-form-item prop="date1">
                        <el-date-picker type="date" placeholder="Pick a date" v-model="ruleForm.date1" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-form-item>
                <el-form-item label="Address" prop="desc">
                    <el-input type="textarea" v-model="ruleForm.desc"></el-input>
                </el-form-item>
                <el-form-item align="right">
                    <el-button @click="resetForm('ruleForm')">Reset Field</el-button>
                    <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
                </el-form-item>
            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>
            </span>
        </el-dialog> -->
    </el-col>
    <el-col :span="24">
        <ImportPatient v-if="import_patient" :dialog-visible="import_patient" @close="import_patient=false" />
    </el-col>
</el-row>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
import PatientAddUpdate from './patient/PatientAddUpdate'
import PatientHistoryList from './patient/PatientHistoryList'
import PaginationComponent from './helper/PaginationComponent'
import { calAge } from '../constants'
import ImportPatient from './patient/ImportPatient'
export default {
    components: { PatientAddUpdate, PatientHistoryList, PaginationComponent, ImportPatient },
    data() {
        const item = {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
        };
        return {
            //data: Array(523).fill(item),
            //data: JSON.parse(JSON.stringify(this.$store.state.patients.patients)),
            // page: 1,
	    	// pageSize: 10,
            loading: true,
            search: "",

            managePatientDialog: false,
            managePatientHistory: false,
            selectedPatient: [],
            selectedData: null,
            //lastReload: new Date().toLocaleString(),
            dialogTitle: '',
            import_patient: false
        }
    },
    methods: {
        ...mapActions(['getPatients', 'managePatients']),
        handleAddNewExposure(index, row) {
            //this.$store.commit('SET_SELECTED_HISTORY', row)
            var row_data = this.ListData?.find(d=>d.id==row.id)
            var new_expo = true
            this.$store.commit('SET_SELECTED_PATIENT', {...row_data, new_expo})
            this.selectedPatient = row_data
            this.managePatientHistory = true
        },
        handleView(index, row) {
            var row_data = this.ListData?.find(d=>d.id==row.id)
            var new_expo = false
            this.$store.commit('SET_SELECTED_PATIENT', {...row_data, new_expo})
            this.selectedPatient = row_data
            this.managePatientHistory = true
        },
        handleEdit(index, row) {
            this.selectedData = row
            this.selectedData.form_type = 'edit'
            this.dialogTitle = 'Edit Patient Info.'
            this.managePatientDialog = true
        },
        async handleDelete(index, row) {
            await this.$confirm('This will permanently delete the record. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                var form = JSON.parse(JSON.stringify(row))
                form.form_type = "delete"
                this.managePatients(form).then(()=>{
                    if (this.request.status == 'success') {
                        this.$message({
                            type: 'success',
                            message: 'Delete completed'
                        });
                    } else {
                        this.$notify({
                            title: 'Error',
                            message: this.request.message,
                            type: 'error',
                            duration: 0,
                        });
                    }
                })

            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });
            });
		},
        // handleCurrentChange(val) {
		// 	this.page = val;
		// },
        addPatient() {
            //this.managePatients({id: 2, data: ['data1']});
            this.selectedData = null
            this.dialogTitle = 'Add Patient'
            this.managePatientDialog = true
        },
        calculateAge(row) {
            //return !!row.birth_date ? calAge(row.birth_date) : 'N/A';
            if (!!row.birth_date) {
                return calAge(row.birth_date) || 'N/A';
            } else {
                return row.history.length ? '~' + Math.max(...row.history.map(d=>d.age_of_patient)) || 'N/A' : 'N/A';
            }
        },
        reduceFalseValue(prop) { return prop?.date_of_incident? prop?.date_of_incident : prop || 'N/A'; },
        reloadData() {
            if (!!this.search) {
                this.searchFunction()
            } else {
                this.$store.commit('SET_LOADING_COMPONENT', true)
                this.$store.dispatch("getPatients").then(()=>{
                    this.$nextTick(()=>{
                        this.$store.commit('SET_LOADING_COMPONENT', false)
                        //this.lastReload = new Date().toLocaleString()
                    })
                });
            }
        },
        searchFunction() {
            this.$store.commit('SET_LOADING_COMPONENT', true)
            this.$store.dispatch("getPatients", {search_param: this.search.toString().trim(), page_number: 1}).then(()=>{
                this.$nextTick(()=>{
                    this.$store.commit('SET_LOADING_COMPONENT', false)

                })
            });
        },
        resetFunction() {
            this.search = ""
            this.reloadData()
        },
        handleCommand(command) {
            if (command == 'import') {
                this.import_patient = true
            } else {

            }
        }
    },
    watch: {
        selected_patient(val) {
            this.reloadData()
        }
    },
    computed: {
        ...mapGetters(['patients', 'auth', 'request', 'loading_component', 'patients_last_reload', 'selected_patient']),
        data() {
            return this.patients.data || []
        },
        // ListData() {
        //     if(this.search == null) return this.data;
        //     this.filtered = this.data.filter(data => !this.search || data.name.toLowerCase().includes(this.search.toLowerCase()) || data.address.toLowerCase().includes(this.search.toLowerCase()));
        //     this.total = this.filtered.length;
        //     return this.filtered.slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page);
        // }
        // searching() {
            // if (!this.search) {
            //     this.total = this.data.length;
            //     return this.data;
            // }
            // this.page = 1;
            // return this.data.filter(
            //     data => data.name.toLowerCase().includes(this.search.toLowerCase()) || data.address.toLowerCase().includes(this.search.toLowerCase()));
            // return this.data
        // },
        ListData() {
            // this.total = this.searching.length;
            // return this.searching.slice(
            //     this.pageSize * this.page - this.pageSize,
            //     this.pageSize * this.page
            // );
            //return this.data
            return this.patients?.data || []
        },
        lastReload() {
            return this.patients_last_reload
        }
    },
    mounted() {
        this.loading = false
        //this.getPatients();
        //this.data = this.patients
        // this.$store.commit('SET_LOADING_COMPONENT', false)
        // this.$root.$on('reload_patient_data', () => {
        //     this.reloadData()
        // })
    },
    beforeCreate() {
        //this.data = this.$store.state.patients.patients
        this.$store.dispatch("getPatients").then(()=>{
            this.$store.commit('SET_LOADING_COMPONENT', false)
        });
    }
}
</script>

<style scoped>
    .search-button:hover {
        background-color: #409EFF !important;
        color: white;
    }
    .reset-button:hover {
        background-color: #FFBD00 !important;
        color: white;
    }
</style>