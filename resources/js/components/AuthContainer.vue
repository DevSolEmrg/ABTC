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
        <el-aside v-if="side_nav" style="background-color: #272E3F; overflow-x:hidden">
            <div class="row" style="background-color:#272E3F; text-align:center">
                <div class="col-12">
                    <el-avatar class="mt-4 mb-3" :size="200" :src="baseUrl + 'image/user.png'" @error="errorHandler" style="background-color:#0F6540">
                        <img :src="baseUrl + 'image/user.png'"/>
                    </el-avatar>
                </div>
                <div class="col-12" style="background-color:#0F6540">
                    <div class="row">
                        <div class="col-12" style="color:#BDBEC1; text-shadow: 0 1px 0 grey;"><strong>ABTC SORSOGON</strong></div>
                        <div class="col-12" style="color:#9C9EA3; background-color:#0C5133; text-shadow: 0 1px 0 #BDBEC1; border-bottom:1px solid rgba(0,0,0,.08)">{{ userName() }}</div>
                        <div class="col-12" style="color:#9C9EA3; background-color:#0C5133; overflow-x:auto; white-space:nowrap;">&nbsp;&nbsp;{{ userRole() }}&nbsp;&nbsp;</div>
                    </div>
                </div>
            </div>
            <el-menu
                style="border:none"
                :default-active="$route.name"
                class="el-menu-vertical-demo"
                @open="handleOpen"
                @close="handleClose"
                background-color="#272E3F"
                text-color="#fff"
                active-text-color="#0B822B"
                router
                :default-openeds="navExpandOpen"
            >
                <el-menu-item index="Dashboard" :route="{ name: 'Dashboard' }" @click="handlePageLoading('Dashboard')">
                    <i class="el-icon-s-home"></i>
                    <span>Dashboard</span>
                </el-menu-item>
                <!-- <el-menu-item index="Patient List" :route="{ name: 'Patient List' }" @click="handlePageLoading('Patient List')">
                    <i class="el-icon-user-solid"></i>
                    <span>Patient</span>
                </el-menu-item> -->
                <el-menu-item index="Patient List" :route="{ name: 'Patient List' }" @click="handlePageLoading('Patient List')">
                    <i class="el-icon-s-order"></i>
                    <span>Patient</span>
                </el-menu-item>
                <!-- <el-menu-item index="Personnel List" :route="{ name: 'Personnel List' }" @click="handlePageLoading('Personnel List')">
                    <i class="el-icon-s-custom"></i>
                    <span>Personnel</span>
                </el-menu-item>
                <el-menu-item index="Vaccine List" :route="{ name: 'Vaccine List' }" @click="handlePageLoading('Vaccine List')">
                    <i class="el-icon-s-order"></i>
                    <span>Vaccines</span>
                </el-menu-item> -->

                <el-menu-item index="9">
                    <i class="el-icon-s-data"></i>
                    <span>Reports <span class="mdi mdi-alert-outline" style="color:#FEFF80" /> </span>
                </el-menu-item>

                <el-submenu index="user_setting">
                    <template slot="title">
                        <i class="el-icon-s-custom"></i>
                        <span>User Setting</span>
                    </template>
                    <el-menu-item index="1-1" style="padding-left:53px">My Profile <span class="mdi mdi-alert-outline" style="color:#FEFF80" /></el-menu-item>
                    <el-menu-item index="User List" :route="{ name: 'User List' }" @click="handlePageLoading('User List', 'user_setting')" style="padding-left:53px">User Management</el-menu-item>
                    <el-menu-item index="Role & Permission List" :route="{ name: 'Role & Permission List' }" @click="handlePageLoading('Role & Permission List', 'user_setting')" style="padding-left:53px">Role & Permission</el-menu-item>
                </el-submenu>

                <el-submenu index="general_setting">
                    <template slot="title">
                        <i class="el-icon-s-tools"></i>
                        <span>General Setting</span>
                    </template>
                    <el-menu-item index="Personnel List" :route="{ name: 'Personnel List' }" @click="handlePageLoading('Personnel List')" style="padding-left:53px"> Personnel </el-menu-item>
                    <el-menu-item index="Vaccine List" :route="{ name: 'Vaccine List' }" @click="handlePageLoading('Vaccine List')" style="padding-left:53px"> Vaccine </el-menu-item>
                    <el-menu-item index="App Instance" :route="{ name: 'App Instance' }" @click="handlePageLoading('App Instance')" style="padding-left:53px"> App Instance </el-menu-item>
                </el-submenu>


            </el-menu>
        </el-aside>

        <el-container>
            <el-header style="background-color:white;border-bottom: 1px solid #eee; ">
                <div class="row">
                    <!-- <div class="col-6 px-1"> <span class="mdi mdi-menu btn" @click="toggleSideNav()"/> Title / sgsd / sdg</div> -->
                    <div class="col-6 px-1"> <span class="mdi mdi-menu btn" @click="toggleSideNav()"/> {{ $route.name }} </div>
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
<!-- <el-badge :value="200" :max="99" style="
  margin-right: 10px; background-color:green; height:1px; padding:0px;">


                        <i class="mdi mdi-bell" style="margin-right: 10px; margin-top:0px;font-size:18px; background-color:red"></i>
