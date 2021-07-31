<template>
    <div class="notfound-center">
        <div class="row">
            <div class="col-12" style="text-align:center">
                <el-avatar class="mb-2" :size="300" :src="baseUrl + 'image/user.png'" @error="errorHandler" style="background-color:#FFC230">
                        <img :src="baseUrl + 'image/user.png'"/>
                    </el-avatar>
            </div>
            <div class="col-12" style="text-align:center">
                <h1><strong style="color:#FD0001">404</strong></h1>
            </div>
            <div class="col-12 mb-2" style="text-align:center">
                <h5 style="color:grey">Page Not Found {{ currentURL }}</h5>
            </div>
            <div class="col-12" style="text-align:center">
                <el-button type="danger" icon="el-icon-back" @click="back">BACK</el-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentURL: `"URL(${location.href})"`,
            baseUrl: location.origin.concat('/')
        }
    },
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
        background-color: #1A1A1D;
    }
</style>