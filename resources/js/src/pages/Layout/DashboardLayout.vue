<template>
    <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
        <PreLoader v-if="preloader"></PreLoader>
        <div v-else>
            <DialogCard v-if="!isAuthenticated">
                <section slot="body">
                    Oops. Session expired. Please relogin.
                    <md-dialog-actions>
                        <md-button class="md-primary md-dense" @click="logOut"
                            >Confirm</md-button
                        >
                    </md-dialog-actions>
                </section>
            </DialogCard>
            <notifications></notifications>

            <template v-if="permissions">
                <!-- <side-bar
      :sidebar-item-color="sidebarBackground"
      :sidebar-background-image="sidebarBackgroundImage"
    > -->
                <side-bar>
                    <mobile-menu slot="content"></mobile-menu>
                    <sidebar-link class="sample" to="/dashboard">
                        <!-- <md-icon>dashboard</md-icon> -->
                        <p>Home</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="role != 'Employee' && hasPermission(['employee'])"
                        to="/employee"
                    >
                        <!-- <md-icon>people_outline</md-icon> -->
                        <p>Employees</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="
                            role != 'Employee' &&
                            hasPermission(['service record'])
                        "
                        to="/history"
                    >
                        <!-- <md-icon>people_outline</md-icon> -->
                        <p>History</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="
                            hasPermission([
                                'schedule',
                                'employee schedule',
                                'special date',
                                'dtr',
                            ])
                        "
                        to="/schedule"
                    >
                        <!-- <md-icon>people_outline</md-icon> -->
                        <p>Schedule</p>
                    </sidebar-link>
                    <!-- <sidebar-link 
        v-if="role === 'Employee' && hasPortalPermission('employee schedule')" 
        to="/portal-schedule">
          <p>Schedule</p>
        </sidebar-link> -->
                    <sidebar-link
                        v-if="hasPermission(['request'])"
                        to="/request"
                    >
                        <p>Request</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="role != 'Employee' && hasPermission(['position'])"
                        to="/positions"
                    >
                        <p>Positions</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="hasPermission(['training'])"
                        to="/training"
                    >
                        <!-- <md-icon>people_outline</md-icon> -->
                        <p>Training</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="role != 'Employee' && hasPermission(['user'])"
                        to="/users"
                    >
                        <!-- <md-icon>outlined_flag</md-icon> -->
                        <p>Users</p>
                    </sidebar-link>

                    <sidebar-link v-if="role != 'Employee'" to="/appraisal">
                        <!-- <md-icon>outlined_flag</md-icon> -->
                        <p>Appraisal</p>
                    </sidebar-link>

                    <sidebar-link
                        v-if="role != 'Employee' && hasPermission(['award'])"
                        to="/relations"
                    >
                        <!-- <md-icon>outlined_flag</md-icon> -->
                        <p>Relations</p>
                    </sidebar-link>

                    <sidebar-link
                        v-if="role != 'Employee' && hasReportsPermission()"
                        to="/reports"
                    >
                        <!-- <md-icon>outlined_flag</md-icon> -->
                        <p>Reports</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="
                            role != 'Employee' && hasPermission(['applicant'])
                        "
                        to="/applicant-matrix"
                    >
                        <!-- <md-icon>outlined_flag</md-icon> -->
                        <p>Applicant Matrix</p>
                    </sidebar-link>
                    <sidebar-link
                        v-if="
                            role == 'Administrator' || role == 'HR'
                        "
                        to="/settings"
                    >
                        <!-- <md-icon>settings_applications</md-icon> -->
                        <p>Settings</p>
                    </sidebar-link>
                    <!--  -->
                    <!-- <sidebar-link to="/user">
        <md-icon>person</md-icon>
        <p>User Profile</p>
      </sidebar-link>
      <sidebar-link to="/table">
        <md-icon>content_paste</md-icon>
        <p>Table list</p>
      </sidebar-link>
      <sidebar-link to="/typography">
        <md-icon>library_books</md-icon>
        <p>Typography</p>
      </sidebar-link>
      <sidebar-link to="/icons">
        <md-icon>bubble_chart</md-icon>
        <p>Icons</p>
      </sidebar-link>
      <sidebar-link to="/maps">
        <md-icon>location_on</md-icon>
        <p>Maps</p>
      </sidebar-link>
      <sidebar-link to="/notifications">
        <md-icon>notifications</md-icon>
        <p>Notifications</p>
      </sidebar-link> -->

                    <!-- Promotion -->
                    <!-- <sidebar-link to="/upgrade" class="active-pro">
      <md-icon>unarchive</md-icon>
        <p>Upgrade to PRO</p>
      </sidebar-link> -->
                </side-bar>

                <div class="main-panel">
                    <top-navbar></top-navbar>

                    <!-- <fixed-plugin
        :color.sync="sidebarBackground"
        :image.sync="sidebarBackgroundImage"
      > -->
                    <!-- <fixed-plugin></fixed-plugin> -->

                    <dashboard-content> </dashboard-content>

                    <content-footer
                        v-if="!$route.meta.hideFooter"
                    ></content-footer>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "../../pages/Layout/MobileMenu.vue";
