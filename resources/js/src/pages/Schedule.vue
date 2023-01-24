<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-25">
                <!-- <label
                    v-if="userAction === 'emp_selected'"
                > -->
                <label>
                    <h5>
                        Schedule For:
                        <label style="text-transform: uppercase !important">{{
                            fullName
                        }}</label>
                    </h5>
                </label>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-75 text-right">
                <!-- <md-button class="md-primary md-dense md-raised" @click="searchEmp" v-if="currentPage === 'schedule'">Attach Files</md-button> -->
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="searchEmp"
                    v-if="
                        currentPage === 'schedule' &&
                        ($permissions.includes('search dtr') ||
                            $permissions.includes('search employee schedule'))
                    "
                    >Employees</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="changePage('templates')"
                    :disabled="currentPage === 'templates'"
                    v-if="
                        $permissions.includes('search schedule') ||
                        $permissions.includes('search employee schedule') ||
                        $permissions.includes('print dtr') ||
                        $permissions.includes('write employee schedule')
                    "
                    >Manage Templates</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="changePage('specialDates')"
                    :disabled="currentPage === 'specialDates'"
                    v-if="$permissions.includes('search special date')"
                    >Special Dates</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="changePage('schedule')"
                    v-if="
                        currentPage === 'specialDates' ||
                        currentPage === 'templates'
                    "
                    >Schedule</md-button
                >
            </div>
        </div>
        <!-- <md-dialog-alert :md-active.sync="fireNotification" :md-content="notificationMessage" md-confirm-text="Okay" /> -->
        <!-- <md-snackbar :md-position="'center'" :md-duration="2000" :md-active.sync="fireSnackbar" md-persistent>
            <span>{{messageSnackbar}}</span>
            <md-button class="md-warning md-dense" @click="fireSnackbar = false">
                <label style="color: black;">Dismiss</label>
            </md-button>
        </md-snackbar> -->
        <SpecialDates v-if="currentPage === 'specialDates'"></SpecialDates>
        <ScheduleTemplate v-if="currentPage === 'templates'"></ScheduleTemplate>

        <ScheduleEmployee
            v-if="role != 'Employee' && currentPage === 'schedule'"
        ></ScheduleEmployee>
        <PortalScheduleEmployee
            v-if="role === 'Employee' && currentPage === 'schedule'"
        ></PortalScheduleEmployee>

        <div
            class="md-layout-item md-small-size-100 md-size-100"
            v-if="currentPage === 'schedule'"
        ></div>
        <DialogCard v-if="empSearch">
            <section slot="header">Search Employee</section>
            <section slot="body">
                <ListEmployee
                    :module="
                        $permissions.includes('search dtr')
                            ? 'dtr'
                            : $permissions.includes('search employee schedule')
                            ? 'employee/schedule'
                            : null
                    "
                    v-on:close-dialog="getNewlySelectedEmployee"
                ></ListEmployee>
                <form>
                    <md-dialog-actions>
                        <md-button class="md-dense md-danger" @click="searchEmp"
                            >Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </div>
</template>

<script>
import axios from "axios";
import UserAction from "../mixins/userAction.js";

// import UserAction from '../mixins/userAction.js';
const SpecialDates = () =>
    import(
        /* webpackChunkName: "SpecialDates" */ "../pages/Schedule/SpecialDates.vue"
    );
const ScheduleTemplate = () =>
    import(
        /* webpackChunkName: "ScheduleTemplate" */ "../pages/Schedule/ScheduleTemplate.vue"
    );
const ScheduleEmployee = () =>
    import(
        /* webpackChunkName: "ScheduleEmployee" */ "../pages/Schedule/ScheduleEmployee.vue"
    );
const ListEmployee = () =>
    import(
        /* webpackChunkName: "ListEmployee" */ "../pages/Employee/ListEmployee.vue"
    );
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );

//Portal Schedule
const PortalScheduleEmployee = () =>
    import(
        /* webpackChunkName: "PortalScheduleEmployee" */ "../pages/PortalSchedule/PortalScheduleEmployee.vue"
    );

// import DialogCard from "../components/Cards/DialogCard.vue";

export default {
    name: "Schedule",
    mixins: [UserAction],
    components: {
        SpecialDates,
        ListEmployee,
        ScheduleTemplate,
        ScheduleEmployee,
        DialogCard,
        PortalScheduleEmployee,
    },
    data() {
        return {
            fullName: localStorage.getItem("full_name"),
            currentPage: "schedule",
            empSearch: false,
            role: null,
        };
    },

    methods: {
        changePage(pageName) {
            this.currentPage = pageName;
        },
        searchEmp() {
            this.empSearch = !this.empSearch;
        },
        getNewlySelectedEmployee() {
            localStorage.setItem("search_user_schedule", "1");
            this.$router.go();
        },
    },

    created() {
        this.role = localStorage.getItem("role");
        if (localStorage.getItem("search_user_schedule") === "1") {
            this.fullName = localStorage.getItem("selection_name_shedule");
        }
    },
};
</script>

<style scoped>
.emp-search {
    float: right;
}
.md-card-header {
    background-color: #042278 !important;
}
</style>
<style lang="scss" scoped>
.md-checkbox {
    display: flex;
}
</style>
