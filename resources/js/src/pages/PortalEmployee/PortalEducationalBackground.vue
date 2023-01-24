<template>
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
                        @click="addEducation"
                        class="md-dense"
                        :disabled="isUpdateEmployee === 'false'"
                    >
                        <!-- <md-icon>plus_one</md-icon> -->
                        Add Education</md-button
                    >
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-table
                        v-model="education"
                        md-sort="level"
                        md-sort-order="asc"
                        md-card
                    >
                        <md-table-toolbar>
                            <h1 class="md-title">Educational History</h1>
                        </md-table-toolbar>
                        <md-table-row slot="md-table-row" slot-scope="{ item }">
                            <md-table-cell
                                md-label="Level"
                                md-sort-by="level"
                                >{{ item.level }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="School Name"
                                md-sort-by="school_name"
                                >{{ item.school_name }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Course"
                                md-sort-by="course"
                                >{{ item.course }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Attended From"
                                md-sort-by="attended_from"
                                >{{ item.attended_from }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Attended To"
                                md-sort-by="attended_to"
                                >{{ item.attended_to }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Graduated"
                                md-sort-by="graduated"
                            >
                                <label v-if="item.graduated === true"
                                    >Yes</label
                                >
                                <label v-if="item.graduated === false"
                                    >No</label
                                >
                                <!-- {{ item.graduated }} -->
                            </md-table-cell>
                            <md-table-cell
                                md-label="Highest Level / Units Earned"
                                md-sort-by="highest_level"
                                >{{ item.highest_level }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Year Graduated"
                                md-sort-by="year_graduated"
                                >{{ item.year_graduated }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Honors"
                                md-sort-by="honors"
                                >{{ item.honors }}</md-table-cell
                            >
                            <md-table-cell md-label="Actions">
                                <md-button
                                    class="md-raised md-simple md-primary"
                                    @click="editEducation(item.id)"
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
                                    @click="deleteEducation(item.id)"
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
                <DialogCard v-if="isAddEducation">
                    <section slot="header">Add Education</section>
                    <section slot="body">
                        <form
                            method="post"
                            @submit.prevent="validateAddEducation"
                        >
                            <md-field>
                                <label>Level</label>
                                <md-select
                                    v-model="form.level"
                                    :required="true"
                                >
                                    <md-option
                                        v-for="lvl in getParamLevel"
                                        :key="lvl"
                                        :value="lvl"
                                    >
                                        {{ lvl }}
                                    </md-option>
                                </md-select>
                            </md-field>
                            <md-autocomplete
                                v-model="form.schoolName"
                                :md-options="paramSchoolName"
                                required
                            >
                                <label>School Name</label>
                            </md-autocomplete>
                            <!-- <md-field>
                                <label>School Name</label>
                                <md-input
                                    v-model="form.schoolName"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field> -->
                            <md-autocomplete
                                v-model="form.course"
                                :md-options="paramCourse"
                                required
                            >
                                <label>Program / Course Name</label>
                            </md-autocomplete>
                            <!-- <md-field>
                                <label>Program / Course Name</label>
                                <md-input
                                    v-model="form.course"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field> -->
                            <md-field>
                                <label>Attended From</label>
                                <md-input
                                    v-model="form.attendedFrom"
                                    type="number"
                                    maxlength="4"
                                    min="1900"
                                    required
                                ></md-input>
                            </md-field>
                            <md-field>
                                <label>Attended To</label>
                                <md-input
                                    v-model="form.attendedTo"
                                    type="number"
                                    maxlength="4"
                                    min="1900"
                                    required
                                ></md-input>
                            </md-field>
                            <!-- <md-datepicker
                                :md-model-type="String"
                                label="Attended From"
                                v-model="form.attendedFrom"
                                ><label>Attended From</label></md-datepicker
                            >
                            <md-datepicker
                                :md-model-type="String"
                                label="Attended To"
                                v-model="form.attendedTo"
                                ><label>Attended To</label></md-datepicker
                            > -->
                            <!-- <md-field> -->
                            <label>Graduated</label><br />
                            <!-- <md-select v-model="form.graduated" required>
                                    <md-option value="true">Yes</md-option>
                                    <md-option value="false">No</md-option>
                                </md-select> -->
                            <md-radio v-model="form.graduated" :value="true"
                                >Yes</md-radio
                            >
                            <md-radio v-model="form.graduated" :value="false"
                                >No</md-radio
                            >
                            <!-- </md-field> -->
                            <md-field v-if="form.graduated === true">
                                <label>Year Graduated</label>
                                <md-input
                                    v-model="form.yearGraduated"
                                    type="number"
                                    maxlength="4"
                                    min="1900"
                                    required
                                ></md-input>
                            </md-field>
                            <md-autocomplete
                                v-model="form.highestLevel"
                                :md-options="paramHighestLevel"
                                required
                            >
                                <label>Highest Level/Units Earned</label>
                            </md-autocomplete>
                            <!-- <md-field>
                                <label>Highest Level / Units Earned</label>
                                <md-input
                                    v-model="form.highestLevel"
                                    type="text"
                                    required
                                ></md-input>
                            </md-field> -->
                            <md-autocomplete
                                v-model="form.honors"
                                :md-options="paramHonors"
                            >
                                <label>Honors</label>
                            </md-autocomplete>
                            <!-- <md-field>
                                <label>Honors</label>
                                <md-input
                                    v-model="form.honors"
                                    type="text"
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
                                    + {{ btnMessage }}</md-button
                                >
                                <md-button
                                    v-else
                                    class="md-primary md-dense"
                                    @click="updateEducation"
                                    :disabled="isUpdating"
                                >
                                    <!-- <md-icon>arrow_circle_up</md-icon> -->
                                    ↑ {{ btnMessage }}</md-button
                                >
                                <md-button
                                    class="md-dense md-danger"
                                    @click="addEducation"
                                >
                                    <!-- <md-icon>close</md-icon> -->
                                    ✕ Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>

                <!-- <ordered-table></ordered-table> -->
                <div class="md-layout-item md-size-100 text-right">
                    <!-- <md-button class="md-dense md-success"
                        ><md-icon>save</md-icon> Save Educational
                        Background</md-button> -->
                </div>
            </div>
        </md-card-content>
    </md-card>
</template>
<script>
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import DialogCard from "../../components/Cards/DialogCard.vue";
export default {
    name: "PortalEducationalBackground",
    components: {
        DialogCard,
    },
    mixins: [userAction],
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        isAddEducation: false,
        currentSort: "level",
        currentSortOrder: "asc",
        getParamLevel: [],
        form: {
            level: [],
            schoolName: "School Name",
            course: "Course",
            attendedFrom: null,
            attendedTo: null,
            graduated: true,
            highestLevel: "Highest Level",
            yearGraduated: "Year Graduated",
            honors: "Honors",
        },
        education: [],

        isUpdating: false,
        btnMessage: "Education",
        isDeleted: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,

        isUpdateEmployee: false,

        //For Auto Completion
        paramSchoolName: [],
        paramCourse: [],
        paramHighestLevel: [],
        paramHonors: [],
    }),
    methods: {
        addEducation() {
            this.isAddEducation = !this.isAddEducation;
            this.isEdit = false;
            this.isUpdating = false;
            this.btnMessage = "Add Education";
        },

        //Save Education
        async validateAddEducation() {
            if (!Boolean(this.form.graduated)) {
                this.form.yearGraduated = null;
            }
            this.isUpdating = true;
            this.btnMessage = "Adding...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/education/portal/create/";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    level: this.form.level,
                    school_name: this.form.schoolName,
                    course: this.form.course,
                    attended_from: this.form.attendedFrom,
                    attended_to: this.form.attendedTo,
                    graduated: Boolean(this.form.graduated),
                    highest_level: this.form.highestLevel,
                    year_graduated: this.form.yearGraduated,
                    honors: this.form.honors,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.isUpdating = false;
                    this.btnMessage = "Add Education";
                    this.getEducation();
                    this.addEducation();
                    this.resetData();
                })
                .catch(function (error) {
                    console.error("ERRR: ", error);
                });
        },

        //Update Specific Education
        async updateEducation() {
            if (!Boolean(this.form.graduated)) {
                this.form.yearGraduated = null;
            }
            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/education/portal/update/" +
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
                    level: this.form.level,
                    school_name: this.form.schoolName,
                    course: this.form.course,
                    attended_from: this.form.attendedFrom,
                    attended_to: this.form.attendedTo,
                    graduated: Boolean(this.form.graduated),
                    highest_level: this.form.highestLevel,
                    year_graduated: this.form.yearGraduated,
                    honors: this.form.honors,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.resetData();
                    this.addEducation();
                    this.getEducation();
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Get Previously Saved Education
        async getEducation() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/education/portal/search/";

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
                    this.education = response.data.data;
                    console.log(this.education);
                })
                .catch((error) => {
                    console.error(error.data);
                });
            await this.getParam();
        },

        //Get Param for levels
        async getParam() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/education/portal/parameter/";
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
                    this.getParamLevel = response.data.level;
                    this.paramSchoolName = response.data.school_name;
                    this.paramCourse = response.data.course;
                    this.paramHighestLevel = response.data.highest_level;
                    this.paramHonors = response.data.honors;
                })
                .catch((error) => {
                    console.error(error.data);
                });
            console.log("get Param");
        },
        //Delete Education
        async deleteEducation(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/education/portal/delete/" + id;

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
                    this.notificationMessage = "Education has been deleted!";
                    this.isDeleted = true;
                })
                .catch(function (error) {
                    console.error(error);
                });
            this.getEducation();
        },

        //Get Specific Education
        async editEducation(id) {
            this.updateId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/education/portal/search/" + id;

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
                    this.form.level = response.data.level;
                    this.form.schoolName = response.data.school_name;
                    this.form.course = response.data.course;
                    this.form.attendedFrom = response.data.attended_from;
                    this.form.attendedTo = response.data.attended_to;
                    this.form.graduated = response.data.graduated;
                    this.form.yearGraduated = response.data.year_graduated;
                    this.form.highestLevel = response.data.highest_level;
                    this.form.honors = response.data.honors;
                    this.addEducation();
                    this.isEdit = true;
                    this.btnMessage = "Update Education";
                })
                .catch((error) => {
                    console.error(error);
                });
            this.getEducation();
        },

        //Reset Data
        resetData() {
            this.form.level = null;
            this.form.schoolName = null;
            this.form.course = null;
            this.form.attendedFrom = null;
            this.form.attendedTo = null;
            this.form.graduated = true;
            this.form.highestLevel = null;
            this.form.yearGraduated = null;
            this.form.honors = null;
        },
    },
    async mounted() {
        await this.getEducation();
        await this.getParam();
        this.isUpdateEmployee = localStorage.getItem("isUpdateEmployee");
    },
};
</script>
<style scoped>
/* .date{
    margin-top: -20px;
  } */
.md-card-header {
    background-color: #042278 !important;
}
.educationalBackground {
    background-color: #495057;
    border-color: #495057;
    color: white !important;
}
.md-table-sortable-icon {
    display: none !important;
}
</style>
