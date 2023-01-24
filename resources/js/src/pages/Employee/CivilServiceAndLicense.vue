<template>
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
        <md-dialog-alert
            :md-active.sync="isDeleted"
            :md-content="notificationMessage"
            md-confirm-text="Okay"
        />
        <md-card-header class="md-card-header">
            <h4 class="title">Civil Service Eligibility / Licences</h4>
            <p class="category">Complete the employee's profile</p>
        </md-card-header>
        <md-card-content>
            <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-button
                        class="md-dense"
                        @click="addEligibility"
                        :disabled="empSelected"
                    >
                        <!-- <md-icon>plus_one</md-icon> -->
                        Add Civil Service Eligibility</md-button
                    >
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-table
                        v-model="eligibility"
                        md-sort="name"
                        md-sort-order="asc"
                        md-card
                    >
                        <md-table-toolbar>
                            <h1 class="md-title">Eligibility</h1>
                        </md-table-toolbar>
                        <md-table-row slot="md-table-row" slot-scope="{ item }">
                            <md-table-cell md-label="Type" md-sort-by="type">{{
                                item.type
                            }}</md-table-cell>
                            <md-table-cell
                                md-label="Rating"
                                md-sort-by="emairatingl"
                                >{{ item.rating }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Date Conferment / Isssued"
                                md-sort-by="dateConferment"
                                >{{ item.date_conferment }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Place Conferment"
                                md-sort-by="placeConferment"
                                >{{ item.place_conferment }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="License Number"
                                md-sort-by="licenseNumber"
                                >{{ item.license_number }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="License Validity"
                                md-sort-by="licenseValidity"
                                >{{ item.license_validity }}</md-table-cell
                            >
                            <md-table-cell md-label="Actions">
                                <md-button
                                    class="md-raised md-dense md-primary"
                                    @click="editEligibility(item.id)"
                                    :disabled="empSelected"
                                >
                                    Edit
                                    <md-tooltip md-direction="top"
                                        >Edit this record.</md-tooltip
                                    >
                                </md-button>
                                <md-button
                                    class="md-raised md-dense md-danger"
                                    @click="deleteEligibility(item.id)"
                                    :disabled="empSelected"
                                >
                                    Delete
                                    <md-tooltip md-direction="top"
                                        >Delete this record.</md-tooltip
                                    >
                                </md-button>
                            </md-table-cell>
                        </md-table-row>
                    </md-table>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                    <!-- <md-button class="md-raised md-success"
                            ><md-icon>save</md-icon> Save Eligibility
                            Records</md-button
                        > -->
                </div>
            </div>
        </md-card-content>
        <DialogCard v-if="isAddEligibility">
            <section slot="header">Add Eligibility</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateAddEligibility">
                    <md-autocomplete
                        v-model="form.type"
                        :md-options="paramType"
                    >
                        <label>Type</label>
                    </md-autocomplete>

                    <!-- <md-input
                            v-model="form.type"
                            type="text"
                            required
                        ></md-input> -->
                    <label>Rating Not Applicable</label><br />
                    <md-radio v-model="rating_valid" :value="true"
                        >Yes</md-radio
                    >
                    <md-radio v-model="rating_valid" :value="false"
                        >No</md-radio
                    >
                    <md-field>
                        <label>Rating</label>
                        <md-input
                            v-if="!rating_valid"
                            v-model="form.rating"
                            type="text"
                            required
                            :disabled="rating_valid"
                        ></md-input>
                        <span v-else>N/A</span>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        v-model="form.date_conferment"
                        required
                    >
                        <label>Date of Conferment / Examination</label>
                    </md-datepicker>
                    <md-autocomplete
                        v-model="form.place_conferment"
                        :md-options="paramPlaceConferment"
                    >
                        <label>Place of Conferment / Examination</label>
                    </md-autocomplete>
                    <!-- <md-field>
                        <label>Place of Conferment / Examination</label>
                        <md-input
                            v-model="form.place_conferment"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->
                    <md-field>
                        <label>License Number</label>
                        <md-input
                            v-model="form.license_number"
                            type="text"
                        ></md-input>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        v-model="form.license_validity"
                    >
                        <label>License Validity</label>
                    </md-datepicker>
                    <md-dialog-actions>
                        <md-button
                            v-if="!isEdit"
                            class="md-primary md-dense"
                            type="submit"
                            :disabled="isUpdating"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            {{ btnMessage }}
                        </md-button>
                        <md-button
                            v-else
                            class="md-primary md-dense"
                            @click="updateEligibility"
                            :disabled="isUpdating"
                        >
                            <!-- <md-icon>arrow_circle_up</md-icon> -->
                            {{ btnMessage }}
                        </md-button>
                        <md-button class="md-dense" @click="addEligibility">
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Close
                        </md-button>
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </md-card>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../../components/Cards/DialogCard.vue";
// const axios = () =>
//     import(
//         /* webpackChunkName: "axios" */ "axios"
//     );
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";
export default {
    components: {
        DialogCard,
    },
    name: "CivilServiceAndLicense",
    mixins: [LogOut, userAction],
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        isAddEligibility: false,
        currentSort: "name",
        currentSortOrder: "asc",
        rating_valid: false,
        form: {
            type: null,
            rating: null,
            date_conferment: "2021-01-04",
            place_conferment: null,
            license_number: null,
            license_validity: "2021-01-04",
        },
        eligibility: [
            {
                type: null,
                rating: null,
                date_conferment: null,
                place_conferment: null,
                license_number: null,
                license_validity: null,
            },
        ],

        isUpdating: false,
        btnMessage: "Add Eligibility",
        isDeleted: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,
        isAuthenticated: true,
        updateId: null,
        isAuthenticated: true,

        //For Auto Complete
        paramType: [],
        paramPlaceConferment: [],
    }),
    methods: {
        addEligibility() {
            this.isAddEligibility = !this.isAddEligibility;
            this.isEdit = false;
            this.isUpdating = false;
            this.btnMessage = "Add Eligibility";
        },

        //Save Record
        async validateAddEligibility() {
            //Add NA in rating
            if (this.rating_valid) {
                this.form.rating = null;
            }

            this.isUpdating = true;
            this.btnMessage = "Adding...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/eligibility/create/" +
                this.empSelectionID;

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    type: this.form.type,
                    rating: this.form.rating,
                    date_conferment: this.form.date_conferment,
                    place_conferment: this.form.place_conferment,
                    license_number: this.form.license_number,
                    license_validity: this.form.license_validity,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.addEligibility();
                    this.getEligibilityRecord();
                })
                .catch(function (error) {
                    console.error("ERRR: ", error);
                });
        },

        //Get All Record
        async getEligibilityRecord() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/eligibility/search/" +
                this.empSelectionID;

            const options = {
                method: "GET",
                url: this.baseUrl,
                params: { perPage: "100" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data.data);
                    this.eligibility = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });

            await this.getParam();
        },

        //Get Param for for auto complete
        async getParam() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/eligibility/parameter/";
            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    // this.getParamLevel = response.data.level
                    console.log(response.data);
                    this.paramType = response.data.type;
                    this.paramPlaceConferment = response.data.place_conferment;
                })
                .catch((error) => {
                    console.error(error.data);
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
        },
        //Get Specific Eligibility
        async editEligibility(id) {
            this.updateId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/eligibility/search/" +
                this.empSelectionID +
                "/" +
                id;

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.form.type = response.data.type;
                    this.form.rating = response.data.rating;
                    this.form.date_conferment = response.data.date_conferment;
                    this.form.place_conferment = response.data.place_conferment;
                    this.form.license_number = response.data.license_number;
                    this.form.license_validity = response.data.license_validity;
                    this.addEligibility();
                    this.isEdit = true;
                    this.btnMessage = "Update Eligibility";
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Update Specific Record
        async updateEligibility() {
            //Add NA in rating
            if (this.rating_valid) {
                this.form.rating = null;
            }

            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/eligibility/update/" +
                this.updateId;

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    type: this.form.type,
                    rating: this.form.rating,
                    date_conferment: this.form.date_conferment,
                    place_conferment: this.form.place_conferment,
                    license_number: this.form.license_number,
                    license_validity: this.form.license_validity,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.isUpdating = false;
                    this.btnMessage = "Add Eligibility";
                    this.getEligibilityRecord();
                    this.addEligibility();
                })
                .catch(function (error) {
                    console.error("ERRRRP:".error.response);
                });
        },
        //Delete Record
        async deleteEligibility(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/eligibility/delete/" + id;

            const options = {
                method: "DELETE",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.notificationMessage = "Eligibility has been deleted!";
                    this.isDeleted = true;
                })
                .catch(function (error) {
                    console.error(error);
                });
            this.getEligibilityRecord();
        },

        //Reset Data
        resetData() {
            this.form.type = null;
            this.form.rating = null;
            this.form.date_conferment = null;
            this.form.place_conferment = null;
            this.form.license_number = null;
            this.form.license_validity = null;
            this.rating_valid = false;
        },
    },
    async mounted() {
        await this.getEligibilityRecord();
        await this.getParam();
        if (this.userAction === "emp_selected") {
            this.empSelected = true;
        }
    },
    watch: {
        empSelectionID(newVal, oldVal) {
            if (newVal === null) {
                //Do Nothing
                this.getEligibilityRecord();
            } else {
                this.getEligibilityRecord();
            }
        },
        userAction(newVal, oldVal) {
            if (newVal === "edit") {
                this.empSelected = false;
            }
            if (newVal === "emp_selected") {
                this.empSelected = true;
            }
        },
    },
};
</script>
<style lang="scss" scoped>
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
.md-menu-content {
    z-index: 99 !important;
}
</style>
