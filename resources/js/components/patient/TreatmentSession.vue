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
  <el-table :data="tableData" style="width: 100%" max-height="250">
    <el-table-column prop="date" label="Date" width="150">
      <template slot-scope="scope">
          <el-input size="small"
            style="text-align:center"
            v-model="scope.row.date" controls-position="right"></el-input>
       </template>
    </el-table-column>
    <el-table-column prop="name" label="Name" width="120">
      <template slot-scope="scope">
          <el-input size="small"
            style="text-align:center"
            v-model="scope.row.name"></el-input>
       </template>
    </el-table-column>
    <el-table-column prop="state" label="State" width="120">
      <template slot-scope="scope">
          <el-input size="small"
            style="text-align:center"
            v-model="scope.row.state"
            :disabled="scope.$index<addCount"></el-input>
       </template>
    </el-table-column>
    <el-table-column prop="city" label="City" width="120">
      <template slot-scope="scope">
          <el-input size="small"
            style="text-align:center"
            v-model="scope.row.city"></el-input>
       </template>
    </el-table-column>
    <el-table-column prop="address" label="Address" width="300">
      <template slot-scope="scope">
          <el-input size="small"
            style="text-align:center"
            v-model="scope.row.address"></el-input>
       </template>
    </el-table-column>
    <el-table-column prop="zip" label="Zip" width="120">
      <template slot-scope="scope">
          <el-input size="small"
            style="text-align:center"
            v-model="scope.row.zip"
            :disabled="scope.$index<addCount"></el-input>
       </template>
    </el-table-column>
    <el-table-column fixed="right" label="Operations" width="120">
      <template slot-scope="scope">
        <el-button @click.native.prevent="saveRow(scope.$index, scope.row)" type="text" size="small">
         Save
        </el-button>
        <el-button @click.native.prevent="deleteRow(scope.$index, scope.row)" type="text" size="small">
          Delete
        </el-button>
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



            tableData: [{
          date: '2016-05-03',
          name: 'Tom',
          state: 'California',
          city: 'Los Angeles',
          address: 'No. 189, Grove St, Los Angeles',
          zip: 'CA 90036',
          tag: 'Home'
        }, {
          date: '2016-05-02',
          name: 'Tom',
          state: 'California',
          city: 'Los Angeles',
          address: 'No. 189, Grove St, Los Angeles',
          zip: 'CA 90036',
          tag: 'Office'
        }, {
          date: '2016-05-04',
          name: 'Tom',
          state: 'California',
          city: 'Los Angeles',
          address: 'No. 189, Grove St, Los Angeles',
          zip: 'CA 90036',
          tag: 'Home'
        }, {
          date: '2016-05-01',
          name: 'Tom',
          state: 'California',
          city: 'Los Angeles',
          address: 'No. 189, Grove St, Los Angeles',
          zip: 'CA 90036',
          tag: 'Office'
        }],
       addCount:0
        }
    },
    computed: {
        ...mapGetters(['vaccines']),
    },
    methods: {
        handleEdit() {

        },
        handleDelete() {

        },


        deleteRow(index, rows) {
        this.tableData.splice(index, 1);
        if(this.addCount > 0)
          -- this.addCount;
      },
     saveRow(index, rows) {
        //  api
      },
     addRow(){
       let newRow  = {
         state:"California",
         zip: "CA 90036",
       };
       this.tableData = [newRow,...this.tableData];
       ++ this.addCount;
     },
     saveAll:function(){
       // api
       //console.log(JSON.stringify(this.disabledList));
     },
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




    .el-table__row .el-input .el-input__inner{
  border-style:none;
}
.hover-row .el-input .el-input__inner{
  border-style:solid;
}
</style>