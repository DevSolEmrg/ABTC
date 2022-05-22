<template>
    <el-dialog
        title="Import Patient List"
        :visible.sync="dialog_visible"
        fullscreen
        :before-close="handleClose"
    >
        <!-- <span>This is a message</span>
        <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">Cancel</el-button>
            <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>
        </span> -->
        <el-row :gutter="24">
            <el-col :span="24">
                <el-upload
                    class="upload-demo"
                    ref="upload"
                    action="#"
                    :auto-upload="false"
                    :on-change="upload"
                    :limit="1"
                    :on-exceed="handleExceed"
                    :on-remove="handleRemove"
                    :before-remove="beforeRemove"
                >
                    <el-button slot="trigger" size="small" icon="el-icon-paperclip" title="Note: You can upload one excel file with several worksheets; to cancel/delete the current chosen file, click reset button or hover over the filename and click the 'X' button on the right side of the filename.">Browse excel file to import data...</el-button>
                    <el-popover content="Make sure you select correct excel format .xlsx/.csv, click here to download excel template." placement="top-start" title="Required Excel Format" width="350" trigger="hover">
                        <el-button slot="reference" size="small" type="info" plain icon="mdi mdi-file-excel-outline"></el-button>
                    </el-popover>
                    <!-- <el-popover content="Make sure you select correct excel format .xlsx/.csv, click here to download excel template." placement="top-start" title="Data reader config." width="350" trigger="hover"> -->
                        <el-button size="small" type="info" :plain="!importConfig" :icon="`mdi mdi-cog${importConfig?'-off':''}`" @click="importConfig=!importConfig"></el-button>
                    <!-- </el-popover> -->
                    <el-button v-if="excel_data.length" size="small" type="danger" icon="el-icon-delete" @click="$refs.upload.clearFiles(); handleRemove(null, null)">Reset</el-button>
                    <el-popover content="The uploaded record will be placed in a queue; while waiting for the data to upload, you can move to any page. Please wait for the message to see if the data was successfully uploaded." placement="top-start" title="Upload Note" width="350" trigger="hover">
                        <el-button v-if="!excel_error.length && excel_data.length" slot="reference" style="margin-left: 10px;" size="small" type="primary" @click.stop="submitUpload" icon="el-icon-upload">Upload to Server/Database</el-button>
                        <el-button v-else slot="reference" style="margin-left: 10px;" size="small" type="primary" icon="el-icon-upload" disabled>Upload to Server/Database</el-button>
                    </el-popover>
                    <div class="el-upload__tip" slot="tip">.xlsx/.csv file</div>

                    <el-input align="right" v-model="search" :disabled="!excel_data.length" size="small" prefix-icon="el-icon-search" :placeholder="`Search on worksheet name: ${excel_data.length ? tab : 'N.A.'}`" clearable style="width:400px;margin-bottom:15px; float:right">
                            <!-- <template slot="append"> {{ search?`${ListData.length}/${item.content.length}`:item.content.length }} Record</template> -->
                        </el-input>

                </el-upload>
            </el-col>
            <el-col :span="24" v-if="importConfig">
                <el-collapse value="1" accordion style="margin-bottom:10px">
                    <el-collapse-item title="DATA READER CONFIGURATION" name="1">
                        <div>Start reading data on row? <input v-model="configs.start_row" onkeypress="return event.charCode >= 48 && event.charCode != 101" title="Do not include header" type="number" min="1" style="width:50px; text-align: center; border: 1px solid #E1E1E1; border-radius: 4px;" /> </div>
                        <div>
                            <!-- <br> -->
                            EXCEL SHEET COLUMNS


                            <!-- <el-divider></el-divider> -->
                            <el-row>
                                <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">

                                    <table>
                                        <tr style="background-color:rgb(240,240,240)">
                                            <th>Column</th>
                                            <th>Name Box</th>
                                        </tr>
                                        <tr>
                                            <td>NO. (REGISTRATION) </td>
                                            <td><input v-model="configs.registration_number" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.registration_number" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>DATE (REGISTRATION)</td>
                                            <td><input v-model="configs.registration_date" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.registration_date" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>NAME OF PATIENT</td>
                                            <td><input v-model="configs.name" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.name" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>ADDRESS</td>
                                            <td><input v-model="configs.address" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.address" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>AGE</td>
                                            <td><input v-model="configs.age" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.age" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>SEX</td>
                                            <td><input v-model="configs.gender" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.gender" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>DATE (HISTORY OF EXPOSURE)</td>
                                            <td><input v-model="configs.date_of_incident" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.date_of_incident" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>PLACE (WHERE BITING OCCURRED)</td>
                                            <td><input v-model="configs.place_of_incident" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.place_of_incident" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>TYPE OF ANIMAL</td>
                                            <td><input v-model="configs.type_of_animal" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.type_of_animal" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>TYPE (B/NB)</td>
                                            <td><input v-model="configs.type_of_exposure" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.type_of_exposure" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>SITE (BODY PARTS)</td>
                                            <td><input v-model="configs.site_of_infection" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.site_of_infection" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>CATEGORY (1,2 AND 3)</td>
                                            <td><input v-model="configs.category" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.category" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                    </table>




                                    <!-- NO. = <input v-model="configs.registration_number" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            DATE = <input v-model="configs.registration_date" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            NAME OF PATIENT = <input v-model="configs.name" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            ADDRESS = <input v-model="configs.address" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            AGE = <input v-model="configs.age" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            SEX = <input v-model="configs.gender" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            DATE = <input v-model="configs.date_of_incident" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            PLACE (WHERE BITING OCCURRED) = <input v-model="configs.place_of_incident" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            TYPE OF ANIMAL = <input v-model="configs.type_of_animal" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            TYPE (B/NB) = <input v-model="configs.type_of_exposure" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            SITE (BODY PARTS) = <input v-model="configs.site_of_infection" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            CATEGORY (1,2 AND 3) = <input v-model="configs.category" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br> -->
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">

                                    <table>
                                        <tr style="background-color:rgb(240,240,240)">
                                            <th>Column</th>
                                            <th>Name Box</th>
                                        </tr>
                                        <tr>
                                            <td>WASHING OF BITE (Y/N) </td>
                                            <td><input v-model="configs.is_washed" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.is_washed" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>RIG DATE GIVEN</td>
                                            <td><input v-model="configs.rig_date_given" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.rig_date_given" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>ROUTE</td>
                                            <td><input v-model="configs.route" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.route" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>D0</td>
                                            <td><input v-model="configs.d_one" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.d_one" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>D3</td>
                                            <td><input v-model="configs.d_tree" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.d_tree" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>D7</td>
                                            <td><input v-model="configs.d_seven" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.d_seven" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>D14</td>
                                            <td><input v-model="configs.d_fourteen" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.d_fourteen" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>D28</td>
                                            <td><input v-model="configs.d_twenty_eight" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.d_twenty_eight" /> <span>&nbsp;{{ configs.start_row }}</span> </span></td>
                                        </tr>
                                        <tr>
                                            <td>BRAND NAME</td>
                                            <td><input v-model="configs.brand_name" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.brand_name" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>OUTCOME (C/Inc/N/D) </td>
                                            <td><input v-model="configs.outcome" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.outcome" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>BITING ANIMAL STATUS (after 14 days) (Alive/dead/lost)</td>
                                            <td><input v-model="configs.animal_status" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.animal_status" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>REMARKS</td>
                                            <td><input v-model="configs.remarks" class="name-box" onkeydown="return /[a-z]/i.test(event.key)" type="text" :title="configs.remarks" /> <span>&nbsp;{{ configs.start_row }}</span></td>
                                        </tr>
                                    </table>

                                    <!-- WASHING OF BITE (Y/N) = <input v-model="configs.is_washed" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            RIG DATE GIVEN = <input v-model="configs.rig_date_given" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            ROUTE = <input v-model="configs.route" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            D0 = <input v-model="configs.d_one" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            D3 = <input v-model="configs.d_tree" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            D7 = <input v-model="configs.d_seven" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            D14 = <input v-model="configs.d_fourteen" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            D28 = <input v-model="configs.d_twenty_eight" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            BRAND NAME = <input v-model="configs.brand_name" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            OUTCOME (C/Inc/N/D) = <input v-model="configs.outcome" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            BITING ANIMAL STATUS (after 14 days) (Alive/dead/lost) = <input v-model="configs.animal_status" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> <br>
                            REMARKS = <input v-model="configs.remarks" class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ configs.start_row }}</span> -->

                                </el-col>
                            </el-row>
