<template>
    <el-dropdown trigger="click">
        <span class="el-dropdown-link">
            <i class="mdi mdi-list-status" style="margin-left: 5px; margin-top:0px;font-size:16px;" @click="toggle=!toggle;getData()"> <span v-if="side_nav" style="position:relative; top:-12px; right:3px; background-color:#E40D0D; color:white; border-radius:50%; font-size:10px;padding:3px; font-weight:normal; font-style:normal">12</span> </i>
        </span>
        <el-dropdown-menu slot="dropdown" style="width:750px">

            <el-row>
                <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12">
                    <div class="px-3 mdi mdi-chevron-double-right" style="color:#409EFF"> &nbsp;On Queue</div>
                </el-col>
                <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12" style="text-align:right !important">
                    <div class="pr-4" style="color:#409EFF; cursor:pointer; width:60px; float:right" @click="toggle=true;getData()">Reload</div>
                    <!-- <el-button icon="el-icon-refresh" size="small" circle></el-button> -->
                    <!-- <el-button type="text" size="mini" class="mdi mdi-reload"></el-button> -->
                </el-col>
            </el-row>
            <!-- loading{{ loading }} -->

            <!-- <el-dropdown-item divided>Notification 1</el-dropdown-item>
            <el-dropdown-item>Notification 2</el-dropdown-item>
            <el-dropdown-item>Notification 3</el-dropdown-item>
            <el-dropdown-item>Notification 4</el-dropdown-item>
            <el-dropdown-item>Notification 5</el-dropdown-item>
            <el-dropdown-item>Notification 6</el-dropdown-item>
            <el-dropdown-item>Notification 7</el-dropdown-item>
            <el-dropdown-item>Notification 8</el-dropdown-item>
            <el-dropdown-item>Notification 9</el-dropdown-item>
            <el-dropdown-item>Notification 10</el-dropdown-item>
            <el-dropdown-item>Notification 11</el-dropdown-item>
            <el-dropdown-item>Notification 12</el-dropdown-item>
            <el-dropdown-item divided> <i class="mdi mdi-history"></i> Show All</el-dropdown-item> -->

            <el-dropdown-item divided></el-dropdown-item>

            <el-table v-loading="loading" :data="jobs" style="width: 100%" border>
                <el-table-column prop="batch_id" label="Batch Id" width="280"></el-table-column>
                <el-table-column prop="batch.total_jobs" label="Total"></el-table-column>
                <el-table-column prop="batch.pending_jobs" label="Pending"></el-table-column>
                <el-table-column prop="batch.failed_jobs" label="Failed"></el-table-column>
                <el-table-column type="expand" label="Jobs" width="60">
                        <template slot-scope="props">
                            ssdgsd
                        </template>
                </el-table-column>
            </el-table>


            <el-dropdown-item divided> <i class="mdi mdi-history"></i> Show All</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
            side_nav: true,
            toggle: false,
            loading: false,
            jobs: []
        }
    },
    computed: {
        ...mapGetters(['auth']),
    },
    methods: {
        async getData() {
            this.loading = true
            // console.log(this.toggle)
            if (this.toggle) {
                await axios.get(`processed_jobs?user_id=${this.auth?.id}`).then((result) => {
                    console.log('mounted on queue component: SUCCESS', result.data)
                    this.jobs = result.data
                    // this.$nextTick(()=>{
                    //     if (this.jobs.length > 0) {
                    //         // this.$destroy()
                    //     }
                    // })
                }).catch((err) => {
                    console.log('mounted on queue component: FAILED', err)
                }).finally(()=>{
                    setTimeout(() => {
                        this.loading = false
                    }, 500);

                });
            }
        }
    },
    mounted() {
        // this.$destroy()
    },
    beforeDestroy() {
        this.toggle = false
    }
}
</script>

<style>

</style>