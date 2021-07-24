<template>
    <el-drawer
        title="I'm inner Drawer"
        :visible.sync="visible"
        size="59%"
        :wrapperClosable="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :before-close="closeTreatment"
    >
        <p>_(:зゝ∠)_</p>
    </el-drawer>
</template>

<script>
export default {
    props: ['visible'],
    data() {
        return {

        }
    },
    methods: {
        closeTreatment() {
            this.$emit('close', false)
        }
    }
}
</script>

<style>

</style>