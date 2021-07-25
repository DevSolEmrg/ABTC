<template>
    <el-drawer
        title="I have a nested table inside!"
        :visible.sync="visible"
        direction="rtl"
        :size="`${size}%`"
        :wrapperClosable="false"
        :close-on-press-escape="false"
        :destroy-on-close="true"
        :modal="true"
        :before-close="closeDrawer"
    >
        <el-table :data="gridData">
            <el-table-column property="date" label="Date" width="150"></el-table-column>
            <el-table-column property="name" label="Name" width="200"></el-table-column>
            <el-table-column property="address" label="Address"></el-table-column>
            <el-table-column label="Action" align="center">
                <el-button @click="innerDrawer = true">Click me!</el-button>
            </el-table-column>
        </el-table>
        <el-drawer
            title="I'm inner Drawer"
            :append-to-body="true"
            :visible.sync="innerDrawer"
            :size="`${size-1}%`"
        >
            <p>_(:зゝ∠)_</p>
        </el-drawer>
    </el-drawer>
</template>

<script>
import { drawerSize } from '../../constants'
export default {
    props: ['visible'],
    data() {
        return {
            size: 60,
            gridData: [
                {
                    date: '2016-05-02',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }, {
                    date: '2016-05-04',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }, {
                    date: '2016-05-01',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }, {
                    date: '2016-05-03',
                    name: 'Peter Parker',
                    address: 'Queens, New York City'
                }
            ],
            innerDrawer: false,
        }
    },
    methods: {
        closeDrawer() {
            this.$emit('close', false)
        },
        rezize() {
            this.size = drawerSize(window.innerWidth)
        }
    },
    created() {
        window.onresize = function() { this.rezize() }.bind(this)
    },
    mounted() {
        this.rezize()
    }
}
</script>

<style>

</style>