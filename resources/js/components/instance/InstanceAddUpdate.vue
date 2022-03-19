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
            <el-form-item label="Code" prop="code">
                <el-input v-model="ruleForm.code" ref="name" clearable></el-input>
            </el-form-item>
            <el-form-item label="Description" prop="desc">
                <el-input type="textarea" rows="3" v-model="ruleForm.desc" :clearable="true"></el-input>
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
import elDragDialog from './../../directive/el-drag-dialog'
export default {
    directives: { elDragDialog },
    props: ['dialogVisible', 'selectedData', 'categoryId', 'dialogTitle'],
    data() {
        return {
            size: 30,
            ruleForm: {
                form_type: 'add',
                reference_category_id: null,
                code: '',
                desc: ''
            },
            rules: {
                code: [
                    { required: true, message: 'Please input instance code', trigger: 'change' },
                ],
                desc: [
                    { required: true, message: 'Please input instance description', trigger: 'change' }
                ]
            },
            isEdit: false
        }
    },
    computed: {
        ...mapGetters(['request'])
    },
    methods: {
        ...mapActions(['manageInstance']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                let form = JSON.parse(JSON.stringify(this.ruleForm))
                this.manageInstance(form).then(()=>{
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
                this.isEdit = true
            }
        } else {
            this.ruleForm.reference_category_id = this.categoryId
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