<!--
                            NO. = 2 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            DATE = 4 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            NAME OF PATIENT = 5 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            ADDRESS = 6 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            AGE = 7 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            SEX = 8 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            DATE = 9 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            PLACE (WHERE BITING OCCURRED) = 10 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            TYPE OF ANIMAL = 11 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            TYPE (B/NB) = 12 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            SITE (BODY PARTS) = 13 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            CATEGORY (1,2 AND 3) = 14 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            WASHING OF BITE (Y/N) = 15 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            RIG DATE GIVEN = 16 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            ROUTE = 17 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            D0 = 18 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            D3 = 19 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            D7 = 20 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            D14 = 21 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            D28 = 22 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            BRAND NAME = 23 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            OUTCOME (C/Inc/N/D) = 24 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            BITING ANIMAL STATUS (after 14 days) (Alive/dead/lost) = 29 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> <br>
                            REMARKS = 35 <input class="name-box" type="text" title="Name Box" /> <span>&nbsp;{{ start_on_row }}</span> -->
                        </div>
                        <div>
                            <el-button type="primary" style="float:right; margin-top:17px; margin-bottom:17px; margin-left:8px" @click="saveConfigs()"> Save Configuration</el-button>
                             <el-button style="float:right; margin-top:17px; margin-bottom:17px; margin-left:8px" @click="getConfigs()"> Reload/Reset Configuration </el-button>
                        </div>
                    </el-collapse-item>
                </el-collapse>
            </el-col>
            <el-col :span="24" v-if="excel_error.length">
                <el-collapse accordion style="border:3px solid #F56C6C; border-radius: 5px">
                    <el-collapse-item :title="`ERROR FOUND (${excel_error.length}), EDIT RECORD TO IMPORT`" name="1" style="padding-left:8px; padding-right:8px">
                        <table>
                            <tr style="background-color:rgb(240,240,240)">
                                <th style="width:10px">#</th>
                                <th>Worksheet Name</th>
                                <th>Cell Position</th>
                                <th>Description</th>
                                <th>Value</th>
                                <th>Valid Input</th>
                            </tr>
                            <tr v-for="(error, i) in excel_error" :key="i">
                                <td> {{ i + 1 }} </td>
                                <td> {{ error.tab }} </td>
                                <td> {{ error.cell_position }} </td>
                                <td> {{ error.message }} </td>
                                <td> {{ error.value }} </td>
                                <td> {{ error.valid_input }} </td>
                            </tr>
                        </table>
                    </el-collapse-item>
                </el-collapse>
            </el-col>
            <!-- <el-col
                :span="24"
                v-show="
                    is_preview &&
                        excel_data.length > 0 &&
                        excel_table_headers.length > 0
                "
            >
                <v-card>
                    <v-tabs
                        v-model="tab"
                        background-color="primary"
                        dark
                    >
                        <v-tab
                            v-for="item in excel_data"
                            :key="item.tab"
                        >
                            {{ item.tab }}
                        </v-tab>
                    </v-tabs>
                    <v-tabs-items v-model="tab">
                        <v-tab-item
                            v-for="item in excel_data"
                            :key="item.id"
                        >
                            <v-card flat>
                                <v-data-table
                                    :headers="
                                        excel_table_headers
                                    "
                                    :items="item.content"
                                    class="elevation-1"
                                >
                                    <template
                                        v-slot:[`header.Office_Name`]="{
                                            header
                                        }"
                                    >
                                        {{
                                            header.text.toUpperCase()
                                        }}
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>
            </el-col> -->

            <el-col
                :span="24"
                v-show="!is_preview && excel_data.length > 0"
            >
                <!-- <v-alert
                    dense
                    outlined
                    type="error"
                    style="border: 1px solid rgba(0,0,0,0) !important;"
                >
                    ERROR FOUND, Please see error log bellow
                </v-alert> -->
                <!-- <ul>
                    <dl>
                        <dt>CONTENT</dt>
                        <ol>
                            <li
                                v-for="error in excel_error[0]"
                                :key="error.id"
                            >
                                <strong>{{
                                    error.value
                                }}</strong>
                                {{ error.message }}
                                <strong
                                    >[{{
                                        error.cell_position
                                    }}]</strong
                                >
                            </li>
                        </ol>
                    </dl>
                </ul> -->
            </el-col>
            <el-col :span="24" v-if="excel_data.length">
                <el-tabs v-model="tab" type="border-card" :closable="excel_data.length>1" @tab-remove="removeTab">
                    <el-tab-pane
                        v-for="(item, index) in excel_data"
                        :key="item.id"
                        :label="item.tab+'('+item.content.length+')'"
                        :name="item.tab"
                    >
                        <!-- {{item.content}} -->
                        <!-- <el-input v-model="search" size="mini" prefix-icon="el-icon-search" placeholder="Type to search" clearable style="width:400px;margin-bottom:15px">
                            <template slot="append"> {{ search?`${ListData.length}/${item.content.length}`:item.content.length }} Record</template>
                        </el-input> -->
                        <el-table :data="ListData" border :header-cell-style="{ background: 'rgba(0,0,0,0.04)' }" :row-class-name="tableRowClassName">
                            <!-- <el-table-column prop="registration_number" label="No." width="50" />
                            <el-table-column prop="registration_date" label="Date" width="100" />
                            <el-table-column prop="name" label="Name" width="200" />
                            <el-table-column prop="address" label="Address" width="300" />
                            <el-table-column prop="age" label="Age" width="48" />
                            <el-table-column prop="gender" label="Gender" width="75" />
                            <el-table-column prop="date_of_incident" label="Date of Inci" width="100" />
                            <el-table-column prop="place_of_incident" label="Place of Inci" width="300" />
                            <el-table-column prop="type_of_animal" label="Type of animal" />
                            <el-table-column prop="type_of_exposure" label="Type of Exposure" />
                            <el-table-column prop="site_of_infection" label="Site of Infection" />
                            <el-table-column prop="category" label="Category" />
                            <el-table-column prop="is_washed" label="Washed?" />
                            <el-table-column prop="rig_date_given" label="Rig Date" width="100" />
                            <el-table-column prop="route" label="Route" />
                            <el-table-column prop="d_one" label="D0" width="100" />
                            <el-table-column prop="d_tree" label="D3" width="100" />
                            <el-table-column prop="d_seven" label="D7" width="100" />
                            <el-table-column prop="d_fourteen" label="D14" width="100" />
                            <el-table-column prop="d_twenty_eight" label="D28" width="100" />
                            <el-table-column prop="brand_name" label="Brand Name" />
                            <el-table-column prop="outcome" label="Outcome" />
                            <el-table-column prop="animal_status" label="Animal Status" />
                            <el-table-column prop="remarks" label="Remarks" /> -->

                            <el-table-column prop="registration_number" label="NO." width="50" fixed="left" />
                            <el-table-column prop="registration_date" label="DATE" width="100" fixed="left" />
                            <el-table-column prop="name" label="NAME OF PATIENT" width="200" fixed="left" />
                            <el-table-column prop="address" label="ADDRESS" width="275" />
                            <el-table-column prop="age" label="AGE" width="55" />
                            <el-table-column prop="gender" label="SEX" width="75" />
                            <el-table-column prop="date_of_incident" label="DATE" width="100" />
                            <el-table-column prop="place_of_incident" label="PLACE (WHERE BITING OCCURRED)" width="275" />
                            <el-table-column prop="type_of_animal" label="TYPE OF ANIMAL" />
                            <el-table-column prop="type_of_exposure" label="TYPE (B/NB)" />
                            <el-table-column prop="site_of_infection" label="SITE (BODY PARTS)" />
                            <el-table-column prop="category" label="CATEGORY (1,2 AND 3)" />
                            <el-table-column prop="is_washed" label="WASHING OF BITE (Y/N)" />
                            <el-table-column prop="rig_date_given" label="RIG DATE GIVEN" width="100" />
                            <el-table-column prop="route" label="ROUTE" />
                            <el-table-column prop="d_one" label="D0" width="100" />
                            <el-table-column prop="d_tree" label="D3" width="100" />
                            <el-table-column prop="d_seven" label="D7" width="100" />
                            <el-table-column prop="d_fourteen" label="D14" width="100" />
                            <el-table-column prop="d_twenty_eight" label="D28" width="100" />
                            <el-table-column prop="brand_name" label="BRAND NAME" width="100" />
                            <el-table-column prop="outcome" label="OUTCOME (C/Inc/N/D)" width="120" />
                            <el-table-column prop="animal_status" label="BITING ANIMAL STATUS (after 14 days) (Alive/dead/lost)" width="150" />
                            <el-table-column prop="remarks" label="REMARKS" width="200" />

                            <!-- registration_number: dataCol[2],
                                                    registration_date: dataCol[4],
                                                    name: dataCol[5],
                                                    address: dataCol[6],
                                                    age: dataCol[7],
                                                    gender: dataCol[8],
                                                    date_of_incident: dataCol[9],
                                                    place_of_incident: dataCol[10],
                                                    type_of_animal: dataCol[11],
                                                    type_of_exposure: dataCol[12],
                                                    site_of_infection: dataCol[13],
                                                    category: dataCol[14],
                                                    is_washed: dataCol[15],
                                                    rig_date_given: dataCol[16],
                                                    route: dataCol[17],
                                                    d_one: dataCol[18],
                                                    d_tree: dataCol[19],
                                                    d_seven: dataCol[20],
                                                    d_fourteen: dataCol[21],
                                                    d_twenty_eight: dataCol[22],
                                                    brand_name: dataCol[23],
                                                    outcome: dataCol[24],
                                                    animal_status: dataCol[25],
                                                    remarks: dataCol[26], -->
                        </el-table>

                        <div style="text-align: center; overflow-x:auto">
                            <el-pagination
                                background
                                layout="prev, pager, next"
                                @current-change="handleCurrentChange"
                                :page-size="pageSize"
                                :total="total"
                                hide-on-single-page>
                            </el-pagination>
                        </div>

                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>
    </el-dialog>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { buildDate } from './../../constants'
