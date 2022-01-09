<template>
    <el-dialog
        :title="dialogTitle"
        :visible.sync="dialogVisible"
        :width="`${size}%`"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :before-close="closeDialog"
        v-el-drag-dialog
    >
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="ruleForm.name" ref="name" clearable></el-input>
            </el-form-item>

            <el-form-item label="Description" prop="description">
                <el-input type="textarea" rows="3" style="width:100%" v-model="ruleForm.description" :clearable="true"></el-input>
            </el-form-item>

            <el-form-item label="Permissions" prop="selected_permission">
                <el-collapse>
                    <el-collapse-item :name="i+1" v-for="(permit, i) in permission_category" :key="permit.category_name">
                        <template slot="title">
                            <el-switch
                                v-model="permit.selected"
                                :active-color="permit.color"
                                @change="hasChangeSelected(i)"
                                @click.stop.native=""
                            />
                            &nbsp;&nbsp; <span :style="`color:${permit.has_selected?permit.color:'#DCDFE6'}; font-weight:bold`">{{ permit.category_name }} &nbsp; ({{ permit.count }})</span>
                        </template>
                        <div>
                            <div
                                v-for="p in permit.permissions"
                                :key="p.name"
                            >
                                <el-switch
                                    :active-text="p.name"
                                    v-model="p.selected"
                                    @change="hasChange(i)"
                                /><br>
                            </div>
                        </div>
                    </el-collapse-item>
                </el-collapse>
            </el-form-item>

            <el-form-item align="right">
                <el-button @click="resetForm('ruleForm')">Reset Field</el-button>
                <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { dialogSize } from '../../constants'
import elDragDialog from './../../directive/el-drag-dialog'
export default {
    directives: { elDragDialog },
    props: ['dialogVisible', 'selectedData', 'dialogTitle'],
    data() {
        return {
            size: 30,
            ruleForm: {
                form_type: 'add',
                name: '',
                description: '',
                selected_permission: []
            },
            rules: {
                name: [
                    { required: true, message: 'Please input role name', trigger: 'change' },
                ],
                // description: [
                //     { required: true, message: 'Please input role description', trigger: 'change' },
                // ],
                description: [
                    { required: false }
                ],
                selected_permission: [
                    { required: true, message: 'Please select role permission', trigger: 'change' }
                ],
            },
            isEdit: false,
            permission_category: []
        }
    },
    computed: {
        ...mapGetters(['request'])
    },
    methods: {
        ...mapActions(['manageRole']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    let form = JSON.parse(JSON.stringify(this.ruleForm))
                    this.manageRole(form).then(()=>{
                        if (this.request.status == 'success') {
                            this.$notify({
                                title: 'Success',
                                message: this.request.message,
                                type: 'success',
                                duration: 6000,
                            });
                            this.$nextTick(()=>{
                                if (!this.isEdit) this.resetForm('ruleForm')

                                this.$refs.name.$el.getElementsByTagName('input')[0].focus();
                            })
                        } else {
                            this.$notify({
                                title: 'Error',
                                message: this.request.message,
                                type: 'error',
                                duration: 0,
                            });
                        }
                    })
                } else {
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.permission_category = JSON.parse(JSON.stringify(this.selectedData.permission_category))
            this.$refs[formName].resetFields();
        },
        rezize() {
            this.size = dialogSize(window.innerWidth)
        },
        hasChangeSelected(index) {
            this.permission_category[index].permissions.forEach((p, i)=>{
                this.permission_category[index].permissions[i].selected = this.permission_category[index].selected
            })
            let count = JSON.parse(JSON.stringify(this.permission_category[index].permissions)).filter(p=>p.selected==true)
            this.permission_category[index].count =`${count.length}/${this.permission_category[index].permissions.length}`
            this.permission_category[index].has_selected = count.length ? true : false
            this.fillPermissionValue()
        },
        hasChange(index) {
            this.permission_category[index].selected = this.permission_category[index].permissions.every(p=>p.selected == true)
            let count = JSON.parse(JSON.stringify(this.permission_category[index].permissions)).filter(p=>p.selected==true)
            this.permission_category[index].count =`${count.length}/${this.permission_category[index].permissions.length}`
            this.permission_category[index].has_selected = count.length ? true : false
            this.fillPermissionValue()
        },
        fillPermissionValue() {
            this.ruleForm.selected_permission = JSON.parse(JSON.stringify(this.permission_category)).reduce((permits, current) => {
                current.permissions.forEach(p => { if (p.selected == true) permits.push(p.name); })
                return permits;
            },[])
        }
    },
    created() {
        this.permission_category = JSON.parse(JSON.stringify(this.selectedData.permission_category))
        if (this.selectedData) {
            Object.assign(this.ruleForm ,JSON.parse(JSON.stringify(this.selectedData)))
            if (this.selectedData.form_type == 'edit') {
                if (this.selectedData.current_permission.length) {
                    this.ruleForm.id = this.selectedData.id
                    this.ruleForm.selected_permission = this.selectedData.current_permission
                }
                this.isEdit = true
            }
        }
        window.onresize = function() { this.rezize() }.bind(this)
    },
    mounted() {
        this.$nextTick(()=>{
            this.$refs.name.$el.getElementsByTagName('input')[0].focus();
        })

        this.rezize()
    }
}
</script>

<style>

</style>