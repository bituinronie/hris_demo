<template>
    <div id="root">
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
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Mass Approvers</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <!-- Leave Approvers -->
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <h5>Leave Approvers</h5>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 1</label>
                            <md-input v-model="leaves_1.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('leaves_1')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 2</label>
                            <md-input v-model="leaves_2.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('leaves_2')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 3</label>
                            <md-input v-model="leaves_3.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('leaves_3')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>

                    <!-- OB Approvers -->
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <h5>OB Approvers</h5>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 1</label>
                            <md-input v-model="ob_1.name" disabled> </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('ob_1')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 2</label>
                            <md-input v-model="ob_2.name" disabled> </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('ob_2')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 3</label>
                            <md-input v-model="ob_3.name" disabled> </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('ob_3')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>

                    <!-- OT Approvers -->
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <h5>OT Approvers</h5>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 1</label>
                            <md-input v-model="overtime_1.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('overtime_1')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 2</label>
                            <md-input v-model="overtime_2.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('overtime_2')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 3</label>
                            <md-input v-model="overtime_3.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('overtime_3')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>

                    <!-- Request Approver -->
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <h5>Request Approvers</h5>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 1</label>
                            <md-input v-model="request_1.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('request_1')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 2</label>
                            <md-input v-model="request_2.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('request_2')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Approver 3</label>
                            <md-input v-model="request_3.name" disabled>
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                @click="searchApprover('request_3')"
                                >☰</md-button
                            >
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-100">
                        <h6>Select Employees to attach</h6>
                        <h6>
                            <b
                                >Currently Selected Employees:
                                <!-- {{ employeeName }} -->
                            </b>
                        </h6>
                        <md-chips v-model="selectionOfEmployees">
                            <template slot="md-chip" slot-scope="{ chip }">
                                ID: {{ chip.id }} Employee No:
                                {{ chip.employee_number }} Name: {{ chip.name }}
                            </template>
                        </md-chips>
                    </div>
                    <div class="md-layout-item md-size-100">
                        <md-button
                            style="color: black !important"
                            class="md-primary md-dense md-warning"
                            @click="isSelectMultipleEmployee = true"
                            >Select Employees</md-button
                        >

                        <md-button
                            style="float: right"
                            class="md-primary md-dens"
                            @click="updateMassApprovers"
                            :disabled="isUpdating"
                            >{{ btnMessage }}</md-button
                        >
                    </div>
                </div>
            </md-card-content>
        </md-card>
        <!-- Get Approver -->
        <DialogCard v-if="isGetApprover">
            <section slot="header">Select Approver</section>
            <section slot="body">
                <ListApprover
                    v-on:close-dialog="getApprover(modelIdentifier)"
                ></ListApprover>
                <form>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-warning md-raised"
                            style="color: black !important"
                            @click="clearApprover(modelIdentifier)"
                            >Remove Approver</md-button
                        >
                        <md-button
                            class="md-dense md-danger"
                            @click="isGetApprover = false"
                            >Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Get Approver Loading -->
        <DialogCard v-if="isGettingApprovers">
            <section slot="header">Getting Approvers...</section>
            <section slot="body">
                Please do not refresh or close this window
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
                            class="md-layout-item md-small-size-100 md-size-70"
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
                            class="md-layout-item md-small-size-100 md-size-30"
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
                        <md-table-cell md-label="Name" md-sort-by="name">{{
                            item.name
                        }}</md-table-cell>
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
                            isSelectMultipleEmployee = !isSelectMultipleEmployee
                        "
                        >✕ Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

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
    </div>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
const ListApprover = () =>
    import(
        /* webpackChunkName: "ListApprover" */ "../Request/ListApprover.vue"
    );
import LogOut from "../../mixins/logOut.js";
import userAction from "../../mixins/userAction.js";

import axios from "axios";

