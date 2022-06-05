<template>
    <el-dropdown trigger="click" @visible-change="toggler">
        <span class="el-dropdown-link">
            <i class="mdi mdi-list-status" style="margin-left: 5px; margin-top:0px;font-size:16px;" @click="toggle=!toggle;getData()"> <span v-if="has_pending" style="position:relative; top:-12px; right:3px; background-color:#E40D0D; color:white; border-radius:50%; font-size:10px;padding:3px; font-weight:normal; font-style:normal">12</span> </i>
        </span>
        <el-dropdown-menu slot="dropdown" style="width:800px">

            <el-row>
                <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12">
                    <div class="px-3 mdi mdi-chevron-double-right" style="color:#409EFF"> &nbsp;On Queue</div>
                </el-col>
                <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12" style="text-align:right !important">
                    <el-badge is-dot class="item" v-if="has_changes">
                        <div class="pr-4" style="color:#409EFF; cursor:pointer; width:60px; float:right" @click="toggle=true;getData()">Reload</div>
                    </el-badge>
                    <div v-else class="pr-4" style="color:#409EFF; cursor:pointer; width:60px; float:right" @click="toggle=true;getData()">Reload</div>
                    <!-- <el-button icon="el-icon-refresh" size="small" circle></el-button> -->
                    <!-- <el-button type="text" size="mini" class="mdi mdi-reload"></el-button> -->
                </el-col>
            </el-row>
            <!-- loading{{ loading }} -->

            <!-- <el-dropdown-item divided>Notification 1</el-dropdown-item>
            <el-dropdown-item>Notification 2</el-dropdown-item>
            <el-dropdown-item>Notification 3</el-dropdown-item>
            <el-dropdown-item>Notification 4</el-dropdown-item>
            <el-dropdown-item>Notification 5</el-dropdown-item>
            <el-dropdown-item>Notification 6</el-dropdown-item>
            <el-dropdown-item>Notification 7</el-dropdown-item>
            <el-dropdown-item>Notification 8</el-dropdown-item>
            <el-dropdown-item>Notification 9</el-dropdown-item>
            <el-dropdown-item>Notification 10</el-dropdown-item>
            <el-dropdown-item>Notification 11</el-dropdown-item>
            <el-dropdown-item>Notification 12</el-dropdown-item>
            <el-dropdown-item divided> <i class="mdi mdi-history"></i> Show All</el-dropdown-item> -->

            <el-dropdown-item divided></el-dropdown-item>

            <el-table v-loading="loading" :data="batches" style="width: 100%" border :row-class-name="tableRowClassName">
                <el-table-column prop="id" label="Batch Id" min-width="290"></el-table-column>
                <el-table-column prop="total_jobs" label="Total" width="57"></el-table-column>
                <el-table-column prop="pending_jobs" label="Pending" width="80"></el-table-column>
                <el-table-column prop="failed_jobs" label="Failed" width="65"></el-table-column>
                <el-table-column prop="dispatch_on" label="Created At" width="135"></el-table-column>
                <el-table-column width="65" align="center" label="Action">
                    <template slot-scope="scope">
                        <el-tooltip class="item" effect="light" :content="`${scope.row.pending_jobs > 0 ? 'Cancel' : 'Remove'} Batch`" placement="top" :enterable="false">
                            <el-button v-if="scope.row.pending_jobs > 0" type="danger" size="mini" icon="mdi mdi-cancel" circle plain @click="handleDelete(scope.row)"></el-button>
                            <el-button v-else type="primary" size="mini" icon="mdi mdi-minus-thick" circle plain @click="deleteBatch(scope.row.id)"></el-button>
                        </el-tooltip>
                    </template>
                </el-table-column>
                <el-table-column type="expand" label="Jobs" width="60">
                    <template slot-scope="props">
                        <el-row :gutter="10">
                            <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" style="padding: 0px 12px 0px 12px;">
                                <!-- second -->
                                <el-table :data="props.row.jobs" size="mini" border style="width: 100%" :height="props.row.jobs.length > 4 ? 250 : -1">
                                    <el-table-column label="Patient List" align="center">
                                        <el-table-column label="Name" min-width="230">
                                            <template slot-scope="props">
                                                {{ patientHistory(props.row.payload, 'registration_number') + '. ' + patientInfo(props.row.payload, 'name') }}
                                            </template>
                                        </el-table-column>
                                        <el-table-column label="Date of Inci." width="90">
                                            <template slot-scope="props">
                                                {{ patientHistory(props.row.payload, 'date_of_incident') }}
                                            </template>
                                        </el-table-column>
                                        <!-- <el-table-column label="Desig. Day">
                                            <template slot-scope="props">
                                                {{ patientHistory(props.row.payload, 'place_of_incident') }}
                                            </template>
                                        </el-table-column> -->
                                        <el-table-column label="Queue Status" width="180">
                                            <template slot-scope="props">
                                                <el-tag size="mini" :type="props.row.status == 'Processed' ? 'success' : `${props.row.status == 'Failed' ? 'danger' : 'info'}`" disable-transitions>{{!!props.row.status ? props.row.status : 'On Queue' }}</el-tag>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="remarks" label="Queue Remarks"> </el-table-column>
                                    </el-table-column>

                                    <!-- <el-table-column prop="designated_day" label="Desig. Day" width="180"> </el-table-column>
                                    <el-table-column prop="date" label="Date" width="180"> </el-table-column>
                                    <el-table-column prop="vaccine_id" label="Vaccine"> </el-table-column> -->
                                </el-table>
                            </el-col>
                        </el-row>
                    </template>
                </el-table-column>
            </el-table>


            <el-dropdown-item divided> <i class="mdi mdi-history"></i> Show All</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
            has_pending: true,
            toggle: false,
            loading: false,
            batches: [],
            has_changes: true,
            request_source: null
        }
    },
    computed: {
        ...mapGetters(['auth']),
    },
    methods: {
        toggler($event) {
            if (!$event) {
                this.toggle = false
            }
            console.log($event)
        },
        tableRowClassName({row, rowIndex}) {
            return 'expanded-table-row';
        },
        patientInfo(item = "{}", key = null) {
            let patient = JSON.parse(item)?.patient
            return patient[key]
        },
        patientHistory(item = "{}", key = null) {
            let patient_history = JSON.parse(item)?.patient_history
            return patient_history[key]
        },
        async getData() {
            this.loading = true
            // console.log(this.toggle)
            if (this.toggle) {
                if (this.request_source) {
                    this.request_source.cancel()
                }
                //interceptor err cacellation - todo - duplicate
                this.request_source = axios.CancelToken.source()

                await axios.get(`processed_jobs?user_id=${this.auth?.id}`, { cancelToken: this.request_source.token }).then((result) => {
                    console.log('mounted on queue component: SUCCESS', result.data)
                    this.batches = result.data
                    this.has_changes = false
                    // this.$nextTick(()=>{
                    //     if (this.jobs.length > 0) {
                    //         // this.$destroy()
                    //     }
                    // })
                }).catch((err) => {
                    console.log('mounted on queue component: FAILED', err)
                }).finally(()=>{
                    setTimeout(() => {
                        this.loading = false
                    }, 500);

                });
            }
        },
        async deleteBatch(batch_id) {
            if (confirm('Are you sure you want to delete selected batch ?')) {
                await axios.post(`delete_processed_jobs/${batch_id}`).then((result) => {
                    alert('Sucsess on deleting selected batch')
                    this.getData()
                })
            }
        }
    },
    mounted() {
        // this.$destroy()
    },
    beforeDestroy() {
        this.toggle = false
        this.request_source.cancel()
    }
}
</script>

<style lang="css" scoped>
    .item {
        margin-top: 0px;
        margin-right: 20px;
    }
</style>