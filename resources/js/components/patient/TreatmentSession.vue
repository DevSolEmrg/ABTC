<template>
    <el-card class="box-card" style="margin-bottom:5px">
        <div slot="header" class="clearfix">
            <label style="margin-bottom:0px;vertical-align: middle;text-align: center;">SAMPLE</label>
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
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
                <el-form-item label="Desig. Day" prop="designated_day">
                    <el-input type="text" ref="designated_day" v-model="ruleForm.designated_day" :clearable="true"></el-input>
                </el-form-item>

                <el-form-item label="Date" required>
                    <el-form-item prop="date">
                        <el-date-picker type="date" placeholder="Pick a date" v-model="ruleForm.date" :picker-options="pickerOptions" timezone="UTC"></el-date-picker>
                    </el-form-item>
                </el-form-item>
                <!-- <el-form-item label="Vaccine" prop="vaccine_id">
                    <el-select v-model="ruleForm.vaccine_id" placeholder="Select" clearable>
                        <el-option v-for="type in enumValues.type_of_animal" :key="type.code" :label="type.code" :value="type.code" :title="type.desc" />
                    </el-select>
                </el-form-item> -->


            <!-- <el-form-item align="right">
                <el-button @click="resetForm('ruleForm')">Reset Field</el-button>
                <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
            </el-form-item> -->
        </el-form>
        </div>
        <div>
            <el-button type="primary" style="width:100%">SAVE</el-button>
        </div>
    </el-card>
</template>

<script>
export default {
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
        }
    },
    methods: {
        handleEdit() {

        },
        handleDelete() {

        }
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