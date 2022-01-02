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
        <el-tabs class="mb-3" :stretch="true">
            <el-tab-pane label="Patient Exposure">
                <!-- <el-row :gutter="10">
                    <el-col :xs="12" :sm="12" :md="16" :lg="16" :xl="16"><div class="grid-content bg-purple"></div></el-col>
                    <el-col :xs="12" :sm="12" :md="16" :lg="16" :xl="16"><div class="grid-content bg-purple-light"></div></el-col>
                </el-row> -->
                <span slot="label"><i class="mdi mdi-history"></i> Patient Exposure</span>
                <el-row>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Date of Incident" required>
                            <el-form-item prop="date_of_incident">
                                <!-- <el-date-picker ref="name" type="date" style="width:100%" size="small" placeholder="Pick a date" @change="checkDateOfSecondDate" v-model="ruleForm.date_of_incident" :picker-options="pickerOptions" timezone="UTC"></el-date-picker> -->
                                <el-date-picker
                                    ref="name"
                                    style="width:100%"
                                    size="small"
                                    @change="checkDateOfSecondDate"
                                    v-model="ruleForm.date_of_incident"
                                    :picker-options="pickerOptionShortcut"
                                    timezone="UTC"
                                    type="datetime"
                                    placeholder="Pick a date and time"
                                    default-time="12:00:00"
                                />
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
                                <!-- <el-date-picker type="date" style="width:100%" size="small" placeholder="Pick a date" v-model="ruleForm.date_of_physical_exam" :picker-options="pickerOptionsInBetween" timezone="UTC"></el-date-picker> -->
                                <el-date-picker
                                    style="width:100%"
                                    size="small"
                                    v-model="ruleForm.date_of_physical_exam"
                                    :picker-options="pickerOptionsInBetween"
                                    timezone="UTC"
                                    type="datetime"
                                    placeholder="Pick a date and time"
                                    default-time="12:00:00"
                                />
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
                        <el-form-item label="Type of Animal" prop="type_of_animal_id">
                            <el-select v-model="ruleForm.type_of_animal_id" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.type_of_animal" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Type of Expos." prop="type_of_exposure_id">
                            <el-select v-model="ruleForm.type_of_exposure_id" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.type_of_exposure" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                        <el-form-item label="Site of Infect." prop="site_of_infection_id">
                            <!-- <el-select v-model="ruleForm.site_of_infection_id" multiple placeholder="Select one or more" style="width:100%" size="small" allow-create filterable default-first-option>
                                <el-option v-for="type in enumValues.site_of_infection_history" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
                            </el-select> -->
                            <el-select v-model="ruleForm.site_of_infection_id" multiple placeholder="Select one or more" style="width:100%" size="small" filterable clearable>
                                <el-option v-for="type in enumValues.site_of_infection_history" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
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
                        <el-form-item label="Category" prop="category_id">
                            <el-select v-model="ruleForm.category_id" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.category" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                        <el-form-item label="Outcome" prop="outcome_id">
                            <el-select v-model="ruleForm.outcome_id" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.outcome" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                        <el-form-item label="Animal Status" prop="biting_animal_status_id">
                            <el-select v-model="ruleForm.biting_animal_status_id" placeholder="Select" style="width:100%" size="small" clearable>
                                <el-option v-for="type in enumValues.biting_animal_status" :key="type.code" :label="type.code" :value="type.id" :title="type.desc" />
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
            <el-tab-pane label="Patient Session" v-if="Object.entries(selectedHistory).length">
                <span slot="label"><i class="mdi mdi-calendar-check"></i> Patient Session</span>
                <el-form-item align="right">
                    <el-button v-if="!!isEditingTreatmentSession || addCount > 0" type="primary" size="small" disabled>Add New</el-button>
                    <el-button v-else type="primary" size="small" @click="addRow()">Add New</el-button>
                </el-form-item>
                <!-- <div v-if="treatmentList.length">
                    <div v-for="t in treatmentList" :key="t.id">
                        <TreatmentSession :treatment="t"/>
                    </div>
                </div> -->

                <el-table :data="treatmentList" style="width: 100%" :row-class-name="tableRowClassName" border>
                    <el-table-column prop="designated_day" label="Designated Day" width="200">
                        <template slot-scope="scope">
                            <span v-if="!scope.row.manage || !isEditingTreatmentSession">{{ scope.row.designated_day }}</span>
                            <el-input
                                v-else
                                size="small"
                                placeholder="E.g. D0, D3, D7..."
                                v-model.trim="scope.row.designated_day"
                                clearable
                                @input="(val) => (scope.row.designated_day = scope.row.designated_day.toUpperCase())"
                            />
                        </template>
                    </el-table-column>
                    <el-table-column prop="date" label="Date of Apperance (Y-m-d)" width="243">
                        <template slot-scope="scope">
                            <span v-if="!scope.row.manage || !isEditingTreatmentSession">{{ scope.row.date }}</span>
                            <el-date-picker
                                v-else
                                value-format="yyyy-MM-dd"
                                type="date"
                                placeholder="Pick a date"
                                size="small"
                                v-model="scope.row.date"
                                :picker-options="pickerOptions"
                                timezone="UTC"
                            />
                        </template>
                    </el-table-column>
                    <el-table-column prop="time" label="Time (24hr)" width="243">
                        <template slot-scope="scope">
                            <span v-if="!scope.row.manage || !isEditingTreatmentSession">{{ scope.row.time }}</span>
                            <el-time-select
                                v-else
                                value-format="HH:mm"
                                :picker-options="{
                                    start: '01:00',
                                    step: '00:10',
                                    end: '24:00'
                                }"
                                placeholder="Pick a time"
                                size="small"
                                v-model="scope.row.time"
                                timezone="UTC"
                            />
                        </template>
                    </el-table-column>
                    <el-table-column prop="vaccine_id" label="Vaccine" min-width="143">
                        <template slot-scope="scope">
                            <span v-if="!scope.row.manage || !isEditingTreatmentSession">{{ getVaccineName(scope.row.vaccine_id) }}</span>
                            <el-select
                                v-else
                                v-model="scope.row.vaccine_id"
                                placeholder="Select"
                                size="small"
                                clearable
                            >
                                <el-option v-for="vac in vaccines" :key="vac.id" :label="vac.name" :value="vac.id" :title="`${vac.name} - ${vac.description}`" />
                            </el-select>
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" label="Action" width="80">
                        <template slot-scope="scope">
                            <el-button-group style="float: right;">
                                <el-tooltip v-if="!scope.row.manage" class="item" effect="light" content="Edit" placement="top" :enterable="false" style="margin-bottom:0px">
                                    <el-button v-if="!!isEditingTreatmentSession" type="primary" size="mini" icon="mdi mdi-lead-pencil" circle plain disabled />
                                    <el-button v-else type="primary" size="mini" icon="mdi mdi-lead-pencil" circle plain @click="handleEdit(scope.$index, scope.row)"></el-button>
                                </el-tooltip>
                                <el-tooltip v-if="!scope.row.manage" class="item" effect="light" content="Delete" placement="top" :enterable="false" style="margin-bottom:0px">
                                    <el-button v-if="!!isEditingTreatmentSession" type="danger" size="mini" icon="mdi mdi-delete" circle plain disabled />
                                    <el-button v-else type="danger" size="mini" icon="mdi mdi-delete" circle plain @click="handleDelete(scope.$index, scope.row)"></el-button>
                                </el-tooltip>
                                <el-tooltip v-if="scope.row.manage && !!isEditingTreatmentSession" class="item" effect="light" content="Cancel" placement="top" :enterable="false" style="margin-bottom:0px">
                                    <el-button type="warning" size="mini" icon="mdi mdi-close-thick" circle @click="handleCancel(scope.$index, scope.row)"></el-button>
                                </el-tooltip>
                                <el-tooltip v-if="scope.row.manage && !!isEditingTreatmentSession" class="item" effect="light" content="Save" placement="top" :enterable="false" style="margin-bottom:0px">
                                    <el-button type="success" size="mini" icon="mdi mdi-check-bold" circle @click="saveRow(scope.$index, scope.row)"></el-button>
                                </el-tooltip>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>

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
                type_of_animal_id: '',
                type_of_exposure_id: '',
                site_of_infection_id: [],
                is_washed: '',
                route: '',
                category_id: '',
                outcome_id: '',
                biting_animal_status_id: '',
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
                type_of_animal_id: [
                    { required: true, message: 'Please select type of animal', trigger: 'change' },
                ],
                type_of_exposure_id: [
                    { required: true, message: 'Please select type of exposure', trigger: 'change' },
                ],
                site_of_infection_id: [
                    { required: true, message: 'Please select site of infection', trigger: 'change' },
                ],
                is_washed: [
                    { required: true, message: 'Please select if infected area washed or not', trigger: 'change' },
                ],
                route: [
                    { required: true, message: 'Please input route', trigger: 'change' },
                ],
                category_id: [
                    { required: true, message: 'Please select category', trigger: 'change' },
                ],
                outcome_id: [
                    { required: true, message: 'Please select outcome', trigger: 'change' },
                ],
                biting_animal_status_id: [
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
            pickerOptionsInBetween: {
                disabledDate: time => {
                    return time.getTime() < new Date(this.ruleForm?.date_of_incident) || time.getTime() > Date.now()
                }
            },
            pickerOptionShortcut: {
                shortcuts: [{
                    text: 'Today',
                    onClick(picker) {
                    picker.$emit('pick', new Date());
                    }
                }, {
                    text: 'Yesterday',
                    onClick(picker) {
                    const date = new Date();
                    date.setTime(date.getTime() - 3600 * 1000 * 24);
                    picker.$emit('pick', date);
                    }
                }, {
                    text: 'A week ago',
                    onClick(picker) {
                    const date = new Date();
                    date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                    picker.$emit('pick', date);
                    }
                }],
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            },
            isEdit: false,
            enumValues: [],
            treatmentList: [],
            tableData: [
                {
                    date: '2016-05-03',
                    designated_day: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Home',
                    vaccine_id: 1,
                    manage: false
                }, {
                    date: '2016-05-02',
                    designated_day: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Office',
                    vaccine_id: 1,
                    manage: true
                }, {
                    date: '2016-05-04',
                    designated_day: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Home',
                    vaccine_id: 1,
                    manage: false
                }, {
                    date: '2016-05-01',
                    designated_day: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Office',
                    vaccine_id: 1,
                    manage: false
                }
            ],
            addCount:0,
            isEditingTreatmentSession: false,
            old_value_edit_item: {}
        }
    },
    computed: {
        ...mapGetters(['request', 'enum', 'patients', 'vaccines', 'selected_patient']),
        // treatmentSessionChanges() {
        //     var s = this.treatmentList
        //     console.log('has changes')
        //     return s
        // }
    },
    watch: {
        treatmentList(val) {
            console.log('has changes')
        },
        selected_patient(val) {
            this.treatmentList = JSON.parse(JSON.stringify(this.selectedHistory?.treatment || []))
        }
        // treatmentList: {
        //    // 'handle1',
        //     function handle2 (val, oldVal) { /* ... */ console.log('has changes') },
        //     //{
        //         //handler: function handle3 (val, oldVal) { /* ... */ },
        //         /* ... */
        //    // }
        // },
        // treatmentList: {
        //     handler (val) {
        //         console.log('has changes', val)
        //     },
        //     deep: true
        // }
        // handleChange (newVal) {
        // // Handle changes here!
        //     console.log('has changes to this object', newVal);
        // },
    },
    methods: {
        ...mapActions(['manageVaccines', 'getVaccines', 'manageTreatment', 'managePatientHistory']),
        closeDialog() {
            this.$emit('close-dialog', false)
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                let form = JSON.parse(JSON.stringify(this.ruleForm))
                this.managePatientHistory(form).then((res)=>{
                    if (this.request.status == 'success') {
                        this.$notify({
                            title: 'Success',
                            message: this.request.message,
                            type: 'success',
                            duration: 6000,
                        });
                        this.$nextTick(()=>{
                            //if (!this.isEdit) this.resetForm('ruleForm')

                            if (!this.isEdit) {
                                this.$emit('new-history', res?.data?.id)
                            }

                            //this.$refs.name.$el.getElementsByTagName('input')[0].focus();
                            //this.$emit('close')
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
        },
        checkDateOfSecondDate($event) {
            if (!!this.ruleForm.date_of_physical_exam && this.ruleForm.date_of_physical_exam != "") {
                if ($event > this.ruleForm.date_of_physical_exam) {
                    this.ruleForm.date_of_physical_exam = ""
                }
            }
        },
        handleEdit(index, rows) {
            this.old_value_edit_item = JSON.parse(JSON.stringify(rows))

            console.log("edit", index, rows)
            // this.$nextTick(()=>{
            //     this.treatmentList[index].manage = true
            // })
            // setTimeout(() => {
            //     console.log('done')
                //this.treatmentList[index].manage = true

                this.$set(this.treatmentList[index], 'manage', true)

                this.$set(this.treatmentList[index], 'form_type', 'edit')
                this.$set(this.treatmentList[index], 'patient_history_id', this.selectedHistory.id)
                this.$set(this.treatmentList[index], 'patient_id', this.selectedHistory.patient_id)

                this.isEditingTreatmentSession = true
                //this.isEditing()
            // }, 5000);
        },
        async handleDelete(index, rows) {
            await this.$confirm('This will permanently delete the record. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.$set(this.treatmentList[index], 'form_type', 'delete')
                this.$set(this.treatmentList[index], 'patient_history_id', this.selectedHistory.id)
                this.$set(this.treatmentList[index], 'patient_id', this.selectedHistory.patient_id)
                this.saveRow(index, rows).then(()=>{
                    if (this.request.status == 'success') {
                        this.$message({
                            type: 'success',
                            message: 'Delete completed'
                        });
                        this.treatmentList.splice(index, 1);
                        if(this.addCount > 0)
                        -- this.addCount;
                    } else {
                        this.$notify({
                            title: 'Error',
                            message: this.request.message,
                            type: 'error',
                            duration: 0,
                        });
                    }
                })
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });
            });
        },
        handleCancel(index, rows) {
            if (rows?.form_type == 'add') {
                this.treatmentList.splice(index, 1);
                this.addCount = 0
            } else {
                //this.treatmentList[index].manage = false
                this.treatmentList[index] = JSON.parse(JSON.stringify(this.old_value_edit_item))
                this.$set(this.treatmentList[index], 'manage', false)
            }
            this.isEditingTreatmentSession = false
            ///this.isEditing()
        },
        getVaccineName(vac_id) {
            return this.vaccines.find(v=>v?.id==vac_id)?.name || ''
        },
        isEditing() {
            this.isEditingTreatmentSession = this.treatmentList.some(d=>d.manage==true)
        },
        async saveRow(index, rows) {
            //  api
            await this.manageTreatment(this.treatmentList[index]).then(()=>{
                //this.$root.$emit('reload_patient_data')
                // this.treatmentList.forEach(d=>d.manage=false)
                if (this.request.status == 'success') {
                    this.treatmentList.forEach(d=>d.manage=false)
                    this.isEditingTreatmentSession = false
                    this.addCount = 0
                    this.$notify({
                        title: 'Success',
                        message: this.request.message,
                        type: 'success',
                        duration: 6000,
                    });
                } else {
                    this.$notify({
                        title: 'Error',
                        message: this.request.message,
                        type: 'error',
                        duration: 0,
                    });
                }
                //alert('success')
            }).catch(()=>{
                //alert('error')
                this.$notify({
                    title: 'Error',
                    message: this.request.message,
                    type: 'error',
                    duration: 0,

                });
            })
        },
        addRow(){
            if (this.addCount < 1) {
                this.treatmentList.forEach(d=>d.manage=false)
                var day = ['D0', 'D3', 'D7', 'D14', 'D28'];
                var time = new Date().toTimeString().split(" ")[0].split(':');
                let newRow  = {
                    form_type: 'add',
                    manage: true,
                    patient_history_id: this.selectedHistory.id,
                    patient_id: this.selectedHistory.patient_id,
                    vaccine_id: this.treatmentList?.length > 0 ? this.treatmentList[0].vaccine_id : null,
                    date: buildDate(new Date()),
                    time: time[0] + ':' + (time[1][0] + '0') || '12:00',
                    designated_day: day[this.treatmentList?.length] || null,
                };
                this.treatmentList = [...this.treatmentList, newRow];
                ++ this.addCount;

                this.isEditingTreatmentSession = true
            } else {
                alert('Add once at a time please check')
            }
        },
        saveAll:function(){
            // api
            //console.log(JSON.stringify(this.disabledList));
        },
        tableRowClassName({row, rowIndex}) {
            return row.manage ? 'highlight-row' : ''
        }
    },
    created() {
        this.enumValues = JSON.parse(JSON.stringify(this.enum))
        // var col_histories = this.patients.reduce((histories, row)=>{
        //     if (row.history.length) {
        //         row.history.map(h=>h.site_of_infection).forEach(h=>{
        //             h.forEach(element => {
        //                 if (!histories.map(c=>c.code).includes(element)) {
        //                     histories.push({code: element, desc: element})
        //                 }
        //             });
        //         })
        //     }
        //     return histories
        // }, [])
        // this.enumValues.site_of_infection_history = col_histories
        this.enumValues.site_of_infection_history = this.enumValues.site_of_infection

        this.getVaccines()
        this.treatmentList = JSON.parse(JSON.stringify(this.selectedHistory.treatment || []))
        this.treatmentList.forEach(t=>{
            //this.$watch(() => t, this.handleChange, {deep: true});
            t.manage = false
            t.vaccine = JSON.parse(JSON.stringify(this.vaccines)).find(v=>v.id == t.vaccine_id)
        })

        //console.log("safasf", this.selectedData)

        if (this.selectedHistory.id) {
            var form_type = 'edit'
            var is_washed = Number(this.selectedHistory.is_washed).toString()
            var date_of_incident = new Date(this.selectedHistory.date_of_incident)
            var date_of_physical_exam = new Date(this.selectedHistory.date_of_physical_exam)
            Object.assign(this.ruleForm ,{...JSON.parse(JSON.stringify(this.selectedHistory)), form_type, is_washed, date_of_incident, date_of_physical_exam})
            this.isEdit = true
            //if (this.selectedHistory.form_type == 'edit') {
              //  this.isEdit = true
            //}
        } else {
            this.ruleForm.patient_id = JSON.parse(JSON.stringify(this.selectedPatient.id))
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