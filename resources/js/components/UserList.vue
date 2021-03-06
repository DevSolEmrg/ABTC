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
                                    <!-- <el-dropdown-item><i class="mdi mdi-cloud-upload"></i> Import</el-dropdown-item> -->
                                    <el-dropdown-item><i class="mdi mdi-cloud-download"></i> Export</el-dropdown-item>
                                </el-dropdown-menu>
                        </el-dropdown>
                        </el-button-group>
                    </div>
                </div>
            </div>

            <el-table  v-loading="loading" :data="ListData" border>
                <el-table-column prop="name" label="Fullname" width="220" />
                <el-table-column prop="email" label="Email | Username" width="220" />
                <el-table-column label="Role" align="center" min-width="120">
                    <template slot-scope="scope">
                        <div v-if="scope.row.roles.length == 0">N/A</div>
                        <el-popover v-for="role in scope.row.roles" :key="role.id" :content="role.description" placement="top-start" :title="role.name" width="350" trigger="hover">
                            <el-tag slot="reference" size="small" style="margin:1px;" class="mdi mdi-account-key">&nbsp;{{ role.name }}</el-tag>
                        </el-popover>
                    </template>
                </el-table-column>
                <el-table-column label="Permissions" min-width="350">
                    <template slot-scope="scope">
                        <div v-if="scope.row.roles.length == 0">N/A</div>
                        <div v-else v-for="role in scope.row.roles" :key="role.id">
                            <el-tag v-for="permit in role.permissions" :key="permit.id" size="small" :color="generateColor(permit)" style="margin:1px; color:white">{{ permit.name }}</el-tag>
                        </div>
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
                    <el-button  size="medium" circle style="border:none; background-color:rgba(0,0,0,0);padding:4px;color:red" @click="reloadData" :loading="loading_component">
                        <i class="el-icon-refresh" v-if="!loading_component"/>
                    </el-button>
                </el-tooltip>
            </span>
        </div>
    </el-col>
    <el-col :span="24">
        <user-add-update v-if="manageVaccineDialog" :dialog-title="dialogTitle" :dialog-visible="manageVaccineDialog" @close-dialog="manageVaccineDialog=$event" :selected-data="selectedData" />
    </el-col>
</el-row>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
import UserAddUpdate from './user/UserAddUpdate'
import { permission_color } from '../constants'
export default {
    components: { UserAddUpdate },
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
        ...mapActions(['manageUser']),
        handleEdit(index, row) {
            this.selectedData = row
            this.selectedData.form_type = 'edit'
            this.dialogTitle = "Edit User Account Info."
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
                form.password = "none"
                form.password_confirmation = "none"
                this.manageUser(form).then(()=>{
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
            this.dialogTitle = 'Add User Account'
            this.manageVaccineDialog = true
        },
        reloadData() {
            this.$store.commit('SET_LOADING_COMPONENT', true)
            this.$store.dispatch("getUsers").then(()=>{
                this.$nextTick(()=>{
                    this.$store.commit('SET_LOADING_COMPONENT', false)
                    this.lastReload = new Date().toLocaleString()

                })
            });
        },
        generateColor(permission) {
            return permission_color[permission?.name?.split('-')[1]] || '#725F72'
        }
    },
    computed: {
        ...mapGetters(['request', 'all_user', 'loading_component']),
        data() {
            return this.all_user || []
        },
        searching() {
            if (!this.search) {
                this.total = this.data.length;
                return this.data;
            }
            this.page = 1;
            return this.data.filter(
                data => data.name.toLowerCase().includes(this.search.toLowerCase()) || data.email.toLowerCase().includes(this.search.toLowerCase()));
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
        this.$store.dispatch("getUsers").then(()=>{
            this.$store.commit('SET_LOADING_COMPONENT', false)
        });
    }
}
</script>

<style scoped>

</style>