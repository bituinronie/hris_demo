<template>
    <div>
        <md-card>
            <md-card-content>
                <div class="md-layout">
                    <div
                        class="md-layout-item md-small-size-100 md-size-100"
                    ></div>
                    <div class="md-layout-item md-small-size-100 md-size-20">
                        <!-- <br>    -->
                        <md-button
                            class="md-primary md-dense md-raised"
                            @click="
                                (addOffense = true),
                                    (saveButton = 'Save'),
                                    resetOffenseParameter()
                            "
                            >Add Offense</md-button
                        >
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-20">
                        <md-field>
                            <label>Per Page</label>
                            <md-select
                                v-model="perPage"
                                @md-selected="getOffense()"
                            >
                                <md-option :value="5">5 per page</md-option>
                                <md-option :value="10">10 per page</md-option>
                                <md-option :value="20">20 per page</md-option>
                                <md-option :value="31">31 per page</md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-table v-model="offenses" md-card>
                            <md-table-empty-state
                                md-label="No offense found for this employee"
                            >
                                <md-button
                                    class="md-primary md-dense md-raised"
                                    @click="addOffense = true"
                                    >Add Offense</md-button
                                >
                            </md-table-empty-state>

                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell md-label="Recieved Date">{{
                                    item.receivedDateOnDisplay
                                }}</md-table-cell>
                                <md-table-cell md-label="Type">{{
                                    item.type
                                }}</md-table-cell>
                                <md-table-cell md-label="Offense">{{
                                    item.offense
                                }}</md-table-cell>
                                <md-table-cell
                                    md-label="Corrective Action Taken"
                                    >{{
                                        item.corrective_action_taken
                                    }}</md-table-cell
                                >
                                <md-table-cell md-label="Status">{{
                                    item.status
                                }}</md-table-cell>
                                <md-table-cell md-label="Remarks">{{
                                    item.remarks
                                }}</md-table-cell>
                                <md-table-cell md-label="Memo Date">{{
                                    item.memoDateOnDisplay
                                }}</md-table-cell>

                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-dense md-primary md-raised"
                                        @click="
                                            getOffenseInformation(
                                                item.recieved_date,
                                                item.type,
                                                item.offense,
                                                item.corrective_action_taken,
                                                item.status,
                                                item.remarks,
                                                item.memo_date,
                                                item.id
                                            )
                                        "
                                        >✎</md-button
                                    >
                                    <md-button
                                        class="md-dense md-danger md-raised"
                                        @click="
                                            deleteOffenseInformation(item.id)
                                        "
                                        >⌫</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                        <div class="md-layout-item md-size-100 text-right">
                            <label v-for="(link, i) in links" :key="i">
                                <md-button
                                    class="button-paginate md-warning"
                                    @click="getOffenseLink(link.url)"
                                    :disabled="link.active || link.url === null"
                                >
                                    <label
                                        style="color: black !important"
                                        v-html="link.label"
                                    ></label>
                                </md-button>
                            </label>
                        </div>
                    </div>
                    <div class="md-layout-item md-size-100 text-right">
                        <!-- <b>5</b> - Outstanding, <b>4</b> - Very Satisfactory,
                        <b>3</b> - Satisfactory, <b>2</b> - Unsatisfactory,
                        <b>1</b> - Poor -->
                    </div>
                </div>
            </md-card-content>
        </md-card>
        <!-- Begin Award here -->
        <DialogCard v-if="addOffense || editOffense">
            <section slot="header" v-if="!editOffense">Add Offense</section>
            <section slot="header" v-else>Edit Offense</section>
            <section slot="body">
                <form @submit.prevent="saveOffense()">
                    <md-datepicker
                        :md-model-type="String"
                        label="Recieved Date
