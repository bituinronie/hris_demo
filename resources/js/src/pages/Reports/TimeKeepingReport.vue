<template>
    <form>
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Time Keeping Report</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-medium-size-100 md-size-100">
                        <md-table md-card>
                            <md-table-toolbar>
                                <!-- <h1 class="md-title"></h1> -->
                            </md-table-toolbar>

                            <md-table-row>
                                <md-table-head>Description</md-table-head>
                                <md-table-head>Actions</md-table-head>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Log-in and Log-out summary</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printLoginLogOutSummary =
                                                !printLoginLogOutSummary
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Summary of Employees
                                    Tardiness</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printEmployeeTardiness =
                                                !printEmployeeTardiness
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Summary of Employee Absences</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryOfEmployeeAbsences =
                                                !printSummaryOfEmployeeAbsences
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Monthly Attendance Report</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printMonthlyAttendanceReport =
                                                !printMonthlyAttendanceReport
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </div>
                </div>
            </md-card-content>
        </md-card>

        <!-- Print Login Logout Summary -->
        <DialogCard v-if="printLoginLogOutSummary">
            <section slot="header">Print Log-in and Log-out Summary</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintLoginLogOutSummary"
                >
                    <md-field>
                        <label>Division</label>
                        <md-input v-model="divisionName" disabled> </md-input>
                        <md-button
                            class="md-raised md-primary"
                            @click="divSearch = true"
                            >☰</md-button
                        >
                    </md-field>
                    <md-autocomplete
                        v-model="placeOfWork"
                        :md-options="suggestionPlaceOfWork"
                        required
                    >
                        <label>Place of Work</label>
                    </md-autocomplete>
                    <md-field>
                        <label>Select Month</label>
                        <md-select v-model="month">
                            <md-option value="1">January</md-option>
                            <md-option value="2">February</md-option>
                            <md-option value="3">March</md-option>
                            <md-option value="4">April</md-option>
                            <md-option value="5">May</md-option>
                            <md-option value="6">June</md-option>
                            <md-option value="7">July</md-option>
                            <md-option value="8">August</md-option>
                            <md-option value="9">September</md-option>
                            <md-option value="10">October</md-option>
                            <md-option value="11">November</md-option>
                            <md-option value="12">December</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Year</label>
                        <md-input
                            v-model="year"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <!-- <md-autocomplete
                        v-model="placeOfWork"
                        :md-options="suggestionPlaceOfWork"
                        required
                    >
                        <label>Place of Work</label>
                    </md-autocomplete> -->

                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionEmployee()"
                        required
                    >
                        <label>Prepared</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Prepared</label>
                        <md-input
                            v-model="prepared"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Prepared Position</label>
                        <md-input
                            v-model="preparedPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorPosition()"
                        required
                    >
                        <label>Super Visor</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Super Visor</label>
                        <md-input
                            v-model="supervisor"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Supervisor Position</label>
                        <md-input
                            v-model="supervisorPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printLoginLogOutSummary = !printLoginLogOutSummary
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Summary of Employees Tardiness -->
        <DialogCard v-if="printEmployeeTardiness">
            <section slot="header">
                Print Summary of Employees Tardiness
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintEmployeeTardiness"
                >
                    <md-field>
                        <label>Type of Time Date Selection</label>
                        <md-select v-model="dateRangeSelection">
                            <md-option :value="'monthYear'"
                                >Month and Year
                            </md-option>
                            <md-option :value="'dateRange'"
                                >Date Range
                            </md-option>
                        </md-select>
                    </md-field>
                    <div v-if="dateRangeSelection === 'dateRange'">
                        <md-datepicker
                            :md-model-type="String"
                            label="To"
                            v-model="dateFrom"
                        >
                            <label>From</label>
                        </md-datepicker>
                        <md-datepicker
                            :md-model-type="String"
                            label="From"
                            v-model="dateTo"
                        >
                            <label>To</label>
                        </md-datepicker>
                    </div>
                    <div v-else>
                        <md-field>
                            <label>Select Month</label>
                            <md-select v-model="month">
                                <md-option value="1">January</md-option>
                                <md-option value="2">February</md-option>
                                <md-option value="3">March</md-option>
                                <md-option value="4">April</md-option>
                                <md-option value="5">May</md-option>
                                <md-option value="6">June</md-option>
                                <md-option value="7">July</md-option>
                                <md-option value="8">August</md-option>
                                <md-option value="9">September</md-option>
                                <md-option value="10">October</md-option>
                                <md-option value="11">November</md-option>
                                <md-option value="12">December</md-option>
                            </md-select>
                        </md-field>
                        <md-field>
                            <label>Year</label>
                            <md-input
                                v-model="year"
                                type="text"
                                required
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- <md-field>
                        <label>Place of Work</label>
                        <md-input
                            v-model="placeOfWork"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-autocomplete
                        v-model="placeOfWork"
                        :md-options="suggestionPlaceOfWork"
                        required
                    >
                        <label>Place of Work</label>
                    </md-autocomplete>

                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionEmployee()"
                        required
                    >
                        <label>Prepared</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Prepared</label>
                        <md-input
                            v-model="prepared"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->
                    <md-field>
                        <label>Prepared Position</label>
                        <md-input
                            v-model="preparedPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorPosition()"
                        required
                    >
                        <label>Super Visor</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Super Visor</label>
                        <md-input
                            v-model="supervisor"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Supervisor Position</label>
                        <md-input
                            v-model="supervisorPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printEmployeeTardiness = !printEmployeeTardiness
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Monthly Attendance Report -->
        <DialogCard v-if="printMonthlyAttendanceReport">
            <section slot="header">Monthly Attendance Report</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validateMonthlyAttendanceReport"
                >
                    <md-field>
                        <label>Division</label>
                        <md-input v-model="divisionName" disabled> </md-input>
                        <md-button
                            class="md-raised md-primary"
                            @click="divSearch = true"
                            >☰</md-button
                        >
                    </md-field>
                    <!-- <md-field>
                        <label>Place of Work</label>
                        <md-input
                            v-model="placeOfWork"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-autocomplete
                        v-model="placeOfWork"
                        :md-options="suggestionPlaceOfWork"
                        required
                    >
                        <label>Place of Work</label>
                    </md-autocomplete>

                    <md-field>
                        <label>Select Month</label>
                        <md-select v-model="month">
                            <md-option value="1">January</md-option>
                            <md-option value="2">February</md-option>
                            <md-option value="3">March</md-option>
                            <md-option value="4">April</md-option>
                            <md-option value="5">May</md-option>
                            <md-option value="6">June</md-option>
                            <md-option value="7">July</md-option>
                            <md-option value="8">August</md-option>
                            <md-option value="9">September</md-option>
                            <md-option value="10">October</md-option>
                            <md-option value="11">November</md-option>
                            <md-option value="12">December</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Year</label>
                        <md-input
                            v-model="year"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <!-- <md-field>
                        <label>Prepared</label>
                        <md-input
                            v-model="prepared"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionEmployee()"
                        required
                    >
                        <label>Prepared</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <md-field>
                        <label>Prepared Position</label>
                        <md-input
                            v-model="preparedPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorPosition()"
                        required
                    >
                        <label>Super Visor</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Super Visor</label>
                        <md-input
                            v-model="supervisor"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Supervisor Position</label>
                        <md-input
                            v-model="supervisorPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printMonthlyAttendanceReport =
                                !printMonthlyAttendanceReport
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Summary of Employee Absences -->
        <DialogCard v-if="printSummaryOfEmployeeAbsences">
            <section slot="header">Summary of Employee Absences</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintSummaryOfEmployeeAbsences"
                >
                    <md-autocomplete
                        v-model="placeOfWork"
                        :md-options="suggestionPlaceOfWork"
                        required
                    >
                        <label>Place of Work</label>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Place of Work</label>
                        <md-input
                            v-model="placeOfWork"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Select Month</label>
                        <md-select v-model="month">
                            <md-option value="1">January</md-option>
                            <md-option value="2">February</md-option>
                            <md-option value="3">March</md-option>
                            <md-option value="4">April</md-option>
                            <md-option value="5">May</md-option>
                            <md-option value="6">June</md-option>
                            <md-option value="7">July</md-option>
                            <md-option value="8">August</md-option>
                            <md-option value="9">September</md-option>
                            <md-option value="10">October</md-option>
                            <md-option value="11">November</md-option>
                            <md-option value="12">December</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Year</label>
                        <md-input
                            v-model="year"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionEmployee()"
                        required
                    >
                        <label>Prepared</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Prepared</label>
                        <md-input
                            v-model="prepared"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Prepared Position</label>
                        <md-input
                            v-model="preparedPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorPosition()"
                        required
                    >
                        <label>Super Visor</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <!-- <md-field>
                        <label>Super Visor</label>
                        <md-input
                            v-model="supervisor"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Supervisor Position</label>
                        <md-input
                            v-model="supervisorPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printSummaryOfEmployeeAbsences =
                                !printSummaryOfEmployeeAbsences
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Division -->
        <DialogCard v-if="divSearch">
            <section slot="header">Select Division</section>
            <section slot="body">
                <ListDivision
                    v-on:close-dialog="getDivNameAndId"
                ></ListDivision>
                <form>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-danger"
                            @click="divSearch = !divSearch"
                            >✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

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

        <!-- -->
        <DialogCard v-if="!isParamLoaded">
            <section slot="header">Getting Requied Parameters...</section>
            <section slot="body">
                Please do not refresh or close this window
            </section>
        </DialogCard>
        <!-- -->
    </form>
