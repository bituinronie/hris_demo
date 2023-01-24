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
            <h4 class="title">Voluntary Work</h4>
            <p class="category">Complete the employee's profile</p>
        </md-card-header>
        <md-card-content>
            <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-button
                        @click="addVoluntaryWork"
                        class="md-dense"
                        :disabled="empSelected"
                    >
                        <!-- <md-icon>plus_one</md-icon> -->
                        Add Voluntary Work</md-button
                    >
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-table
                        v-model="workExperiences"
                        md-sort="name"
                        md-sort-order="asc"
                        md-card
                    >
                        <md-table-toolbar>
                            <h1 class="md-title">Voluntary Work</h1>
                        </md-table-toolbar>
                        <md-table-row slot="md-table-row" slot-scope="{ item }">
                            <md-table-cell
                                md-label="Organization"
                                md-sort-by="organization"
                                >{{ item.organization }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Date From"
                                md-sort-by="date_from"
                                >{{ item.date_from }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Date To"
                                md-sort-by="date_to"
                                >{{ item.date_to }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Hours"
                                md-sort-by="number_of_hours"
                                >{{ item.number_of_hours }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Position"
                                md-sort-by="position"
                                >{{ item.position }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Nature of Work"
                                md-sort-by="nature_of_work"
                                >{{ item.nature_of_work }}</md-table-cell
                            >
                            <md-table-cell md-label="Actions">
                                <md-button
                                    class="md-raised md-dense md-primary"
                                    @click="editVoluntaryWork(item.id)"
                                    :disabled="empSelected"
                                >
                                    Edit
                                    <md-tooltip md-direction="top"
                                        >Edit this record.</md-tooltip
                                    >
                                </md-button>
                                <md-button
                                    class="md-raised md-dense md-danger"
                                    @click="deleteVoluntaryWork(item.id)"
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
            </div>
        </md-card-content>
        <DialogCard v-if="isAddVoluntaryWork">
            <section slot="header">Add Voluntary Work</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateVoluntaryWork">
                    <md-field>
                        <label>Organization</label>
                        <md-input
                            v-model="form.organization"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date From"
                        v-model="form.date_from"
                        ><label>Date From</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        label="Date To"
                        v-model="form.date_to"
                        ><label>Date To</label></md-datepicker
                    >
                    <md-field>
                        <label>Number of Hours</label>
                        <md-input
                            v-model="form.number_of_hours"
                            type="number"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Position</label>
                        <md-input
                            v-model="form.position"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Nature of Work</label>
                        <md-input
                            v-model="form.nature_of_work"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            v-if="!isEdit"
                            class="md-primary md-dense"
                            type="submit"
                            :disabled="isUpdating"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            {{ btnMessage }}</md-button
                        >
                        <md-button
                            v-else
                            class="md-primary md-dense"
                            @click="updateVoluntaryWork"
                            :disabled="isUpdating"
                        >
                            <!-- <md-icon>arrow_circle_up</md-icon> -->
                            {{ btnMessage }}</md-button
                        >
                        <md-button class="md-dense" @click="addVoluntaryWork">
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </md-card>
</template>
<script>
import DialogCard from "../../components/Cards/DialogCard.vue";
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";

export default {
    name: "VoluntaryWork",
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        isAddVoluntaryWork: false,
        currentSort: "name",
        currentSortOrder: "asc",
        form: {
            organization: null,
            date_from: null,
            date_to: null,
            number_of_hours: null,
            position: null,
            nature_of_work: null,
        },
        workExperiences: [],

        isUpdating: false,
        btnMessage: "Experience",
        isDeleted: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,
        isAuthenticated: true,
    }),
    methods: {
        addVoluntaryWork() {
            this.isAddVoluntaryWork = !this.isAddVoluntaryWork;
            this.btnMessage = "Voluntary Work";
            this.isUpdating = false;
            this.isEdit = false;
        },

        //Create Record
        async validateVoluntaryWork() {
            this.btnMessage = "Adding...";
            this.isUpdating = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/volunteering/create/" +
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
                    organization: this.form.organization,
                    date_from: this.form.date_from,
                    date_to: this.form.date_to,
                    number_of_hours: this.form.number_of_hours,
                    position: this.form.position,
                    nature_of_work: this.form.nature_of_work,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.getVoluntaryWork();
                    this.addVoluntaryWork();
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Delete Voluntary Work
        async deleteVoluntaryWork(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/volunteering/delete/" + id;

            const options = {
                method: "DELETE",
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
                    this.notificationMessage =
                        "Voluntary work record has been deleted!";
                    this.isDeleted = true;
                    this.getVoluntaryWork();
                })
                .catch((error) => {
                    console.error(error);
                    this.notificationMessage =
                        "Error in deleting the record. Please try again!";
                    this.isDeleted = true;
                });
        },

        //Update Voluntary Work
        async updateVoluntaryWork() {
            this.btnMessage = "Updating...";
            this.isUpdating = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/volunteering/update/" +
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
                    organization: this.form.organization,
                    date_from: this.form.date_from,
                    date_to: this.form.date_to,
                    number_of_hours: this.form.number_of_hours,
                    position: this.form.position,
                    nature_of_work: this.form.nature_of_work,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.addVoluntaryWork();
                    this.getVoluntaryWork();
                })
                .catch(function (error) {
                    console.error(error);
                    this.notificationMessage =
                        "Error in updating the required information. Please try again";
                    this.isDeleted = true;
                });
        },

        //Get Record
        async getVoluntaryWork() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/volunteering/search/" +
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

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.workExperiences = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
        },
        //Get Specific Exp Records
        async editVoluntaryWork(id) {
            this.updateId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/volunteering/search/" +
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

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.form.organization = response.data.organization;
                    this.form.date_from = response.data.date_from;
                    this.form.date_to = response.data.date_to;
                    this.form.number_of_hours = response.data.number_of_hours;
                    this.form.position = response.data.position;
                    this.form.nature_of_work = response.data.nature_of_work;
                    this.addVoluntaryWork();
                    this.isEdit = true;
                    this.btnMessage = "Update Voluntary Work";
                })
                .catch((error) => {
                    console.error(error);
                    this.notificationMessage =
                        "Error in getting the required information. Please try again";
                    this.isDeleted = true;
                });
        },

        //Reset Data props
        resetData() {
            this.form.organization = null;
            this.form.date_from = null;
            this.form.date_to = null;
            this.form.number_of_hours = null;
            this.form.position = null;
            this.form.nature_of_work = null;
        },
    },
    async mounted() {
        await this.getVoluntaryWork();
        if (this.userAction === "emp_selected") {
            this.empSelected = true;
        }
    },
    watch: {
        empSelectionID(newVal, oldVal) {
            if (newVal === null) {
                //Do Nothing
                this.getVoluntaryWork();
            } else {
                this.getVoluntaryWork();
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
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
</style>
