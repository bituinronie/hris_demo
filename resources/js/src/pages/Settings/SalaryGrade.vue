<template>
    <form>
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
        <DialogCard v-if="isAddingTranche">
            <section slot="body">
                Confirm addition of tranche.
                <md-dialog-actions>
                    <md-button
                        @click="addTranche"
                        class="md-dense md-primary"
                        :disabled="isConfirmingAddingTranche"
                    >
                        {{ addTranceBtnMesage }}
                    </md-button>
                    <md-button
                        @click="isAddingTranche = false"
                        class="md-dense md-danger"
                        :disabled="isConfirmingAddingTranche"
                    >
                        Cancel
                    </md-button>
                </md-dialog-actions>
            </section>
        </DialogCard>

        <DialogCard v-if="isAddingSalaryGrade">
            <section slot="body">
                <form method="post" @submit.prevent="addSg">
                    <md-field>
                        <label>Salary Grade</label>
                        <md-input
                            v-model="salaryGrade"
                            type="number"
                            required
                        ></md-input>
                    </md-field>
                    <label
                        >Step (The current steps stored in this tranche is
                        {{ maxStep.step }}. Please put the step not more than
                        {{ maxStepWhenAdding }} )</label
                    >
                    <md-field>
                        <label>Steps</label>
                        <md-input
                            v-model="sgStep"
                            type="number"
                            min="1"
                            :max="maxStepWhenAdding"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Salary</label>
                        <md-input
                            v-model="sgSalary"
                            type="number"
                            required
                        ></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary"
                            type="submit"
                            :disabled="isConfirmingAddingSalaryGrade"
                        >
                            {{ addSgBtnMessage }}
                        </md-button>
                        <md-button
                            @click="isAddingSalaryGrade = false"
                            class="md-dense md-danger"
                            :disabled="isConfirmingAddingSalaryGrade"
                        >
                            Cancel
                        </md-button>
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
        <md-dialog-alert
            :md-active.sync="isDeleted"
            :md-content="notificationMessage"
            md-confirm-text="Okay"
        />
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Salary Grade</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-field>
                            <label>Tranches</label>
                            <md-select
                                v-model="currentTrancheSelection"
                                @md-selected="checkTrancheSelection"
                            >
                                <md-option
                                    v-for="t in tranche"
                                    :key="t"
                                    :value="t"
                                    >Tranche {{ t }}</md-option
                                >
                            </md-select>
                            <md-button
                                @click="isAddingTranche = true"
                                class="md-dense"
                                v-if="
                                    $permissions.includes('write salary grade')
                                "
                            >
                                + Tranche
                            </md-button>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <!-- {{salaryGradeTrancheDisplay}} -->
                        <table class="zui-table" v-if="isTrancheSelected">
                            <thead>
                                <tr>
                                    <th>Salary Grade</th>
                                    <th
                                        v-for="step in maxStep.step"
                                        :key="step"
                                    >
                                        Step {{ step }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        value, index, key
                                    ) in salaryGradeTrancheDisplay.salary_grade"
                                    :key="key"
                                >
                                    <td>{{ index }}</td>
                                    <td
                                        v-for="step in maxStep.step"
                                        :key="step"
                                    >
                                        <!-- <span>{{value[step]}}</span> -->
                                        <span>{{
                                            value[step]
                                                ? value[step].salary
                                                : "0"
                                        }}</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Salary Grade</th>
                                    <th
                                        v-for="step in maxStep.step"
                                        :key="step"
                                    >
                                        Step {{ step }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        <!-- <md-table v-model="salaryGradeTrancheDisplay" md-card>
                            <md-table-toolbar>
                                <h1 class="md-title">Salary Grade</h1>
                            </md-table-toolbar>
                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell md-label="Salary Grade">
                                    <span>{{item.salary_grade}}</span>
                                    <md-field>
                                        <md-input v-model="item.salary_grade" disabled></md-input>
                                    </md-field>
                                </md-table-cell>

                                <template v-for="step in maxStep.step">
                                    <md-table-cell :md-label="'Step ' +step" :key="step.id">
                                        <md-field>
                                            <md-input v-if="step == item.step" v-model="item.salary" disabled></md-input>
                                        </md-field>
                                    </md-table-cell>
                                </template>
                                </md-table-row>
                        </md-table> -->
                    </div>
                    <div class="md-layout-item md-size-100 text-right"></div>
                </div>
                <md-button
                    @click="isAddingSalaryGrade = true"
                    class="md-dense md-primary md-raised"
                    style="float: right !important"
                    :disabled="!isTrancheSelected"
                    v-if="$permissions.includes('write salary grade')"
                >
                    Add / modify Salary Grade
                </md-button>
                <br />

                <!-- Active Tranche -->
                <div
                    class="md-layout-item md-small-size-100 md-size-100"
                    style="
                        margin-top: 100px !important;
                        margin-bottom: 20px !important;
                    "
                >
                    <h5>Modify Active Tranche Record</h5>
                </div>

                <!-- Active Component -->
                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field>
                        <label>Active Tranche Record</label>
                        <md-input
                            type="number"
                            v-model="activeTranche"
                            :disabled="!isEditActiveTranche"
                        >
                        </md-input>
                        <md-button
                            class="md-raised md-primary"
                            :disabled="!isEditActiveTranche"
                            @click="updateActiveTranche()"
                            v-if="$permissions.includes('write setting')"
                            >{{ btnActiveTrance }}</md-button
                        >
                        <md-button
                            v-if="
                                !isEditActiveTranche &&
                                $permissions.includes('write setting')
                            "
                            class="md-raised md-warning"
                            style="color: black !important"
                            @click="isEditActiveTranche = true"
                            >Edit</md-button
                        >
                        <md-button
                            v-else
                            class="md-raised md-danger"
                            @click="isEditActiveTranche = false"
                            >Cancel</md-button
                        >
                    </md-field>
                </div>
            </md-card-content>
        </md-card>
        <md-snackbar
            :md-position="'center'"
            :md-duration="4000"
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
    </form>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../../components/Cards/DialogCard.vue";
import LogOut from "../../mixins/logOut.js";
import axios from "axios";
let baseUrl = localStorage.getItem("base_url");
let token = localStorage.getItem("token");
export default {
    mixins: [LogOut],
    components: {
        DialogCard,
    },
    data() {
        return {
            stepsArr: [],
            maxStep: [1],
            maxStepWhenAdding: 2,
            salaryGrade: null,
            sgStep: null,
            sgSalary: null,
            currentTrancheSelection: null,
            currentTrancheLength: null,
            tranche: [],
            salaryGradeTranche: [],
            isUpdating: false,
            btnMessage: "Add Experience",
            isDeleted: false,
            notificationMessage: null,
            isEdit: false,
            updateId: null,
            isAuthenticated: true,

            isAddingTranche: false,
            addTranceBtnMesage: "Confirm Add Tranche",
            isConfirmingAddingTranche: false,

            isAddingSalaryGrade: false,
            addSgBtnMessage: "Add / Update Salary Grade",
            isConfirmingAddingSalaryGrade: false,
            salaryGradeTrancheDisplay: { salary_grade: {} },
            isTrancheSelected: false,

            //Tranche Record - Set Active or not
            activeTranche: null,
            isEditActiveTranche: false,
            btnActiveTrance: "Update",

            fireSnackbar: false,
            messageSnackbar: null,
        };
    },
    methods: {
        //Get Active Tranche
        async getActiveTranche() {
            let newURL = baseUrl + "/api/setting/ACTIVE_TRANCHE";
            const options = {
                method: "GET",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    this.activeTranche = response.data.message;
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error getting the report address. Please refresh the page";
                });
        },

        //Update Active Tranche
        async updateActiveTranche() {
            this.isEditActiveTranche = false;
            this.btnActiveTrance = "Updating...";
            let newURL = baseUrl + "/api/setting/ACTIVE_TRANCHE";
            const options = {
                method: "PUT",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: { value: this.activeTranche },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Setting the active tranche has been completed.";
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error setting the active tranche. Please try again.";
                });
            await this.getActiveTranche();
            this.btnActiveTrance = "Update";
        },

        //Add Tranche
        async addTranche() {
            this.isUpdating = true;
            this.addTranceBtnMesage = "Adding Tranche...";
            this.isConfirmingAddingTranche = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            let newTranche = this.currentTrancheLength + 1;
            this.baseUrl =
                this.baseUrl + "/api/salary-grade/create/" + newTranche;

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: [{ salary_grade: 1, step: 1, salary: 1 }],
            };

            await this.axiosRequest(options);
            await this.getParam();
            this.isUpdating = false;
            this.isDeleted = true;
            this.isAddingTranche = false;
            this.addTranceBtnMesage = "Confirm Add Tranche";
            this.isConfirmingAddingTranche = false;
            this.notificationMessage = "New tranche has been added";
        },

        //Add salary grade
        async addSg() {
            this.isUpdating = true;
            this.addSgBtnMesage = "Adding Salary Grade...";
            this.isConfirmingAddingSalaryGrade = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/salary-grade/create/" +
                this.currentTrancheSelection;

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    salary_grade: {
                        salary_grade: this.salaryGrade,
                        salary: this.sgSalary,
                        step: this.sgStep,
                    },
                },
            };

            this.salaryGradeTranche.push({
                salary_grade: this.salaryGrade,
                salary: this.sgSalary,
                step: this.sgStep,
            });

            await this.axiosRequest(options);
            await this.getParam();
            this.isUpdating = false;
            this.isDeleted = true;
            this.isAddingSalaryGrade = false;
            this.addSgBtnMesage = "Add / Update Salary Grade";
            this.isConfirmingAddingSalaryGrade = false;
            this.notificationMessage =
                "Information has been recorded successfully!";
            await this.getTrancheRecords(this.currentTrancheSelection);
            // ...
            (this.salaryGrade = ""), (this.sgStep = ""), (this.sgSalary = "");
        },

        //Get Tranches
        async getParam() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/salary-grade/parameter";
            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer" + getToken,
                },
            };

            let param = await this.axiosRequest(options);
            this.tranche = param.data.tranche;

            //Remove Duplicates
            let chars = this.tranche;
            let uniqueChars = [...new Set(chars)];
            this.tranche = uniqueChars;

            this.currentTrancheLength =
                param.data.tranche[param.data.tranche.length - 1];
        },

        //Get Tranche Records
        async getTrancheRecords(tranche) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/salary-grade/search/" +
                tranche +
                "?perPage=10000";
            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let trancheRecord = await this.axiosRequest(options);
            console.log(trancheRecord.data.data);
            /* Use this to format the number to currency */
            for (var i in trancheRecord.data.data) {
                for (var k in trancheRecord.data.data[i]) {
                    if (k == "salary") {
                        // console.log(trancheRecord.data.data[i][k]);
                        let currentSalary = trancheRecord.data.data[i][k];
                        currentSalary = currentSalary.toFixed(2);
                        currentSalary = Number(currentSalary).toLocaleString();
                        console.log(currentSalary);
                        // trancheRecord.data.data[i][k] = parseFloat(currentSalary.toString().replace(/,/g, ''));
                        trancheRecord.data.data[i][k] = currentSalary;
                    }
                }
            }
            /* Use this to format the number to currency */

            this.salaryGradeTranche = trancheRecord.data.data;
            var keys = Object.keys(this.salaryGradeTranche);
            // Steps
            for (let i = 0; i < keys.length; i++) {
                var steps = {
                    step: this.salaryGradeTranche[i].step,
                };
                this.stepsArr.push(steps);
            }

            // Max step
            this.maxStep = this.stepsArr.reduce((a, b) =>
                Number(a.step) > Number(b.step) ? a : b
            );
            console.log(this.maxStep);
            console.log(this.salaryGradeTranche);
            let keysInSGTranche = Object.values(this.salaryGradeTranche);
            this.salaryGradeTrancheDisplay.salary_grade = {};
            for (const key of keysInSGTranche) {
                if (
                    this.salaryGradeTrancheDisplay.salary_grade[
                        key.salary_grade
                    ] === undefined
                ) {
                    this.salaryGradeTrancheDisplay.salary_grade[
                        key.salary_grade
                    ] = {};
                    this.salaryGradeTrancheDisplay.salary_grade[
                        key.salary_grade
                    ][key.step] = key;
                } else {
                    let currentSalaryGrade = key.salary_grade;
                    if (key.salary_grade === currentSalaryGrade) {
                        this.salaryGradeTrancheDisplay.salary_grade[
                            key.salary_grade
                        ][key.step] = key;
                    }
                }
            }
            console.log(this.salaryGradeTrancheDisplay);

            //Set Max Step
            this.maxStepWhenAdding = this.maxStep.step + 1;
            console.log(this.maxStepWhenAdding);
            // console.log(maxStep);
            // console.log(this.stepsArr)
            // console.log(this.salaryGradeTranche)
            // this.salaryGradeTranche.salary = parseFloat(this.salaryGradeTranche.salary.replace(/,/g, ''));
            // console.log(this.salaryGradeTranche.salary);
            // console.log(this.salaryGradeTranche);
        },

        //Check Current Selection
        checkTrancheSelection() {
            this.stepsArr = [];
            (this.isTrancheSelected = true),
                this.getTrancheRecords(this.currentTrancheSelection);
        },

        //Call Axios
        async axiosRequest(options) {
            let getResp;
            await axios
                .request(options)
                .then((response) => {
                    getResp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
            return getResp;
        },
    },
    async created() {
        await this.getParam();
        await this.getActiveTranche();
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

.md-table-sortable-icon {
    display: none !important;
}
.zui-table {
    border: solid 1px #ddeeee;
    border-collapse: collapse;
    border-spacing: 0;
    font: normal 13px Arial, sans-serif;
    width: 100% !important;
}
.zui-table thead th {
    background-color: #032278;
    border: solid 1px white;
    color: white !important;
    padding: 10px;
    text-align: left;
}
.zui-table tfoot th {
    background-color: #032278;
    border: solid 1px white;
    color: white !important;
    padding: 10px;
    text-align: left;
}
.zui-table tbody td {
    border: solid 1px #ddeeee;
    color: #333;
    padding: 10px;
}
</style>
