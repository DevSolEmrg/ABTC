<template>
    <el-dialog
        title="Add Patient"
        :visible.sync="dialogVisible"
        :width="`${size}%`"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :before-close="closeDialog"
    >
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="Gender" prop="gender">
                <el-select v-model="ruleForm.gender" placeholder="Select">
                    <el-option label="Male" value="Male"></el-option>
                    <el-option label="Female" value="Female"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Birth Date" required>
                <el-form-item prop="birth_date">
                    <el-date-picker type="date" placeholder="Pick a date" v-model="ruleForm.birth_date" style="width: 100%;" :picker-options="pickerOptions" timezone="UTC"></el-date-picker>
                </el-form-item>
            </el-form-item>
            <el-form-item label="Address" prop="address">
                <el-input type="textarea" v-model="ruleForm.address"></el-input>
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
import { mapGetters, mapActions } from "vuex";
import { dialogSize, buildDate } from '../../constants'
export default {
    props: ['dialogVisible'],
    data() {
        return {
            size: 30,
            ruleForm: {
                name: '',
                gender: '',
                birth_date: '',
                address: ''
            },
            rules: {
                name: [
                    { required: true, message: 'Please input Activity name', trigger: 'blur' },
                    { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' }
                ],
                gender: [
                    { required: true, message: 'Please select Activity zone', trigger: 'change' }
                ],
                birth_date: [
                    { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' }
                ],
                address: [
                    { required: true, message: 'Please input activity form', trigger: 'blur' }
                ]
            },
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            },
        }
    },
    methods: {
        ...mapActions(['managePatients']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                //alert('submit!');
                let form = JSON.parse(JSON.stringify(this.ruleForm))
                form.birth_date = buildDate(form.birth_date)
                this.managePatients(form)
            } else {
                console.log('error submit!!');
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
        window.onresize = function() { this.rezize() }.bind(this)
    },
    mounted() {
        this.rezize()
    }
}
</script>

<style>

</style>