<template>
    <el-row :gutter="24">
        <el-col :span="24">
            <el-collapse v-model="activeCategory" @change="handleChange" style="border-left:1px solid green; background-color:white; padding-left:10px;" accordion>
                <el-collapse-item v-for="item in Object.entries(this.enum)" :key="item[0]" :title="readableName(item)" :name="item[0]" class="app-instance-collapse">
                    <!-- <div style="border-right:1px solid green"> -->
                    <div>
                        <el-table
                            :data="item[1]"
                            border
                            style="width: 100%"
                            size="mini"
                            :header-cell-style="{ background: 'rgba(0,0,0,0)' }"
                        >
                            <el-table-column
                                prop="code"
                                label="Code"
                                width="150"
                            ></el-table-column>
                            <el-table-column
                                prop="desc"
                                label="Description"
                                min-width="180"
                            ></el-table-column>

                            <el-table-column align="center" width="79" fixed="right">
                                <template slot="header" slot-scope="scope">
                                    <el-tooltip class="item" effect="light" content="Add Option" placement="top" :enterable="false">
                                        <el-button type="primary" size="mini">Add</el-button>
                                    </el-tooltip>
                                </template>
                                <template slot-scope="scope">
                                    <el-button-group>
                                        <el-tooltip class="item" effect="light" content="Edit" placement="top" :enterable="false">
                                            <el-button type="primary" size="mini" icon="mdi mdi-lead-pencil" circle plain @click="handleEdit(scope.$index, scope.row)"></el-button>
                                        </el-tooltip>
                                        <el-tooltip class="item" effect="light" content="Delete" placement="top" :enterable="false">
                                            <el-button type="danger" size="mini" icon="mdi mdi-delete" circle plain @click="handleDelete(scope.$index, scope.row)"></el-button>
                                        </el-tooltip>
                                    </el-button-group>
                                </template>
                            </el-table-column>

                        </el-table>
                    </div>
                </el-collapse-item>
            </el-collapse>
            <!-- <el-button style="width:100%" type="text" plain>Add</el-button> -->
        </el-col>
    </el-row>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    data() {
        return {
            activeCategory: ""
        }
    },
    computed: {
        ...mapGetters(['loading_component', 'enum'])
    },
    beforeCreate() {
        this.$store.commit('SET_LOADING_COMPONENT', false)
    },
    mounted() {
        // let category = Object.entries(this.enum)
        // console.log(this.enum, category)
    },
    methods: {
        handleChange(val) {
            // console.log(val);
        },
        handleEdit(index, row) {
            // console.log(index, row);
        },
        handleDelete(index, row) {
            // console.log(index, row);
        },
        readableName(item) {
            function capitalize(wrd) {
                return wrd.toLowerCase()
                    .split(' ')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            }
            let categ = item[1][0]?.category
            let name = categ?.name || item[0]
            return capitalize(name?.replaceAll('_', ' ') || '') || 'N/A'
        }
    }
}
</script>

<style>

</style>