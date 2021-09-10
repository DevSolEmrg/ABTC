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
            <el-form-item label="Position" prop="position">
                <!-- <el-input type="textarea" rows="3" v-model="ruleForm.position" :clearable="true"></el-input> -->
                <el-autocomplete
                    class="inline-input"
                    v-model="ruleForm.position"
                    value-key="position"
                    :clearable="true"
                    :fetch-suggestions="querySearch"
                    style="width:100%"
                    autocomplete="off"
                >
                    <template slot-scope="{ item }">
                        <div :title="item.position">
                            {{ item.position }}
                        </div>
                    </template>
                </el-autocomplete>
            </el-form-item>
            <el-form-item label="Active" prop="is_active">
                <el-select v-model="ruleForm.is_active" placeholder="Select">
                    <el-option label="Yes" value="1"></el-option>
                    <el-option label="No" value="0"></el-option>
                </el-select>
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
                    { required: true, message: 'Please input personnel name', trigger: 'change' },
                ],
                position: [
                    { required: true, message: 'Please input personnel position', trigger: 'change' }
                ],
                is_active: [
                    { required: true, message: 'Please select personnel status', trigger: 'change' }
                ],
            },
            isEdit: false
        }
    },
    computed: {
        ...mapGetters(['request', 'personnels'])
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
        querySearch(queryString, cb) {
            var personnels = this.personnels;
            var results = queryString ? personnels.filter(this.createFilter(queryString)) : personnels;
            cb(results);
        },
        createFilter(queryString) {
            return (personnel) => {
                return (personnel.position.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
        },
    },
    created() {
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