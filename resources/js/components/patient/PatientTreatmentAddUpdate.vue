<template>
    <!-- <el-dialog
        :title="dialogTitle"
        :visible.sync="dialogVisible"
        :width="`${size}%`"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :before-close="closeDialog"
    > -->
<div class="px-1" style="margin:0px !important">

    <!-- <el-tabs type="border-card">
        <el-tab-pane label="Patient History">Patient History1</el-tab-pane>
        <el-tab-pane label="Patient Session">Patient Session1</el-tab-pane>
    </el-tabs> -->

    <!-- <el-divider content-position="left" style="margin-top:0px">Rabindranath Tagore</el-divider> -->
    <!-- <el-card class="box-card" :body-style="{ padding: '12px' }" shadow="hover">
  <div slot="header" class="clearfix">
    <span>Card name</span>
    <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
  </div> -->
  <div class="text item">
    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
        <el-tabs type="border-card" class="mb-3">
            <el-tab-pane label="Patient Exposure">
                <!-- <el-row :gutter="10">
                    <el-col :xs="12" :sm="12" :md="16" :lg="16" :xl="16"><div class="grid-content bg-purple"></div></el-col>
                    <el-col :xs="12" :sm="12" :md="16" :lg="16" :xl="16"><div class="grid-content bg-purple-light"></div></el-col>
                </el-row> -->
                <el-row>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Date of Incident" required>
                            <el-form-item prop="date_of_incident">
                                <el-date-picker ref="name" type="date" style="width:100%" size="small" placeholder="Pick a date" v-model="ruleForm.date_of_incident" :picker-options="pickerOptions" timezone="UTC"></el-date-picker>
                            </el-form-item>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Place of Inci." prop="place_of_incident">
                            <el-input type="textarea" rows="1" style="width:100%" v-model="ruleForm.place_of_incident" :clearable="true"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Date of Exam" required>
                            <el-form-item prop="date_of_physical_exam">
                                <el-date-picker type="date" style="width:100%" size="small" placeholder="Pick a date" v-model="ruleForm.date_of_physical_exam" :picker-options="pickerOptions" timezone="UTC"></el-date-picker>
                            </el-form-item>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Place of Exam" prop="place_of_physical_exam">
                            <el-input type="textarea" rows="1" style="width:100%" v-model="ruleForm.place_of_physical_exam" :clearable="true"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Type of Animal" prop="type_of_animal">
                            <el-select v-model="ruleForm.type_of_animal" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.type_of_animal" :key="type.code" :label="type.code" :value="type.code" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Type of Expos." prop="type_of_exposure">
                            <el-select v-model="ruleForm.type_of_exposure" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.type_of_exposure" :key="type.code" :label="type.code" :value="type.code" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Site of Infect." prop="site_of_infection">
                            <el-select v-model="ruleForm.site_of_infection" multiple placeholder="Select one or more" style="width:100%" size="small" allow-create filterable default-first-option>
                                <el-option v-for="type in enumValues.site_of_infection_history" :key="type.code" :label="type.code" :value="type.code" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6">
                        <el-form-item label="Washed ?" prop="is_washed">
                            <el-select v-model="ruleForm.is_washed" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.is_washed" :key="type.code" :label="type.desc" :value="type.code" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6">
                        <el-form-item label="Route" prop="route">
                            <el-input v-model="ruleForm.route" style="width:100%" size="small" clearable></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                        <el-form-item label="Category" prop="category">
                            <el-select v-model="ruleForm.category" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.category" :key="type.code" :label="type.code" :value="type.code" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                        <el-form-item label="Outcome" prop="outcome">
                            <el-select v-model="ruleForm.outcome" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.outcome" :key="type.code" :label="type.code" :value="type.code" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                        <el-form-item label="Animal Status" prop="bitting_animal_status">
                            <el-select v-model="ruleForm.bitting_animal_status" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.bitting_animal_status" :key="type.code" :label="type.code" :value="type.code" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item label="Remarks" prop="remarks">
                    <el-input type="textarea" rows="4" v-model="ruleForm.remarks" size="small" :clearable="true"></el-input>
                </el-form-item>
                <el-form-item align="right">
                    <el-button @click="resetForm('ruleForm')">Reset Field</el-button>
                    <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
                </el-form-item>
            </el-tab-pane>
            <el-tab-pane label="Patient Treatment Session">
                <el-form-item align="right">
                    <el-button type="primary" @click="addTreatmentSession">Add New</el-button>
                </el-form-item>
                <div v-if="treatmentList.length">
                    <div v-for="t in treatmentList" :key="t.id">
                        <TreatmentSession :treatment="t"/>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>

            <!-- <el-form-item align="right">
                <el-button @click="resetForm('ruleForm')">Reset Field</el-button>
                <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
            </el-form-item> -->
        </el-form>
  </div>