"
                        v-model="recieved_date"
                    >
                        <label>Recieved Date </label>
                    </md-datepicker>

                    <md-autocomplete
                        v-model="type"
                        :md-options="paramType"
                        required
                    >
                        <label>Type</label>
                    </md-autocomplete>

                    <md-autocomplete
                        v-model="activity"
                        :md-options="paramActivity"
                        required
                    >
                        <label>Activity</label>
                    </md-autocomplete>

                    <md-autocomplete
                        v-model="offense"
                        :md-options="paramOffense"
                        required
                    >
                        <label>Offense</label>
                    </md-autocomplete>

                    <md-autocomplete
                        v-model="corrective_action_taken"
                        :md-options="paramCorrective_action_taken"
                        required
                    >
                        <label>Corrective Action Taken</label>
                    </md-autocomplete>

                    <md-autocomplete
                        v-model="status"
                        :md-options="paramStatus"
                        required
                    >
                        <label>Status</label>
                    </md-autocomplete>

                    <md-field>
                        <label>Remarks</label>
                        <md-input
                            v-model="remarks"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-datepicker
                        :md-model-type="String"
                        label="Memo Date"
                        v-model="memo_date"
                    >
                        <label>Memo Date</label>
                    </md-datepicker>

                    <md-dialog-actions>
                        <md-button
                            v-if="!editOffense"
                            class="md-dense md-primary md-raised"
                            @click="saveOffense()"
                            :disabled="isSaving"
                            type="submit"
                            >{{ saveButton }}</md-button
                        >
                        <md-button
                            v-else
                            class="md-dense md-primary md-raised"
                            @click="updateOffense()"
                            :disabled="isSaving"
                            >{{ saveButton }}</md-button
                        >
                        <md-button
                            class="md-dense md-danger md-raised"
                            @click="(addOffense = false), (editOffense = false)"
                            >Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <DialogCard v-if="deleteOffense">
            <section slot="header">Delete Offense Record?</section>
            <section slot="body">
                <form>
                    You cannot undo the changes once deleted. Continue?
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary md-raised"
                            @click="validateDeleteOffense()"
                            :disabled="isDeleting"
                            >{{ deleteButton }}</md-button
                        >
                        <md-button
                            class="md-dense md-danger md-raised"
                            @click="deleteOffense = false"
                            >Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- End Offense here -->

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
    name: "OffenseUser",
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

            //Offense
            addOffense: false,
            editOffense: false,
            offenses: [],
            recieved_date: null,
            type: null,
            offense: null,
            corrective_action_taken: null,
            status: null,
            remarks: null,
            memo_date: null,
            deleteOffense: false,
            deleteButton: "Confirm Deletion",
            isDeleting: false,
            links: null,
            saveButton: "Save",
            isSaving: false,
            offenseId: null,

            //OffenseParams
            paramType: [],
            paramOffense: [],
            paramCorrective_action_taken: [],
            paramStatus: [],

            //UI
            perPage: 5,
            year: null,

            isDeleteAppraisal: false,
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
            await this.getOffense();
        },

        //Begin Offense
        //Get Offense
        async getOffense() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                params: { perPage: this.perPage },
                url: baseUrl + "/api/offense/search/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response);
                    this.offenses = response.data.data;
                    this.links = response.data.links;
                    console.log(this.offenses);
                })
                .catch((error) => {});
        },

        //Links
        async getOffenseLink(url) {
            const getToken = localStorage.getItem("token");

            const options = {
                method: "GET",
                params: { perPage: this.perPage },
                url: url,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response);
                    this.offenses = response.data.data;
                    this.links = response.data.links;
                    console.log(this.offenses);
                })
                .catch((error) => {});
        },
        //Save Offense
        async saveOffense() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            this.isSaving = true;
            this.saveButton = "Saving...";

            const options = {
                method: "POST",
                url: baseUrl + "/api/offense/create/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    recieved_date: this.recieved_date,
                    type: this.type,
                    offense: this.offense,
                    corrective_action_taken: this.corrective_action_taken,
                    status: this.status,
                    remarks: this.remarks,
                    memo_date: this.memo_date,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Offense has been saved!";
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });

            await this.getOffense();
            this.isSaving = false;
            this.addOffense = false;
            this.saveButton = "Save";
        },

        //Get Offense Information
        getOffenseInformation(
            recieved_date,
            type,
            offense,
            corrective_action_taken,
            status,
            remarks,
            memo_date,
            id
        ) {
            this.recieved_date = recieved_date;
            this.type = type;
            this.offense = offense;
            this.corrective_action_taken = corrective_action_taken;
            this.status = status;
            this.remarks = remarks;
            this.memo_date = memo_date;
            this.offenseId = id;
            this.editOffense = true;
            this.saveButton = "Update";
        },

        //Update Offense
        async updateOffense() {
            this.isSaving = true;
            this.saveButton = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "PUT",
                url: baseUrl + "/api/offense/update/" + this.offenseId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    employee_id: this.employeeId,
                    recieved_date: this.recieved_date,
                    type: this.type,
                    offense: this.offense,
                    corrective_action_taken: this.corrective_action_taken,
                    status: this.status,
                    remarks: this.remarks,
                    memo_date: this.memo_date,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Offense has been updated!";
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });

            await this.getOffense();
            this.isSaving = false;
            this.editOffense = false;
            this.saveButton = "Save";
        },

        //Delete Offense
        deleteOffenseInformation(id) {
            this.awardId = id;
            this.deleteOffense = true;
            this.deleteButton = "Confirm Deletion";
        },

        //validate Delete Offense
        async validateDeleteOffense() {
            this.isDeleting = true;
            this.deleteButton = "Deleting...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            const options = {
                method: "DELETE",
                url: baseUrl + "/api/offense/delete/" + this.awardId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Offense has been deleted!";
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });

            this.isDeleting = false;
            this.deleteButton = "Confirm Deletion";
            this.deleteOffense = false;
            await this.getOffense();
        },

        //End Offense

        //Begin Award
        //Get Parameters
        async getParams() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                url: baseUrl + "/api/offense/parameter/",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    this.paramStatus = response.data.status;
                    this.paramCorrective_action_taken =
                        response.data.corrective_action_taken;
                    this.paramOffense = response.data.offense;
                    this.paramType = response.data.type;
                })
                .catch((error) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage =
                        "There is an error getting the parameters.";
                });
        },
        //End Award

        //Reset Parameters
        resetOffenseParameter() {
            this.recieved_date = null;
            this.type = null;
            this.offense = null;
            this.corrective_action_taken = null;
            this.status = null;
            this.remarks = null;
            this.memo_date = null;
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
.button-paginate {
    border: 0px !important;
    margin-left: 2px !important;
    margin-right: 2px !important;
    padding: 3px !important;
    max-width: 80px !important;
    min-width: 80px !important;
}
</style>
