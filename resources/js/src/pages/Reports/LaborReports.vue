<template>
    <form>
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Labor Reports</h4>
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
                                    >Summary of Appraisal</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryOfAppraiasal =
                                                !printSummaryOfAppraiasal
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell>Summary of Awards</md-table-cell>
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryOfAwards =
                                                !printSummaryOfAwards
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Summary of Offenses</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryOfOffenses =
                                                !printSummaryOfOffenses
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

        <!-- -->
        <!-- Summary of Appraisal -->
        <DialogCard v-if="printSummaryOfAppraiasal">
            <section slot="header">Summary of Appraisal</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validateSummaryOfAppraisal()"
                >
                    <md-field>
                        <label>Year</label>
                        <md-input
                            v-model="year"
                            type="number"
                            maxlength="4"
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

                    <md-field>
                        <label>Prepared Position</label>
                        <md-input
                            v-model="preparedPosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="noted"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionNoted()"
                        required
                    >
                        <label>Noted</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>
                    <md-field>
                        <label>Noted Position</label>
                        <md-input
                            v-model="notedPosition"
                            type="text"
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printSummaryOfAppraiasal = !printSummaryOfAppraiasal
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <DialogCard v-if="printSummaryOfAwards">
            <section slot="header">Summary of Awards</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateSummaryOfAwards()">
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
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="noted"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionNoted()"
                        required
                    >
                        <label>Noted</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>
                    <md-field>
                        <label>Noted Position</label>
                        <md-input
                            v-model="notedPosition"
                            type="text"
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="printSummaryOfAwards = !printSummaryOfAwards"
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <DialogCard v-if="printSummaryOfOffenses">
            <section slot="header">Summary of Offenses</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validateSummaryOfOffenses()"
                >
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
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="noted"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionNoted()"
                        required
                    >
                        <label>Noted</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>
                    <md-field>
                        <label>Noted Position</label>
                        <md-input
                            v-model="notedPosition"
                            type="text"
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printSummaryOfOffenses = !printSummaryOfOffenses
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>
        <!-- -->

        <!-- Select Single Employee -->
        <DialogCard v-if="isSelectEmployee">
            <section slot="header">Select Employee</section>
            <section slot="body">
                <md-table
                    v-model="employees"
                    md-sort="name"
                    md-sort-order="asc"
                    md-card
                    @md-selected="onSelect"
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
                        md-selectable="single"
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
                        <md-table-cell md-label="Name" md-sort-by="name"
                            >{{ item.first_name }} {{ item.middle_name }}
                            {{ item.last_name }}
                            {{ item.name_extension }}</md-table-cell
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
                <md-button
                    class="md-raised md-primary"
                    @click="changeCurrentEmployeeSelection()"
                    v-if="isSelected"
                >
                    Confirm
                </md-button>
                <md-dialog-actions>
                    <md-button
                        class="md-dense md-danger"
                        @click="isSelectEmployee = !isSelectEmployee"
                        >✕ Close</md-button
                    >
                </md-dialog-actions>
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

        <!-- Dialog Card for getting parameters -->
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
// const ListDivision = () =>
//     import(
//         /* webpackChunkName: "ListDivision" */ "../../pages/Positions/ListDivision.vue"
//     );
document.getElementsByClassName("md-input").disabled = true;

import LogOut from "../../mixins/logOut.js";
import axios from "axios";
let baseURL = localStorage.getItem("base_url");
let token = localStorage.getItem("token");
export default {
    components: {
        DialogCard,
        // ListDivision,
    },
    mixins: [LogOut],
    name: "LaborReports",
    data() {
        return {
            isSelectEmployee: false,
            employees: [],

            //Summary of Appraisal
            year: null,
            noted: null,
            notedPosition: null,
            printSummaryOfAppraiasal: false,

            //Summary of Awards
            printSummaryOfAwards: false,

            //Summary of Offenses
            printSummaryOfOffenses: false,

            isAuthenticated: true,

            prepared: null,
            preparedPosition: null,
            supervisor: null,
            supervisorPosition: null,
            supervisorDivision: null,
            printEmployeeTardiness: false,
            placeOfWork: null,

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
                division: suggestionsSuperVisors.division,
                toLowerCase: () => suggestionsSuperVisors.name.toLowerCase(),
                toString: () => suggestionsSuperVisors.name,
            }));
        },
    },
    methods: {
        //Print
        async validateSummaryOfAppraisal() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print appraisal",
                    model_name: {
                        year: this.year,
                        prepared: this.prepared,
                        preparedPosition: this.preparedPosition,
                        noted: this.noted,
                        notedPosition: this.notedPosition,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/5/single/appraisal-summary/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async validateSummaryOfAwards() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print award",
                    model_name: {
                        prepared: this.prepared,
                        preparedPosition: this.preparedPosition,
                        noted: this.noted,
                        notedPosition: this.notedPosition,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/5/single/award-summary/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async validateSummaryOfOffenses() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print offense",
                    model_name: {
                        prepared: this.prepared,
                        preparedPosition: this.preparedPosition,
                        noted: this.noted,
                        notedPosition: this.notedPosition,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/5/single/offense-summary/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        //Print
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
                    this.divisions = response.data.divisionId;
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
            let newPrepared = this.prepared;
            this.prepared = newPrepared.name;
            this.preparedPosition = newPrepared.position;
        },
        //Get Position Noted
        getPositionNoted() {
            let newNoted = this.noted;
            this.noted = newNoted.name;
            this.notedPosition = newNoted.position;
        },
        //Get Position Super Visor
        getSuperVisorPosition() {
            this.supervisorPosition = this.supervisor.position;
            this.supervisor = this.supervisor.name;
        },

        //Get Division Super Visor
        getSuperVisorDivision() {
            this.supervisorDivision = this.supervisor.division;
            this.supervisor = this.supervisor.name;
        },

        //Get Supervisor Position and Division
        getSuperVisorPositionDivision() {
            this.supervisorPosition = this.supervisor.position;
            this.supervisorDivision = this.supervisor.division;
            this.supervisor = this.supervisor.name;
        },
        getThroughDivisionPosition() {
            this.throughPosition = this.through.position;
            this.throughDivision = this.through.division;
            this.through = this.through.name;
        },
        getSignedPositionDivision() {
            this.signedDivision = this.signed.position;
            this.signedPosition = this.signed.division;
            this.signed = this.signed.name;
        },

        //Search Employee
        async searchEmployee() {
            this.isSearching = true;
            this.searchBtnName = "Searching";
            const options = {
                method: "GET",
                url: baseURL + "/api/token/employees/parameter",
                params: { searchValue: this.searchValue, perPage: "10" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.employees = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isSearching = false;
            this.searchBtnName = "Search";
        },

        //event on selection of employee
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                this.employeeId = item.id;
                this.isSelected = true;
            }
        },
        //Select Employee
        async changeCurrentEmployeeSelection() {
            this.isSelectEmployee = false;
            this.isParamLoaded = false;
            const options = {
                method: "GET",
                url: baseURL + "/api/token/report/parameter/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.employeeName = response.data.self.employee.name;
                    this.employeePosition =
                        response.data.self.employee.position;
                    this.employeeDivision =
                        response.data.self.employee.division;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isParamLoaded = true;
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
