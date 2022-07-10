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
            <el-form-item label="Name" required>
                <el-row>
                    <el-col :xs="24" :sm="24" :md="9" :lg="9" :xl="9">
                        <el-input ref="name" v-model="name.last" @input="(v)=>(name.last=name.last.toUpperCase())" placeholder="DELA CRUZ" clearable title="Last Name"></el-input>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="9" :lg="9" :xl="9">
                        <el-input v-model="name.first" @input="(v)=>(name.first=name.first.toUpperCase())" placeholder="JUAN" clearable title="First Name"></el-input>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6">
                        <el-input v-model="name.middle" @input="(v)=>(name.middle=name.middle.toUpperCase())" placeholder="M." clearable title="Middle Initial/Name"></el-input>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="Full Name" prop="name">
                <el-input v-model="ruleForm.name" placeholder="DELA CRUZ, JUAN M." clearable disabled></el-input>
            </el-form-item>
            <el-form-item label="Gender" prop="gender">
                <el-select v-model="ruleForm.gender" placeholder="Select" clearable>
                    <el-option label="Male" value="Male"></el-option>
                    <el-option label="Female" value="Female"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Civil Status" prop="civil_status">
                <el-select v-model="ruleForm.civil_status" placeholder="Select" clearable>
                    <el-option label="Single" value="Single"></el-option>
                    <el-option label="Married" value="Married"></el-option>
                    <el-option label="Divorced" value="Divorced"></el-option>
                    <el-option label="Widowed" value="Widowed"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Birth Date">
                <el-form-item prop="birth_date">
                    <el-date-picker type="date" :picker-options="pickerOptionShortcut" placeholder="Pick a date" v-model="ruleForm.birth_date" style="width: 75%;" timezone="UTC"></el-date-picker>
                    <el-input type="text" style="width:23%" placeholder="Age" :value="pAge" disabled />
                </el-form-item>
            </el-form-item>
            <el-form-item label="Address" prop="address">
                <el-input type="textarea" v-model="ruleForm.address" :clearable="true"></el-input>
            </el-form-item>
            <el-form-item label="Contact" prop="contact_number">
                <el-input v-model="ruleForm.contact_number" clearable></el-input>
            </el-form-item>
            <el-form-item align="right">
                <!-- <el-button @click="resetForm('ruleForm')">Reset Field</el-button> -->
                <el-popconfirm
                    cancel-button-text='No, Thanks'
                    title="Are you sure you want to reset this field?"
                    @confirm="resetForm('ruleForm')"
                    style="margin-right:10px"
                >
                    <el-button slot="reference">Reset Field</el-button>
                </el-popconfirm>
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
import { dialogSize, buildDate, calAge } from '../../constants'
import elDragDialog from './../../directive/el-drag-dialog'
export default {
    directives: { elDragDialog },
    props: ['dialogVisible', 'selectedData', 'dialogTitle'],
    data() {
        var validateName = (rule, value, callback) => {
            if (!value.toString().trim()) {
                callback(new Error('Please input patient name'));
            } else if (!(/^[a-z0-9,. Ññ]+$/i.test(value))) {
                callback(new Error('Name can contain only " [a-z,A-Z,0-9,. ] " characters.'));
            } else if (!value.match(/[^,]+,[^,]+/g)) {
                callback(new Error('Must be a correct name format "LastName, FirstName MiddleName"'));
            } else {
                if (value.split(',')[1][0] != " " || value.split(',')[1][1] == " ") {
                    callback(new Error('Must contain 1 space after the comma on LastName'));
                } else {
                    callback();
                }
            }
        };
        return {
            size: 30,
            name: {
                last: '',
                first: '',
                middle: '',
            },
            ruleForm: {
                form_type: 'add',
                name: '',
                gender: 'Male',
                civil_status: 'Single',
                birth_date: '',
                address: '',
                contact_number: '',
            },
            rules: {
                name: [
                    { validator: validateName, required: true, trigger: 'change' },
                ],
                gender: [
                    { required: true, message: 'Please select patient gender', trigger: 'change' }
                ],
                civil_status: [
                    // { required: true, message: 'Please select patient civil status', trigger: 'change' }
                    { required: false }
                ],
                birth_date: [
                    // { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' }
                    { required: false }
                ],
                address: [
                    { required: true, message: 'Please input patient address', trigger: 'change' }
                ],
                contact_number: [
                    // { required: true, message: 'Please input patient contact number', trigger: 'change' },
                    { required: false }
                ],
            },
            // pickerOptions: {
            //     disabledDate(time) {
            //         return time.getTime() > Date.now();
            //     }
            // },
            isEdit: false,
            pickerOptionShortcut: {
                shortcuts: [
                    {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*5)))).toLocaleDateString("en-CA").substr(0,4) + " ~5 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*5));
                            // picker.$emit('pick', date);
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*10)))).toLocaleDateString("en-CA").substr(0,4) + " ~10 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*10));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*15)))).toLocaleDateString("en-CA").substr(0,4) + " ~15 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*15));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*20)))).toLocaleDateString("en-CA").substr(0,4) + " ~20 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*20));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*25)))).toLocaleDateString("en-CA").substr(0,4) + " ~25 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*25));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*30)))).toLocaleDateString("en-CA").substr(0,4) + " ~30 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*30));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*40)))).toLocaleDateString("en-CA").substr(0,4) + " ~40 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*40));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*50)))).toLocaleDateString("en-CA").substr(0,4) + " ~50 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*50));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*60)))).toLocaleDateString("en-CA").substr(0,4) + " ~60 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*60));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*70)))).toLocaleDateString("en-CA").substr(0,4) + " ~70 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*70));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }, {
                        text: new Date((new Date().setTime(new Date().getTime() - 3600 * 1000 * 24 * (365*80)))).toLocaleDateString("en-CA").substr(0,4) + " ~80 yrs",
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * (365*80));
                            picker.$emit('pick', new Date(date.getFullYear() + "-01-01"));
                        }
                    }
                ],
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            },
        }
    },
    watch: {
        'name.last'(val) {
            var name = `${val.toString().trim()}, ${this.name.first.toString().trim()} ${this.name.middle.toString().trim()}`
            this.ruleForm.name = name.toString().trim() == "," ? '' : name.toString().trim()
        },
        'name.first'(val) {
            var name = `${this.name.last.toString().trim()}, ${val.toString().trim()} ${this.name.middle.toString().trim()}`
            this.ruleForm.name = name.toString().trim() == "," ? '' : name.toString().trim()
        },
        'name.middle'(val) {
            var name = `${this.name.last.toString().trim()}, ${this.name.first.toString().trim()} ${val.toString().trim()}`
            this.ruleForm.name = name.toString().trim() == "," ? '' : name.toString().trim()
        }
    },
    computed: {
        ...mapGetters(['request']),
        pAge () {
            return !!this.ruleForm.birth_date ? calAge(this.ruleForm.birth_date) || null : null
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
                this.managePatients(form).then(()=>{
                    if (this.request.status == 'success') {

                        this.$notify({
                            title: 'Success',
                            message: this.request.message,
                            type: 'success',
                            duration: 6000,
                        });

                        this.$nextTick(()=>{

                            if (!this.isEdit) {
                                this.name = {
                                    last: '',
                                    first: '',
                                    middle: '',
                                }
                                this.resetForm('ruleForm')
                            }

                            this.$refs.name.$el.getElementsByTagName('input')[0].focus();
                        })

                        // setTimeout(() => {
                        //     this.closeDialog()
                        // }, 600);

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
                this.ruleForm.birth_date = !!this.selectedData.birth_date ? new Date(this.selectedData.birth_date) : ""
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