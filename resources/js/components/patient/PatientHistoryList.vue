<template>
    <el-drawer
        :title="`${selectedPatient.name.toUpperCase() || ''}`"
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
            <span>LIST OF EXPOSURE</span>
            <el-card shadow="never" :body-style="{ padding: '0px' }">
                <div slot="header">
                    <div class="row">
                        <div class="col-8 px-1">
                            <el-input v-model="search" size="mini" prefix-icon="el-icon-search" placeholder="Type to search" clearable>
                                <template slot="append"> {{ search?`${ListData.length}/${data.length}`:data.length }} Record</template>
                            </el-input>
                        </div>
                        <div class="col-4 px-1">
                            <el-button-group style="float: right;">
                                <el-button type="primary" size="mini" @click="selectedHistory={}; innerDrawer=true">ADD</el-button>

                            </el-button-group>
                        </div>
                    </div>
                </div>

                <el-table :data="ListData" border :cell-style="moreDetailStyle" :row-class-name="tableRowClassName">
                    <el-table-column label="Age of Patient" width="120" align="center">
                        <template slot-scope="props">
                            {{ ( !props.row.age_of_patient ? (!!selectedPatient.birth_date ? calculateAge(props.row.date_of_incident) : 'N/A') : (props.row.age_of_patient || 'N/A') ) }}
                        </template>
                    </el-table-column>
                    <el-table-column property="date_of_incident" label="Date of Incident" width="155"></el-table-column>
                    <el-table-column property="place_of_incident" label="Place of Incident" min-width="200"></el-table-column>

                    <el-table-column property="doctors_order" label="Dr's Order" min-width="200"></el-table-column>
                    <el-table-column property="nurses_notes" label="Nurse's Notes" min-width="200"></el-table-column>

                    <el-table-column property="remarks" label="Remarks" min-width="200"></el-table-column>

                    <el-table-column type="expand" label="View More" width="100">
                        <template slot-scope="props">
                            <!-- <p><strong>Date of Physical Examination:</strong> {{ props.row.date_of_physical_exam }}</p>
                            <p><strong>Place of Physical Examination:</strong> {{ props.row.place_of_physical_exam }}</p>
                            <p><strong>Type of Animal:</strong> {{ props.row.type_of_animal }}</p>
                            <p><strong>Type of Exposure:</strong> {{ props.row.type_of_exposure }}</p>
                            <p><strong>Site of Infection:</strong> {{ props.row.site_of_infection }}</p>
                            <p><strong>Washing of Bite:</strong> {{ props.row.is_washed }}</p>
                            <p><strong>Route:</strong> {{ props.row.route }}</p>
                            <p><strong>Category:</strong> {{ props.row.category }}</p>
                            <p><strong>Outcome:</strong> {{ props.row.outcome }}</p>
                            <p><strong>Biting Animal Status:</strong> {{ props.row.biting_animal_status }}</p> -->
                            <el-row :gutter="10">
                                <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12" style="padding: 0px 12px 0px 12px;">
                                    <!-- first -->
                                    <p>Registration Date: <strong>{{ props.row.registration_date }}</strong></p>
                                    <p>Registration Number: <strong>{{ props.row.registration_number }}</strong></p>

                                    <p>Date of Physical Examination: <strong>{{ props.row.date_of_physical_exam }}</strong></p>
                                    <p>Place of Physical Examination: <strong>{{ props.row.place_of_physical_exam }}</strong></p>
                                    <p>Type of Animal: <strong>{{ getValues('type_of_animal', props.row.type_of_animal_id) }}</strong></p>
                                    <p>Type of Exposure: <strong>{{ getValues('type_of_exposure', props.row.type_of_exposure_id) }}</strong></p>
                                    <p>Site of Infection: <strong>{{ getValues('site_of_infection', props.row.site_of_infection_id) }}</strong></p>
                                    <p>Is washed: <strong>{{ (Number(props.row.is_washed) ? 'Yes' : 'No') }}</strong></p>

                                    <p>Rig. Date Given: <strong>{{ props.row.rig_date_given }}</strong></p>

                                    <p>Route: <strong>{{ props.row.route }}</strong></p>
                                    <p>Category: <strong>{{ getValues('category', props.row.category_id) }}</strong></p>
                                    <p>Outcome: <strong>{{ getValues('outcome', props.row.outcome_id) }}</strong></p>
                                    <p>Biting Animal Status: <strong>{{ getValues('biting_animal_status', props.row.biting_animal_status_id) }}</strong></p>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12" style="padding: 0px 12px 0px 12px;">
                                    <!-- second -->
                                    <el-table :data="props.row.treatment" size="mini" border style="width: 100%">
                                         <el-table-column label="Treatment Session List" align="center">
                                            <el-table-column prop="designated_day" label="Desig. Day" width="180"> </el-table-column>
                                            <el-table-column prop="date" label="Date" width="180"> </el-table-column>
                                            <el-table-column prop="vaccine.name" label="Vaccine"> </el-table-column>
                                        </el-table-column>

                                        <!-- <el-table-column prop="designated_day" label="Desig. Day" width="180"> </el-table-column>
                                        <el-table-column prop="date" label="Date" width="180"> </el-table-column>
                                        <el-table-column prop="vaccine_id" label="Vaccine"> </el-table-column> -->
                                    </el-table>
                                </el-col>
                            </el-row>
                        </template>
                    </el-table-column>

                    <!-- <el-table-column property="type_of_animal" label="Type of Animal" width="120"></el-table-column>
                    <el-table-column property="type" label="Type" width="60"></el-table-column>
                    <el-table-column property="body_parts" label="Body Parts" width="100"></el-table-column>
                    <el-table-column property="outcome" label="Outcome" width="90"></el-table-column>
                    <el-table-column property="biting_animal_status" label="Biting Animal Status" width="160"></el-table-column> -->

                    <!-- <el-table-column label="Action" align="center" fixed="right" width="135">
                        <el-button @click="innerDrawer = true">Click me!</el-button>
                    </el-table-column> -->
                    <el-table-column width="80" align="center" label="Action">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-tooltip class="item" effect="light" content="Edit" placement="top" :enterable="false">
                                    <el-button type="success" size="mini" icon="mdi mdi-lead-pencil" circle plain @click="selectedHistory=scope.row; innerDrawer=true"></el-button>
                                </el-tooltip>
                                <el-tooltip class="item" effect="light" content="Delete" placement="top" :enterable="false">
                                    <el-button type="danger" size="mini" icon="mdi mdi-delete" circle plain @click="handleDelete(scope.row)"></el-button>
                                </el-tooltip>
                            </el-button-group>
                        </template>
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
            :title="`${getSelectedHistoryTitle()}`"
            :append-to-body="true"
            :visible.sync="innerDrawer"
            :size="`${size-1}%`"
        >
            <PatientTreatmentAddUpdate v-if="innerDrawer" :selected-patient="selectedPatient" :selected-history="selectedHistory" @new-history="getSelectedHistory($event)" @close="innerDrawer=false" />
        </el-drawer>
    </el-drawer>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { drawerSize, calAge } from '../../constants'
