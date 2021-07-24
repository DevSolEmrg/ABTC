<template>
    <el-dialog
        title="Add Patient"
        :visible.sync="dialogVisible"
        width="30%"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :before-close="closeDialog"
    >
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="Gender" prop="region">
                <el-select v-model="ruleForm.region" placeholder="Activity zone">
                <el-option label="Zone one" value="shanghai"></el-option>
                <el-option label="Zone two" value="beijing"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Birth Date" required>
                <el-form-item prop="date1">
                    <el-date-picker type="date" placeholder="Pick a date" v-model="ruleForm.date1" style="width: 100%;"></el-date-picker>
                </el-form-item>
            </el-form-item>
            <el-form-item label="Address" prop="desc">
                <el-input type="textarea" v-model="ruleForm.desc"></el-input>
            </el-form-item>
            <el-form-item align="right">
                <el-button @click="resetForm('ruleForm')">Reset Field</el-button>
                <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
            </el-form-item>
        </el-form>

        <!-- <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">Cancel</el-button>
            <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>
        </span> -->
    </el-dialog>
</template>

<script>
export default {
    props: ['dialogVisible'],
    data() {
        return {
            ruleForm: {
                name: '',
                region: '',
                date1: '',
                resource: '',
                desc: ''
            },
            rules: {
                name: [
                    { required: true, message: 'Please input Activity name', trigger: 'blur' },
                    { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' }
                ],
                region: [
                    { required: true, message: 'Please select Activity zone', trigger: 'change' }
                ],
                date1: [
                    { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' }
                ],
                date2: [
                    { type: 'date', required: true, message: 'Please pick a time', trigger: 'change' }
                ],
                type: [
                    { type: 'array', required: true, message: 'Please select at least one activity type', trigger: 'change' }
                ],
                resource: [
                    { required: true, message: 'Please select activity resource', trigger: 'change' }
                ],
                desc: [
                    { required: true, message: 'Please input activity form', trigger: 'blur' }
                ]
            }
        }
    },
    methods: {
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                alert('submit!');
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        }
    }
}
</script>

<style>

</style>