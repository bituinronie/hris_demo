<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-50">
                <md-field>
                    <label>Select Action</label>
                    <md-select v-model="currentTab" @md-selected="onChange">
                        <md-option
                            value="alphaList"
                            v-if="$permissions.includes('print employee')"
                            >Alpha List</md-option
                        >

                        <md-option
                            value="positionDescriptionForm"
                            v-if="$permissions.includes('print position')"
                            >Position Description Form</md-option
                        >
                        <md-option
                            value="manpowerUpdates"
                            v-if="$permissions.includes('print service record')"
                            >Manpower Updates</md-option
                        >
                        <md-option
                            value="manpowerComplement"
                            v-if="$permissions.includes('print service record')"
                            >Manpower Complement</md-option
                        >
                        <md-option
                            value="statisticalSummary"
                            v-if="$permissions.includes('print service record')"
                            >Statistical Summary</md-option
                        >
                        <md-option
                            value="timeKeepingReport"
                            v-if="$permissions.includes('print dtr')"
                            >Time Keeping Report</md-option
                        >
                        <md-option value="requestReport"
                            >Request Reports</md-option
                        >
                        <md-option value="laborReport"
                            >Labort Reports</md-option
                        >
                    </md-select>
                </md-field>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-100">
                <ManPowerUpdates
                    v-if="currentTab === 'manpowerUpdates'"
                ></ManPowerUpdates>
                <EmployeesAlphaList
                    v-if="currentTab === 'alphaList'"
                ></EmployeesAlphaList>
                <PositionDescriptionForm
                    v-if="currentTab === 'positionDescriptionForm'"
                ></PositionDescriptionForm>
                <ManpowerComplement
                    v-if="currentTab === 'manpowerComplement'"
                ></ManpowerComplement>
                <StatisticalSummary
                    v-if="currentTab === 'statisticalSummary'"
                ></StatisticalSummary>
                <TimeKeepingReport
                    v-if="currentTab === 'timeKeepingReport'"
                ></TimeKeepingReport>
                <RequestReports
                    v-if="currentTab === 'requestReport'"
                ></RequestReports>
                <LaborReports
                    v-if="currentTab === 'laborReport'"
                ></LaborReports>
            </div>
        </div>
        <!-- <md-dialog-alert :md-active.sync="fireNotification" :md-content="notificationMessage" md-confirm-text="Okay" /> -->
        <!-- <md-snackbar :md-position="'center'" :md-duration="2000" :md-active.sync="fireSnackbar" md-persistent>
            <span>{{messageSnackbar}}</span>
            <md-button class="md-warning md-dense" @click="fireSnackbar = false">
                <label style="color: black;">Dismiss</label>
            </md-button>
        </md-snackbar>         -->
    </div>
</template>

<script>
import axios from "axios";
const ManPowerUpdates = () =>
    import(
        /* webpackChunkName: "ManPowerUpdates" */ "../pages/Reports/ManPowerUpdates.vue"
    );
const EmployeesAlphaList = () =>
    import(
        /* webpackChunkName: "EmployeesAlphaList" */ "../pages/Reports/EmployeesAlphaList.vue"
    );
const PositionDescriptionForm = () =>
    import(
        /* webpackChunkName: "PositionDescriptionForm" */ "../pages/Reports/PositionDescriptionForm.vue"
    );
const ManpowerComplement = () =>
    import(
        /* webpackChunkName: "ManpowerComplement" */ "../pages/Reports/ManpowerComplement.vue"
    );
const StatisticalSummary = () =>
    import(
        /* webpackChunkName: "StatisticalSummary" */ "../pages/Reports/StatisticalSummary.vue"
    );
const TimeKeepingReport = () =>
    import(
        /* webpackChunkName: "TimeKeepingReport" */ "../pages/Reports/TimeKeepingReport.vue"
    );
const RequestReports = () =>
    import(
        /* webpackChunkName: "RequestReports" */ "../pages/Reports/RequestReports.vue"
    );
const LaborReports = () =>
    import(
        /* webpackChunkName: "LaborReports" */ "../pages/Reports/LaborReports.vue"
    );

// import UserAction from '../mixins/userAction.js';
export default {
    name: "Reports",
    components: {
        ManPowerUpdates,
        EmployeesAlphaList,
        PositionDescriptionForm,
        ManpowerComplement,
        StatisticalSummary,
        TimeKeepingReport,
        RequestReports,
        LaborReports,
    },
    data() {
        return {
            currentTab: "laborReport",
        };
    },

    methods: {
        onChange() {
            //do nothing
            console.log(this.currentTab);
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