import PatientTreatmentAddUpdate from './PatientTreatmentAddUpdate'
export default {
    props: ['visible', 'selectedPatient'],
    components: { PatientTreatmentAddUpdate },
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
            lastReload: new Date().toLocaleString(),
            selectedHistory: null,
            new_history: null
        }
    },
    watch: {
        selected_patient (val) {
            if (this.new_history) {
                var current_history_id = JSON.parse(JSON.stringify(this.new_history || null))
                this.selectedHistory = val.history.find(h=>h.id==current_history_id)
                if (this.selectedHistory) this.new_history = null;
            } else {
                var current_history_id = JSON.parse(JSON.stringify(this.selectedHistory?.id || null))
                this.selectedHistory = val.history.find(h=>h.id==current_history_id)
            }
        }
    },
    computed: {
        ...mapGetters(['selected_patient', 'enum', 'request']),
        data() {
            // return JSON.parse(JSON.stringify(this.selectedPatient.history))
            return JSON.parse(JSON.stringify(this.selected_patient.history))
        },
        searching() {
            if (!this.search) {
                this.total = this.data.length;
                return this.data;
            }
            this.page = 1;
            return this.data.filter(
                data => data.date_of_incident.toLowerCase().includes(this.search.toLowerCase()) || data.place_of_incident.toLowerCase().includes(this.search.toLowerCase()));
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
        ...mapActions(['managePatientHistory']),
        closeDrawer() {
            this.$emit('close', false)
        },
        rezize() {
            this.size = drawerSize(window.innerWidth)
        },
        handleCurrentChange(val) {
			this.page = val;
		},
        moreDetailStyle({row, column, rowIndex, columnIndex}) {
            return columnIndex == 3 ? 'background-color:rgba(0,0,0,0.01)' : ''
        },
        calculateAge(date_of_incident_string) {
            var date_of_incident_timestamp = new Date((Date.parse(date_of_incident_string)/1000)) * 1000
            return calAge(this.selectedPatient.birth_date, date_of_incident_timestamp) || 'N/A'
        },
        getSelectedHistoryTitle() {
            return this.selectedPatient.name.toUpperCase() + " - " + (this.selectedHistory?.date_of_incident ? this.selectedHistory?.date_of_incident : "NEW EXPOSURE")
        },
        getValues(columnKey, id) {
            if (typeof id == "number") {
                return this.enum[columnKey]?.find(c=>c.id == id)?.code || 'N/A'
            } else {
                return this.enum[columnKey]?.reduce((items, row) => {
                    if (id?.includes(row.id)) {
                        items.push(row.code)
                    }
                    return items
                }, []).join(', ')
            }
        },
        tableRowClassName({row, rowIndex}) {
            return 'expanded-table-row';
        },
        getSelectedHistory(id) {
            this.new_history = id
        },
        async handleDelete(row) {
            await this.$confirm('This will permanently delete the record. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                var form_type = "delete"
                var rowData = {...row, form_type}
                this.managePatientHistory(rowData).then((res)=>{
                    this.$notify({
                        title: 'Success',
                        message: this.request.message,
                        type: 'success',
                        duration: 6000,
                    });
                }).catch(()=>{
                    this.$notify({
                        title: 'Error',
                        message: this.request.message,
                        type: 'error',
                        duration: 0,
                    });
                })
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });
            });
        }
    },
    created() {
        window.onresize = function() { this.rezize() }.bind(this)
    },
    mounted() {
        this.rezize()
        this.gridData = JSON.parse(JSON.stringify(this.selectedPatient.history))

        if (this.selected_patient?.new_expo) {
            this.selectedHistory={};
            this.$nextTick(()=>{
                this.innerDrawer=true
            })

        }
    }
}
</script>

<style>

</style>