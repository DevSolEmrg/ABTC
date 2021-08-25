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
            <el-form-item label="Vaccine" prop="name">
                <el-input v-model="ruleForm.name" ref="name" clearable></el-input>
            </el-form-item>
            <el-form-item label="Description" prop="description">
                <el-input type="textarea" rows="6" v-model="ruleForm.description" :clearable="true"></el-input>
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
                description: ''
            },
            rules: {
                name: [
                    { required: true, message: 'Please input vaccine name', trigger: 'blur' },
                ],
                description: [
                    { required: true, message: 'Please input vaccine description', trigger: 'blur' }
                ]
            },
            isEdit: false
        }
    },
    computed: {
        ...mapGetters(['request'])
    },
    methods: {
        ...mapActions(['manageVaccines']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                let form = JSON.parse(JSON.stringify(this.ruleForm))
                form.birth_date = buildDate(form.birth_date)
                this.manageVaccines(form).then(()=>{
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
        }
    },
    created() {
        if (this.selectedData) {
            Object.assign(this.ruleForm ,JSON.parse(JSON.stringify(this.selectedData)))
            if (this.selectedData.form_type == 'edit') {
                this.ruleForm.birth_date = new Date(this.selectedData.birth_date)
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