import DialogCard from "../../components/Cards/DialogCard.vue";
import logOut from "../../mixins/logOut.js";
// import FixedPlugin from "./Extra/FixedPlugin.vue";
import axios from "axios";

const PreLoader = () =>
    import(
        /* webpackChunkName: "PreLoader" */ "../../components/Preloader.vue"
    );

export default {
    mixins: [logOut],
    components: {
        PreLoader,
        TopNavbar,
        DashboardContent,
        ContentFooter,
        MobileMenu,
        DialogCard,
        // FixedPlugin
    },
    data() {
        return {
            sidebarBackground: "green",
            baseURL: null,
            role: null,
            accountId: null,
            shouldChange: null,
            isAuthenticated: true,
            permissions: null,

            preloader: false,
        };
    },
    methods: {
        async getCurrentAccount() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/auth";
            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let newResp = await this.axiosRequest(options);
            console.log(newResp.data);
            this.role = newResp.data.role;
            this.accountId = newResp.data.employee_id;
            this.full_name = newResp.data.fullName;
            this.shouldChange = newResp.data.shouldChange;
            this.isUpdateEmployee = newResp.data.settings.isUpdateEmployee;
            this.permissions = newResp.data.permissions;
            localStorage.setItem("role", this.role);
            localStorage.setItem("isUpdateEmployee", this.isUpdateEmployee);
            localStorage.setItem("accountId", this.accountId);
            localStorage.setItem("full_name", this.full_name);
            localStorage.setItem("shouldChange", this.shouldChange);
            localStorage.setItem(
                "permissions",
                JSON.stringify(this.permissions)
            );

            this.$store.commit("changeUserInfo", newResp.data);

            //Check Permission
            if (
                newResp.data.permissions.indexOf("search employee schedule") !==
                -1
            ) {
                if (
                    newResp.data.permissions.indexOf(
                        "write employee schedule"
                    ) !== -1
                ) {
                    if (
                        newResp.data.permissions.indexOf(
                            "delete employee schedule"
                        ) !== -1
                    ) {
                        if (
                            newResp.data.permissions.indexOf(
                                "restore employee schedule"
                            ) !== -1
                        ) {
                        }
                    }
                }
            }
        },
        //Separate Request
        async axiosRequest(options) {
            let getResp;
            await axios
                .request(options)
                .then((response) => {
                    getResp = response;
                })
                .catch((error) => {
                    getResp = error.status;
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
            return getResp;
        },
        // Check if user has at least 1 permission to access
        hasPermission(modules) {
            let modulePermissions = [];
            modules.map((val) => {
                modulePermissions.push("search " + val);
                modulePermissions.push("write " + val);
                modulePermissions.push("delete " + val);
                modulePermissions.push("restore " + val);
                modulePermissions.push("print " + val);
                modulePermissions.push("portal " + val);
            });

            let permissions = this.permissions;
            if (modulePermissions.some((val) => permissions.includes(val))) {
                return true;
            } else {
                return false;
            }
        },
        hasPortalPermission(module) {
            if (this.permissions.includes("portal " + module)) {
                return true;
            } else {
                return false;
            }
        },
        hasReportsPermission() {
            if (this.permissions.some((val) => val.startsWith("print"))) {
                return true;
            } else {
                return false;
            }
        },
    },
    async beforeMount() {
        // console.log("Refresh Counter: "+localStorage.getItem("refreshCounter"));
        if (localStorage.getItem("refreshCounter") === "0") {
            this.preloader = true;
            setTimeout(() => {
                localStorage.setItem("refreshCounter", "1");
                // this.$router.go();
                this.$router.go({ name: "Dashboard" });
            }, 100);
        } else {
            this.preloader = false;
        }
        const getToken = localStorage.getItem("token");
        if (getToken === null) {
            this.$router.push({ name: "login" });
        }
        await this.getCurrentAccount();
    },
};
</script>
<style scoped>
p {
    color: black;
}
.sidebar {
    background-color: #042278 !important;
}
</style>
