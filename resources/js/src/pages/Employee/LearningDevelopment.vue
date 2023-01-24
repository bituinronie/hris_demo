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
            <h4 class="title">Learning and Development</h4>
            <p class="category">Complete the employee's profile</p>
        </md-card-header>
        <md-card-content>
            <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-button
                        @click="addLearningDevelopment"
                        class="md-dense"
                        :disabled="empSelected"
                    >
                        <!-- <md-icon>plus_one</md-icon> -->
                        Add Learning / Development</md-button
                    >
                </div>

                <div class="md-layout-item md-size-100">
                    <md-table
                        v-model="learningAndDevelopment"
                        md-sort="program"
                        md-sort-order="asc"
                    >
                        <md-table-toolbar>
                            <h1 class="md-title">Learning and Development</h1>
                        </md-table-toolbar>
                        <md-table-row slot="md-table-row" slot-scope="{ item }">
                            <md-table-cell
                                md-label="Program"
                                md-sort-by="program"
                                >{{ item.program }}</md-table-cell
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
                                md-label="Number of Hours"
                                md-sort-by="number_of_hours"
                                >{{ item.number_of_hours }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Type of LD"
                                md-sort-by="type_of_ld"
                                >{{ item.type_of_ld }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Sponsored By"
                                md-sort-by="sponsored_by"
                                >{{ item.sponsored_by }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Conducted By"
                                md-sort-by="conducted_by"
                                >{{ item.conducted_by }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Location"
                                md-sort-by="location"
                                >{{ item.location }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Actions"
                                md-sort-by="actions"
                            >
                                <md-button
                                    class="md-raised md-dense md-primary"
                                    @click="editLearningDevelopment(item.id)"
                                    :disabled="empSelected"
                                >
                                    Edit
                                    <md-tooltip md-direction="top"
                                        >Edit this record.</md-tooltip
                                    >
                                </md-button>
                                <md-button
                                    class="md-raised md-dense md-danger"
                                    @click="deleteLearningDevelopment(item.id)"
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

                <DialogCard v-if="isAddLearningAndDevelopment">
                    <section slot="header">Add Learning Development</section>
                    <section slot="body">
                        <form
                            method="post"
                            @submit.prevent="validateLearningDevelopment"
                        >
                            <md-field>
                                <label>Program</label>
                                <md-input
                                    v-model="form.program"
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
                                <label>Type of LD</label>
                                <md-input
                                    v-model="form.type_of_ld"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field>
                            <md-field>
                                <label>Sponsored By</label>
                                <md-input
                                    v-model="form.sponsored_by"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field>
                            <md-field>
                                <label>Conducted By</label>
                                <md-input
                                    v-model="form.conducted_by"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field>
                            <md-field>
                                <label>Location</label>
                                <md-select
                                    v-model="form.location"
                                    :disabled="empSelected"
                                >
                                    <md-option value="LOCAL">LOCAL</md-option>
                                    <md-option value="FOREIGN"
                                        >FOREIGN</md-option
                                    >
                                </md-select>
                            </md-field>

                            <!-- <md-field>
                                <label>Location</label>
                                <md-input
                                    v-model="form.location"
                                    type="text"
                                    disabled
                                ></md-input>
                            </md-field> -->

                            <md-dialog-actions>
                                <md-button
                                    v-if="!isEdit"
                                    class="md-primary md-dense"
                                    type="submit"
                                >
                                    <!-- <md-icon>plus_one</md-icon> -->
                                    {{ btnMessage }}</md-button
                                >
                                <md-button
                                    v-else
                                    class="md-primary md-dense"
                                    @click="updateLearningDevelopment"
                                >
                                    <!-- <md-icon>arrow_circle_up</md-icon> -->
                                    {{ btnMessage }}</md-button
                                >
                                <md-button
                                    class="md-dense"
                                    @click="addLearningDevelopment"
                                >
                                    <!-- <md-icon>close</md-icon> -->
                                    ✕ Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>
            </div>
        </md-card-content>
    </md-card>
</template>
<script>
import DialogCard from "../../components/Cards/DialogCard.vue";
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";
export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    name: "LearningDevelopment",
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        currentSort: "name",
        currentSortOrder: "asc",
        isAddLearningAndDevelopment: false,
        form: {
            program: null,
            date_from: null,
            date_to: null,
            number_of_hours: null,
            type_of_ld: null,
            sponsored_by: null,
            conducted_by: null,
            location: "LOCAL",
        },
        learningAndDevelopment: [],

        isUpdating: false,
        btnMessage: "Add Learning and Development",
        isDeleted: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,
        isAuthenticated: true,
    }),
    methods: {
        addLearningDevelopment() {
            this.isAddLearningAndDevelopment =
                !this.isAddLearningAndDevelopment;
            this.btnMessage = "Add Learning and Development";
            this.isEdit = false;
        },

        //Add Learning Development
        async validateLearningDevelopment() {
            this.btnMessage = "Adding...";
            this.isUpdating = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/training/create/" +
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
                    program: this.form.program,
                    date_from: this.form.date_from,
                    date_to: this.form.date_to,
                    number_of_hours: this.form.number_of_hours,
                    type_of_ld: this.form.type_of_ld,
                    sponsored_by: this.form.sponsored_by,
                    conducted_by: this.form.conducted_by,
                    location: this.form.location,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.getLearningDevelopment();
                    this.addLearningDevelopment();
                })
                .catch((error) => {
                    console.error(error);
                    this.notificationMessage =
                        "Error in adding this record. Please try again";
                    this.isDeleted = true;
                });
        },

        //Get Learning Development
        async getLearningDevelopment() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/training/search/" +
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
                    this.learningAndDevelopment = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
        },

        //Get Specific Learning Development
        async editLearningDevelopment(id) {
            this.updateId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/training/search/" +
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
                    this.form.program = response.data.program;
                    this.form.date_from = response.data.date_from;
                    this.form.date_to = response.data.date_to;
                    this.form.number_of_hours = response.data.number_of_hours;
                    this.form.type_of_ld = response.data.type_of_ld;
                    this.form.sponsored_by = response.data.sponsored_by;
                    this.form.conducted_by = response.data.conducted_by;
                    this.form.location = response.data.location;
                    this.addLearningDevelopment();
                    this.isEdit = true;
                    this.btnMessage = "Update Learning Development";
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Update Learning Development
        async updateLearningDevelopment() {
            this.btnMessage = "Updating...";
            this.isUpdating = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/training/update/" + this.updateId;

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    program: this.form.program,
                    date_from: this.form.date_from,
                    date_to: this.form.date_to,
                    number_of_hours: this.form.number_of_hours,
                    type_of_ld: this.form.type_of_ld,
                    sponsored_by: this.form.sponsored_by,
                    conducted_by: this.form.conducted_by,
                    location: this.form.location,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.getLearningDevelopment();
                    this.addLearningDevelopment();
                })
                .catch((error) => {
                    console.error(error);
                    this.notificationMessage =
                        "Error in updating this record. Please try again";
                    this.isDeleted = true;
                });
        },

        //Delete Learning Development
        async deleteLearningDevelopment(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/training/delete/" + id;

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
                    this.getLearningDevelopment();
                    this.notificationMessage = "The record has been deleted.";
                    this.isDeleted = true;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Reset Data
        resetData() {
            this.form.program = null;
            this.form.date_from = null;
            this.form.date_to = null;
            this.form.number_of_hours = null;
            this.form.type_of_ld = null;
            this.form.sponsored_by = null;
            this.form.conducted_by = null;
            this.form.location = "LOCAL";
        },
    },

    async mounted() {
        await this.getLearningDevelopment();
        if (this.userAction === "emp_selected") {
            this.empSelected = true;
        }
    },
    watch: {
        empSelectionID(newVal, oldVal) {
            if (newVal === null) {
                //Do Nothing
                this.getLearningDevelopment();
            } else {
                this.getLearningDevelopment();
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
