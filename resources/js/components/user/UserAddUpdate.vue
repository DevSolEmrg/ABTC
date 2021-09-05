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
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm" autocomplete="off">

            <!--  fake fields are a workaround for chrome/opera autofill getting the wrong fields -->
            <input id="email" style="display:none" type="text" name="fakeusernameremembered">
            <input id="password" style="display:none" type="password" name="fakepasswordremembered">

            <el-form-item label="User Fullname" prop="name">
                <el-autocomplete
                    class="inline-input"
                    v-model="ruleForm.name"
                    value-key="name"
                    :clearable="true"
                    :fetch-suggestions="querySearch"
                    style="width:100%"
                    ref="name"
                    autocomplete="off"
                    id="real-userfullname"
                >
                    <template slot-scope="{ item }">
                        <div :title="`${item.name} | ${item.position}`">
                            {{ item.name }}
                            <el-tag size="mini" style="padding-left:2px; margin:0px">{{ item.position }}</el-tag>
                        </div>
                    </template>
                </el-autocomplete>
            </el-form-item>
            <el-form-item label="User Role" prop="role">
                <el-select v-model="ruleForm.role" multiple placeholder="Select one or more" style="width:100%">
                    <el-option
                        v-for="item in roles.roles"
                        :key="item.id"
                        :label="item.name"
                        :value="item.name"
                    >
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="Email" prop="email">
                <el-input type="text" v-model="ruleForm.email" :clearable="true" placeholder="Username" autocomplete="off"></el-input>
            </el-form-item>

            <el-form-item label="Password" prop="password">
                <el-input id="real-password" type="password" v-model="ruleForm.password" clearable autocomplete="off"></el-input>
            </el-form-item>

            <el-form-item label="Confirm Pass." prop="password_confirmation">
                <el-input id="real-password1" type="password" v-model="ruleForm.password_confirmation" clearable autocomplete="off"></el-input>
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
        var validatePass = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input the password'));
            } else {
                if (this.ruleForm.password_confirmation !== '') {
                    this.$refs.ruleForm.validateField('password_confirmation');
                }
                callback();
            }
        };
        var validatePass2 = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input the password again'));
            } else if (value !== this.ruleForm.password) {
                callback(new Error('Two inputs don\'t match!'));
            } else {
                callback();
            }
        };
        var validateEmail = (rule, value, callback) => {
            if (!value || value == '') {
                callback(new Error('This field is required'));
            } else {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!re.test(value)) {
                    callback(new Error('Please input a correct email address'));
                } else {
                    if (this.exist_email.length) {
                        if (this.exist_email.includes(value) && (!this.isEdit || (this.isEdit && value != this.edit_exist_email))) {
                            callback(new Error('Email address already exist.'));
                        } else {
                            callback();
                        }
                    } else {
                        callback();
                    }
                }
            }
        };
        return {
            size: 30,
            ruleForm: {
                form_type: 'add',
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: []
            },
            rules: {
                name: [
                    { required: true, message: 'Please input user fullname', trigger: 'change' },
                ],
                role: [
                    { required: true, message: 'Please input user role', trigger: 'change' },
                ],
                email: [
                    { validator: validateEmail, required: true, trigger: 'change' }
                ],
                password: [
                    { validator: validatePass, required: true, message: 'Please input password', trigger: 'change' }
                ],
                password_confirmation: [
                    { validator: validatePass2, required: true, trigger: 'change' }
                ],
            },
            isEdit: false,
            exist_email: [],
            edit_exist_email: ''
        }
    },
    computed: {
        ...mapGetters(['request', 'personnels', 'roles', 'all_user'])
    },
    methods: {
        ...mapActions(['getPersonnels', 'getRoles', 'getUsers', 'manageUser']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                let form = JSON.parse(JSON.stringify(this.ruleForm))
                this.manageUser(form).then(()=>{
                    if (this.request.status == 'success') {
                        this.$notify({
                            title: 'Success',
                            message: this.request.message,
                            type: 'success',
                            duration: 6000,
                        });
                        this.getUsers().then(()=>{
                            this.exist_email = this.all_user.map(u=>u.email)
                            this.edit_exist_email = this.ruleForm.email
                        })
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
            // call callback function to return suggestions
            cb(results);
        },
        createFilter(queryString) {
            return (personnel) => {
                return (personnel.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
        },
    },
    created() {
        if (this.selectedData) {
            Object.assign(this.ruleForm ,JSON.parse(JSON.stringify(this.selectedData)))
            if (this.selectedData.form_type == 'edit') {
                if (this.selectedData.roles.length) {
                    this.ruleForm.role = this.selectedData.roles.map(r=>r.name)
                }
                this.edit_exist_email = this.selectedData.email
                this.isEdit = true
            }
        }
        window.onresize = function() { this.rezize() }.bind(this)

        this.getPersonnels()
        this.getRoles()
    },
    mounted() {
        this.rezize()
        this.exist_email = this.all_user.map(u=>u.email)
    }
}
</script>

<style>

</style>