<!-- </el-card> -->
        <!-- <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm" style="background-color:green">
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
        </el-form> -->
        </div>
    <!-- </el-dialog> -->
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { dialogSize, buildDate } from '../../constants'
import TreatmentSession from './TreatmentSession'
export default {
    props: ['dialogVisible', 'selectedData', 'dialogTitle', 'selectedPatient', 'selectedHistory'],
    components: {
        TreatmentSession
    },
    data() {
        return {
            size: 30,
            ruleForm: {
                form_type: 'add',
                date_of_incident: '',
                place_of_incident: '',
                date_of_physical_exam: '',
                place_of_physical_exam: '',
                type_of_animal: '',
                type_of_exposure: '',
                site_of_infection: [],
                is_washed: '',
                route: '',
                category: '',
                outcome: '',
                bitting_animal_status: '',
                remarks: ''
            },
            rules: {
                date_of_incident: [
                    { type: 'date', required: true, message: 'Please pick a date of incident', trigger: 'change' }
                ],
                place_of_incident: [
                    { required: true, message: 'Please input place of incident', trigger: 'change' }
                ],
                date_of_physical_exam: [
                    { type: 'date', required: true, message: 'Please pick a date of physical examination', trigger: 'change' }
                ],
                place_of_physical_exam: [
                    { required: true, message: 'Please input place of physical examination', trigger: 'change' }
                ],
                type_of_animal: [
                    { required: true, message: 'Please select type of animal', trigger: 'change' },
                ],
                type_of_exposure: [
                    { required: true, message: 'Please select type of exposure', trigger: 'change' },
                ],
                site_of_infection: [
                    { required: true, message: 'Please select site of infection', trigger: 'change' },
                ],
                is_washed: [
                    { required: true, message: 'Please select if infected area washed or not', trigger: 'change' },
                ],
                route: [
                    { required: true, message: 'Please input route', trigger: 'change' },
                ],
                category: [
                    { required: true, message: 'Please select category', trigger: 'change' },
                ],
                outcome: [
                    { required: true, message: 'Please select outcome', trigger: 'change' },
                ],
                bitting_animal_status: [
                    { required: true, message: 'Please select bitting animal status', trigger: 'change' },
                ],
                remarks: [
                    { required: true, message: 'Please input remarks', trigger: 'change' }
                ],

            },
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            },
            isEdit: false,
            enumValues: [],
            treatmentList: []
        }
    },
    computed: {
        ...mapGetters(['request', 'enum', 'patients', 'vaccines'])
    },
    methods: {
        ...mapActions(['manageVaccines', 'getVaccines']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                let form = JSON.parse(JSON.stringify(this.ruleForm))
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
        },
        addTreatmentSession() {
            this.treatmentList.unshift({
                designated_day: '',
                date: '',
                vaccine_id: ''
            })
        }
    },
    created() {
        this.enumValues = JSON.parse(JSON.stringify(this.enum))
        var col_histories = this.patients.reduce((histories, row)=>{
            if (row.history.length) {
                row.history.map(h=>h.site_of_infection).forEach(h=>{
                    if (!histories.map(c=>c.code).includes(h)) {
                        histories.push({code: h, desc: h})
                    }
                })
            }
            return histories
        }, [])
        this.enumValues.site_of_infection_history = col_histories

        this.getVaccines()
        this.treatmentList = JSON.parse(JSON.stringify(this.selectedHistory.treatment))
        this.treatmentList.forEach(t=>{
            t.vaccine = JSON.parse(JSON.stringify(this.vaccines)).find(v=>v.id == t.vaccine_id)
        })

        if (this.selectedData) {
            Object.assign(this.ruleForm ,JSON.parse(JSON.stringify(this.selectedData)))
            if (this.selectedData.form_type == 'edit') {
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

<style scoped>
.text {
    font-size: 14px;
  }

  .item {

  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }
  .clearfix:after {
    clear: both
  }

  .box-card {
    width: 100%;
  }
</style>