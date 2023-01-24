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
                                (addAward = true),
                                    (saveButton = 'Save'),
                                    resetAwardParameter()
                            "
                            >Add Award</md-button
                        >
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-20">
                        <md-field>
                            <label>Per Page</label>
                            <md-select
                                v-model="perPage"
                                @md-selected="getAwards()"
                            >
                                <md-option :value="5">5 per page</md-option>
                                <md-option :value="10">10 per page</md-option>
                                <md-option :value="20">20 per page</md-option>
                                <md-option :value="31">31 per page</md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-table v-model="awards" md-card>
                            <md-table-empty-state
                                md-label="No awards found for this employee"
                            >
                                <md-button
                                    class="md-primary md-dense md-raised"
                                    @click="addAward = true"
                                    >Add Award</md-button
                                >
                            </md-table-empty-state>

                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell md-label="Date Awarded">{{
                                    item.dateAwardedOnDisplay
                                }}</md-table-cell>
                                <md-table-cell md-label="Type">{{
                                    item.type
                                }}</md-table-cell>
                                <md-table-cell md-label="Activity">{{
                                    item.activity
                                }}</md-table-cell>
                                <md-table-cell md-label="Remarks">{{
                                    item.remarks
                                }}</md-table-cell>

                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-dense md-primary md-raised"
                                        @click="
                                            getAwardInformation(
                                                item.date_awarded,
                                                item.type,
                                                item.activity,
                                                item.remarks,
                                                item.id
                                            )
                                        "
                                        >✎</md-button
                                    >
                                    <!-- <md-button
                                        class="md-danger md-raised"
                                        @click="deleteCollege(index)"
                                        >⌫</md-button
                                    >                                     -->
                                    <md-button
                                        class="md-dense md-danger md-raised"
                                        @click="deleteAwardInformation(item.id)"
                                        >⌫</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                        <div class="md-layout-item md-size-100 text-right">
                            <label v-for="(link, i) in links" :key="i">
                                <md-button
                                    class="button-paginate md-warning"
                                    @click="getAwardsLink(link.url)"
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
        <DialogCard v-if="addAward || editAward">
            <section slot="header" v-if="!editAward">Add Award</section>
            <section slot="header" v-else>Edit Award</section>
            <section slot="body">
                <form>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date Awarded"
                        v-model="date_awarded"
                    >
                        <label>Date Awarded</label>
                    </md-datepicker>

                    <md-autocomplete v-model="type" :md-options="paramType">
                        <label>Type</label>
                    </md-autocomplete>

                    <md-autocomplete
                        v-model="activity"
                        :md-options="paramActivity"
                    >
                        <label>Activity</label>
                    </md-autocomplete>

                    <md-field>
                        <label>Remarks</label>
                        <md-input v-model="remarks" type="text"></md-input>
                    </md-field>

                    <md-dialog-actions>
                        <md-button
                            v-if="!editAward"
                            class="md-dense md-primary md-raised"
                            @click="saveAward()"
                            :disabled="isSaving"
                            >{{ saveButton }}</md-button
                        >
                        <md-button
                            v-else
                            class="md-dense md-primary md-raised"
                            @click="updateAward()"
                            :disabled="isSaving"
                            >{{ saveButton }}</md-button
                        >
                        <md-button
                            class="md-dense md-danger md-raised"
                            @click="(addAward = false), (editAward = false)"
                            >Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <DialogCard v-if="deleteAward">
            <section slot="header">Delete Award Record?</section>
            <section slot="body">
                <form>
                    You cannot undo the changes once deleted. Continue?
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary md-raised"
                            @click="validateDeleteAward()"
                            :disabled="isDeleting"
                            >{{ deleteButton }}</md-button
                        >
                        <md-button
                            class="md-dense md-danger md-raised"
                            @click="deleteAward = false"
                            >Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- End Award here -->

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
    name: "AwardUser",
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

            //Award
            addAward: false,
            editAward: false,
            awards: [],
            date_awarded: null,
            type: null,
            activity: null,
            remarks: null,
            paramType: [],
            paramActivity: [],
            awardId: null,
            deleteAward: false,
            deleteButton: "Confirm Deletion",
            isDeleting: false,
            links: null,
            saveButton: "Save",
            isSaving: false,

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
            await this.getAwards();
        },

        //Begin Award
        //Save Award
        async saveAward() {
            this.saveButton = "Saving...";
            this.isSaving = true;

            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            const options = {
                method: "POST",
                url: baseUrl + "/api/award/create/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    date_awarded: this.date_awarded,
                    type: this.type,
                    activity: this.activity,
                    remarks: this.remarks,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Award saved successfully!";
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });
            this.addAward = false;
            this.isSaving = false;
            this.saveButton = "Save";
            await this.getAwards();
        },

        //Get Awards
        async getAwards() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                params: { perPage: this.perPage },
                url: baseUrl + "/api/award/search/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.awards = response.data.data;
                    this.links = response.data.links;
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });
        },

        //Get Award using Link
        async getAwardsLink(url) {
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
                    this.awards = response.data.data;
                    this.links = response.data.links;
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });
        },
        //Get Award Information
        getAwardInformation(date_awarded, type, activity, remarks, id) {
            this.date_awarded = date_awarded;
            this.type = type;
            this.activity = activity;
            this.remarks = remarks;
            this.awardId = id;
            this.editAward = true;
            this.saveButton = "Update";
        },

        //Update Award
        async updateAward() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            this.isSaving = true;
            this.saveButton = "Updating...";

            const options = {
                method: "PUT",
                url: baseUrl + "/api/award/update/" + this.awardId,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    employee_id: this.employeeId,
                    date_awarded: this.date_awarded,
                    type: this.type,
                    activity: this.activity,
                    remarks: this.remarks,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Award has been updated!";
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });

            this.editAward = false;
            this.isSaving = false;
            this.saveButton = "Save";
            await this.getAwards();
        },

        //Delete Award
        deleteAwardInformation(id) {
            this.awardId = id;
            this.deleteAward = true;
            this.deleteButton = "Confirm Deletion";
        },

        //Validate Delete Award
        async validateDeleteAward() {
            this.isDeleting = true;
            this.deleteButton = "Deleting...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            const options = {
                method: "DELETE",
                url: baseUrl + "/api/award/delete/" + this.awardId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Award has been deleted!";
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;
                    this.fireSnackBar = true;
                    this.snackBarMessage = errorMessage;
                });

            this.isDeleting = false;
            this.deleteButton = "Delete";
            this.deleteAward = false;
            await this.getAwards();
        },

        //Get Parameters
        async getParams() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");

            const options = {
                method: "GET",
                url: baseUrl + "/api/award/parameter/",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    this.paramType = response.data.type;
                    this.paramActivity = response.data.activity;
                })
                .catch((error) => {
                    this.fireSnackBar = true;
                    this.snackBarMessage =
                        "There is an error getting the parameters.";
                });
        },
        //End Award
        //Reset Parameters
        resetAwardParameter() {
            this.date_awarded = null;
            this.type = null;
            this.remarks = null;
            this.activity = null;
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
