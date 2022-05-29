<template>
    <el-dropdown trigger="click">
        <span class="el-dropdown-link">
            <i class="mdi mdi-list-status" style="margin-left: 5px; margin-top:0px;font-size:16px;"> <span v-if="side_nav" style="position:relative; top:-12px; right:3px; background-color:#E40D0D; color:white; border-radius:50%; font-size:10px;padding:3px; font-weight:normal; font-style:normal">12</span> </i>
        </span>
        <el-dropdown-menu slot="dropdown" style="width:650px">
            <div class="px-3 mdi mdi-chevron-double-right" style="color:#409EFF"> &nbsp;On Queue</div>
            <el-dropdown-item divided>Notification 1</el-dropdown-item>
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
            <el-dropdown-item divided> <i class="mdi mdi-history"></i> Show All</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
export default {
    data() {
        return {
            side_nav: true
        }
    },
    mounted() {
        console.log('mounted on queue component')
    }
}
</script>

<style>

</style>