</template>
<script>
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
const ListDivision = () =>
    import(
        /* webpackChunkName: "ListDivision" */ "../../pages/Positions/ListDivision.vue"
    );
import LogOut from "../../mixins/logOut.js";
import axios from "axios";
let baseURL = localStorage.getItem("base_url");
let token = localStorage.getItem("token");
export default {
    components: {
        DialogCard,
        ListDivision,
    },
    mixins: [LogOut],
    name: "TimeKeepingReport",
    data() {
        return {
            isAuthenticated: true,

            printJO: false,
            printPlantilla: false,

            printLoginLogOutSummary: false,
            prepared: null,
            preparedPosition: null,
            supervisor: null,
            supervisorPosition: null,

            printEmployeeTardiness: false,
            placeOfWork: null,
            dateFrom: null,
            dateTo: null,
            dateRangeSelection: "monthYear",

            divSearch: false,
            printMonthlyAttendanceReport: false,
            divisionId: null,
            month: 1,
            year: 2021,

            printSummaryOfEmployeeAbsences: false,
            divisionName: null,

            //Suggestion
            suggestions: [],
            suggestionsEmployee: [],
            suggestionsEmployeePosition: [],
            suggestionsSuperVisor: [],
            suggestionHigherSuperVisor: [],
            suggestionPlaceOfWork: null,

            //UI
            isParamLoaded: false,
        };
    },
    computed: {
        getSanitizedSuggestionEmployee() {
            return this.suggestionsEmployee.map((suggestionsEmployees) => ({
                name: suggestionsEmployees.name,
                position: suggestionsEmployees.position,
                toLowerCase: () => suggestionsEmployees.name.toLowerCase(),
                toString: () => suggestionsEmployees.name,
            }));
        },
        getSanitizedSuggestionSupervisor() {
            return this.suggestionsSuperVisor.map((suggestionsSuperVisors) => ({
                name: suggestionsSuperVisors.name,
                position: suggestionsSuperVisors.position,
                toLowerCase: () => suggestionsSuperVisors.name.toLowerCase(),
                toString: () => suggestionsSuperVisors.name,
            }));
        },
    },
    methods: {
        //Get Suggestions
        async getSuggestions() {
            let newURL = baseURL + "/api/token/report/parameter";
            const options = {
                method: "GET",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.suggestions = response.data;
                    this.suggestionPlaceOfWork = this.suggestions.placeOfWork;
                    //Get Employee
                    for (const [key, employeeValue1] of Object.entries(
                        this.suggestions
                    )) {
                        if (key === "suggestions") {
                            for (const [key, employeeValue2] of Object.entries(
                                employeeValue1
                            )) {
                                this.suggestionsEmployee.push(
                                    employeeValue2.employee
                                );
                            }
                        }
                    }

                    //Get Super visor
                    for (const [key, superVisorValue1] of Object.entries(
                        this.suggestions
                    )) {
                        if (key === "suggestions") {
                            for (const [
                                key,
                                superVisorValue2,
                            ] of Object.entries(superVisorValue1)) {
                                this.suggestionsSuperVisor.push(
                                    superVisorValue2.supervisor
                                );
                            }
                        }
                    }

                    //Get Higher Supervisor
                    for (const [key, higherSuperVisor1] of Object.entries(
                        this.suggestions
                    )) {
                        if (key === "suggestions") {
                            for (const [
                                key,
                                higherSuperVisor2,
                            ] of Object.entries(higherSuperVisor1)) {
                                this.suggestionHigherSuperVisor.push(
                                    higherSuperVisor2.higherSupervisor
                                );
                            }
                        }
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        //Get Position Employee
        getPositionEmployee() {
            this.preparedPosition = this.prepared.position;
            this.prepared = this.prepared.name;
        },

        //Get Position Super Visor
        getSuperVisorPosition() {
            console.log(this.supervisor);
            this.supervisorPosition = this.supervisor.position;
            this.supervisor = this.supervisor.name;
        },

        //New Report Here
        validatePrintLoginLogOutSummary() {
            const employeeID = localStorage.getItem("accountId");
            // console.log(employeeID);
            //const empID = this.selectedEmpId;
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
                    permission: "print dtr",
                    model_name: {
                        divisionId: this.divisionId,
                        placeOfWork: this.placeplaceOfWork,
                        month: this.month,
                        year: this.year,
                        prepared: this.prepared,
                        preparedPosition: this.preparedPosition,
                        supervisor: this.supervisor,
                        supervisorPosition: this.supervisorPosition,
                    },
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    parentURL =
                        parentURL +
                        "/generate/report/2/single/bandi-summary/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        validatePrintEmployeeTardiness() {
            const employeeID = localStorage.getItem("accountId");
            // console.log(employeeID);
            //const empID = this.selectedEmpId;
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";
            let options;

            if (this.dateRangeSelection === "monthYear") {
                options = {
                    method: "POST",
                    url: this.baseUrl,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken,
                    },
                    data: {
                        permission: "print dtr",
                        model_name: {
                            placeOfWork: this.placeOfWork,
                            month: this.month,
                            year: this.year,
                            prepared: this.prepared,
                            preparedPosition: this.preparedPosition,
                            supervisor: this.supervisor,
                            supervisorPosition: this.supervisorPosition,
                        },
                    },
                };
            } else {
                options = {
                    method: "POST",
                    url: this.baseUrl,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken,
                    },
                    data: {
                        permission: "print dtr",
                        model_name: {
                            placeplaceOfWork: this.placeOfWork,
                            dateFrom: this.dateFrom,
                            dateTo: this.dateTo,
                            prepared: this.prepared,
                            preparedPosition: this.preparedPosition,
                            supervisor: this.supervisor,
                            supervisorPosition: this.supervisorPosition,
                        },
                    },
                };
            }

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    parentURL =
                        parentURL +
                        "/generate/report/2/single/tardiness-summary/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        validateMonthlyAttendanceReport() {
            const employeeID = localStorage.getItem("accountId");
            // console.log(employeeID);
            //const empID = this.selectedEmpId;
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
                    permission: "print dtr",
                    model_name: {
                        placeOfWork: this.placeOfWork,
                        divisionId: this.divisionId,
                        month: this.month,
                        year: this.year,
                        prepared: this.prepared,
                        preparedPosition: this.preparedPosition,
                        supervisor: this.supervisor,
                        supervisorPosition: this.supervisorPosition,
                    },
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    parentURL =
                        parentURL +
                        "/generate/report/2/single/monthly-attendance/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        validatePrintSummaryOfEmployeeAbsences() {
            const employeeID = localStorage.getItem("accountId");
            // console.log(employeeID);
            //const empID = this.selectedEmpId;
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
                    permission: "print dtr",
                    model_name: {
                        placeOfWork: this.placeOfWork,
                        month: this.month,
                        year: this.year,
                        prepared: this.prepared,
                        preparedPosition: this.preparedPosition,
                        supervisor: this.supervisor,
                        supervisorPosition: this.supervisorPosition,
                    },
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    parentURL =
                        parentURL +
                        "/generate/report/2/single/employee-absences/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getDivNameAndId() {
            this.divisionName = localStorage.getItem("division_name");
            this.divisionId = localStorage.getItem("division_id");
            this.divSearch = !this.divSearch;
        },
    },
    async created() {
        this.isParamLoaded = false;
        await this.getSuggestions();
        this.isParamLoaded = true;
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
