<template>
    <div>
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
                <h4 class="title">Print Settings</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <!-- Settings Print -->
                    <div
                        class="md-layout-item md-small-size-100 md-size-100"
                        style="
                            margin-top: 20px !important;
                            margin-bottom: 20px !important;
                        "
                    >
                        <h5>Modify Print Settings</h5>
                    </div>

                    <!-- Report Address -->
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-field>
                            <label>Report Address</label>
                            <md-input
                                v-model="reportAddress"
                                :disabled="!isEditReportAddress"
                            >
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                :disabled="!isEditReportAddress"
                                @click="updateReportAddress()"
                                v-if="$permissions.includes('write setting')"
                                >{{ btnReportAddress }}</md-button
                            >
                            <md-button
                                v-if="
                                    !isEditReportAddress &&
                                    $permissions.includes('write setting')
                                "
                                class="md-raised md-warning"
                                style="color: black !important"
                                @click="isEditReportAddress = true"
                                >Edit</md-button
                            >
                            <md-button
                                v-else
                                class="md-raised md-danger"
                                @click="isEditReportAddress = false"
                                >Cancel</md-button
                            >
                        </md-field>
                    </div>

                    <!-- Report Contact Number -->
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-field>
                            <label>Report Contact Number</label>
                            <md-input
                                v-model="reportContactNumber"
                                :disabled="!isEditReportContactNumber"
                            >
                            </md-input>
                            <md-button
                                class="md-raised md-primary"
                                :disabled="!isEditReportContactNumber"
                                @click="updateReportContactNumber()"
                                v-if="$permissions.includes('write setting')"
                                >{{ btnReportContactNumber }}</md-button
                            >
                            <md-button
                                v-if="
                                    !isEditReportContactNumber &&
                                    $permissions.includes('write setting')
                                "
                                class="md-raised md-warning"
                                style="color: black !important"
                                @click="isEditReportContactNumber = true"
                                >Edit</md-button
                            >
                            <md-button
                                v-else
                                class="md-raised md-danger"
                                @click="isEditReportContactNumber = false"
                                >Cancel</md-button
                            >
                        </md-field>
                    </div>
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
    </div>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
import LogOut from "../../mixins/logOut.js";
import userAction from "../../mixins/userAction.js";
import axios from "axios";
let baseUrl = localStorage.getItem("base_url");
let token = localStorage.getItem("token");
export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    name: "EmployerSettings",
    props: {
        dataBackgroundColor: {
            type: String,
        },
    },
    data: () => ({
        isAuthenticated: true,
        fireSnackbar: null,
        messageSnackbar: null,

        //Data for Settings
        //Report Address
        reportAddress: null,
        isEditReportAddress: false,
        btnReportAddress: "Update",

        //Report Contact Number
        reportContactNumber: null,
        isEditReportContactNumber: false,
        btnReportContactNumber: "Update",
    }),
    methods: {
        //Get Report Contact Number
        async getReportContactNumber() {
            let newURL = baseUrl + "/api/setting/REPORT_CONTACT_NUMBER";
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
                    this.reportContactNumber = response.data.message;
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error getting the report address. Please refresh the page";
                });
        },

        //Get Update Contact Number
        async updateReportContactNumber() {
            this.isEditReportContactNumber = false;
            this.btnReportContactNumber = "Updating...";
            let newURL = baseUrl + "/api/setting/REPORT_CONTACT_NUMBER";

            const options = {
                method: "PUT",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: { value: this.reportContactNumber },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Updating Report Contact Number completed.";
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error updating the Report Address. Plese try again";
                });
            this.getReportContactNumber();
            this.btnReportContactNumber = "Update";
        },

        //Get Report Address
        async getReportAddres() {
            let newURL = baseUrl + "/api/setting/REPORT_ADDRESS";
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
                    console.log(response.data);
                    this.reportAddress = response.data.message;
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error getting the report address. Please refresh the page";
                });
        },

        //Update Report Address
        async updateReportAddress() {
            this.isEditReportAddress = false;
            this.btnReportAddress = "Updating...";
            let newURL = baseUrl + "/api/setting/REPORT_ADDRESS";
            const options = {
                method: "PUT",
                url: newURL,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: { value: this.reportAddress },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Updating Report Address completed.";
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error updating the Report Address. Plese try again";
                });
            await this.getReportAddres();
            this.btnReportAddress = "Update";
        },
    },

    //Created
    async created() {
        await this.getReportAddres();
        await this.getReportContactNumber();
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
.addChild {
    background-color: #495057;
    border-color: #495057;
    color: white !important;
}
.md-table-sortable-icon {
    display: none !important;
}
</style>
