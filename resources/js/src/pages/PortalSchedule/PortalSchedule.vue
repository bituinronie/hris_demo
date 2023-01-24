<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-25">
                <!-- <label
                    v-if="userAction === 'emp_selected'"
                > -->
                <label>
                    <h5>Schedule For: {{ fullName }}</h5>
                </label>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-75 text-right">
                <!-- <md-button class="md-primary md-dense md-raised" @click="searchEmp" v-if="currentPage === 'schedule'">Attach Files</md-button> -->
                <!-- <md-button
                    class="md-primary md-dense md-raised"
                    @click="searchEmp"
                    v-if="currentPage === 'schedule'"
                    >Employees</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="changePage('templates')"
                    :disabled="currentPage === 'templates'"
                    >Manage Templates</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="changePage('specialDates')"
                    :disabled="currentPage === 'specialDates'"
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
                > -->
            </div>
        </div>

        <!-- <SpecialDates v-if="currentPage === 'specialDates'"></SpecialDates>
        <ScheduleTemplate v-if="currentPage === 'templates'"></ScheduleTemplate> -->
        <ScheduleEmployee v-if="currentPage === 'schedule'"></ScheduleEmployee>
        <div
            class="md-layout-item md-small-size-100 md-size-100"
            v-if="currentPage === 'schedule'"
        ></div>
    </div>
</template>

<script>
import axios from "axios";
import UserAction from "../../mixins/userAction.js";

const ScheduleEmployee = () =>
    import(
        /* webpackChunkName: "ScheduleEmployee" */ "../PortalSchedule/PortalScheduleEmployee.vue"
    );

// import DialogCard from "../../components/Cards/DialogCard.vue";

export default {
    name: "PortalSchedule",
    mixins: [UserAction],
    components: {
        ScheduleEmployee,
        // DialogCard,
    },
    data() {
        return {
            fullName: localStorage.getItem("full_name"),
            currentPage: "schedule",
            empSearch: false,
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
            this.$router.go();
        },
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