export default {
    components: {
        DialogCard,
        ListApprover,
    },
    mixins: [LogOut, userAction],
    name: "MassApprovers",
    props: {
        dataBackgroundColor: {
            type: String,
        },
    },
    data: () => ({
        isAuthenticated: true,
        isGetApprover: false,

        leaves_1: [],
        leaves_2: [],
        leaves_3: [],
        ob_1: [],
        ob_2: [],
        ob_3: [],
        overtime_1: [],
        overtime_2: [],
        overtime_3: [],
        request_1: [],
        request_2: [],
        request_3: [],

        modelIdentifier: null,
        makeNull: false,
        employeeID: localStorage.getItem("accountId"),
        employeeName: localStorage.getItem("full_name"),
        isUpdating: false,
        btnMessage: "Update Approvers",

        fireSnackbar: false,
        messageSnackbar: null,

        //UI
        isGettingApprovers: false,
        massApprove: false,

        //Selection of Multiple Employees
        searchValue: null,
        isSearching: false,
        massAssignEmployee: false,
        selectionOfEmployees: [],
        employeeIds: [],
        isSelectMultipleEmployee: false,
        isSelected: false,
        employees: [],
        searchBtnName: "Search",
    }),
    methods: {
        //Update Approvers
        async updateMassApprovers() {
            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/approver/mass/";

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    employeeIds: this.employeeIds,
                    leaves_1: this.leaves_1.id,
                    leaves_2: this.leaves_2.id,
                    leaves_3: this.leaves_3.id,
                    ob_1: this.ob_1.id,
                    ob_2: this.ob_2.id,
                    ob_3: this.ob_3.id,
                    overtime_1: this.overtime_1.id,
                    overtime_2: this.overtime_2.id,
                    overtime_3: this.overtime_3.id,
                    request_1: this.request_1.id,
                    request_2: this.request_2.id,
                    request_3: this.request_3.id,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Updating of approvers success!";
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error updating the approvers. Please try again!";
                });
            this.isUpdating = false;
            this.btnMessage = "Update Approvers";
            // await this.getApprovers();
        },

        //Get Approvers
        async getApprovers() {
            this.isGettingApprovers = true;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/approver/search/" + this.employeeID;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    if (response.data.leaves_1 === null) {
                        this.leaves_1.id = null;
                        this.leaves_1.name = null;
                    } else {
                        this.leaves_1.id = response.data.leaves_1.id;
                        this.leaves_1.name = response.data.leaves_1.name;
                    }

                    if (response.data.leaves_2 === null) {
                        this.leaves_2.id = null;
                        this.leaves_2.name = null;
                    } else {
                        this.leaves_2.id = response.data.leaves_2.id;
                        this.leaves_2.name = response.data.leaves_2.name;
                    }

                    if (response.data.leaves_3 === null) {
                        this.leaves_3.id = null;
                        this.leaves_3.name = null;
                    } else {
                        this.leaves_3.id = response.data.leaves_3.id;
                        this.leaves_3.name = response.data.leaves_3.name;
                    }

                    //OB
                    if (response.data.ob_1 === null) {
                        this.ob_1.id = null;
                        this.ob_1.name = null;
                    } else {
                        this.ob_1.id = response.data.ob_1.id;
                        this.ob_1.name = response.data.ob_1.name;
                    }

                    if (response.data.ob_2 === null) {
                        this.ob_2.id = null;
                        this.ob_2.name = null;
                    } else {
                        this.ob_2.id = response.data.ob_2.id;
                        this.ob_2.name = response.data.ob_2.name;
                    }

                    if (response.data.ob_3 === null) {
                        this.ob_3.id = null;
                        this.ob_3.name = null;
                    } else {
                        this.ob_3.id = response.data.ob_3.id;
                        this.ob_3.name = response.data.ob_3.name;
                    }

                    //OT
                    if (response.data.overtime_1 === null) {
                        this.overtime_1.id = null;
                        this.overtime_1.name = null;
                    } else {
                        this.overtime_1.id = response.data.overtime_1.id;
                        this.overtime_1.name = response.data.overtime_1.name;
                    }

                    if (response.data.overtime_2 === null) {
                        this.overtime_2.id = null;
                        this.overtime_2.name = null;
                    } else {
                        this.overtime_2.id = response.data.overtime_2.id;
                        this.overtime_2.name = response.data.overtime_2.name;
                    }

                    if (response.data.overtime_3 === null) {
                        this.overtime_3.id = null;
                        this.overtime_3.name = null;
                    } else {
                        this.overtime_3.id = response.data.overtime_3.id;
                        this.overtime_3.name = response.data.overtime_3.name;
                    }

                    //Request
                    if (response.data.request_1 === null) {
                        this.request_1.id = null;
                        this.request_1.name = null;
                    } else {
                        this.request_1.id = response.data.request_1.id;
                        this.request_1.name = response.data.request_1.name;
                    }

                    if (response.data.request_2 === null) {
                        this.request_2.id = null;
                        this.request_2.name = null;
                    } else {
                        this.request_2.id = response.data.request_2.id;
                        this.request_2.name = response.data.request_2.name;
                    }

                    if (response.data.request_3 === null) {
                        this.request_3.id = null;
                        this.request_3.name = null;
                    } else {
                        this.request_3.id = response.data.request_3.id;
                        this.request_3.name = response.data.request_3.name;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            this.isGettingApprovers = false;
        },

        //Select Approvers
        searchApprover(modelName) {
            this.modelIdentifier = modelName;
            this.isGetApprover = true;
            this.makeNull = false;
        },

        clearApprover(modelName) {
            if (modelName === "leaves_1") {
                this.leaves_1.name = null;
                this.leaves_1.id = null;
            }
            if (modelName === "leaves_2") {
                this.leaves_2.name = null;
                this.leaves_2.id = null;
            }
            if (modelName === "leaves_3") {
                this.leaves_3.name = null;
                this.leaves_3.id = null;
            }

            if (modelName === "ob_1") {
                this.ob_1.name = null;
                this.ob_1.id = null;
            }
            if (modelName === "ob_2") {
                this.ob_2.name = null;
                this.ob_2.id = null;
            }
            if (modelName === "ob_3") {
                this.ob_3.name = null;
                this.ob_3.id = null;
            }

            if (modelName === "overtime_1") {
                this.overtime_1.name = null;
                this.overtime_1.id = null;
            }
            if (modelName === "overtime_2") {
                this.overtime_2.name = null;
                this.overtime_2.id = null;
            }
            if (modelName === "overtime_3") {
                this.overtime_3.name = null;
                this.overtime_3.id = null;
            }

            if (modelName === "request_1") {
                this.request_1.name = null;
                this.request_1.id = null;
            }
            if (modelName === "request_2") {
                this.request_2.name = null;
                this.request_2.id = null;
            }
            if (modelName === "request_3") {
                this.request_3.name = null;
                this.request_3.id = null;
            }

            if (modelName === "search_employee") {
                this.getEmployee();
            }

            this.isGetApprover = !this.isGetApprover;
            this.fireSnackbar = true;
            this.messageSnackbar = "Removed Approver";
        },

        //Close Approver
        getApprover(modelName) {
            if (modelName === "leaves_1") {
                this.leaves_1.name = localStorage.getItem("approver_name");
                this.leaves_1.id = localStorage.getItem("approver_id");
            }
            if (modelName === "leaves_2") {
                this.leaves_2.name = localStorage.getItem("approver_name");
                this.leaves_2.id = localStorage.getItem("approver_id");
            }
            if (modelName === "leaves_3") {
                this.leaves_3.name = localStorage.getItem("approver_name");
                this.leaves_3.id = localStorage.getItem("approver_id");
            }

            if (modelName === "ob_1") {
                this.ob_1.name = localStorage.getItem("approver_name");
                this.ob_1.id = localStorage.getItem("approver_id");
            }
            if (modelName === "ob_2") {
                this.ob_2.name = localStorage.getItem("approver_name");
                this.ob_2.id = localStorage.getItem("approver_id");
            }
            if (modelName === "ob_3") {
                this.ob_3.name = localStorage.getItem("approver_name");
                this.ob_3.id = localStorage.getItem("approver_id");
            }

            if (modelName === "overtime_1") {
                this.overtime_1.name = localStorage.getItem("approver_name");
                this.overtime_1.id = localStorage.getItem("approver_id");
            }
            if (modelName === "overtime_2") {
                this.overtime_2.name = localStorage.getItem("approver_name");
                this.overtime_2.id = localStorage.getItem("approver_id");
            }
            if (modelName === "overtime_3") {
                this.overtime_3.name = localStorage.getItem("approver_name");
                this.overtime_3.id = localStorage.getItem("approver_id");
            }

            if (modelName === "request_1") {
                this.request_1.name = localStorage.getItem("approver_name");
                this.request_1.id = localStorage.getItem("approver_id");
            }
            if (modelName === "request_2") {
                this.request_2.name = localStorage.getItem("approver_name");
                this.request_2.id = localStorage.getItem("approver_id");
            }
            if (modelName === "request_3") {
                this.request_3.name = localStorage.getItem("approver_name");
                this.request_3.id = localStorage.getItem("approver_id");
            }

            if (modelName === "search_employee") {
                this.getEmployee();
            }
            this.isGetApprover = !this.isGetApprover;
        },

        //Get Employee
        async getEmployee() {
            this.employeeID = localStorage.getItem("approver_id");
            this.employeeName = localStorage.getItem("approver_name");
            console.log(this.employeeID);
            this.initializeData();
            // this.isGettingApprovers = true;
            await this.getApprovers();
            // this.isGettingApprovers = false;
        },

        //Search Employee
        async searchEmployee() {
            let baseUrl = localStorage.getItem("base_url");
            let token = localStorage.getItem("token");

            this.isSearching = true;
            this.searchBtnName = "Searching...";
            const options = {
                method: "GET",
                url: baseUrl + "/api/employee/search/",
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
        //Initialize Data
        initializeData() {
            this.leaves_1.id = null;
            this.leaves_2.id = null;
            this.leaves_3.id = null;
            this.ob_1.id = null;
            this.ob_2.id = null;
            this.ob_3.id = null;
            this.overtime_1.id = null;
            this.overtime_2.id = null;
            this.overtime_3.id = null;
            this.request_1.id = null;
            this.request_2.id = null;
            this.request_3.id = null;

            this.leaves_1.name = null;
            this.leaves_2.name = null;
            this.leaves_3.name = null;
            this.ob_1.name = null;
            this.ob_2.name = null;
            this.ob_3.name = null;
            this.overtime_1.name = null;
            this.overtime_2.name = null;
            this.overtime_3.name = null;
            this.request_1.name = null;
            this.request_2.name = null;
            this.request_3.name = null;
        },
    },
    //Created
    async created() {
        this.initializeData();
        //await this.getApprovers();
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
</style>
