<template>
    <div>
        Treatment
    </div>
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