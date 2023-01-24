<template>
    <div class="content">
        <div class="md-layout">
            <div
                class="md-layout-item md-medium-size-100 md-size-100 md-layout"
            >
                <DialogCard v-if="empSearch">
                    <section slot="header">Search Employee</section>
                    <section slot="body">
                        <ListEmployee
                            v-on:close-dialog="getNewlySelectedEmployee"
                        ></ListEmployee>
                        <form>
                            <md-dialog-actions>
                                <!-- <md-button class="md-primary md-dense" type="submit">Search Employee</md-button > -->
                                <md-button
                                    v-if="!isEmployeeSelected"
                                    class="md-dense md-danger"
                                    @click="goBack"
                                    >Cancel</md-button
                                >
                                <md-button
                                    v-else
                                    class="md-dense"
                                    @click="searchEmp"
                                    :disabled="!isEmployeeSelected"
                                    >Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>
                <div class="md-layout-item md-small-size-100 md-size-25">
                    <label
                        v-if="
                            userAction === 'emp_selected' ||
                            userAction === 'edit'
                        "
                    >
                        <h5>
                            Name:
                            <label
                                style="text-transform: uppercase !important"
                                >{{ fullName }}</label
                            >
                        </h5>
                    </label>
                </div>

                <div
                    class="
                        md-layout-item md-small-size-100 md-size-75
                        text-right
                    "
                >
                    <md-button
                        class="md-raised md-primary md-dense emp-search"
                        @click="searchEmp"
                        v-if="$permissions.includes('search service record')"
                    >
                        Employee Search
                    </md-button>
                    <md-button
                        class="md-raised md-dense md-warning"
                        @click="
                            isPrintCertificateOfEmployment =
                                !isPrintCertificateOfEmployment
                        "
                        style="color: black !important; float: right !important"
                        v-if="$permissions.includes('print service record')"
                    >
                        Print Certificate of Employment
                    </md-button>
                    <md-button
                        class="md-raised md-dense md-warning"
                        @click="isPrintServiceRecord = !isPrintServiceRecord"
                        style="color: black !important; float: right !important"
                        v-if="$permissions.includes('print service record')"
                    >
                        Print Service Record
                    </md-button>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-card>
                        <md-card-header class="md-card-header">
                            <h4 class="title">Service Record</h4>
                        </md-card-header>
                        <md-card-content>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-100
                                    "
                                >
                                    <md-button
                                        class="md-raised md-dense"
                                        @click="addServiceRecord"
                                        v-if="
                                            $permissions.includes(
                                                'write service record'
                                            )
                                        "
                                    >
                                        Add Service Record
                                    </md-button>
                                </div>
                                <div
                                    class="md-layout-item md-size-100"
                                    style="margin-top: 50px"
                                >
                                    <md-table
                                        v-model="serviceRecords"
                                        md-sort="position"
                                        md-sort-order="asc"
                                        md-card
                                    >
                                        <md-table-toolbar>
                                            <h1 class="md-title">Records</h1>
                                        </md-table-toolbar>
                                        <md-table-row
                                            slot="md-table-row"
                                            slot-scope="{ item }"
                                        >
                                            <md-table-cell
                                                md-label="From"
                                                md-sort-by="date_from"
                                            >
                                                {{ item.date_from }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="To"
                                                md-sort-by="date_to"
                                            >
                                                {{ item.date_to }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Designation"
                                                md-sort-by="position"
                                            >
                                                {{ item.position }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Status"
                                                md-sort-by="status"
                                            >
                                                {{ item.status }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Salary"
                                                md-sort-by="salary"
                                            >
                                                ₱
                                                {{
                                                    Number(
                                                        item.salary.toFixed(1)
                                                    ).toLocaleString()
                                                }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Office / Project"
                                                md-sort-by="division"
                                            >
                                                {{ item.division }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Supervisor"
                                                md-sort-by="supervisor"
                                            >
                                                {{ item.supervisor }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Date of Separation"
                                                md-sort-by="date_seperation"
                                            >
                                                {{ item.date_seperation }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Cause of Separation"
                                                md-sort-by="cause"
                                            >
                                                {{ item.cause }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Leave without pay"
                                                md-sort-by="actions"
                                            >
                                                {{ item.status }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Remarks"
                                                md-sort-by="remark"
                                            >
                                                {{ item.remark }}
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Show in Reports"
                                                md-sort-by="show_in_reports"
                                            >
                                                <label
                                                    v-if="
                                                        item.show_in_reports ===
                                                        true
                                                    "
                                                    >Yes</label
                                                >
                                                <label
                                                    v-if="
                                                        item.show_in_reports ===
                                                        false
                                                    "
                                                    >No</label
                                                >
                                                <!-- {{ item.show_in_reports }} -->
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Attachments"
                                                md-sort-by="attachment"
                                            >
                                                <md-button
                                                    v-if="item.attachment"
                                                    @click="
                                                        viewAttachment(
                                                            item.attachment
                                                        )
                                                    "
                                                    class="md-dense md-primary"
                                                >
                                                    View
                                                </md-button>
                                            </md-table-cell>
                                            <md-table-cell
                                                md-label="Actions"
                                                md-sort-by="actions"
                                            >
                                                <md-button
                                                    class="
                                                        md-dense
                                                        md-primary
                                                        md-raised
                                                    "
                                                    @click="
                                                        editServiceRecord(
                                                            item.id
                                                        )
                                                    "
                                                    :disabled="item.isDeleted"
                                                    v-if="
                                                        $permissions.includes(
                                                            'write service record'
                                                        )
                                                    "
                                                    >✎</md-button
                                                >
                                                <md-button
                                                    class="
                                                        md-dense
                                                        md-danger
                                                        md-raised
                                                    "
                                                    @click="
                                                        deleteServiceRecord(
                                                            item.id
                                                        )
                                                    "
                                                    v-if="
                                                        $permissions.includes(
                                                            'delete service record'
                                                        )
                                                    "
                                                    :disabled="item.isDeleted"
                                                    >⌫</md-button
                                                >
                                                <md-button
                                                    class="
                                                        md-dense
                                                        md-warning
                                                        md-raised
                                                    "
                                                    @click="
                                                        restoreServiceRecord(
                                                            item.id
                                                        )
                                                    "
                                                    v-if="
                                                        $permissions.includes(
                                                            'restore service record'
                                                        )
                                                    "
                                                    :disabled="!item.isDeleted"
                                                >
                                                    <label style="color: black"
                                                        >⟳</label
                                                    >
                                                </md-button>
                                            </md-table-cell>
                                        </md-table-row>
                                    </md-table>
                                </div>
                            </div>
                        </md-card-content>
                    </md-card>
                </div>

                <!-- Show add service record module -->
                <DialogCard v-if="isAddServiceRecord">
                    <section v-if="!isUpdate" slot="header">
                        Add Service Record
                    </section>
                    <section v-else slot="header">Edit Service Record</section>
                    <section slot="body">
                        <form>
                            <md-checkbox v-model="show_in_reports"
                                >Show in reports
                            </md-checkbox>
                            <md-checkbox v-model="date_hired"
                                >Date Hired</md-checkbox
                            >
                            <md-checkbox v-model="is_uniformed"
                                >Uniformed</md-checkbox
                            >
                            <md-checkbox v-model="is_exempted"
                                >Output Based / Timekeeping
                                Exempted</md-checkbox
                            >
                            <md-checkbox v-model="is_wfh"
                                >Work From Home</md-checkbox
                            >

                            <md-field>
                                <label>Remarks</label>
                                <md-select v-model="remark_id" required>
                                    <md-option
                                        v-for="r in parameter.remark"
                                        :key="r.id"
                                        :value="r.id"
                                        >{{ r.name }}</md-option
                                    >
                                </md-select>
                            </md-field>
                            <md-datepicker
                                :md-model-type="String"
                                label="To"
                                v-model="date_from"
                            >
                                <label>From</label>
                            </md-datepicker>
                            <md-datepicker
                                :md-model-type="String"
                                label="From"
                                v-model="date_to"
                            >
                                <label>To</label>
                            </md-datepicker>
                            <md-field>
                                <label>Designation</label>
                                <md-input v-model="position_name" disabled>
                                </md-input>
                                <md-button
                                    class="md-dense md-raised md-primary"
                                    @click="searchPosition"
                                    >☰</md-button
                                >
                            </md-field>
                            <md-field>
                                <label>Designation (On Print)</label>
                                <md-input v-model="positionOnPrint"> </md-input>
                            </md-field>
                            <md-field>
                                <label>Status</label>
                                <md-select
                                    v-model="employment_status_id"
                                    required
                                >
                                    <md-option
                                        v-for="s in parameter.employment_status"
                                        :key="s.id"
                                        :value="s.id"
                                        >{{ s.name }}</md-option
                                    >
                                </md-select>
                            </md-field>
                            <md-field>
                                <label>Salary</label>
                                <md-input v-model="salary" required> </md-input>
                            </md-field>
                            <md-field>
                                <label>Station / Place of Assignment</label>
                                <md-input v-model="division_name" disabled>
                                </md-input>
                            </md-field>
                            <md-field>
                                <label
                                    >Station / Place of Assignment (on
                                    print)</label
                                >
                                <md-input v-model="divisionOnPrint"> </md-input>
                            </md-field>
                            <md-field>
                                <label>Place of Work</label>
                                <md-input v-model="place_of_work"> </md-input>
                            </md-field>
                            <md-field>
                                <label>Supervisor</label>
                                <md-input v-model="superVisor" disabled>
                                </md-input>
                            </md-field>
                            <md-field>
                                <label>Supervisor (on print)</label>
                                <md-input v-model="supervisorOnPrint">
                                </md-input>
                            </md-field>
                            <md-field>
                                <label>Employee Group</label>
                                <md-select v-model="employee_group_id">
                                    <md-option
                                        v-for="eg in parameter.employee_group"
                                        :key="eg.id"
                                        :value="eg.id"
                                        >{{ eg.name }}</md-option
                                    >
                                </md-select>
                            </md-field>
                            <md-field>
                                <label>Classification</label>
                                <md-select v-model="classification" required>
                                    <md-option
                                        v-for="c in parameter.classification"
                                        :key="c"
                                        :value="c"
                                        >{{ c }}</md-option
                                    >
                                </md-select>
                            </md-field>
                            <md-field>
                                <label>Level</label>
                                <md-select v-model="level" required>
                                    <md-option
                                        v-for="l in parameter.level"
                                        :key="l"
                                        :value="l"
                                        >{{ l }}</md-option
                                    >
                                </md-select>
                            </md-field>
                            <md-field>
                                <label>Attachment</label>
                                <!-- <md-file
                                    @change="
                                        (e) => (attachment = e.target.files[0])
                                    "
                                    accept="image/*"
                                /> -->
                                <md-file
                                    @change="
                                        (e) => (attachment = e.target.files[0])
                                    "
                                />
                            </md-field>

                            <md-dialog-actions>
                                <label
                                    v-if="fireNotification"
                                    style="color: red"
                                >
                                    {{ notificationMessage }}
                                </label>
                                <md-button
                                    v-if="!isUpdate"
                                    class="md-dense md-primary"
                                    @click="validateAddServiceRecord"
                                    :isSaving="isSaving"
                                >
                                    {{ btnMessage }}
                                </md-button>
                                <md-button
                                    v-else
                                    class="md-dense md-primary"
                                    @click="updateServiceRecord"
                                    :isSaving="isSaving"
                                >
                                    {{ btnMessage }}
                                </md-button>
                                <md-button
                                    class="md-dense md-danger"
                                    @click="addServiceRecord"
                                    >Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>

                <div class="md-layout-item md-size-50 text-right">
                    <!-- <md-button v-if="userAction != 'add' " class="md-raised md-dense md-warning" style="color: black !important; float: right !important;" @click="generatePds">PRINT PDS</md-button> -->
                </div>
            </div>
        </div>

        <!-- Show Position -->
        <DialogCard v-if="isSelecPosition">
            <section slot="header">Select Position</section>
            <section slot="body">
                <ListPosition
                    v-on:close-dialog="getPositionNameAndID"
                ></ListPosition>
                <md-dialog-actions>
                    <md-button class="md-dense" @click="searchPosition"
                        >Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- Print Service Record -->
        <DialogCard v-if="isPrintServiceRecord">
            <section slot="header">Print Service Record</section>
            <section slot="body">
                <md-field>
                    <label>Supervisor</label>
                    <md-input v-model="printServiceRecordSupervisor" required>
                    </md-input>
                </md-field>
                <md-field>
                    <label>Position</label>
                    <md-input v-model="printServiceRecordPosition" required>
                    </md-input>
                </md-field>
                <md-field>
                    <label>Division</label>
                    <md-input v-model="printServiceRecordDivision" required>
                    </md-input>
                </md-field>
                <md-dialog-actions>
                    <md-button
                        class="md-primary md-dense"
                        @click="generateServiceRecord"
                        >Generate Service Record</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="isPrintServiceRecord = !isPrintServiceRecord"
                        >✕ Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- Print Service Record -->
        <DialogCard v-if="isPrintCertificateOfEmployment">
            <section slot="header">Print Certificate of Employment</section>
            <section slot="body">
                <h4>Signature 1</h4>
                <md-field>
                    <label>Name</label>
                    <md-input v-model="printCoESignature1Name" required>
                    </md-input>
                </md-field>
                <md-field>
                    <label>Position</label>
                    <md-input v-model="printCoESignature1Position" required>
                    </md-input>
                </md-field>
                <md-field>
                    <label>Division</label>
                    <md-input v-model="printCoESignature1Division" required>
                    </md-input>
                </md-field>
                <h4>Signature 2</h4>
                <md-field>
                    <label>Name</label>
                    <md-input v-model="printCoESignature2Name" required>
                    </md-input>
                </md-field>
                <md-field>
                    <label>Position</label>
                    <md-input v-model="printCoESignature2Position" required>
                    </md-input>
                </md-field>
                <md-field>
                    <label>Division</label>
                    <md-input v-model="printCoESignature2Division" required>
                    </md-input>
                </md-field>
                <md-dialog-actions>
                    <md-button
                        class="md-primary md-dense"
                        @click="generateCertificateOfEmployment"
                        >Generate Certificate of Employment</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            isPrintCertificateOfEmployment =
                                !isPrintCertificateOfEmployment
                        "
                        >✕ Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- isUploadingAttachment -->
        <DialogCard v-if="isUploadingAttachment">
            <section slot="header">Uploading attachment</section>
            <section slot="body">
                <label
                    >Please do not close or refresh this window. Please
                    wait...</label
                >
            </section>
        </DialogCard>

        <!-- <md-dialog-alert :md-active.sync="fireNotification" :md-content="notificationMessage" md-confirm-text="Okay" /> -->
        <md-snackbar
            :md-position="'center'"
            :md-duration="2000"
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
const ListEmployee = () =>
    import(
        /* webpackChunkName: "ListEmployee" */ "../pages/Employee/ListEmployee.vue"
    );
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../components/Cards/DialogCard.vue";
import axios from "axios";
import UserAction from "../mixins/userAction.js";
const ListPosition = () =>
    import(
        /* webpackChunkName: "ListPosition" */ "../pages/Positions/ListPosition.vue"
    );
export default {
    name: "History",
    components: {
        DialogCard,
        ListEmployee,
        ListPosition,
    },
    mixins: [UserAction],
    data() {
        return {
            empSearch: false,
            currentTab: "personalInformation",
            fullName: localStorage.getItem("full_name"),
            isAddServiceRecord: false,
            parameter: [],
            btnMessage: "Add Record",
            isSaving: false,
            fireNotification: false,
            notificationMessage: null,
            isUpdate: false,

            //Print Service Record
            isPrintServiceRecord: false,
            printServiceRecordSupervisor: null,
            printServiceRecordPosition: null,
            printServiceRecordDivision: null,

            //Print Certificate of Employment
            isPrintCertificateOfEmployment: false,
            printCoESignature1Name: null,
            printCoESignature1Position: null,
            printCoESignature1Division: null,
            printCoESignature2Name: null,
            printCoESignature2Position: null,
            printCoESignature2Division: null,

            //Desginate a position
            isSelecPosition: false,
            position_name: null,
            positon_id: null,
            positionOnPrint: null,
            salary: null,
            updateId: null,
            fireSnackbar: false,
            messageSnackbar: null,

            //Division and Supervisor
            assigned_to: null,
            divisionOnPrint: null,
            division_name: null,
            assigned_supervisor: null,
            superVisor: null,
            supervisorOnPrint: null,

            //Show Employee Group
            employee_group_id: null,
            date_from: null,
            date_to: null,
            date_seperation: null,
            cause: null,
            employment_status_id: null,
            remark_id: null,
            awol_at: null,
            show_in_reports: true,
            is_uniformed: true,
            cancellation_reason: null,
            is_exempted: true,
            date_hired: true,
            place_of_work: null,
            is_wfh: true,
            classification: null,
            level: null,
            attachment: null,
            //Service Records
            serviceRecords: [],

            //Check if there is a selected employee
            isEmployeeSelected: true,

            //UI
            isUploadingAttachment: false,
        };
    },

    methods: {
        searchEmp() {
            this.empSearch = !this.empSearch;
        },

        //Go Back to Dashboard when user selected close
        goBack() {
            this.$router.push({ name: "Dashboard" });
        },

        //Ger Newly Selected Employee
        getNewlySelectedEmployee() {
            localStorage.setItem("search_user_history", "1");
            this.$router.go();
        },

        //Search Position
        searchPosition() {
            this.isSelecPosition = !this.isSelecPosition;
        },
        //View Attachment
        viewAttachment(attachmentUrl) {
            if (attachmentUrl.startsWith("http://localhost")) {
                window.open(
                    attachmentUrl.replace("localhost", "127.0.0.1:8000")
                );
            } else {
                window.open(attachmentUrl);
            }
        },
        async getPositionNameAndID() {
            this.position_name = localStorage.getItem("position_name");
            this.positionOnPrint = this.position_name;
            this.positon_id = localStorage.getItem("position_id");
            this.supervisorOnPrint = localStorage.getItem(
                "immediateSupervisor"
            );
            await this.getPosition();
            this.searchPosition();
        },

        //Show Modal For Adding Record
        addServiceRecord() {
            this.isAddServiceRecord = !this.isAddServiceRecord;
            this.isUpdate = false;
            this.btnMessage = "Add Service Record";
        },

        //Edit Service Record
        async editServiceRecord(id) {
            this.updateId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/service-record/search/" +
                this.empSelectionID +
                "/" +
                this.updateId;

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.axiosRequest(options);
            resp = resp.data;
            console.log(resp);
            this.date_from = resp.date_from;
            this.date_to = resp.date_to;
            this.positionOnPrint = resp.positionOnPrint;
            this.salary = resp.salary;
            this.divisionOnPrint = resp.divisionOnPrint;
            this.supervisorOnPrint = resp.supervisorOnPrint;
            this.date_seperation = resp.date_seperation;
            this.cause = resp.cause;
            this.employment_status_id = resp.employment_status_id;
            this.remark_id = resp.remark_id;
            this.awol_at = resp.awol_at;
            this.show_in_reports = resp.show_in_reports;
            this.is_uniformed = resp.is_uniformed;
            this.cancellation_reason = resp.cancellation_reason;
            this.is_exempted = resp.is_exempted;
            this.date_hired = resp.date_hired;
            this.place_of_work = resp.place_of_work;
            this.is_wfh = resp.is_wfh;
            this.classification = resp.classification;
            this.level = resp.level;
            // this.positon_id = resp.position.position_id
            // this.position_name = resp.position.name
            this.positon_id = resp.position_id;
            this.position_name = resp.positionOnPrint;
            // this.salary = resp.position.salary
            // this.assigned_to = resp.division.assigned_to
            // this.division_name = resp.division.name
            this.division_name = resp.divisionOnPrint;
            this.assigned_supervisor = resp.supervisor;
            this.assigned_supervisor = resp.supervisor;
            this.employee_group_id = resp.employee_group.employee_group_id;
            this.employment_status_id =
                resp.employment_status.employment_status_id;
            this.remark_id = resp.remark.remark_id;

            this.addServiceRecord();
            this.isUpdate = true;
            this.btnMessage = "Update Record";
        },

        //Delete Service Record
        async deleteServiceRecord(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/service-record/delete/" + id;

            const options = {
                method: "DELETE",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.axiosRequest(options);
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been deleted";
            await this.getServiceRecord();
        },

        //Restore Service Record
        async restoreServiceRecord(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/service-record/restore/" + id;

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.axiosRequest(options);
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been restored";
            await this.getServiceRecord();
        },

        //Get Service Record
        async getServiceRecord() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/service-record/search/" +
                this.empSelectionID;

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.axiosRequest(options);
            if (resp.status === 200) {
                this.serviceRecords = resp.data.data;
            }

            console.log(this.serviceRecords);
        },

        //Add Service Record
        async validateAddServiceRecord() {
            this.btnMessage = "Adding";
            this.isSaving = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/service-record/create/" +
                this.empSelectionID;

            let newData = {
                date_from: this.date_from,
                date_to: this.date_to,
                employee_group_id: this.employee_group_id,
                position_id: this.positon_id,
                positionOnPrint: this.positionOnPrint,
                salary: this.salary,
                assigned_to: this.assigned_to,
                divisionOnPrint: this.divisionOnPrint,
                assigned_supervisor: null,
                supervisorOnPrint: this.supervisorOnPrint,
                date_seperation: this.date_seperation,
                cause: this.cause,
                employment_status_id: this.employment_status_id,
                remark_id: this.remark_id,
                awol_at: null,
                show_in_reports: this.show_in_reports,
                is_uniformed: this.is_uniformed,
                cancellation_reason: this.cancellation_reason,
                is_exempted: this.is_exempted,
                date_hired: this.date_hired,
                place_of_work: this.place_of_work,
                is_wfh: this.is_wfh,
                classification: this.classification,
                level: this.level,
            };

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: newData,
            };

            let newlyCreatedId = null;
            await axios
                .request(options)
                .then((response) => {
                    this.btnMessage = "Add Record";
                    this.isSaving = false;
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Service Record saved succcessfully!";
                    this.addServiceRecord();
                    newlyCreatedId = response.data.data;
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There are error(s) in one or more fields. Please try again";
                    this.btnMessage = "Add Record";
                    this.isSaving = false;
                });

            //Update attachment after saving the form data
            if (this.attachment) {
                this.isUploadingAttachment = true;
                var formData = new FormData();
                formData.append("attachment", this.attachment);

                this.baseUrl = localStorage.getItem("base_url");

                let newOptionsAttachment = {
                    method: "POST",
                    url:
                        this.baseUrl +
                        "/api/service-record/attach/" +
                        newlyCreatedId,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "multipart/form-data",
                        Authorization: "Bearer " + getToken,
                    },
                    data: formData,
                };
                await axios
                    .request(newOptionsAttachment)
                    .then(() => {
                        console.log("attachment successful!");
                        this.getServiceRecord();
                    })
                    .catch((error) => {
                        console.log("attachment not successful!");
                    });

                this.isUploadingAttachment = false;
            }

            await this.getServiceRecord();
        },

        //Convert to proper Form Data
        // buildFormData(formData, data, parentKey) {
        //     if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
        //         Object.keys(data).forEach(key => {
        //         this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
        //         });
        //     } else {
        //         const value = data == null ? '' : data;

        //         formData.append(parentKey, value);
        //     }
        // },

        // jsonToFormData(data) {
        //     const formData = new FormData();

        //     this.buildFormData(formData, data);

        //     return formData;
        // },
        //Validate Update Service Record
        async updateServiceRecord() {
            this.btnMessage = "Updating...";
            this.isSaving = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/service-record/update/" + this.updateId;

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    date_from: this.date_from,
                    date_to: this.date_to,
                    employee_group_id: this.employee_group_id,
                    position_id: this.positon_id,
                    positionOnPrint: this.positionOnPrint,
                    salary: this.salary,
                    assigned_to: this.assigned_to,
                    divisionOnPrint: this.divisionOnPrint,
                    assigned_supervisor: null,
                    supervisorOnPrint: this.supervisorOnPrint,
                    date_seperation: this.date_seperation,
                    cause: this.cause,
                    employment_status_id: this.employment_status_id,
                    remark_id: this.remark_id,
                    awol_at: null,
                    show_in_reports: this.show_in_reports,
                    is_uniformed: this.is_uniformed,
                    cancellation_reason: this.cancellation_reason,
                    is_exempted: this.is_exempted,
                    date_hired: this.date_hired,
                    place_of_work: this.place_of_work,
                    is_wfh: this.is_wfh,
                    classification: this.classification,
                    level: this.level,
                },
            };

            let resp = await this.axiosRequest(options);
            console.log(resp.status);
            if (resp.status === 422) {
                this.fireSnackbar = true;
                this.messageSnackbar =
                    "There are error(s) in one or more fields. Please try again";
                this.btnMessage = "Update Record";
                this.isSaving = false;
            } else {
                this.fireSnackbar = true;
                this.messageSnackbar = "Service Record updated succcessfully!";
                this.btnMessage = "Update Record";
                this.isSaving = false;
                this.addServiceRecord();
            }

            //Update attachment
            if (this.attachment) {
                this.isUploadingAttachment = true;
                var formData = new FormData();
                formData.append("attachment", this.attachment);

                this.baseUrl = localStorage.getItem("base_url");

                let newOptionsAttachment = {
                    method: "POST",
                    url:
                        this.baseUrl +
                        "/api/service-record/attach/" +
                        this.updateId,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "multipart/form-data",
                        Authorization: "Bearer " + getToken,
                    },
                    data: formData,
                };
                await axios
                    .request(newOptionsAttachment)
                    .then(() => {
                        console.log("attachment successful!");
                        this.getServiceRecord();
                    })
                    .catch((error) => {
                        console.log("attachment not successful!");
                    });
                this.isUploadingAttachment = false;
            }

            await this.getServiceRecord();
        },

        //Get Position
        async getPosition() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/position/search/" + this.positon_id;

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let position = await this.axiosRequest(options);
            this.assigned_to = position.data.div.division_id;
            this.divisionOnPrint = position.data.div.name;
            this.division_name = this.divisionOnPrint;
            this.place_of_work = this.division_name;
            this.salary = position.data.sg.salary;
            this.assigned_supervisor =
                position.data.immediateSupervisor.supervisor_id;
            this.supervisorOnPrint = position.data.immediateSupervisor.name;
            this.superVisor = this.supervisorOnPrint;

            this.classification = position.data.classification;
            this.level = position.data.level;
        },

        //Get Parameter
        async getParam() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/service-record/parameter";

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            this.parameter = await this.axiosRequest(options);
            console.log(this.parameter);
            this.parameter = this.parameter.data;
        },

        //Generate Service Record
        async generateServiceRecord() {
            const employeeID = localStorage.getItem("accountId");
            // console.log(employeeID);
            //const empID = this.selectedEmpId;
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    permission: "print service record",
                    model_name: {
                        employeeId: this.empSelectionID,
                        supervisorName: this.printServiceRecordSupervisor,
                        position: this.printServiceRecordPosition,
                        division: this.printServiceRecordDivision,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    console.log(printToken);

                    //New Tab to generate the Report
                    parentURL =
                        parentURL +
                        "/generate/report/1/single/sr/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Generate Certificate of Employment
        async generateCertificateOfEmployment() {
            const employeeID = localStorage.getItem("accountId");
            // console.log(employeeID);
            //const empID = this.selectedEmpId;
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    permission: "print service record",
                    model_name: {
                        employeeId: this.empSelectionID,
                        mame1: this.printCoESignature1Name,
                        position1: this.printCoESignature1Position,
                        division1: this.printCoESignature1Division,
                        name2: this.printCoESignature2Name,
                        position2: this.printCoESignature2Position,
                        division2: this.printCoESignature2Division,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    console.log(printToken);

                    //New Tab to generate the Report
                    parentURL =
                        parentURL +
                        "/generate/report/1/single/ce/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Model Axios Request
        async axiosRequest(options) {
            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    resp = error.response;
                });
            return resp;
        },
    },
    async created() {
        console.log(this.empSelectionID);
        if (this.empSelectionID === null) {
            this.isEmployeeSelected = false;
            this.empSearch = true;
        } else {
            this.isEmployeeSelected = true;
        }
        if (localStorage.getItem("search_user_history") === "1") {
            this.fullName = localStorage.getItem("selection_name_history");
        }
        await this.getParam();
        await this.getServiceRecord();
    },
};
</script>

<style scoped>
.emp-search {
    float: right;
}
.md-card-header {
    background-color: #042278 !important;
}
</style>
<style lang="scss" scoped>
.md-checkbox {
    display: flex;
}
</style>
