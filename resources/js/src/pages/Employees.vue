<template>
    <div class="content">
        <div class="md-layout">
            <div
                class="md-layout-item md-medium-size-100 md-size-100 md-layout"
            >
                <DialogCard v-if="empSearch">
                    <section slot="header">Search Employee</section>
                    <section slot="body">
                        <ListEmployee
                            v-on:close-dialog="getNewlySelectedEmployee"
                        ></ListEmployee>
                        <form>
                            <md-dialog-actions>
                                <md-button
                                    class="md-dense md-primary emp-search"
                                    @click="addEmp"
                                >
                                    <!-- <md-icon class="emp_search">add</md-icon> -->
                                    Add Employee
                                </md-button>
                                <!-- <md-button class="md-primary md-dense" type="submit">Search Employee</md-button > -->
                                <md-button
                                    v-if="userAction != 'emp_selected'"
                                    class="md-dense md-danger"
                                    @click="goBack"
                                    >Cancel</md-button
                                >
                                <md-button
                                    v-else
                                    class="md-dense md-danger"
                                    @click="searchEmp"
                                    :disabled="userAction != 'emp_selected'"
                                    >✕ Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>
                <div class="md-layout-item md-small-size-100 md-size-50">
                    <label
                        v-if="
                            userAction === 'emp_selected' ||
                            userAction === 'edit'
                        "
                    >
                        <h5>
                            Name:
                            <label
                                style="text-transform: uppercase !important"
                                >{{ fullName }}</label
                            >
                        </h5>
                    </label>
                    <label v-else>
                        <h5>Add New Employee</h5>
                    </label>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-button
                        class="md-dense md-primary emp-search"
                        @click="searchEmp"
                        v-if="$permissions.includes('search employee')"
                        >Employee Search
                        <!-- <md-icon class="emp_search">search</md-icon> -->
                    </md-button>
                    <md-button
                        class="md-dense md-primary emp-search"
                        @click="addEmp"
                        v-if="$permissions.includes('write employee')"
                    >
                        <!-- <md-icon class="emp_search">add</md-icon> -->
                        Add Employee
                    </md-button>
                    <md-button
                        v-if="
                            userAction != 'add' &&
                            $permissions.includes('print employee')
                        "
                        class="md-raised md-dense md-warning"
                        style="color: black !important; float: right !important"
                        @click="generatePds"
                    >
                        Print PDS
                    </md-button>
                </div>

                <!-- Begin Stepper -->
                <div
                    class="
                        md-layout-item md-medium-size-100 md-size-100 md-layout
                    "
                    style="margin-bottom: 30px"
                >
                    <div
                        class="md-layout-item md-small-size-100 md-size-100"
                        style="padding: 0px !important"
                    >
                        <md-steppers @md-changed="stepChange($event)">
                            <md-step
                                id="personalInformation"
                                md-label="Personal Information"
                            >
                            </md-step>
                            <label v-if="userAction != 'add'">
                                <md-step
                                    id="familyBackground"
                                    md-label="Family Background"
                                >
                                </md-step>

                                <md-step
                                    id="educationalBackground"
                                    md-label="Educational Background"
                                >
                                </md-step>

                                <md-step
                                    id="learningDevelopment"
                                    md-label="Learning Development"
                                >
                                </md-step>

                                <md-step
                                    id="eligibility"
                                    md-label="Civil Service & License"
                                >
                                </md-step>

                                <md-step
                                    id="workExperience"
                                    md-label="Work Experience"
                                >
                                </md-step>

                                <md-step
                                    id="voluntaryWork"
                                    md-label="Voluntary Work"
                                >
                                </md-step>

                                <md-step id="others" md-label="Others">
                                </md-step>
                            </label>
                        </md-steppers>
                    </div>
                </div>
                <!-- End Stepper -->

                <keep-alive>
                    <PersonalInformation
                        v-if="checkCurrentTab('personalInformation')"
                    ></PersonalInformation>
                    <FamilyBackground
                        v-if="checkCurrentTab('familyBackground')"
                    ></FamilyBackground>
                    <EducationalBackground
                        v-if="checkCurrentTab('educationalBackground')"
                    ></EducationalBackground>
                    <LearningDevelopment
                        v-if="checkCurrentTab('learningDevelopment')"
                    ></LearningDevelopment>
                    <CivilServiceAndLicense
                        v-if="checkCurrentTab('eligibility')"
                    ></CivilServiceAndLicense>
                    <WorkExperience
                        v-if="checkCurrentTab('workExperience')"
                    ></WorkExperience>
                    <VoluntaryWork
                        v-if="checkCurrentTab('voluntaryWork')"
                    ></VoluntaryWork>
                    <Others v-if="checkCurrentTab('others')"></Others>
                </keep-alive>

                <div class="md-layout-item md-size-50">
                    <md-button
                        v-if="
                            empSelected &&
                            $permissions.includes('write employee')
                        "
                        class="md-raised md-dense md-warning"
                        style="color: black !important"
                        @click="editEmp"
                        >Edit information</md-button
                    >
                </div>
                <div class="md-layout-item md-size-50 text-right">
                    <!-- <md-button v-if="userAction != 'add' " class="md-raised md-dense md-warning" style="color: black !important; float: right !important;" @click="generatePds">PRINT PDS</md-button> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const PersonalInformation = () =>
    import(
        /* webpackChunkName: "PortalPersonalInformation" */ "../pages/Employee/PersonalInformation.vue"
    );
