<template>
    <form>
        <md-card>
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

            <md-card-header class="md-card-header">
                <h4 class="title">Employee Alpha List</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-medium-size-100 md-size-100">
                        <md-table md-card>
                            <md-table-toolbar>
                                <!-- <h1 class="md-title"></h1> -->
                            </md-table-toolbar>

                            <md-table-row>
                                <md-table-head>Classification</md-table-head>
                                <md-table-head>Actions</md-table-head>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell>JO / COS</md-table-cell>
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="printJO = !printJO"
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell>Plantilla</md-table-cell>
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printPlantilla = !printPlantilla
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

        <DialogCard v-if="printJO">
            <section slot="header">Print Employee Alpha List - JO</section>
            <section slot="body">
                <form method="post" @submit.prevent="validatePrintJO">
                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionEmployee()"
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
                        @click="printJO = !printJO"
                        >Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <DialogCard v-if="printPlantilla">
            <section slot="header">
                Print Employee Alpha List - Plantilla
            </section>
            <section slot="body">
                <form method="post" @submit.prevent="validatePrintPlantilla">
                    <md-field>
                        <label>Gender</label>
                        <md-select v-model="gender">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="g in filtersInPlantilla.gender"
                                :key="g"
                                :value="g"
                                >{{ g }}</md-option
                            >
                        </md-select>
                    </md-field>

                    <md-field>
                        <label>Employee Group</label>
                        <md-select v-model="employeeGroup">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="eg in employeeGroups"
                                :key="eg.id"
                                :value="eg.id"
                                >{{ eg.code }}</md-option
                            >
                        </md-select>
                    </md-field>

                    <md-datepicker
                        :md-model-type="String"
                        label="Date of Employment"
                        v-model="dateOfEmployment"
                    >
                        <label>Date of Employment</label>
                    </md-datepicker>

                    <md-autocomplete
                        v-model="placeOfWork"
                        :md-options="suggestionPlaceOfWork"
                        required
                    >
                        <label>Place of Work</label>
                    </md-autocomplete>

                    <md-field>
                        <label>Remarks</label>
                        <md-select v-model="remark">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="r in remarks"
                                :key="r.id"
                                :value="r.id"
                                >{{ r.name }}</md-option
                            >
                        </md-select>
                    </md-field>

                    <!-- <md-field>
                        <label>Remarks</label>
                        <md-input
                            v-model="remark"
                            type="text"
                        ></md-input>
                    </md-field> -->

                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionEmployee()"
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
                        @click="printPlantilla = !printPlantilla"
                        >Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Load Parameter-->
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
import LogOut from "../../mixins/logOut.js";
import axios from "axios";
let baseURL = localStorage.getItem("base_url");
let token = localStorage.getItem("token");
export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut],
    name: "EmployeesAlphaList",
    data() {
        return {
            isAuthenticated: true,
            prepared: null,
            preparedPosition: null,
            supervisor: null,
            supervisorPosition: null,

            printJO: false,
            printPlantilla: false,
            suggestions: [],
            suggestionsEmployee: [],
            suggestionsEmployeePosition: [],
            suggestionsSuperVisor: [],
            suggestionHigherSuperVisor: [],

            newSuggesstionEmployee: [],
            filtersInPlantilla: [],
            gender: null,
            employeeGroup: null,
            employeeGroups: [],
            dateOfEmployment: "2021-01-01",
            suggestionPlaceOfWork: null,
            placeOfWork: null,
            remark: null,
            remarks: [],
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

            //Parameter in Token
            await axios
                .request(options)
                .then((response) => {
                    this.suggestionPlaceOfWork = response.data.placeOfWork;
                    this.suggestions = response.data;

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

            //Get Fiilters
            newURL = baseURL + "/api/employee/parameter";
            const newoptions = {
                method: "GET",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(newoptions)
                .then((response) => {
                    console.log(response.data);
                    this.filtersInPlantilla = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });

            //Get Employee Group
            newURL = baseURL + "/api/employee-group/search";
            const employeeGroupOptions = {
                method: "GET",
                url: newURL,
                params: { perPage: "100" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(employeeGroupOptions)
                .then((response) => {
                    this.employeeGroups = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });

            //Get Remarks
            newURL = baseURL + "/api/service-record/parameter";
            const remakrOptions = {
                method: "GET",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(remakrOptions)
                .then((response) => {
                    this.remarks = response.data.remark;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Get Position Employee
        getPositionEmployee() {
            // console.log(this.prepared.name)
            this.preparedPosition = this.prepared.position;
            this.prepared = this.prepared.name;
            // for (let [key, value] of Object.entries(this.suggestionsEmployee)) {
            //     // console.log(value.name)
            //     console.log(this.prepared)
            //     if(value.name === this.prepared){
            //        this.preparedPosition = value.position
            //     }
            // }
        },

        //Get Position Super Visor
        getSuperVisorPosition() {
            console.log(this.supervisor);
            this.supervisorPosition = this.supervisor.position;
            this.supervisor = this.supervisor.name;
        },

        //Validate Print JO
        validatePrintJO() {
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
                    permission: "print employee",
                    model_name: {
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
                    console.log(printToken);

                    //New Tab to generate the PDS
                    parentURL =
                        parentURL + "/generate/report/1/jocos/ea/" + printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        validatePrintPlantilla() {
            //Conditions if null
            if (this.gender === "na") {
                this.gender = null;
            }
            if (this.employeeGroup === "na") {
                this.employeeGroup = null;
            }
            if (this.remark === "na") {
                this.remark = null;
            }
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
                    permission: "print employee",
                    model_name: {
                        remarkId: this.remark,
                        placeOfWork: this.placeOfWork,
                        dateOfEmployment: this.dateOfEmployment,
                        employeeGroupId: this.employeeGroup,
                        gender: this.gender,
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
                    console.log(printToken);

                    //New Tab to generate the PDS
                    parentURL =
                        parentURL +
                        "/generate/report/1/plantilla/ea/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //
    },

    async mounted() {
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
