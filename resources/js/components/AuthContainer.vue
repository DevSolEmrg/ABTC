<template>
    <el-container style="height: 100vh;">
        <!--<el-aside v-if="side_nav" style="background-color: #fff;border-right: 1px solid #eee;">
            <el-menu :default-openeds="['1', '3']" style="border:none">
            <el-submenu index="1">
                <template slot="title"><i class="el-icon-message"></i>Navigator One</template>
                <el-menu-item-group>
                <template slot="title">Group 1</template>
                <el-menu-item index="1-1">Option 1</el-menu-item>
                <el-menu-item index="1-2">Option 2</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="Group 2">
                <el-menu-item index="1-3">Option 3</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="1-4">
                <template slot="title">Option4</template>
                <el-menu-item index="1-4-1">Option 4-1</el-menu-item>
                </el-submenu>
            </el-submenu>
            <el-submenu index="2">
                <template slot="title"><i class="el-icon-menu"></i>Navigator Two</template>
                <el-menu-item-group>
                <template slot="title">Group 1</template>
                <el-menu-item index="2-1">Option 1</el-menu-item>
                <el-menu-item index="2-2">Option 2</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="Group 2">
                <el-menu-item index="2-3">Option 3</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="2-4">
                <template slot="title">Option 4</template>
                <el-menu-item index="2-4-1">Option 4-1</el-menu-item>
                </el-submenu>
            </el-submenu>
            <el-submenu index="3">
                <template slot="title"><i class="el-icon-setting"></i>Navigator Three</template>
                <el-menu-item-group>
                <template slot="title">Group 1</template>
                <el-menu-item index="3-1">Option 1</el-menu-item>
                <el-menu-item index="3-2">Option 2</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="Group 2">
                <el-menu-item index="3-3">Option 3</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="3-4">
                <template slot="title">Option 4</template>
                <el-menu-item index="3-4-1">Option 4-1</el-menu-item>
                </el-submenu>
            </el-submenu>
            </el-menu>
        </el-aside>-->
        <el-aside v-if="side_nav" style="background-color: #545C64;border-right: 1px solid #eee;">
            <el-menu
                style="border:none"
                default-active="2"
                class="el-menu-vertical-demo"
                @open="handleOpen"
                @close="handleClose"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#ffd04b"
            >
                <el-submenu index="1">
                    <template slot="title">
                    <i class="el-icon-location"></i>
                    <span>Navigator One</span>
                    </template>
                    <el-menu-item-group title="Group One">
                    <el-menu-item index="1-1">item one</el-menu-item>
                    <el-menu-item index="1-2">item one</el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item-group title="Group Two">
                    <el-menu-item index="1-3">item three</el-menu-item>
                    </el-menu-item-group>
                    <el-submenu index="1-4">
                    <template slot="title">item four</template>
                    <el-menu-item index="1-4-1">item one</el-menu-item>
                    </el-submenu>
                </el-submenu>
                <el-menu-item index="2">
                    <i class="el-icon-menu"></i>
                    <span>Navigator Two</span>
                </el-menu-item>
                <el-menu-item index="3" disabled>
                    <i class="el-icon-document"></i>
                    <span>Navigator Three</span>
                </el-menu-item>
                <el-menu-item index="4">
                    <i class="el-icon-setting"></i>
                    <span>Navigator Four</span>
                </el-menu-item>
            </el-menu>
        </el-aside>
        
        <el-container>
            <el-header style="background-color:white;border-bottom: 1px solid #eee; ">
                <div class="row">
                    <div class="col-6 px-1"> <span class="mdi mdi-menu btn" @click="toggleSideNav()"/> Title / sgsd / sdg</div>
                    <div class="col-6 pl-1" style="text-align: right; font-size: 12px">
                        <!--<el-dropdown>
                            <i class="el-icon-setting" style="margin-right: 15px"></i>
                            <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item>View</el-dropdown-item>
                            <el-dropdown-item>Add</el-dropdown-item>
                            <el-dropdown-item>Delete</el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                        <span>Tom</span>-->
                        <el-dropdown trigger="click">
                            <span class="el-dropdown-link">
                                Username<i class="el-icon-arrow-down el-icon--right"></i>
                            </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item command="a"><span class="mdi mdi-account" /> Profile</el-dropdown-item>
                                <el-dropdown-item command="a"><span class="mdi mdi-power" /> Logout</el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </div>
                </div>
            
            </el-header>
            
            <el-main>
            <el-table :data="tableData">
                <el-table-column prop="date" label="Date" width="140">
                </el-table-column>
                <el-table-column prop="name" label="Name" width="120">
                </el-table-column>
                <el-table-column prop="address" label="Address">
                </el-table-column>
            </el-table>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
export default {
    data() {
        const item = {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
        };
        return {
            side_nav: true,
            tableData: Array(23).fill(item)
        }
    },
    methods: {
        samplefunct() {
            alert("clicke")
        },
        toggleSideNav() {
            this.side_nav = !this.side_nav
            console.log(this.side_nav)
        },handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      }
    }
}
</script>

<style lang="scss" scoped>
    .el-header {
        background-color: #B3C0D1;
        color: #333;
        line-height: 60px;
    }
    
    .el-aside {
        color: #333;
    }
    .el-menu .el-menu--inline {
        background-color: #333;
    }
</style>