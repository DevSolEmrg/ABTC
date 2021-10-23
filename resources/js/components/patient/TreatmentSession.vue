<template>
    <el-card class="box-card" style="margin-bottom:5px">
        <div slot="header" class="clearfix">
            <label style="margin-bottom:0px;vertical-align: middle;text-align: center;"> {{ ruleForm.designated_day }} </label>
            <!-- <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
            <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
            <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button> -->
            <el-button-group style="float: right;">
                <el-tooltip class="item" effect="light" content="Edit" placement="top" :enterable="false" style="margin-bottom:0px">
                    <el-button type="primary" size="mini" icon="mdi mdi-lead-pencil" circle plain @click="handleEdit()"></el-button>
                </el-tooltip>
                <el-tooltip class="item" effect="light" content="Delete" placement="top" :enterable="false" style="margin-bottom:0px">
                    <el-button type="danger" size="mini" icon="mdi mdi-delete" circle plain @click="handleDelete()"></el-button>
                </el-tooltip>
            </el-button-group>
        </div>
        <!-- <div v-for="o in 4" :key="o" class="text item">
            {{'List item ' + o }}
        </div> -->
        <div>
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm" :inline="true">
                <el-form-item label="Desig. Day" prop="designated_day">
                    <el-input type="text" ref="designated_day" v-model="ruleForm.designated_day" size="small" :clearable="true"></el-input>
                </el-form-item>

                <el-form-item label="Date" required>
                    <el-form-item prop="date">
                        <el-date-picker type="date" placeholder="Pick a date" size="small" v-model="ruleForm.date" :picker-options="pickerOptions" timezone="UTC"></el-date-picker>
                    </el-form-item>
                </el-form-item>
                <el-form-item label="Vaccine" prop="vaccine_id">
                    <el-select v-model="ruleForm.vaccine_id" placeholder="Select" size="small" clearable>
                        <el-option v-for="vac in vaccines" :key="vac.id" :label="vac.name" :value="vac.id" :title="`${vac.name} - ${vac.description}`" />
                    </el-select>
                </el-form-item>

                <el-form-item >
                    <el-button size="small">Cancel</el-button>
                    <el-button size="small" type="primary">Save</el-button>
                </el-form-item>


            <!-- <el-form-item align="right">
                <el-button @click="resetForm('ruleForm')">Reset Field</el-button>
                <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
            </el-form-item> -->
        </el-form>
        </div>
        <!-- <div>
            <el-button type="primary" style="width:100%">SAVE</el-button>
        </div> -->

        <el-button @click="addRow">Add</el-button>
        <el-button @click="saveAll">Save All</el-button>
        <el-table :data="tableData" style="width: 100%" :row-class-name="tableRowClassName" border>
            <el-table-column prop="name" label="Designated Day" width="200">
                <template slot-scope="scope">
                    <span v-if="!scope.row.manage">{{ scope.row.name }}</span>
                    <el-input
                        v-else
                        size="small"
                        placeholder="E.g. D0, D3, D7..."
                        v-model="scope.row.name"
                        clearable
                    />
                </template>
            </el-table-column>
            <el-table-column prop="date" label="Date of Apperance" width="243">
                <template slot-scope="scope">
                    <span v-if="!scope.row.manage">{{ scope.row.date }}</span>
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
            <el-table-column prop="zip" label="Vaccine" min-width="143">
                <template slot-scope="scope">
                    <span v-if="!scope.row.manage">{{ getVaccineName(scope.row.vaccine_id) }}</span>
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
                            <el-button :disabled="isEditing()" type="primary" size="mini" icon="mdi mdi-lead-pencil" circle plain @click="handleEdit(scope.$index, scope.row)"></el-button>
                        </el-tooltip>
                        <el-tooltip v-if="!scope.row.manage" class="item" effect="light" content="Delete" placement="top" :enterable="false" style="margin-bottom:0px">
                            <el-button :disabled="isEditing()" type="danger" size="mini" icon="mdi mdi-delete" circle plain @click="handleDelete(scope.$index, scope.row)"></el-button>
                        </el-tooltip>
                        <el-tooltip v-if="scope.row.manage" class="item" effect="light" content="Cancel" placement="top" :enterable="false" style="margin-bottom:0px">
                            <el-button type="warning" size="mini" icon="mdi mdi-close-thick" circle @click="handleCancel(scope.$index, scope.row)"></el-button>
                        </el-tooltip>
                        <el-tooltip v-if="scope.row.manage" class="item" effect="light" content="Save" placement="top" :enterable="false" style="margin-bottom:0px">
                            <el-button type="success" size="mini" icon="mdi mdi-check-bold" circle @click="saveRow(scope.$index, scope.row)"></el-button>
                        </el-tooltip>
                    </el-button-group>
                </template>
            </el-table-column>
        </el-table>
    </el-card>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    props: ['treatment'],
    data() {
        return {
            ruleForm: {
                form_type: 'add',
                designated_day: '',
                date: '',
                vaccine_id: ''
            },
            rules: {
                designated_day: [
                    { required: true, message: 'Please input designated day', trigger: 'change' }
                ],
                date: [
                    { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' }
                ],
                vaccine_id: [
                    { required: true, message: 'Please select vaccine', trigger: 'change' },
                ],
            },
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            },
            tableData: [
                {
                    date: '2016-05-03',
                    name: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Home',
                    vaccine_id: 1,
                    manage: false
                }, {
                    date: '2016-05-02',
                    name: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Office',
                    vaccine_id: 1,
                    manage: true
                }, {
                    date: '2016-05-04',
                    name: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Home',
                    vaccine_id: 1,
                    manage: false
                }, {
                    date: '2016-05-01',
                    name: 'Tom',
                    state: 'California',
                    city: 'Los Angeles',
                    address: 'No. 189, Grove St, Los Angeles',
                    zip: 'CA 90036',
                    tag: 'Office',
                    vaccine_id: 1,
                    manage: false
                }
            ],
            addCount:0
        }
    },
    computed: {
        ...mapGetters(['vaccines']),
    },
    methods: {
        handleEdit(index, rows) {
            this.tableData[index].manage = true
        },
        handleDelete(index, rows) {
            this.tableData.splice(index, 1);
            if(this.addCount > 0)
            -- this.addCount;
        },
        handleCancel(index, rows) {
            if (rows?.form_type == 'add') {
                this.tableData.splice(index, 1);
                this.addCount = 0
            } else {
                this.tableData[index].manage = false
            }
        },
        getVaccineName(vac_id) {
            return this.vaccines.find(v=>v?.id==vac_id)?.name || ''
        },
        isEditing() {
            return this.tableData.some(d=>d.manage==true)
        },
        saveRow(index, rows) {
            //  api
        },
        addRow(){
            if (this.addCount < 1) {
                this.tableData.forEach(d=>d.manage=false)
                let newRow  = {
                    form_type: 'add',
                    manage: true,
                    state:"California",
                    zip: "CA 90036",
                };
                this.tableData = [newRow,...this.tableData];
                ++ this.addCount;
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
        let treatment = JSON.parse(JSON.stringify(this.treatment))
        this.ruleForm.designated_day = treatment.designated_day
        this.ruleForm.date = treatment.date
        this.ruleForm.vaccine_id = treatment.vaccine_id
        //this.card_title = treatment.designated_day
    }
}
</script>

<style scoped>
    .text {
        font-size: 14px;
    }
    .item {
        margin-bottom: 18px;
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
        width: 480px;
    }
</style>