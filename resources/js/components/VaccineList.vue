<template>
<el-row :gutter="24">
    <el-col :span="24">
        <el-card shadow="never" :body-style="{ padding: '0px' }">
            <div slot="header">
                <div class="row">
                    <div class="col-5 px-1">
                        <el-input v-model="search" size="mini" prefix-icon="el-icon-search" placeholder="Type to search" clearable>
                            <template slot="append"> {{ search?`${ListData.length}/${data.length}`:data.length }} Record</template>
                        </el-input>
                    </div>
                    <div class="col-7 px-1">
                        <el-button-group style="float: right;">
                            <el-button type="primary" size="mini" @click="addVaccine">ADD</el-button>
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
                <el-table-column prop="name" label="Vaccine Name" width="220" />
                <el-table-column prop="description" label="Description" min-width="350" />
                <el-table-column width="80" align="center" fixed="right" label="Action">
                    <template slot-scope="scope">
                        <el-button-group>
                            <el-tooltip class="item" effect="light" content="Edit" placement="top" :enterable="false">
                                <el-button type="primary" size="mini" icon="mdi mdi-lead-pencil" circle plain @click="handleEdit(scope.$index, scope.row)"></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="light" content="Delete" placement="top" :enterable="false">
                                <el-button type="danger" size="mini" icon="mdi mdi-delete" circle plain @click="handleDelete(scope.$index, scope.row)"></el-button>
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
                    <el-button  size="medium" circle style="border:none; background-color:rgba(0,0,0,0);padding:4px;color:red" @click="reloadData" :loading="loading_component">
                        <i class="el-icon-refresh" v-if="!loading_component"/>
                    </el-button>
                </el-tooltip>
            </span>
        </div>
    </el-col>
    <el-col :span="24">
        <vaccine-add-update v-if="manageVaccineDialog" :dialog-title="dialogTitle" :dialog-visible="manageVaccineDialog" @close-dialog="manageVaccineDialog=$event" :selected-data="selectedData" />
    </el-col>
</el-row>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
import VaccineAddUpdate from './vaccine/VaccineAddUpdate'
export default {
    components: { VaccineAddUpdate },
    data() {
        return {
            page: 1,
	    	pageSize: 10,
            loading: true,
            search: "",
            manageVaccineDialog: false,
            selectedData: null,
            lastReload: new Date().toLocaleString(),
            dialogTitle: ''
        }
    },
    methods: {
        ...mapActions(['manageVaccines']),
        handleEdit(index, row) {
            this.selectedData = row
            this.selectedData.form_type = 'edit'
            this.dialogTitle = "Edit Vaccine Info."
            this.manageVaccineDialog = true
        },
        async handleDelete(index, row) {
            await this.$confirm('This will permanently delete the record. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                var form = JSON.parse(JSON.stringify(row))
                form.form_type = "delete"
                this.manageVaccines(form).then(()=>{
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
        handleCurrentChange(val) {
			this.page = val;
		},
        addVaccine() {
            this.selectedData = null
            this.dialogTitle = 'Add Vaccine'
            this.manageVaccineDialog = true
        },
        reloadData() {
            this.$store.commit('SET_LOADING_COMPONENT', true)
            this.$store.dispatch("getVaccines").then(()=>{
                this.$nextTick(()=>{
                    this.$store.commit('SET_LOADING_COMPONENT', false)
                    this.lastReload = new Date().toLocaleString()

                })
            });
        }
    },
    computed: {
        ...mapGetters(['request', 'vaccines', 'loading_component']),
        data() {
            return this.vaccines || []
        },
        searching() {
            if (!this.search) {
                this.total = this.data.length;
                return this.data;
            }
            this.page = 1;
            return this.data.filter(
                data => data.name.toLowerCase().includes(this.search.toLowerCase()) || data.description.toLowerCase().includes(this.search.toLowerCase()));
        },
        ListData() {
            this.total = this.searching.length;
            return this.searching.slice(
                this.pageSize * this.page - this.pageSize,
                this.pageSize * this.page
            );
        }
    },
    mounted() {
        this.loading = false
        // this.$store.commit('SET_LOADING_COMPONENT', false)
    },
    beforeCreate() {
        this.$store.dispatch("getVaccines").then(()=>{
            this.$store.commit('SET_LOADING_COMPONENT', false)
        });
    }
}
</script>

<style scoped>

</style>