const FamilyBackground = () =>
    import(
        /* webpackChunkName: "FamilyBackground" */ "../pages/Employee/FamilyBackground.vue"
    );
const LearningDevelopment = () =>
    import(
        /* webpackChunkName: "LearningDevelopment" */ "../pages/Employee/LearningDevelopment.vue"
    );
const CivilServiceAndLicense = () =>
    import(
        /* webpackChunkName: "CivilServiceAndLicense" */ "../pages/Employee/CivilServiceAndLicense.vue"
    );
const EducationalBackground = () =>
    import(
        /* webpackChunkName: "EducationalBackground" */ "../pages/Employee/EducationalBackground.vue"
    );
const WorkExperience = () =>
    import(
        /* webpackChunkName: "WorkExperience" */ "../pages/Employee/WorkExperience.vue"
    );
const VoluntaryWork = () =>
    import(
        /* webpackChunkName: "VoluntaryWork" */ "../pages/Employee/VoluntaryWork.vue"
    );
const Others = () =>
    import(/* webpackChunkName: "Others" */ "../pages/Employee/Others.vue");
const ListEmployee = () =>
    import(
        /* webpackChunkName: "ListEmployee" */ "../pages/Employee/ListEmployee.vue"
    );
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../components/Cards/DialogCard.vue";
import axios from "axios";
import UserAction from "../mixins/userAction.js";
export default {
    name: "Employees",
    components: {
        PersonalInformation,
        FamilyBackground,
        LearningDevelopment,
        CivilServiceAndLicense,
        EducationalBackground,
        WorkExperience,
        VoluntaryWork,
        Others,
        DialogCard,
        ListEmployee,
    },
    mixins: [UserAction],
    data() {
        return {
            empSearch: false,
            currentTab: "personalInformation",
            fullName: localStorage.getItem("full_name"),
        };
    },
    watch: {
        newCurrentTabSelection() {
            this.currentTab = this.newCurrentTabSelection;
        },
    },
    methods: {
        searchEmp() {
            this.empSearch = !this.empSearch;
        },

        getNewlySelectedEmployee() {
            localStorage.setItem("search_user_employee", "1");
            this.$router.go()
        },

        //Go Back to Dashboard when user selected close
        goBack() {
            this.$router.push({ name: "Dashboard" });
        },

        onChange() {
            console.log(this.currentTab);
        },

        stepChange(id) {
            console.log(id);
            this.currentTab = id;
        },

        checkCurrentTab(tabName) {
            if (this.currentTab === tabName) {
                this.$store.commit("changeCurrentTabSelection", tabName);
                return true;
            } else {
                return false;
            }
        },
        addEmp() {
            this.empSearch = false;
            this.$store.commit("changecurrentSelectionUserId", null);
            this.$store.commit("changeUserStatusAction", "add");
            this.$store.commit(
                "changeCurrentTabSelection",
                "personalInformation"
            );
            this.currentTab = "personalInformation";
        },

        //Edit Information after Employee Selection
        editEmp() {
            this.$store.commit("changeUserStatusAction", "edit");
        },

        //Print Employee
        generatePds() {
            const employeeID = this.empSelectionID;
            console.log(employeeID);
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    permission: "print employee",
                    model_name: {
                        employeeId: employeeID,
                    },
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    console.log(printToken);

                    //New Tab to generate the PDS
                    parentURL =
                        parentURL +
                        "/generate/report/1/single/pds/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
    },
    watch: {
        userAction(newVal, oldVal) {
            if (newVal === "add") {
                this.isUpdate = false;
                this.btnMessage = "Save Personal Information";
                this.empSelected = false;
            }
            if (newVal === "emp_selected") {
                console.log(this.empSelected);
                this.empSelected = true;
            }
            if (newVal === "edit") {
                this.isUpdate = true;
                this.empSelected = false;
                this.btnMessage = "Update Personal Information";
            }
        },
    },
    beforeMount() {
        if (localStorage.getItem("role") === "Employee") {
            this.$router.push({ name: "Dashboard" });
        }

        if (localStorage.getItem("search_user_employee") === "1") {
            this.fullName = localStorage.getItem("selection_name_employee");
        }

        //Check use action
        if (this.userAction === "emp_selected") {
            this.empSelected = true;
            this.empSearch = false;
        } else {
            this.empSearch = true;
        }
    },
};
</script>

<style scoped>
.emp-search {
    float: right;
}
.md-theme-default {
    /* color: white !important; */
}
</style>

<style>
.md-steppers-wrapper {
    max-height: 0px !important;
    min-height: 0px !important;
}
.md-stepper-label {
    font-size: 10px !important;
}
.md-stepper-number {
    display: none !important;
}
.md-stepper-header {
    height: 50px !important;
}
.md-button.md-stepper-header.md-theme-default.md-done {
    background-color: white !important;
}
.md-button.md-stepper-header.md-theme-default.md-active {
    background-color: #fbcc2b !important;
}
.md-button.md-stepper-header.md-theme-default {
    background-color: white !important;
}
</style>
