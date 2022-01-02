<template>
    <el-pagination
        background
        layout="sizes, prev, pager, next, jumper"
        @current-change="getVal"
        :page-size="itemPerPage"
        :total="recordTotal"
        :current-page="currentPage"
        hide-on-single-page
    />
</template>

<script>
/**
 * store: module e.g. 'patients'
 * collection: state e.g. 'patients'
 * stateAction: action to be call to dispatch request on db e.g. 'getPatients'
 * mutation: commit clicked page number request on db e.g. 'SET_CURRENT_PAGE'
 */
export default {
    props: ['store', 'collection', 'stateAction', 'mutation'],
    computed: {
        currentPage: {
            get() {
                return this.$store.state[this.store][this.collection].current_page
            },
            set(value) {
                this.$store.commit(this.mutation, value)
            }
        },
        recordTotal: {
            get() {
                return this.$store.state[this.store][this.collection].total
            }
        },
        itemPerPage() {
            return this.$store.state[this.store][this.collection].per_page
        }
    },
    methods: {
        paginatePage(pageNumber) {
            this.$store.dispatch(this.stateAction, { page_number: pageNumber })
        },
        getVal($event) {
            this.$emit('input')
            this.paginatePage($event)
        }
    },
}
</script>

<style>

</style>