</el-badge> -->

                        <el-dropdown trigger="click" @command="logout">
                            <span class="el-dropdown-link">
                                {{ buildUsernameFromEmail() }}<i class="el-icon-arrow-down el-icon--right"></i>
                            </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item command="a"><span class="mdi mdi-account" /> Profile</el-dropdown-item>
                                <el-dropdown-item command="logout"><span class="mdi mdi-power" /> Logout</el-dropdown-item>

                                <!--<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ 'Logout' }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>-->

                            </el-dropdown-menu>
                        </el-dropdown>


<!-- <i class="el-icon-bell" style="margin-left: 5px; margin-top:0px;font-size:16px;"> <span v-if="side_nav" style="position:relative; top:-12px; right:3px; background-color:#E40D0D; color:white; border-radius:50%; font-size:10px;padding:3px; font-weight:normal; font-style:normal">12</span> </i> -->

                        <el-dropdown trigger="click">
                            <span class="el-dropdown-link">
                                <i class="el-icon-bell" style="margin-left: 5px; margin-top:0px;font-size:16px;"> <span v-if="side_nav" style="position:relative; top:-12px; right:3px; background-color:#E40D0D; color:white; border-radius:50%; font-size:10px;padding:3px; font-weight:normal; font-style:normal">12</span> </i>
                            </span>
                            <el-dropdown-menu slot="dropdown" style="width:300px">
                                <div class="px-3 mdi mdi-format-list-text" style="color:#409EFF"> &nbsp;Notification List</div>
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


                        <!-- <el-popover placement="bottom" width="400" trigger="click">
                            <div class="px-3 mdi mdi-format-list-text" style="color:#409EFF"> &nbsp;Notification List</div>
                            <div v-for="o in 12" :key="o" class="text item"> {{'List item ' + o }} </div>
                            <el-button slot="reference"><i class="el-icon-bell"></i> </el-button>
                        </el-popover> -->

                    </div>
                </div>

                <div class="loader" v-if="loading_component">
                    <div class="loaderBar" />
                </div>

            </el-header>

            <el-main>
                <!-- <router-link to="/home">Home | </router-link>
                <router-link to="/user/gg">Page Not Exist | </router-link>
                <router-link to="/home/sample">Sample | </router-link>
                <router-link to="/home/patient">Patient List</router-link> -->
            <!--<el-table :data="tableData">
                <el-table-column prop="date" label="Date" width="140">
                </el-table-column>
                <el-table-column prop="name" label="Name" width="120">
                </el-table-column>
                <el-table-column prop="address" label="Address">
                </el-table-column>
            </el-table>-->
                <router-view />
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        const item = {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
        };
        return {
            //sideBarColor: '083421',
            side_nav: true,
            tableData: Array(23).fill(item),
            baseUrl: location.origin.concat('/'),
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            navExpandOpen: [],
            auth_info: {}
        }
    },
    computed: {
        ...mapGetters(['auth', 'loading_component', 'recent_route'])
    },
    watch: {
        loading_component(status) {
            this.$nextTick(function () {
                if (!status) this.$store.commit('SET_LOADING_COMPONENT', false);
            })
        },
        $route(to, from) {
          this.$store.commit('SET_RECENT_ROUTE', to.name)
        }
    },
    methods: {
        checkIfHasExpandedNav(clicked_route = null, expandIndex = null) {
            this.navExpandOpen = []
            var expandOption = {
                'user_setting' : ['User List', 'Role & Permission List'],
                'general_setting' : ['Personnel List', 'Vaccine List', 'App Instance']
            }
            this.$nextTick(()=>{
                Object.entries(expandOption).forEach(index=>{
                    if (index[1].includes(clicked_route?clicked_route:this.$route.name) && !this.navExpandOpen.includes(expandIndex)) {
                        this.navExpandOpen.push(index[0])
                    }
                })
            })
        },
        handlePageLoading(clicked_route, expandIndex = null) {
            this.checkIfHasExpandedNav(clicked_route, expandIndex)
            if (clicked_route != JSON.parse(JSON.stringify(this.recent_route)) && !this.loading_component) {
                this.$store.commit('SET_LOADING_COMPONENT', true)
            }
            if (window.innerWidth < 768) {
                this.side_nav = false
            }
        },
        toggleSideNav() {
            this.side_nav = !this.side_nav
        },handleOpen(key, keyPath) {
        },
        handleClose(key, keyPath) {
        },
        logout(command) {
            if (command == 'logout') {
                axios.post('logout').then(response => {
                    if (response.status === 302 || 401) {
                        this.$store.commit("UNSET_AUTH")
                        //location.reload()

                        axios.get('check_auth').then((response) => {
                        }).catch(async(error) => {
                            history.pushState(null, document.title, location.href);
                            location.replace(location.origin.concat('/login'))
                        });
                    }
                    else {
                        // throw error and go to catch block
                    }
                }).catch(error => {
                        history.pushState(null, document.title, location.href);
                        location.replace(location.origin.concat('/login'))
                });
            } else {
            }

        },
        errorHandler() {
            return true
        },
        buildUsernameFromEmail() {
            return this.auth?.email?.split('@')[0] || this.auth_info.usernameFromEmail
        },
        userName() {
            return this.auth?.name || this.auth_info.username
        },
        userRole() {
            return this.auth?.roles?.map(i=>i.name).join(', ') || this.auth_info.userRole
        }
    },
    created() {
        this.checkIfHasExpandedNav()
        this.$store.commit('SET_RECENT_ROUTE', this.$route.name)
        if (this.$attrs.auth) {
            this.$store.commit('SET_AUTH', this.$attrs.auth)
            this.$store.commit('SET_ENUM', this.$attrs.enums)
            this.auth_info.usernameFromEmail = this.auth?.email?.split('@')[0] || 'none'
            this.auth_info.username = this.auth?.name || 'none'
            this.auth_info.userRole = this.auth?.roles?.map(i=>i.name).join(', ') || 'none'
        }
    },
    mounted() {
        // this.$store.commit('SET_RECENT_ROUTE', this.$route.name)
        // if (this.$attrs.auth) {
        //     this.$store.commit('SET_AUTH', this.$attrs.auth)
        //     this.$store.commit('SET_ENUM', this.$attrs.enums)
        //     this.auth_info.usernameFromEmail = this.auth?.email?.split('@')[0] || 'none'
        //     this.auth_info.username = this.auth?.name || 'none'
        //     this.auth_info.userRole = this.auth?.roles?.map(i=>i.name).join(', ') || 'none'
        // }
        this.side_nav = window.innerWidth > 767 ? true : false;

        window.onresize = function() {
            this.side_nav = window.innerWidth > 767 ? true : false;
        }.bind(this)
    },
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