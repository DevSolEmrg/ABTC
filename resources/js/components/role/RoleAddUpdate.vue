<template>
    <el-dialog
        :title="dialogTitle"
        :visible.sync="dialogVisible"
        :width="`${size}%`"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :before-close="closeDialog"
    >
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="ruleForm.name" ref="name" clearable></el-input>
            </el-form-item>

            <el-form-item label="Permissions">
                <el-collapse>
                    <el-collapse-item :name="i+1" v-for="(permit, i) in permission_category" :key="permit.category_name">
                        <template slot="title">
                            <el-switch
                                v-model="permit.selected"
                                :active-color="permit.color"
                                @change="hasChangeSelected(i)"
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
import { dialogSize, buildDate } from '../../constants'
export default {
    props: ['dialogVisible', 'selectedData', 'dialogTitle'],
    data() {
        return {
            size: 30,
            ruleForm: {
                form_type: 'add',
                name: '',
                position: '',
                is_active: '1'
            },
            rules: {
                name: [
                    { required: true, message: 'Please input personnel name', trigger: 'blur' },
                ],
                position: [
                    { required: true, message: 'Please input personnel position', trigger: 'blur' }
                ],
                is_active: [
                    { required: true, message: 'Please select personnel status', trigger: 'change' }
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
        ...mapActions(['managePersonnel']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                let form = JSON.parse(JSON.stringify(this.ruleForm))
                form.birth_date = buildDate(form.birth_date)
                this.managePersonnel(form).then(()=>{
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
        },
        hasChange(index) {
            this.permission_category[index].selected = this.permission_category[index].permissions.every(p=>p.selected == true)
            let count = JSON.parse(JSON.stringify(this.permission_category[index].permissions)).filter(p=>p.selected==true)
            this.permission_category[index].count =`${count.length}/${this.permission_category[index].permissions.length}`
            this.permission_category[index].has_selected = count.length ? true : false
        }
    },
    created() {
        this.permission_category = JSON.parse(JSON.stringify(this.selectedData.permission_category))
        if (this.selectedData) {
            Object.assign(this.ruleForm ,JSON.parse(JSON.stringify(this.selectedData)))
            if (this.selectedData.form_type == 'edit') {
                this.ruleForm.is_active = this.selectedData.is_active.toString()
                this.isEdit = true
            }
        }
        window.onresize = function() { this.rezize() }.bind(this)
    },
    mounted() {
        this.rezize()
    }
}
</script>

<style>

</style>