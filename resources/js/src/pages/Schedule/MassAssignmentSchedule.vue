<template>
    <md-card v-if="$permissions.includes('write employee schedule')">
        <md-card-header class="md-card-header">
            <h4 class="title">Mass Assignment of Schedules</h4>
            <!-- <p class="category">Complete the employee's profile</p> -->
        </md-card-header>
        <md-card-content>
            <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-button
                        @click="massAssignEmployee = true"
                        class="md-dense md-raised md-primary"
                        style="float: right"
                        v-if="$permissions.includes('write employee schedule')"
                    >
                        Mass Assignment of templates to employee</md-button
                    >
                </div>
                <!-- Mass Assignment of Employee -->
                <DialogCard v-if="massAssignEmployee">
                    <section slot="header">Mass Assignment of Employee</section>
                    <section slot="body">
                        <form
                            method="post"
                            @submit.prevent="validateMassAssignment()"
                        >
                            <md-chips v-model="selectionOfEmployees">
                                <md-button
                                    class="md-raised md-dense md-primary"
                                    @click="isSelectMultipleEmployee = true"
                                    style="width: 100% !important"
                                    >Select Employees</md-button
                                >
                                <template slot="md-chip" slot-scope="{ chip }">
                                    ID: {{ chip.id }} Employee No:
                                    {{ chip.employee_number }} Name:
                                    {{ chip.name }}
                                </template>
                            </md-chips>
                            <md-field>
                                <label>Schedule Type</label>
                                <md-select
                                    v-model="schedule_type"
                                    @md-selected="getSpecialCode"
                                    required
                                >
                                    <md-option value="REGULAR"
                                        >REGULAR</md-option
                                    >
                                    <md-option value="SPECIAL"
                                        >SPECIAL</md-option
                                    >
                                </md-select>
                            </md-field>
                            <div v-if="schedule_type != 'SPECIAL'">
                                <md-field>
                                    <label>Code</label>
                                    <md-select v-model="schedule_id" required>
                                        <md-option
                                            v-for="s in paramSchedule"
                                            :key="s.id"
                                            :value="s.id"
                                            >{{ s.code }}</md-option
                                        >
                                    </md-select>
                                </md-field>
                                <md-field>
                                    <label>Type</label>
                                    <md-select v-model="type" required>
                                        <md-option value="PERMANENT"
                                            >PERMANENT</md-option
                                        >
                                        <md-option value="ONE_TIME"
                                            >ONE TIME</md-option
                                        >
                                    </md-select>
                                </md-field>
                                <md-datepicker
                                    :md-model-type="String"
                                    v-model="effective_date"
                                >
                                    <label>Effective Date</label>
                                </md-datepicker>
                            </div>
                            <!-- If special-->
                            <div v-else>
                                <div>
                                    <md-field>
                                        <label>Special Schedule Code</label>
                                        <md-select v-model="specialSchedule">
                                            <md-option
                                                v-for="ssi in specialScheduleInformation"
                                                :key="ssi.id"
                                                :value="ssi.id"
                                                >{{ ssi.code }}</md-option
                                            >
                                        </md-select>
                                    </md-field>
                                </div>
                            </div>
                            <md-button
                                type="submit"
                                class="md-primary md-dense"
                                @click="validateMassAssignment()"
                                :disabled="isChanging"
                                >{{ assignBtn }}</md-button
                            >
                            <md-button
                                class="md-dense md-danger"
                                @click="
                                    massAssignEmployee = !massAssignEmployee
                                "
                                >✕ Close</md-button
                            >
                        </form>
                    </section>
                </DialogCard>

                <!-- Select Multiple Employee -->
                <DialogCard v-if="isSelectMultipleEmployee">
                    <section slot="header">Select Employee</section>
                    <section slot="body">
                        <md-table
                            v-model="employees"
                            md-sort="name"
                            md-sort-order="asc"
                            md-card
                            @md-selected="onSelectMultipleEmployee"
                        >
                            <md-table-toolbar>
                                <div class="md-toolbar-section-start">
                                    <!-- <h2 class="md-title">Employees Information</h2> -->
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-70
                                    "
                                >
                                    <md-field md-clearable>
                                        <form
                                            method="post"
                                            @submit.prevent="searchEmployee()"
                                        >
                                            <md-input
                                                placeholder="Search employee..."
                                                v-model="searchValue"
                                            />
                                        </form>
                                    </md-field>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-30
                                    "
                                >
                                    <md-button
                                        class="md-raised md-primary"
                                        @click="searchEmployee()"
                                        :disabled="isSearching"
                                        >{{ searchBtnName }}</md-button
                                    >
                                </div>
                            </md-table-toolbar>
                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                                md-selectable="multiple"
                            >
                                <md-table-cell
                                    md-label="ID"
                                    md-sort-by="id"
                                    md-numeric
                                    >{{ item.id }}</md-table-cell
                                >
                                <!-- <md-table-cell
                                            md-label="Username"
                                            md-sort-by="username"
                                            md-numeric
                                            >{{ item.username }}</md-table-cell
                                        >                             -->
                                <md-table-cell
                                    md-label="Employee Number"
                                    md-sort-by="employee_number"
                                    >{{ item.employee_number }}</md-table-cell
                                >
                                <!-- <md-table-cell md-label="Birth Date" md-sort-by="birth_date">{{ item.birth_date }}</md-table-cell> -->
                                <md-table-cell
                                    md-label="Name"
                                    md-sort-by="name"
                                    >{{ item.name }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Birth Date"
                                    md-sort-by="birthdate"
                                    >{{ item.birth_date }}</md-table-cell
                                >
                            </md-table-row>

                            <md-table-empty-state
                                md-label="No employee found"
                                :md-description="`Try a different search term`"
                            >
                                <!-- <md-button class="md-primary md-raised">Create New Record</md-button> -->
                            </md-table-empty-state>
                        </md-table>
                        <md-chips
                            v-model="selectionOfEmployees"
                            md-placeholder="Selected Employees:"
                        >
                            <template slot="md-chip" slot-scope="{ chip }">
                                ID: {{ chip.id }} Employee No:
                                {{ chip.employee_number }} Name: {{ chip.name }}
                            </template>
                        </md-chips>
                        <md-button
                            class="md-raised md-primary"
                            @click="changeCurrentEmployeeSelections()"
                            v-if="isSelected"
                        >
                            Confirm
                        </md-button>
                        <md-dialog-actions>
                            <md-button
                                class="md-dense md-danger"
                                @click="
                                    isSelectMultipleEmployee =
                                        !isSelectMultipleEmployee
                                "
                                >✕ Close</md-button
                            >
                        </md-dialog-actions>
                    </section>
                </DialogCard>
            </div>
        </md-card-content>

        <md-snackbar
            :md-position="'center'"
            :md-duration="2000"
            :md-active.sync="fireSnackbar"
            md-persistent
        >
            <span>{{ messageSnackbar }}</span>
            <md-button
                class="md-warning md-dense"
                @click="fireSnackbar = false"
            >
                <label style="color: black">Dismiss</label>
            </md-button>
        </md-snackbar>
    </md-card>
</template>
<script>
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
import axios from "axios";

export default {
    components: {
        DialogCard,
    },
    name: "MassAssignmentSchedule",
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        //Snackkbar
        fireSnackbar: false,
        messageSnackbar: null,

        searchValue: null,
        isSearching: false,
        massAssignEmployee: false,
        selectionOfEmployees: [],
        employeeIds: [],
        isSelectMultipleEmployee: false,
        isSelected: false,
        employees: [],
        schedule_type: "REGULAR",
        schedule_id: null,
        paramSchedule: [],
        type: "PERMANENT",
        specialScheduleInformation: null,
        effective_date: null,

        //UI
        searchBtnName: "Search",
        isChanging: false,
        assignBtn: "Assign Schedule",
    }),
    methods: {
        //Mass Assignment
        async validateMassAssignment() {
            let baseUrl = localStorage.getItem("base_url");
            let token = localStorage.getItem("token");

            this.isChanging = true;
            this.msgButton = "Assigning...";

            if (this.schedule_type === "SPECIAL") {
                let newURL = localStorage.getItem("base_url");
                let getEffectiveDate = {
                    method: "GET",
                    url:
                        newURL +
                        "/api/special-schedule/search/" +
                        this.specialSchedule,
                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + token,
                    },
                };

                await axios
                    .request(getEffectiveDate)
                    .then((response) => {
                        console.log(response.data);
                        this.effective_date = Object.keys(
                            response.data.template
                        )[0];
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
            console.log(this.effective_date);
            let options = {
                method: "POST",
                url: baseUrl + "/api/employee/schedule/mass/",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    employeeIds: this.employeeIds,
                    schedule_type: this.schedule_type,
                    effective_date: this.effective_date,
                    schedule_id: this.schedule_id,
                    special_schedule_id: this.specialSchedule,
                    type: this.type,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Schedule of this employee(s) has been updated";
                    this.massAssignEmployee = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error processing your request. Please try again.";
                });

            this.isChanging = false;
            this.msgButton = "Assign Schedule";
        },

        async searchEmployee() {
            let baseUrl = localStorage.getItem("base_url");
            let token = localStorage.getItem("token");

            this.isSearching = true;
            this.searchBtnName = "Searching...";
            const options = {
                method: "GET",
                url: baseUrl + "/api/employee/schedule/search",
                params: { perPage: "20", searchValue: this.searchValue },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.employees = response.data.data;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isSearching = false;
            this.searchBtnName = "Search";
        },

        //event on selection of multiple employee
        onSelectMultipleEmployee(item) {
            if (item.length <= 0) {
                this.isSelected = false;
                //this.selectionOfEmployees = []
            } else {
                //Iterate the item
                for (var i = 0; i < item.length; i++) {
                    if (
                        this.selectionOfEmployees.some(
                            (e) => e.id === item[i].id
                        )
                    ) {
                        console.log("exist!");
                    } else {
                        this.selectionOfEmployees.push(item[i]);
                    }
                }
                this.isSelected = true;
                console.log(this.selectionOfEmployees);
            }
        },

        //Change Multiple Employee Selection
        changeCurrentEmployeeSelections() {
            this.isSelectMultipleEmployee = false;
            this.employeeIds = [];
            for (const [key, value] of Object.entries(
                this.selectionOfEmployees
            )) {
                this.employeeIds.push(value.id);
            }
        },

        //Get Special Code
        async getSpecialCode() {
            let baseUrl = localStorage.getItem("base_url");
            let token = localStorage.getItem("token");
            const options = {
                method: "GET",
                url: baseUrl + "/api/special-schedule/search",
                params: { perPage: 1000 },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.specialScheduleInformation = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Get Schedules
        async getSchedules() {
            let baseUrl = localStorage.getItem("base_url");
            let token = localStorage.getItem("token");
            const options = {
                method: "GET",
                url: baseUrl + "/api/schedule/search/",
                params: { perPage: "100" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.paramSchedule = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },

    async created() {
        await this.getSchedules();
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
.dob {
    margin-top: -20px;
}
.addChild {
    background-color: #495057;
    border-color: #495057;
    color: white !important;
}
.md-table-sortable-icon {
    display: none !important;
}
.button-paginate {
    border: 0px !important;
    margin-left: 2px !important;
    margin-right: 2px !important;
    padding: 5px !important;
    max-width: 90px !important;
    min-width: 90px !important;
}
</style>
