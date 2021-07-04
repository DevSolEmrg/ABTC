<template>
    <div class="notfound-center">
        <div class="row">
            <div class="col-12" style="text-align:center">
                <h1><strong style="color:red">404</strong></h1>
            </div>
            <div class="col-12 mb-2" style="text-align:center">
                <h4>Page Not Found</h4>
            </div>
            <div class="col-12" style="text-align:center">
                <el-button type="danger" icon="el-icon-back" @click="back">BACK</el-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        back() {
            history.back();
        }
    },
    mounted() {
        //alert(location.href)
    }
}
</script>

<style lang="scss" scoped>
    .notfound-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height:100vh;
    }
</style>