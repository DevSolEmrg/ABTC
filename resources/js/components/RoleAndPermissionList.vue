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
                            <el-button type="primary" size="mini" @click="handleAdd">ADD</el-button>
                        </el-button-group>
                    </div>
                </div>
            </div>

            <el-table  v-loading="loading" :data="ListData" border>
                <el-table-column prop="name" label="Role" width="200" />
                <el-table-column label="Permissions" >
                    <template slot-scope="scope">
                        <el-tag size="small" style="margin:1px; color:white" :color="generateColor(permission)" v-for="permission in scope.row.permissions" :key="permission.id">{{ permission.name }}</el-tag>
                    </template>
                </el-table-column>
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
                    <el-button  size="mini" circle style="border:none; background-color:rgba(0,0,0,0)" @click="reloadData">
                        <i class="el-icon-refresh"/>
                    </el-button>
                </el-tooltip>
            </span>
        </div>
    </el-col>
    <el-col :span="24">
        <personnel-add-update v-if="manageRecordDialog" :dialog-title="dialogTitle" :dialog-visible="manageRecordDialog" @close-dialog="manageRecordDialog=$event" :selected-data="selectedData" />
    </el-col>
</el-row>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
import PersonnelAddUpdate from './personnel/PersonnelAddUpdate'
import { permission_color } from '../constants'
export default {
    components: { PersonnelAddUpdate },
    data() {
        return {
            page: 1,
	    	pageSize: 10,
            loading: true,
            search: "",
            manageRecordDialog: false,
            selectedData: null,
            lastReload: new Date().toLocaleString(),
            dialogTitle: ''
        }
    },
    methods: {
        ...mapActions(['managePersonnel']),
        handleEdit(index, row) {
            this.selectedData = row
            this.selectedData.form_type = 'edit'
            this.dialogTitle = "Edit Personnel Info."
            this.manageRecordDialog = true
        },
        async handleDelete(index, row) {
            console.log(row)
            await this.$confirm('This will permanently delete the record. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                var form = JSON.parse(JSON.stringify(row))
                form.form_type = "delete"
                this.managePersonnel(form).then(()=>{
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
        handleAdd() {
            this.selectedData = null
            this.dialogTitle = 'Add Personnel'
            this.manageRecordDialog = true
        },
        reloadData() {
            this.$store.commit('SET_LOADING_COMPONENT', true)
            this.$store.dispatch("getPersonnels").then(()=>{
                this.$nextTick(()=>{
                    this.$store.commit('SET_LOADING_COMPONENT', false)
                    this.lastReload = new Date().toLocaleString()

                })
            });
        },
        booleanToStr(value) {
            return value ? 'Yes' : 'No'
        },
        generateColor(permission) {
            return permission_color[permission?.name?.split('-')[1]] || '#725F72'
        }
    },
    computed: {
        ...mapGetters(['request', 'vaccines', 'personnels', 'roles']),
        data() {
            return this.roles?.roles
        },
        searching() {
            if (!this.search) {
                this.total = this.data.length;
                return this.data;
            }
            this.page = 1;
            return this.data.filter(
                data => data.name.toLowerCase().includes(this.search.toLowerCase()) );
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
        this.$store.commit('SET_LOADING_COMPONENT', false)
    },
    beforeCreate() {
        this.$store.dispatch("getPersonnels");
        this.$store.dispatch("getRoles");
    }
}
</script>

<style scoped>

</style>