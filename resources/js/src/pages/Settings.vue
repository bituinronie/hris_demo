<template>
    <div class="content">
        <div class="md-layout">
            <div
                class="md-layout-item md-medium-size-100 md-size-100 md-layout"
            >
                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                        <label>Select Action</label>
                        <md-select v-model="currentTab" @md-selected="onChange">
                            <md-option
                                value="employeeGroup"
                                v-if="
                                    $permissions.includes(
                                        'search employee group'
                                    )
                                "
                                >Employee Group</md-option
                            >
                            <md-option
                                value="division"
                                v-if="$permissions.includes('search division')"
                                >Division</md-option
                            >

                            <md-option
                                value="salaryGrade"
                                v-if="
                                    $permissions.includes('search salary grade')
                                "
                                >Salary Grade</md-option
                            >
                            <md-option
                                value="employeeUpdate"
                                v-if="$permissions.includes('search setting')"
                                >Employee Update</md-option
                            >
                            <md-option
                                value="approvers"
                                v-if="$permissions.includes('search approver')"
                                >Approvers</md-option
                            >

                            <md-option
                                value="request_type"
                                v-if="
                                    $permissions.includes('search request type')
                                "
                                >Request Type</md-option
                            >
                            <md-option
                                value="employer_settings"
                                v-if="$permissions.includes('search setting')"
                                >Employer Settings</md-option
                            >
                            <md-option
                                value="earnings"
                                >Earnings</md-option
                            >
                            <md-option
                                value="deductions"
                                >Deductions</md-option
                            >
                            <md-option
                                value="tax"
                                >Tax</md-option
                            >
                            <md-option
                                value="gsis"
                                >GSIS</md-option
                            >
                            <md-option
                                value="philhealth"
                                >PHILHEALTH</md-option
                            >
                            <md-option
                                value="pag_ibig"
                                >PAG-IBIG</md-option
                            >
                            <md-option
                                value="projects"
                                >Projects</md-option
                            >
                            <!-- <md-option
                                value="payroll_setting"
                                >Payroll Setting</md-option
                            >
                            <md-option
                                value="payroll_minimum_amount"
                                >Payroll Minimum Amount</md-option
                            > -->
                        </md-select>
                    </md-field>
                </div>
            </div>
            <div class="md-layout-item md-medium-size-100 md-size-100">
                <Division v-if="currentTab === 'division'"></Division>
                <SalaryGrade v-if="currentTab === 'salaryGrade'"></SalaryGrade>
                <EmployeeUpdate
                    v-if="currentTab === 'employeeUpdate'"
                ></EmployeeUpdate>
                <EmployeeGroup
                    v-if="currentTab === 'employeeGroup'"
                ></EmployeeGroup>
                <Approvers v-if="currentTab === 'approvers'"></Approvers>
                <RequestType v-if="currentTab === 'request_type'"></RequestType>
                <EmployerSettings
                    v-if="currentTab === 'employer_settings'"
                ></EmployerSettings>
                <Earnings
                    v-if="currentTab === 'earnings'"
                ></Earnings>
                <Deductions
                    v-if="currentTab === 'deductions'"
                ></Deductions>
                <Tax
                    v-if="currentTab === 'tax'"
                ></Tax>
                <GSIS
                    v-if="currentTab === 'gsis'"
                ></GSIS>
                <PhilHealth
                    v-if="currentTab === 'philhealth'"
                ></PhilHealth>
                <PAGIBIG
                    v-if="currentTab === 'pag_ibig'"
                ></PAGIBIG>
                <Projects
                    v-if="currentTab === 'projects'"
                ></Projects>
                <!-- <PayrollSetting
                    v-if="currentTab === 'payroll_setting'"
                ></PayrollSetting>
                <PayrollMinimumAmount
                    v-if="currentTab === 'payroll_minimum_amount'"
                ></PayrollMinimumAmount> -->
            </div>
        </div>
    </div>
</template>

<script>
// import PayrollMinimumAmount from './Settings/PayrollMinimumAmount.vue';
const Division = () =>
    import(/* webpackChunkName: "Division" */ "../pages/Settings/Division.vue");
const SalaryGrade = () =>
    import(
        /* webpackChunkName: "SalaryGrade" */ "../pages/Settings/SalaryGrade.vue"
    );
const EmployeeUpdate = () =>
    import(
        /* webpackChunkName: "EmployeeUpdate" */ "../pages/Settings/EmployeeUpdate.vue"
    );
const EmployeeGroup = () =>
    import(
        /* webpackChunkName: "EmployeeGroup" */ "../pages/Settings/EmployeeGroup.vue"
    );
const Approvers = () =>
    import(
        /* webpackChunkName: "Approvers" */ "../pages/Settings/Approvers.vue"
    );
const RequestType = () =>
    import(
        /* webpackChunkName: "RequestType" */ "../pages/Settings/RequestType.vue"
    );
const EmployerSettings = () =>
    import(
        /* webpackChunkName: "PrintSettings" */ "../pages/Settings/EmployerSettings.vue"
    );
const Earnings = () =>
    import(
        /* webpackChunkName: "Earnings" */ "./Settings/Earnings.vue"
    );
const Deductions = () =>
    import(
        /* webpackChunkName: "Deductions" */ "./Settings/Deductions.vue"
    );
const Tax = () =>
    import(
        /* webpackChunkName: "Tax" */ "./Settings/Tax.vue"
    );
const GSIS = () =>
    import(
        /* webpackChunkName: "GSIS" */ "./Settings/GSIS.vue"
    );
const PAGIBIG = () =>
    import(
        /* webpackChunkName: "PAG-IBIG" */ "./Settings/PAGIBIG.vue"
    );
const PhilHealth = () =>
    import(
        /* webpackChunkName: "PhilHealth" */ "./Settings/PhilHealth.vue"
    );
const Projects = () =>
    import(
        /* webpackChunkName: "Projects" */ "./Settings/Projects.vue"
    );
const PayrollSetting = () =>
    import(
        /* webpackChunkName: "Payroll Setting" */ "./Settings/PayrollSetting.vue"
    );
const PayrollMinimumAmount = () =>
    import(
        /* webpackChunkName: "Payroll Minimum Amount" */ "./Settings/PayrollMinimumAmount.vue"
    );
export default {
    name: "Settings",
    components: {
        Division,
        SalaryGrade,
        EmployeeUpdate,
        EmployeeGroup,
        Approvers,
        RequestType,
        EmployerSettings,
        Earnings,
        Deductions,
        Tax,
        GSIS,
        PhilHealth,
        PAGIBIG,
        Projects,
        PayrollSetting,
        PayrollMinimumAmount,
    },
    data() {
        return {
            currentTab: "employer_settings",
        };
    },
    methods: {
        onChange() {
            //do nothing
        },
    },
    beforeMount() {
        if (localStorage.getItem("role") === "Employee") {
            this.$router.push({ name: "Dashboard" });
        }
    },
};
</script>

<style scoped>
.emp-search {
    float: right;
}
.md-theme-default {
    color: white !important;
}
</style>
