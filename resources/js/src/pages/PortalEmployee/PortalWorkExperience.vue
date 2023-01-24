<template>
    <form>
        <md-card>
            <md-dialog-alert
                :md-active.sync="isDeleted"
                :md-content="notificationMessage"
                md-confirm-text="Okay"
            />
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <span v-if="isUpdateEmployee === 'false'"
                            >Updating of record is disabled.</span
                        >
                        <md-button
                            v-else
                            @click="addWorkingExperience"
                            class="md-dense"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            Add Work Experience
                        </md-button>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-table
                            v-model="workExperiences"
                            md-sort="name"
                            md-sort-order="asc"
                            md-card
                        >
                            <md-table-toolbar>
                                <h1 class="md-title">Experiences</h1>
                            </md-table-toolbar>
                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell
                                    md-label="Position"
                                    md-sort-by="position"
                                    >{{ item.position }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Date From"
                                    md-sort-by="dateFrom"
                                    >{{ item.date_from }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Date To"
                                    md-sort-by="dateTo"
                                    >{{ item.date_to }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Company"
                                    md-sort-by="company"
                                    >{{ item.company }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Government"
                                    md-sort-by="isGovernment"
                                >
                                    <label
                                        v-if="
                                            item.is_government_service === true
                                        "
                                        >Yes</label
                                    >
                                    <label
                                        v-if="
                                            item.is_government_service === false
                                        "
                                        >No</label
                                    >
                                    <!-- {{
                                        item.is_government_service
                                    }} -->
                                </md-table-cell>
                                <!-- <md-table-cell
                                    md-label="Sector"
                                    md-sort-by="sector"
                                    >{{ item.sector }}</md-table-cell
                                > -->
                                <md-table-cell
                                    md-label="Salary"
                                    md-sort-by="salary"
                                    >{{ item.salary }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Pay Grade"
                                    md-sort-by="payGrade"
                                    >{{ item.pay_grade }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Status of Appointment"
                                    md-sort-by="statusOfAppointment"
                                    >{{
                                        item.status_of_appointment
                                    }}</md-table-cell
                                >
                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-raised md-simple md-primary"
                                        @click="editExperience(item.id)"
                                        :disabled="isUpdateEmployee === 'false'"
                                    >
                                        <!-- <md-icon>edit</md-icon> -->
                                        Edit
                                        <md-tooltip md-direction="top"
                                            >Edit this record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-raised md-simple md-danger"
                                        @click="deleteExperience(item.id)"
                                        :disabled="isUpdateEmployee === 'false'"
                                    >
                                        <!-- <md-icon>delete</md-icon> -->
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
                            ><md-icon>save</md-icon> Save Work
                            Experience</md-button
                        > -->
                    </div>
                </div>
            </md-card-content>
        </md-card>
        <DialogCard v-if="isAddExperience">
            <section slot="header">Add Work Experience</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateExperience">
                    <md-autocomplete
                        v-model="form.position"
                        :md-options="paramPosition"
                        required
                    >
                        <label>Position</label>
                    </md-autocomplete>
                    <!-- <md-field>
                        <label>Position</label>
                        <md-input
                            v-model="form.position"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->
                    <md-datepicker
                        :md-model-type="String"
                        label="Date From"
                        v-model="form.date_from"
                        ><label>Date From</label></md-datepicker
                    >
                    <md-datepicker
                        v-if="!form.currently_employed"
                        :md-model-type="String"
                        label="Date To"
                        v-model="form.date_to"
                        ><label>Date To</label></md-datepicker
                    >
                    <div>
                        <label>Currently Employed Here?</label><br />
                        <!-- <md-select class="form-control" v-model="form.is_government_service">
                            <md-option v-for="val in [true, false]" :value="val" :key="val">{{ val ? 'Yes' : 'No' }}</md-option>
                        </md-select> -->
                        <md-radio
                            v-model="form.currently_employed"
                            :value="true"
                            >Yes</md-radio
                        >
                        <md-radio
                            v-model="form.currently_employed"
                            :value="false"
                            >No</md-radio
                        >
                    </div>
                    <md-autocomplete
                        v-model="form.company"
                        :md-options="paramCompany"
                        required
                    >
                        <label>Company</label>
                    </md-autocomplete>
                    <!-- <md-field>
                        <label>Company</label>
                        <md-input
                            v-model="form.company"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->
                    <!-- <md-field> -->
                    <label>Government</label><br />
                    <!-- <md-select class="form-control" v-model="form.is_government_service">
                            <md-option v-for="val in [true, false]" :value="val" :key="val">{{ val ? 'Yes' : 'No' }}</md-option>
                        </md-select> -->
                    <md-radio v-model="form.is_government_service" :value="true"
                        >Yes</md-radio
                    >
                    <md-radio
                        v-model="form.is_government_service"
                        :value="false"
                        >No</md-radio
                    >
                    <!-- </md-field> -->
                    <!-- <md-field>
                        <label>Sector</label>
                        <md-input
                            v-model="form.sector"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->
                    <md-field>
                        <label>Salary</label>
                        <md-input
                            v-model="form.salary"
                            type="number"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Pay Grade</label>
                        <md-input
                            v-model="form.pay_grade"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-autocomplete
                        v-model="form.status_of_appointment"
                        :md-options="paramStatusOfAppointment"
                        required
                    >
                        <label>Status of Appointment</label>
                    </md-autocomplete>
                    <!-- <md-field>
                        <label>Status of Appointment</label>
                        <md-input
                            v-model="form.status_of_appointment"
                            type="text"
                            required
                        ></md-input>
                    </md-field> -->
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
                            @click="updateExperience"
                            :disabled="isUpdating"
                        >
                            <!-- <md-icon>arrow_circle_up</md-icon> -->
                            {{ btnMessage }}</md-button
                        >
                        <md-button
                            class="md-dense"
                            @click="addWorkingExperience"
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </form>
</template>
<script>
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";
export default {
    name: "PortalWorkExperience",
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
        isAddExperience: false,
        currentSort: "name",
        currentSortOrder: "asc",
        form: {
            position: null,
            date_from: null,
            date_to: null,
            company: null,
            is_government_service: true,
            sector: null,
            salary: null,
            pay_grade: null,
            status_of_appointment: null,
            currently_employed: true,
        },
        workExperiences: [
            {
                position: null,
                date_from: null,
                date_to: null,
                company: null,
                is_government_service: null,
                sector: null,
                salary: null,
                pay_grade: null,
                status_of_appointment: null,
            },
        ],

        isUpdating: false,
        btnMessage: "Add Experience",
        isDeleted: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,
        isAuthenticated: true,

        isUpdateEmployee: false,

        //For Auto Completion
        paramPosition: [],
        paramCompany: [],
        paramStatusOfAppointment: [],
        paramSector: [],
    }),
    methods: {
        addWorkingExperience() {
            this.isAddExperience = !this.isAddExperience;
            this.isEdit = false;
            this.isUpdating = false;
            this.btnMessage = "Add Experience";
        },

        //Add Experience
        async validateExperience() {
            this.isUpdating = true;
            this.btnMessage = "Adding...";

            if (this.form.currently_employed) {
                this.form.date_to = "Present";
            }

            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/work-experience/portal/create";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    position: this.form.position,
                    date_from: this.form.date_from,
                    date_to: this.form.date_to,
                    company: this.form.company,
                    is_government_service: this.form.is_government_service,
                    sector: this.form.sector,
                    salary: this.form.salary,
                    pay_grade: this.form.pay_grade,
                    status_of_appointment: this.form.status_of_appointment,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.addWorkingExperience();
                    this.getWorkExperiencesRecord();
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Update Experience
        async updateExperience() {
            this.isUpdating = true;
            this.btnMessage = "Updating...";

            if (this.form.currently_employed) {
                this.form.date_to = "Present";
            }

            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/work-experience/portal/update/" +
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
                    position: this.form.position,
                    date_from: this.form.date_from,
                    date_to: this.form.date_to,
                    company: this.form.company,
                    is_government_service: this.form.is_government_service,
                    sector: this.form.sector,
                    salary: this.form.salary,
                    pay_grade: this.form.pay_grade,
                    status_of_appointment: this.form.status_of_appointment,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.addWorkingExperience();
                    this.getWorkExperiencesRecord();
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Get Experience Records
        async getWorkExperiencesRecord() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/work-experience/portal/search/";

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
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });

            await this.getParam();
        },

        //Get Param
        async getParam() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/work-experience/portal/parameter/";
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
                    this.paramPosition = response.data.position;
                    this.paramCompany = response.data.company;
                    this.paramStatusOfAppointment =
                        response.data.status_of_appointment;
                    this.paramSector = response.data.sector;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        //Get Specific Exp Records
        async editExperience(id) {
            this.updateId = id;
            this.btnMessage = "Update Eligibility";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/work-experience/portal/search/" +
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
                    this.form.position = response.data.position;
                    this.form.date_from = response.data.date_from;
                    this.form.date_to = response.data.date_to;
                    this.form.company = response.data.company;
                    this.form.is_government_service =
                        response.data.is_government_service;
                    this.form.sector = response.data.sector;
                    this.form.salary = response.data.salary;
                    this.form.salary = parseFloat(
                        this.form.salary.replace(/,/g, "")
                    );
                    this.form.pay_grade = response.data.pay_grade;
                    this.form.status_of_appointment =
                        response.data.status_of_appointment;
                    this.addWorkingExperience();
                    this.isEdit = true;
                    this.btnMessage = "Update Experience";
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Delete Experience
        async deleteExperience(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/work-experience/portal/delete/" +
                id;
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
                        "Work Experience has been deleted!";
                    this.isDeleted = true;
                })
                .catch(function (error) {
                    console.error(error);
                });
            this.getWorkExperiencesRecord();
        },

        //Reset Data
        resetData() {
            this.form.position = null;
            this.form.date_from = null;
            this.form.date_to = null;
            this.form.company = null;
            this.form.is_government_service = true;
            this.form.sector = null;
            this.form.salary = null;
            this.form.pay_grade = null;
            this.form.status_of_appointment = null;
        },
    },

    async mounted() {
        await this.getWorkExperiencesRecord();
        this.isUpdateEmployee = localStorage.getItem("isUpdateEmployee");
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
</style>
