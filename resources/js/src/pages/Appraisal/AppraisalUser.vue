<template>
    <div>
        <md-card>
            <md-card-content>
                <div class="md-layout">
                    <div
                        class="md-layout-item md-small-size-100 md-size-100"
                    ></div>
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-button
                            class="md-primary md-dense md-raised"
                            @click="
                                (addAppraisal = true), (saveButton = 'Save')
                            "
                            >Add Appraisal</md-button
                        >
                        <!-- <br> -->
                        <div
                            class="md-layout-item md-small-size-100 md-size-25"
                        >
                            <form @submit.prevent="getAppraisals()">
                                <md-field>
                                    <label>Year</label>
                                    <md-input
                                        v-model="year"
                                        type="number"
                                        maxlength="4"
                                        minlength="4"
                                    ></md-input>
                                </md-field>
                            </form>
                        </div>
                        <md-table v-model="appraisals" md-card>
                            <md-table-empty-state
                                md-label="No appraisals found on this employee"
                            >
                                <md-button
                                    class="md-primary md-dense md-raised"
                                    @click="
                                        (addAppraisal = true),
                                            (saveButton = 'Save')
                                    "
                                    >Add Appraisal</md-button
                                >
                            </md-table-empty-state>

                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell md-label="Date">{{
                                    item.date
                                }}</md-table-cell>
                                <md-table-cell md-label="Semester">{{
                                    item.semester
                                }}</md-table-cell>
                                <md-table-cell md-label="Numerical Rating">{{
                                    item.numericRating
                                }}</md-table-cell>
                                <md-table-cell md-label="Adjectival Rating">{{
                                    item.adjectivalRating
                                }}</md-table-cell>
                                <md-table-cell md-label="MFO">
                                    <!-- <md-button
                                        v-if="item.hasMfo === !null"
                                        class="md-raised md-primary md-dense"
                                        >View
                                    </md-button> -->
                                    <md-button
                                        @click="getMFOAppraisal(item.id)"
                                        class="md-raised md-primary md-dense"
                                        >View
                                    </md-button>
                                </md-table-cell>

                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-dense md-primary md-raised"
                                        @click="getAppraisalId(item.id)"
                                        >✎</md-button
                                    >
                                    <!-- <md-button
                                        class="md-danger md-raised"
                                        @click="deleteCollege(index)"
                                        >⌫</md-button
                                    >                                     -->
                                    <md-button
                                        class="md-dense md-danger md-raised"
                                        @click="deleteAppraisal(item.id)"
                                        :disabled="!item.isOkToDelete"
                                        >⌫</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </div>
                    <div class="md-layout-item md-size-100 text-right">
                        <b>5</b> - Outstanding, <b>4</b> - Very Satisfactory,
                        <b>3</b> - Satisfactory, <b>2</b> - Unsatisfactory,
                        <b>1</b> - Poor
                        <!-- <md-button
                            class="md-raised md-primary md-dense"
                            @click="validateUpdateUser"
                            :disabled="!isEdit"
                        >
                            Update User
                        </md-button> -->
                    </div>
                </div>
            </md-card-content>
        </md-card>
        <DialogCard v-if="addAppraisal || editAppraisal">
            <section slot="header" v-if="!editAppraisal">Add Appraisal</section>
            <section slot="header" v-else>Edit Appraisal</section>
            <section slot="body">
                <form>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date"
                        v-model="date"
                    >
                        <label>Date</label>
                    </md-datepicker>
                    <md-field>
                        <label>Semester</label>
                        <md-select v-model="semester">
                            <md-option
                                v-for="s in paramSemester"
                                :value="s"
                                :key="s"
                                >{{ s }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <div v-if="semester === 'OTHERS'">
                        <!-- <md-datepicker
                            :md-model-type="String"
                            label="Date From"
                            v-model="dateFrom"
                        >
                            <label>Date From</label>
                        </md-datepicker>
                        <md-datepicker
                            :md-model-type="String"
                            label="Date To"
                            v-model="dateTo"
                        >
                            <label>Month</label>
                        </md-datepicker> -->
                        <md-field>
                            <label>Select Month From</label>
                            <md-select v-model="monthFrom">
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
                            <label>Select Month To</label>
                            <md-select v-model="monthTo">
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
                            <label>Remarks</label>
                            <md-input v-model="remarks" type="text"></md-input>
                        </md-field>
                    </div>
                    <!-- <md-field>
                        <label>Adjectival Rating</label>
                        <md-select v-model="adjectivalRating">
                            <md-option
                                v-for="a in paramAdjectivalRating"
                                :value="a"
                                :key="a"
                                >{{ a }}</md-option
                            >
                        </md-select>
                    </md-field> -->
                    <md-dialog-actions>
                        <md-button
                            v-if="!editAppraisal"
                            class="md-dense md-primary md-raised"
                            @click="saveAppraisal()"
                            :disabled="isSaving"
                            >{{ saveButton }}</md-button
                        >
                        <md-button
                            v-else
                            class="md-dense md-primary md-raised"
                            @click="updateAppraisal()"
                            :disabled="isSaving"
                            >{{ saveButton }}</md-button
                        >
                        <md-button
                            class="md-dense md-danger md-raised"
                            @click="
                                (addAppraisal = false), (editAppraisal = false)
                            "
                            >Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- View MFO -->
        <DialogCard v-if="viewMFO">
            <section slot="header">MFO</section>
            <section slot="body">
                <b>Overall Average Rating: </b> {{ numericRatingStatus }}
                <b>Overall Adjectival Rating: </b> {{ adjectivalRatingStatus }}
                <br />
                <md-button
                    class="md-dense md-primary md-raised"
                    @click="(addMFO = true), resetMFOParameters()"
                    >Add Mfo</md-button
                >
                <table class="zui-table">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Quality Rating</th>
                            <th>Efficiency Rating</th>
                            <th>Timeliness Rating</th>
                            <th>Average Rating</th>
                            <th>Adjectival Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="mfo.length === 0">
                        <tr>
                            <td colspan="9">
                                <center>
                                    No MFO records found in this appraisal.
                                    Please add one.
                                </center>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr v-for="item in mfo" :key="item.id">
                            <td>{{ item.number }}</td>
                            <td>{{ item.title }}</td>
                            <td>{{ item.description }}</td>
                            <td>{{ item.Q }}</td>
                            <td>{{ item.E }}</td>
                            <td>{{ item.T }}</td>
                            <td>{{ item.averageRating }}</td>
                            <td>{{ item.adjectivalRating }}</td>
                            <td>
                                <md-button
                                    class="md-dense md-primary"
                                    style="float: right"
                                    @click="
                                        editMFOGetRecord(
                                            item.number,
                                            item.title,
                                            item.description,
                                            item.Q,
                                            item.E,
                                            item.T,
                                            item.id
                                        )
                                    "
                                    >✎</md-button
                                >
                                <md-button
                                    class="md-dense md-danger"
                                    style="float: right"
                                    @click="deleteMFO(item.id)"
                                    >⌫</md-button
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
                <md-dialog-actions>
                    <md-button
                        class="md-dense md-danger md-raised"
                        @click="viewMFO = false"
                        >Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <DialogCard v-if="addMFO || editMFO">
            <section slot="header" v-if="!editMFO">Add MFO</section>
            <section slot="header" v-else>Edit MFO</section>
            <section slot="body">
                <form>
                    <md-field>
                        <label>ID Number</label>
                        <md-input v-model="mfoNumber" type="text"></md-input>
                    </md-field>
                    <md-field>
                        <label>Title</label>
                        <md-input v-model="mfoTitle" type="text"></md-input>
                    </md-field>
                    <md-field>
                        <label>Description</label>
                        <md-textarea
                            v-model="mfoDescription"
                            type="text"
                        ></md-textarea>
                    </md-field>
                    <div>
                        Quality Rating<br />
                        <md-radio v-model="mfoQ" :value="null">N/A</md-radio>
                        <md-radio v-model="mfoQ" :value="1">1</md-radio>
                        <md-radio v-model="mfoQ" :value="2">2</md-radio>
                        <md-radio v-model="mfoQ" :value="3">3</md-radio>
                        <md-radio v-model="mfoQ" :value="4">4</md-radio>
                        <md-radio v-model="mfoQ" :value="5">5</md-radio>
                    </div>
                    <div>
                        Efficiency Rating<br />
                        <md-radio v-model="mfoE" :value="null">N/A</md-radio>
                        <md-radio v-model="mfoE" :value="1">1</md-radio>
                        <md-radio v-model="mfoE" :value="2">2</md-radio>
                        <md-radio v-model="mfoE" :value="3">3</md-radio>
                        <md-radio v-model="mfoE" :value="4">4</md-radio>
                        <md-radio v-model="mfoE" :value="5">5</md-radio>
                    </div>
                    <div>
                        Timeliness Rating<br />
                        <md-radio v-model="mfoT" :value="null">N/A</md-radio>
                        <md-radio v-model="mfoT" :value="1">1</md-radio>
                        <md-radio v-model="mfoT" :value="2">2</md-radio>
                        <md-radio v-model="mfoT" :value="3">3</md-radio>
                        <md-radio v-model="mfoT" :value="4">4</md-radio>
                        <md-radio v-model="mfoT" :value="5">5</md-radio>
                    </div>
                </form>
                <md-dialog-actions>
                    <md-button
                        v-if="!editMFO"
                        class="md-dense md-primary md-raised"
                        @click="saveMFO()"
                        :disabled="isSaving"
                        >{{ saveButton }}</md-button
                    >
                    <md-button
                        v-else
                        class="md-dense md-primary md-raised"
                        @click="updateMFO()"
                        :disabled="isSaving"
                        >{{ saveButton }}</md-button
                    >
                    <md-button
                        class="md-dense md-danger md-raised"
                        @click="(addMFO = false), (editMFO = false)"
                        >Cancel</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <DialogCard v-if="isDeleteAppraisal">
            <section slot="header">Delete Appraisal Record?</section>
            <section slot="body">
                <form>
                    You cannot undo the changes once deleted. Continue?
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary md-raised"
                            @click="validateDeleteAppraisal()"
                            :disabled="isDeleting"
                            >{{ deleteButton }}</md-button
                        >
                        <md-button
                            class="md-dense md-danger md-raised"
                            @click="isDeleteAppraisal = false"
                            >Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <DialogCard v-if="isDeleteMFO">
            <section slot="header">Delete MFO Appraisal Record?</section>
            <section slot="body">
                <form>
                    You cannot undo the changes once deleted. Continue?
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary md-raised"
                            @click="validateDeleteMFO()"
                            :disabled="isDeleting"
                            >{{ deleteButton }}</md-button
                        >
                        <md-button
                            class="md-dense md-danger md-raised"
                            @click="isDeleteMFO = false"
                            >Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <md-snackbar
            :md-position="'center'"
            :md-duration="2000"
            :md-active.sync="fireSnackBar"
            md-persistent
        >
            <span>{{ snackBarMessage }}</span>
            <md-button
                class="md-warning md-dense"
                @click="fireSnackBar = false"
            >
                <label style="color: black">Dismiss</label>
            </md-button>
        </md-snackbar>
    </div>
</template>
<script>
import axios from "axios";
import userAction from "../../mixins/userAction.js";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
export default {
    emits: ["close-dialog"],
    name: "AppraisalUser",
    mixins: [userAction],
    components: {
        DialogCard,
    },
    data() {
        return {
            employee_name: null,
            fireSnackBar: false,
            snackBarMessage: "",

            employeeId: localStorage.getItem("user_id"),

            addAppraisal: false,
            editAppraisal: false,
            appraisals: [],
            date: null,
            monthFrom: null,
            monthTo: null,
            remarks: null,
            paramSemester: null,
            paramAdjectivalRating: null,
            semester: null,
            adjectivalRating: null,
            appraisalId: null,

            //MFO
            viewMFO: false,
            addMFO: false,
            mfo: [],
            mfoId: null,
            mfoNumber: null,
            mfoTitle: null,
            mfoDescription: null,
            mfoQ: null,
            mfoE: null,
            mfoT: null,
            editMFO: false,
            isDeleteMFO: false,

            //Stats
            numericRatingStatus: 0,
            adjectivalRatingStatus: "Not Applicable",

            //UI
            perPage: 100,
            year: null,
            saveButton: "Save",
            isSaving: false,
            isDeleteAppraisal: false,
            deleteButton: "Confirm Deletion",
            isDeleting: false,
        };
    },
    methods: {
        //Get user information
        async getUserInformation() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/user/search/" + this.employeeId;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.callAxios(options);
            console.log(resp);
            this.employee_name = resp.data.employee_name;

            await this.getAppraisals();
        },

        //Get Appraisals
        async getAppraisals() {
            // this.fireSnackBar = true;
            // this.snackBarMessage = "Searching Employee Appraisal. Please wait";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                params: { perPage: this.perPage, year: this.year },
                url: baseUrl + "/api/appraisal/search/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.appraisals = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
            // this.fireSnackBar = false;
        },

        //Save Appraisals
        async saveAppraisal() {
            this.saveButton = "Saving...";
            this.isSaving = true;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "POST",
                url: baseUrl + "/api/appraisal/create/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    date: this.date,
                    monthFrom: this.monthFrom,
                    monthTo: this.monthTo,
                    remarks: this.remarks,
                    semester: this.semester,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Appraisal saved successfully!";
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });
            await this.getAppraisals();
            this.saveButton = "Save";
            this.isSaving = false;
            this.addAppraisal = false;
        },

        //Get Appraisal Record / Edit
        async getAppraisalId(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            this.appraisalId = id;
            this.saveButton = "Update";
            const options = {
                method: "GET",
                params: { perPage: this.perPage, year: this.year },
                url:
                    baseUrl +
                    "/api/appraisal/search/" +
                    this.employeeId +
                    "/" +
                    id,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.date = response.data.date;
                    this.monthFrom = response.data.monthFrom;
                    this.monthTo = response.data.monthTo;
                    this.remarks = response.data.remarks;
                    this.semester = response.data.semester;
                    this.editAppraisal = true;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Validate Update Appraisal
        async updateAppraisal() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            this.saveButton = "Updating...";
            this.isSaving = true;
            const options = {
                method: "PUT",
                url: baseUrl + "/api/appraisal/update/" + this.appraisalId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    date: this.date,
                    monthFrom: this.monthFrom,
                    monthTo: this.monthTo,
                    remarks: this.remarks,
                    semester: this.semester,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Appraisal has been updated!";
                })
                .catch((error) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage =
                        "There is an error processing the requeset. Please try agian.";
                });

            await this.getAppraisals();
            this.editAppraisal = false;
            this.saveButton = "Save";
            this.isSaving = false;
        },

        //Initiate Delete
        deleteAppraisal(id) {
            this.appraisalId = id;
            this.isDeleteAppraisal = true;
            this.deleteButton = "Confirm Deletion";
            this.isDeleting = false;
        },

        //Validate Delete Appraisal
        async validateDeleteAppraisal() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            this.deleteButton = "Deleting...";
            this.isDeleting = true;
            const options = {
                method: "DELETE",
                url: baseUrl + "/api/appraisal/delete/" + this.appraisalId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Appraisal has been deleted!";
                })
                .catch((error) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage =
                        "There is an error processing the requeset. Please try agian.";
                });

            await this.getAppraisals();
            this.deleteButton = "Delete";
            this.isDeleting = false;
            this.isDeleteAppraisal = false;
        },

        //Get MFO in Appraisals
        async getMFOAppraisal(id) {
            this.mfo = [];
            this.appraisalId = id;
            this.viewMFO = true;

            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                params: { perPage: this.perPage },
                url: baseUrl + "/api/appraisal/mfo/search/" + this.appraisalId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.mfo = response.data.data;
                    // console.log(this.mfo.length)
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackBar = true;
                    this.snackBarMessage = error.response.data.message;
                });

            await this.getStatus(id);
        },

        //Save MFO
        async saveMFO() {
            this.saveButton = "Saving...";
            this.isSaving = true;

            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            const options = {
                method: "POST",
                url: baseUrl + "/api/appraisal/mfo/create/" + this.appraisalId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    number: this.mfoNumber,
                    title: this.mfoTitle,
                    description: this.mfoDescription,
                    Q: this.mfoQ,
                    E: this.mfoE,
                    T: this.mfoT,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "MFO entry has been added!";
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackBar = true;
                    this.snackBarMessage = error.response.data.message;
                });

            await this.getMFOAppraisal(this.appraisalId);
            this.saveButton = "Save";
            this.isSaving = false;
            this.addMFO = false;
            this.editMFO = false;
        },

        //Validate Update MFO
        async updateMFO() {
            this.isSaving = true;
            this.saveButton = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "PUT",
                url: baseUrl + "/api/appraisal/mfo/update/" + this.mfoId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    number: this.mfoNumber,
                    title: this.mfoTitle,
                    description: this.mfoDescription,
                    Q: this.mfoQ,
                    E: this.mfoE,
                    T: this.mfoT,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "MFO entry has been updated!";
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackBar = true;
                    this.snackBarMessage = error.response.data.message;
                });
            await this.getMFOAppraisal(this.appraisalId);
            this.isSaving = false;
            this.saveButton = "Save";
            this.addMFO = false;
            this.editMFO = false;
        },

        //Edit MFO
        editMFOGetRecord(number, title, description, Q, E, T, id) {
            this.mfoId = id;
            this.mfoNumber = number;
            this.mfoTitle = title;
            this.mfoDescription = description;
            this.mfoQ = Q;
            this.mfoE = E;
            this.mfoT = T;
            this.editMFO = true;
            this.saveButton = "Update";
        },

        //Delete MFO
        deleteMFO(id) {
            this.mfoId = id;
            this.isDeleteMFO = true;
            this.deleteButton = "Confirm Deletion";
            this.isDeleting = false;
        },

        //Validate Delete MFO
        async validateDeleteMFO() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            this.deleteButton = "Deleting...";
            this.isDeleting = true;

            const options = {
                method: "DELETE",
                url: baseUrl + "/api/appraisal/mfo/delete/" + this.mfoId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "MFO has been deleted!";
                })
                .catch((error) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage =
                        "There is an error processing the request. Please try again.";
                });

            await this.getMFOAppraisal(this.appraisalId);
            this.deleteButton = "Delete";
            this.isDeleting = false;
            this.isDeleteMFO = false;
        },

        //Get Status
        async getStatus(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                url: baseUrl + "/api/appraisal/stats/" + id,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response);
                    this.numericRatingStatus = response.data.numericRating;
                    this.adjectivalRatingStatus =
                        response.data.adjectivalRating;
                })
                .catch((error) => {});
        },
        //Get Parameters
        async getParams() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                url: baseUrl + "/api/appraisal/parameter/",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.paramSemester = response.data.semester;
                    this.paramAdjectivalRating = response.data.adjectivalRating;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        resetMFOParameters() {
            this.mfoNumber = null;
            this.mfoTitle = null;
            this.mfoQ = null;
            this.mfoE = null;
            this.mfoT = null;
            this.mfoDescription = null;
        },

        //Call Axios
        async callAxios(options) {
            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    resp = error;
                });
            return resp;
        },
    },
    async created() {
        await this.getParams();
        let searchUser = localStorage.getItem("search_user");
        if (searchUser === "0") {
            //Do nothing
        } else {
            await this.getUserInformation();
        }
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
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