export default {
    props: ['dialogVisible'],
    data() {
        return {
            page: 1,
	    	pageSize: 5,
            loading: true,
            search: "",

            //dialogVisible: false
            valid: false,
            btnloading: false,
            excel_data: [],
            excel_error: [],
            // tab: null,
            tab: '',
            excel_table_headers: [],
            is_preview: false,
            offices: [],
            // data = [{
            //     created_at: '',
            //     name: '',
            //     address: '',
            //     age: '',
            //     gender: '',
            //     history: [{
            //         date: '',
            //         place: '',
            //         type_of_animal: '',
            //         type_of_exposure: '',
            //         site_infect: '',
            //         category: '',
            //         washing: '',
            //         rig_date: '',
            //         route: '',
            //         outcome: '',
            //         biting_animal_stat:'',
            //         remarks: '',
            //         vaccine: {
            //             d0: '',
            //             d3: '',
            //             d7: '',
            //             d14: '',
            //             d28: '',
            //             vaccine: ''
            //         }
            //     }]
            // }],
            dialog_visible: false,
            baseURL: location.origin.concat('/'),

            editableTabsValue: '2',
            editableTabs: [{
            title: 'Tab 1',
            name: '1',
            content: 'Tab 1 content'
            }, {
            title: 'Tab 2',
            name: '2',
            content: 'Tab 2 content'
            }],
            tabIndex: 2,

            importConfig: false,
            start_on_row: 9,
            configs: {}
        };
    },
    computed: {
        ...mapGetters(['enum', 'vaccines']),
        searching() {
            var tabIndex = this.excel_data.findIndex(s=>s.tab==this.tab)
            var data = this.excel_data[tabIndex].content
            if (!this.search) {
                this.total = data.length;
                return data;
            }
            this.page = 1;
            return data.filter(
                data => data.name.toLowerCase().includes(this.search.toLowerCase()) || data.address.toLowerCase().includes(this.search.toLowerCase()));
        },
        ListData() {
            this.total = this.searching.length;
            return this.searching.slice(
                this.pageSize * this.page - this.pageSize,
                this.pageSize * this.page
            );
        }
    },
    async created() {
        await this.getConfigs()
    },
    mounted() {
        this.dialog_visible = JSON.parse(JSON.stringify(this.dialogVisible))
    },
    methods: {
        ...mapActions(['importPatients']),
        handleCurrentChange(val) {
			this.page = val;
		},
        handleTabsEdit(targetName, action) {
        if (action === 'add') {
          let newTabName = ++this.tabIndex + '';
          this.editableTabs.push({
            title: 'New Tab',
            name: newTabName,
            content: 'New Tab content'
          });
          this.editableTabsValue = newTabName;
        }
        if (action === 'remove') {
          let tabs = this.editableTabs;
          let activeName = this.editableTabsValue;
          if (activeName === targetName) {
            tabs.forEach((tab, index) => {
              if (tab.name === targetName) {
                let nextTab = tabs[index + 1] || tabs[index - 1];
                if (nextTab) {
                  activeName = nextTab.name;
                }
              }
            });
          }

          this.editableTabsValue = activeName;
          this.editableTabs = tabs.filter(tab => tab.name !== targetName);
        }
      },
       handleRemove(file, fileList) {
        this.excel_data = []
         this.excel_error = [];
      },
      beforeRemove(file, fileList) {
        return this.$confirm(`Remove ${ file.name }/Reselect other file ? this action will not effect on the database only in the interface.`);
      },
      handleExceed(files, fileList) {
        this.$message.warning(`The limit is 1, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally, Please clear the recent uploaded file and browse again`);
      },
      removeTab(targetName) {
          alert('Are you sure you want to remove worksheet name: ' + targetName)
          if (this.excel_data.length > 1) {
                let tabs = this.excel_data;
                let activeName = this.tab;
                if (activeName === targetName) {
                tabs.forEach((tab, index) => {
                    if (tab.tab === targetName) {
                    let nextTab = tabs[index + 1] || tabs[index - 1];
                    if (nextTab) {
                        activeName = nextTab.tab;
                    }
                    }
                });
                }

                this.tab = activeName;
                this.excel_data = tabs.filter(tab => tab.tab !== targetName);

                this.excel_error = this.excel_error.filter(err=>err.tab!=targetName)

          }

        // let tabs = this.editableTabs;
        // let activeName = this.editableTabsValue;
        // if (activeName === targetName) {
        //   tabs.forEach((tab, index) => {
        //     if (tab.name === targetName) {
        //       let nextTab = tabs[index + 1] || tabs[index - 1];
        //       if (nextTab) {
        //         activeName = nextTab.name;
        //       }
        //     }
        //   });
        // }

        // this.editableTabsValue = activeName;
        // this.editableTabs = tabs.filter(tab => tab.name !== targetName);
      },
        handleClose(done) {
            if (this.excel_data.length) {
                this.$confirm('Are you sure to close this dialog ?')
                .then(_ => {
                    done();
                    this.$emit('close')
                })
                .catch(_ => {});
            } else {
                done();
                this.$emit('close')
            }
        },
        submitUpload() {
            //this.$refs.upload.submit();
            // alert('confirm submit')
            // this.importPatients(this.excel_data)
            let data = this.excel_data.reduce((data, tab)=>{

                tab.content.forEach((item, index)=>{
                    let patient = {
                        'name': item.name,
                        'gender': ['f', 'female'].includes(item.gender.toLowerCase()) ? 'Female' : false || ['m', 'male'].includes(item.gender.toLowerCase()) ? 'Male' : false || 'NA.',
                        'civil_status': '',
                        'birth_date': '',
                        'address': item.address,
                        'contact_number': '',
                    }
                    let patient_history = {
                        'patient_id': "",
                        'registration_number': item.registration_number,
                        'registration_date': item.registration_date,
                        'age_of_patient': item.age,
                        'date_of_incident': item.date_of_incident,
                        'place_of_incident': item.place_of_incident,
                        'date_of_physical_exam': '',
                        'place_of_physical_exam': '',
                        'type_of_animal_id': this.enum?.type_of_animal?.find(t=>t?.code?.toLowerCase() == item?.type_of_animal?.toString()?.toLowerCase())?.id || '',
                        'type_of_exposure_id': this.enum?.type_of_exposure?.find(t=>t?.code?.toLowerCase() == item?.type_of_exposure?.toString()?.toLowerCase())?.id || '',
                        'site_of_infection_id': this.enum?.site_of_infection?.find(t=>t?.code?.toLowerCase() == item?.site_of_infection?.toString()?.toLowerCase())?.id || '',
                        'is_washed': !!item.is_washed && ['Y', 'YES'].includes(item.is_washed?.toString()?.toUpperCase()?.trim()) ? 1 : 0,
                        'rig_date_given': item.rig_date_given,
                        'route': item.route,
                        'category_id': this.enum?.category?.find(t=>t?.code?.toLowerCase() == item?.category?.toString()?.toLowerCase())?.id || '',
                        'outcome_id': this.enum?.outcome?.find(t=>t?.code?.toLowerCase() == item?.outcome?.toString()?.toLowerCase())?.id || '',
                        'biting_animal_status_id': this.enum?.biting_animal_status?.find(t=>t?.code?.toString()?.toLowerCase() == item?.animal_status?.toLowerCase())?.id || '',
                        'doctors_order': '',
                        'nurses_notes': '',
                        'remarks': item.remarks
                    }
                    patient_history.site_of_infection_id = !!patient_history.site_of_infection_id ? [patient_history.site_of_infection_id] : ""
                    let patient_treament = []
                    let vaccine_given = this.vaccines.find(v=>v?.name?.toLowerCase() == item?.brand_name?.toString()?.toLowerCase())?.id

                    if (!!item.d_one) {
                        patient_treament.push({ 'patient_history_id': '',
                            'designated_day': 'D0',
                            'date': item.d_one,
                            'time': '12:00',
                            'vaccine_id' : vaccine_given,
                        })
                    }

                    if (!!item.d_tree) {
                        patient_treament.push({ 'patient_history_id': '',
                            'designated_day': 'D3',
                            'date': item.d_tree,
                            'time': '12:00',
                            'vaccine_id' : vaccine_given,
                        })
                    }

                    if (!!item.d_seven) {
                        patient_treament.push({ 'patient_history_id': '',
                            'designated_day': 'D7',
                            'date': item.d_seven,
                            'time': '12:00',
                            'vaccine_id' : vaccine_given,
                        })
                    }

                    if (!!item.d_fourteen) {
                        patient_treament.push({ 'patient_history_id': '',
                            'designated_day': 'D14',
                            'date': item.d_fourteen,
                            'time': '12:00',
                            'vaccine_id' : vaccine_given,
                        })
                    }

                    if (!!item.d_twenty_eight) {
                        patient_treament.push({ 'patient_history_id': '',
                            'designated_day': 'D28',
                            'date': item.d_twenty_eight,
                            'time': '12:00',
                            'vaccine_id' : vaccine_given,
                        })
                    }

                    data.push({ patient, patient_history, patient_treament })
                })

                return data

            }, [])

            this.importPatients(data)

            console.log("patient list", data, "enum", this.enum, "vaccines", this.vaccines)
        },
        upload(file, fileList) {
            // console.log(file.raw, file.raw.name, file.raw.name.split(".").pop().toLowerCase())
            try {
                var fileExtension = file.raw.name.split(".").pop().toLowerCase();
                if (fileExtension == "xlsx") {
                    this.importPatient(file.raw);
                } else {
                    this.$notify({
                        title: 'Error',
                        message: 'To avoid error required file extension "xlsx"',
                        type: 'error',
                        duration: 0,
                    });
                }
            } catch (error) {
                this.excel_data = [];
                this.excel_error = [];
                this.valid = false;
            }
        },
        async importPatient(file) {
            const Excel = await require("exceljs");

            this.excel_table_headers = [];
            this.excel_table_headers.push(
                // { text: "Office Name", align: "start", value: "Office_Name" },
                // { text: "Office Code", value: "Office_Code" },
                // { text: "Address", value: "Address" },
                // { text: "Contact Number", value: "Contact_Number" },
                // { text: "Email Address", value: "Email_Address" },

                { text: "No.", align: "start", value: "registration_number" },
                { text: "Date", value: "registration_date" },
                { text: "Name", value: "name" },
                { text: "Address", value: "address" },
                { text: "Age", value: "age" },
                { text: "Gender", value: "gender" },
                { text: "Date of Inci", value: "date_of_incident" },
                { text: "Place of Inci", value: "place_of_incident" },
                { text: "Type of Animal", value: "type_of_animal" },
                { text: "Type of Exposure", value: "type_of_exposure" },
                { text: "Site of Infection", value: "site_of_infection" },
                { text: "Category", value: "category" },
                { text: "Washed?", value: "is_washed" },
                { text: "Rig. Date", value: "rig_date_given" },
                { text: "Route", value: "route" },
                { text: "D0", value: "d_one" },
                { text: "D3", value: "d_tree" },
                { text: "D7", value: "d_seven" },
                { text: "D14", value: "d_fourteen" },
                { text: "D28", value: "d_twenty_eight" },
                { text: "Brand Namme", value: "brand_name" },
                { text: "Outcome", value: "outcome" },
                { text: "Animal Status", value: "animal_status" },
                { text: "Remarks", value: "remarks" },
            );
            // var offices = this.$store.state.offices.offices;
            //this.offices = [];
            // offices.forEach(office => {
            //     this.offices.push(office.name.trim().toLowerCase().replace(/\s/g, ""));
            // });
            var offices = []
            this.excel_data = [];
            this.excel_error = [];
            const wb = new Excel.Workbook();
            const reader = new FileReader();
            reader.readAsArrayBuffer(file);
            reader.onload = function() {
                const buffer = reader.result;
                wb.xlsx.load(buffer).then(
                    function(workbook) {
                        workbook.eachSheet(
                            function(sheet, id) {
                                // var sheetIndex = id - 1;
                                var sheetIndex = workbook.worksheets.findIndex(s=>s.id==id)
                                // console.log('sheet', id, sheetIndex, workbook.worksheets, workbook.worksheets[sheetIndex])
                                this.excel_data.push({
                                    id: sheetIndex,
                                    tab: workbook.worksheets[sheetIndex].name.toUpperCase(),
                                    content: []
                                });
                                sheet.eachRow({ includeEmpty: true },
                                    function(row, rowNumber) {
                                        var rowIndex = rowNumber - 1;
                                        // console.log('row', row)
                                        var dataCol = row.values;
                                        if (rowIndex == (this.configs.start_row - 2)) {
                                            // this.excel_table_headers[0].text = dataCol[2]
                                            // this.excel_table_headers[1].text = dataCol[4]
                                            // this.excel_table_headers[2].text = dataCol[5]
                                            // this.excel_table_headers[3].text = dataCol[6]
                                            // this.excel_table_headers[4].text = dataCol[7]
                                            // this.excel_table_headers[5].text = dataCol[8]
                                            // this.excel_table_headers[6].text = dataCol[9]
                                            // this.excel_table_headers[7].text = dataCol[10]
                                            // this.excel_table_headers[8].text = dataCol[11]
                                            // this.excel_table_headers[9].text = dataCol[12]
                                            // this.excel_table_headers[10].text = dataCol[13]
                                            // this.excel_table_headers[11].text = dataCol[14]
                                            // this.excel_table_headers[12].text = dataCol[15]
                                            // this.excel_table_headers[13].text = dataCol[16]
                                            // this.excel_table_headers[14].text = dataCol[17]
                                            // this.excel_table_headers[15].text = dataCol[18]
                                            // this.excel_table_headers[16].text = dataCol[19]
                                            // this.excel_table_headers[17].text = dataCol[20]
                                            // this.excel_table_headers[18].text = dataCol[21]
                                            // this.excel_table_headers[19].text = dataCol[22]
                                            // this.excel_table_headers[20].text = dataCol[23]
                                            // this.excel_table_headers[21].text = dataCol[24]
                                            // this.excel_table_headers[22].text = dataCol[29]
                                            // this.excel_table_headers[23].text = dataCol[35]
                                        }
                                        if (rowIndex >= (this.configs.start_row - 1)) {
                                            // var dataCol = row.values;
                                            if (!!dataCol[3] || !!dataCol[4] || !!dataCol[5]) {
                                                // console.log(sheet?.getCell('B'+rowNumber)?.value)
                                                var row_data = {
                                                    registration_number: this.nullable(sheet?.getCell(this.configs.registration_number + rowNumber)?.value),
                                                    registration_date: this.falsableDate(sheet?.getCell(this.configs.registration_date + rowNumber)?.value),
                                                    name: sheet?.getCell(this.configs.name + rowNumber)?.value,
                                                    address: sheet?.getCell(this.configs.address + rowNumber)?.value,
                                                    age: this.nullable(sheet?.getCell(this.configs.age + rowNumber)?.value),
                                                    gender: sheet?.getCell(this.configs.gender + rowNumber)?.value,
                                                    date_of_incident: this.falsableDate(sheet?.getCell(this.configs.date_of_incident + rowNumber)?.value),
                                                    place_of_incident: this.nullable(sheet?.getCell(this.configs.place_of_incident + rowNumber)?.value),
                                                    type_of_animal: this.nullable(sheet?.getCell(this.configs.type_of_animal + rowNumber)?.value),
                                                    type_of_exposure: this.nullable(sheet?.getCell(this.configs.type_of_exposure + rowNumber)?.value),
                                                    site_of_infection: this.nullable(sheet?.getCell(this.configs.site_of_infection + rowNumber)?.value),
                                                    category: this.nullable(sheet?.getCell(this.configs.category + rowNumber)?.value),
                                                    is_washed: this.nullable(sheet?.getCell(this.configs.is_washed + rowNumber)?.value),
                                                    rig_date_given: this.falsableDate(sheet?.getCell(this.configs.rig_date_given + rowNumber)?.value),
                                                    route: this.nullable(sheet?.getCell(this.configs.route + rowNumber)?.value),
                                                    d_one: this.falsableDate(sheet?.getCell(this.configs.d_one + rowNumber)?.value),
                                                    d_tree: this.falsableDate(sheet?.getCell(this.configs.d_tree + rowNumber)?.value),
                                                    d_seven: this.falsableDate(sheet?.getCell(this.configs.d_seven + rowNumber)?.value),
                                                    d_fourteen: this.falsableDate(sheet?.getCell(this.configs.d_fourteen + rowNumber)?.value),
                                                    d_twenty_eight: this.falsableDate(sheet?.getCell(this.configs.d_twenty_eight + rowNumber)?.value),
                                                    brand_name: this.nullable(sheet?.getCell(this.configs.brand_name + rowNumber)?.value),
                                                    outcome: this.nullable(sheet?.getCell(this.configs.outcome + rowNumber)?.value),
                                                    animal_status: this.nullable(sheet?.getCell(this.configs.animal_status + rowNumber)?.value),
                                                    remarks: this.nullable(sheet?.getCell(this.configs.remarks + rowNumber)?.value),
                                                }

                                                var temp_record_id = this.randomKey()

                                                var err_id = {
                                                    id: temp_record_id,
                                                    tab: workbook.worksheets[sheetIndex].name.toUpperCase()
                                                }

                                                if (!!row_data.registration_number && !(Number(row_data.registration_number) > 0)) {
                                                    //must be integer
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.registration_number,
                                                        message: "Must be integer",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.registration_number + rowNumber}`,
                                                        valid_input: 'Number',
                                                    })
                                                }

                                                if (!row_data.name || !!row_data.name) {
                                                    //invalid name format
                                                    var name_err = []
                                                    if (!row_data.name?.toString()?.trim()) {
                                                        //'Please input patient name'
                                                        name_err.push('required')
                                                    } else if (!(/^[a-z0-9,. Ññ]+$/i.test(row_data.name))) {
                                                        //'Name can contain only " [a-z,A-Z,0-9,. ] " characters.'
                                                        name_err.push('can only contain alpha numeric')
                                                    } else if (!row_data.name?.match(/[^,]+,[^,]+/g)) {
                                                        //'Must be a correct name format "LastName, FirstName MiddleName"'
                                                        name_err.push('invalid format')
                                                    } else {
                                                        if (row_data.name?.split(',')[1][0] != " " || row_data.name?.split(',')[1][1] == " ") {
                                                            //'Must contain 1 space after the comma on LastName'
                                                            name_err.push('has 1 space after comma on last name')
                                                        }
                                                    }

                                                    if (name_err.length) {
                                                        this.excel_error.push({...err_id,
                                                            value: row_data.name,
                                                            message: `Patient name ${name_err.join(', ')}`,
                                                            cell_position: `ws#${sheetIndex + 1} ${this.configs.name + rowNumber}`,
                                                            valid_input: '*Lastname, *Firstname Middlename',
                                                        })
                                                    }
                                                }

                                                if (!row_data.address) {
                                                    //patient address required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.address,
                                                        message: "Patient address required",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.address + rowNumber}`,
                                                        valid_input: 'String',
                                                    })
                                                }

                                                if (!!row_data.age && !(Number(row_data.age) > 0)) {
                                                    //must be integer
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.age,
                                                        message: "Must be integer",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.age + rowNumber}`,
                                                        valid_input: 'Number',
                                                    })
                                                }

                                                if (!row_data.gender || !(['M', 'F', 'MALE', 'FEMALE'].includes(row_data.gender?.toString()?.toUpperCase()?.trim()))) {
                                                    //invalid gender
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.gender,
                                                        message: "Invalid gender",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.gender + rowNumber}`,
                                                        valid_input: 'M or F',
                                                    })
                                                }

                                                if (!row_data.date_of_incident) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.date_of_incident,
                                                        message: "Required",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.date_of_incident + rowNumber}`,
                                                        valid_input: 'Date',
                                                    })
                                                }

                                                if (!row_data.place_of_incident) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.place_of_incident,
                                                        message: "Required",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.place_of_incident + rowNumber}`,
                                                        valid_input: 'String',
                                                    })
                                                }

                                                if (!!row_data.type_of_animal && !this.enum.type_of_animal?.map(i=>i.code)?.includes(row_data.type_of_animal?.toString()?.trim()?.toUpperCase()?.trim())) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.type_of_animal,
                                                        message: "Invalid, not exist on app instance",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.type_of_animal + rowNumber}`,
                                                        valid_input: 'App Instance',
                                                    })
                                                }

                                                if (!!row_data.type_of_exposure && !this.enum.type_of_exposure?.map(i=>i.code)?.includes(row_data.type_of_exposure?.toString()?.trim()?.toUpperCase()?.trim())) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.type_of_exposure,
                                                        message: "Invalid, not exist on app instance",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.type_of_exposure + rowNumber}`,
                                                        valid_input: 'App Instance',
                                                    })
                                                }

                                                if (!!row_data.site_of_infection && !this.enum.site_of_infection?.map(i=>i.code)?.includes(row_data.site_of_infection?.toString()?.trim()?.toUpperCase()?.trim())) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.site_of_infection,
                                                        message: "Invalid, not exist on app instance",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.site_of_infection + rowNumber}`,
                                                        valid_input: 'App Instance',
                                                    })
                                                }

                                                if (!!row_data.category && !this.enum.category?.map(i=>i.code)?.includes(row_data.category?.toString()?.trim()?.toUpperCase()?.trim())) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.category,
                                                        message: "Invalid, not exist on app instance",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.category + rowNumber}`,
                                                        valid_input: 'App Instance',
                                                    })
                                                }

                                                if (!!row_data.is_washed && !(['Y', 'N', 'YES', 'NO'].includes(row_data.is_washed?.toString()?.toUpperCase()?.trim()))) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.is_washed,
                                                        message: "Invalid format",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.is_washed + rowNumber}`,
                                                        valid_input: 'Y or N',
                                                    })
                                                }
                                                //else {
                                                //row_data.is_washed = !!row_data.is_washed && ['Y', 'YES'].includes(row_data.is_washed?.toString()?.toUpperCase()?.trim()) ? 1 : 0
                                                //}

                                                if (!!row_data.brand_name && !this.vaccines?.map(i=>i.name)?.includes(row_data.brand_name?.toString()?.trim()?.toUpperCase()?.trim())) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.brand_name,
                                                        message: "Vaccine not exist",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.brand_name + rowNumber}`,
                                                        valid_input: 'Vaccine',
                                                    })
                                                }

                                                if (!!row_data.outcome && !this.enum.outcome?.map(i=>i.code)?.includes(row_data.outcome?.toString()?.trim()?.toUpperCase()?.trim())) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.outcome,
                                                        message: "Invalid, not exist on app instance",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.outcome + rowNumber}`,
                                                        valid_input: 'App Instance',
                                                    })
                                                }

                                                if (!!row_data.animal_status && !this.enum.biting_animal_status?.map(i=>i.code)?.includes(row_data.animal_status?.toString()?.trim()?.toUpperCase()?.trim())) {
                                                    //required
                                                    this.excel_error.push({...err_id,
                                                        value: row_data.animal_status,
                                                        message: "Invalid, not exist on app instance",
                                                        cell_position: `ws#${sheetIndex + 1} ${this.configs.animal_status + rowNumber}`,
                                                        valid_input: 'App Instance',
                                                    })
                                                }

                                                // if (!row_data.site_of_infection) {
                                                //     //required
                                                // } validate if exist in enum/instance

                                                row_data.has_error = this.excel_error.some(r => r.id == temp_record_id)

                                                this.excel_data[sheetIndex].content.push(row_data)
                                                //this.excel_data[sheetIndex].content.push({
                                                    // Office_Name: dataCol[1] == undefined ? null : dataCol[1],
                                                    // Office_Code: dataCol[2] == undefined ? null : dataCol[2],
                                                    // Address: dataCol[3] == undefined ? null : dataCol[3],
                                                    // Contact_Number: dataCol[4] == undefined ? null : dataCol[4],
                                                    // Email_Address: dataCol[5] instanceof Object ? dataCol[5] == undefined ? null : dataCol[5].text : dataCol[5] == undefined ? null : dataCol[5],

                                                    // place_of_incident: dataCol[2],
                                                    // registration_date: this.falsableDate(dataCol[4]),
                                                    // name: dataCol[5],
                                                    // address: dataCol[6],
                                                    // age: dataCol[7],
                                                    // gender: dataCol[8],
                                                    // date_of_incident: this.falsableDate(dataCol[9]),
                                                    // place_of_incident: dataCol[10],
                                                    // type_of_animal: dataCol[11],
                                                    // type_of_exposure: dataCol[12],
                                                    // site_of_infection: dataCol[13],
                                                    // category: dataCol[14],
                                                    // is_washed: dataCol[15],
                                                    // rig_date_given: this.falsableDate(dataCol[16]),
                                                    // route: dataCol[17],
                                                    // d_one: this.falsableDate(dataCol[18]),
                                                    // d_tree: this.falsableDate(dataCol[19]),
                                                    // d_seven: this.falsableDate(dataCol[20]),
                                                    // d_fourteen: this.falsableDate(dataCol[21]),
                                                    // d_twenty_eight: this.falsableDate(dataCol[22]),
                                                    // brand_name: dataCol[23],
                                                    // outcome: dataCol[24],
                                                    // animal_status: dataCol[29],
                                                    // remarks: dataCol[35],
                                                //});
                                            }
                                        }
                                        // row.eachCell({ includeEmpty: true },
                                        //     function(cell, colNumber) {
                                        //         var colIndex = colNumber - 1;
                                        //         if (rowIndex > 0 && colIndex < 25) {
                                        //             if (cell.value != null && cell.value.toString().trim() !== "") {
                                        //                 if (colIndex == 0 && offices.includes(cell.value.trim().toLowerCase().replace(/\s/g,""))) {
                                        //                     this.excel_error[0].push({
                                        //                         id: this.randomKey(),
                                        //                         value: cell.value,
                                        //                         message: "already exist in the database",
                                        //                         cell_position: this.cellPosition(sheetIndex, colIndex, rowIndex),
                                        //                         tab: workbook.worksheets[sheetIndex].name.toUpperCase()
                                        //                     });
                                        //                 }
                                        //             } else {
                                        //                 if (cell.value == null || cell.value.trim == "") {
                                        //                     this.excel_error[0].push({
                                        //                         id: this.randomKey(),
                                        //                         value: "",
                                        //                         message: "This cell is required ",
                                        //                         cell_position: this.cellPosition(sheetIndex, colIndex, rowIndex),
                                        //                         tab: workbook.worksheets[sheetIndex].name.toUpperCase()
                                        //                     });
                                        //                 }
                                        //             }
                                        //         }
                                        //     }.bind(this)
                                        // );
                                        // row.eachCell({ includeEmpty: true },
                                        //     function(cell, colNumber) {
                                        //         var colIndex = colNumber - 1;
                                        //         if (rowIndex > 0 && colIndex < 3) {
                                        //             if (cell.value != null && cell.value.trim() !== "") {
                                        //                 if (colIndex == 0 && offices.includes(cell.value.trim().toLowerCase().replace(/\s/g,""))) {
                                        //                     this.excel_error[0].push({
                                        //                         id: this.randomKey(),
                                        //                         value: cell.value,
                                        //                         message: "already exist in the database",
                                        //                         cell_position: this.cellPosition(sheetIndex, colIndex, rowIndex)
                                        //                     });
                                        //                 }
                                        //             } else {
                                        //                 if (cell.value == null || cell.value.trim == "") {
                                        //                     this.excel_error[0].push({
                                        //                         id: this.randomKey(),
                                        //                         value: "",
                                        //                         message: "This cell is required ",
                                        //                         cell_position: this.cellPosition(sheetIndex, colIndex, rowIndex)
                                        //                     });
                                        //                 }
                                        //             }
                                        //         }
                                        //     }.bind(this)
                                        // );
                                    }.bind(this)
                                );
                            }.bind(this)
                        );
                        // if (this.excel_error[0].length < 1) {
                        if (this.excel_error.length < 1) {
                            this.is_preview = true;
                            this.valid = true;
                        } else {
                            this.is_preview = false;
                            this.valid = false;
                        }
                        this.tab = this.excel_data[0].tab
                    }.bind(this)
                );
            }.bind(this);
        },
        randomKey() {
            return Math.random().toString(36).substring(7);
        },
        cellPosition(sheet_index, column_index, row_index) {
            return ("ws#" + (sheet_index + 1) + " " + (column_index + 1 + 9).toString(36).toUpperCase() + (row_index + 1));
        },
        falsableDate(date) {
            if (!!date) {
                try {
                    //return new Date(date)?.toLocaleString().split(',')[0] != 'Invalid Date' ? new Date(date)?.toLocaleString().split(',')[0] : null
                    return new Date(date)?.toLocaleString().split(',')[0] != 'Invalid Date' ? buildDate(new Date(date)?.toLocaleString().split(',')[0]) : ""
                } catch (error) {
                    return ""
                }
            } else {
                return ""
            }
        },
        nullable(val) {
            return !!val ? val : ""
        },
        async getConfigs() {
            await axios.get('excel_reader_configs').then((response)=>{
                const [
                    registration_number,
                    registration_date,
                    name,
                    address,
                    age,
                    gender,
                    date_of_incident,
                    place_of_incident,
                    type_of_animal,
                    type_of_exposure,
                    site_of_infection,
                    category,
                    is_washed,
                    rig_date_given,
                    route,
                    d_one,
                    d_tree,
                    d_seven,
                    d_fourteen,
                    d_twenty_eight,
                    brand_name,
                    outcome,
                    animal_status,
                    remarks,
                ] = response.data.name_box
                const start_row = response.data.reader_start_on_row
                this.configs = {
                    ...this.configs,
                    start_row,
                    registration_number,
                    registration_date,
                    name,
                    address,
                    age,
                    gender,
                    date_of_incident,
                    place_of_incident,
                    type_of_animal,
                    type_of_exposure,
                    site_of_infection,
                    category,
                    is_washed,
                    rig_date_given,
                    route,
                    d_one,
                    d_tree,
                    d_seven,
                    d_fourteen,
                    d_twenty_eight,
                    brand_name,
                    outcome,
                    animal_status,
                    remarks,
                }
            })

            await this.$store.dispatch("getVaccines")
        },
        async saveConfigs() {
            if (Object.values(this.configs).every((v) => !!v)) {
                if (confirm("Confirm to save config changes!")) {
                    await axios.post('manage_excel_reader_config', this.configs).then(async(res)=>{
                        this.$notify({
                            title: 'Success',
                            message: 'Config changes has been saved',
                            type: 'success',
                            duration: 6000,
                        });
                        await this.getConfigs()
                    })
                }
            } else {
                this.$notify({
                    title: 'Error',
                    message: 'Invalid input, all field required!',
                    type: 'error',
                    duration: 0,
                });
                await this.getConfigs()
            }
        },
        tableRowClassName({row, rowIndex}) {
            return row.has_error ? 'table-row-error-highlight' : '';
        }
    }
}
</script>

<style scoped>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding-left: 8px;
        padding-right: 8px;
    }
    tr:hover {
        background-color: rgb(245, 245, 245);
    }
</style>