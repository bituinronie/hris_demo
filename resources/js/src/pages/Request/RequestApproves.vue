<template>
    <div>
        <DialogCard v-if="!isAuthenticated">
            <section slot="body">
                Oops. Session expired. Please relogin.
                <md-dialog-actions>
                    <md-button
                        class="md-primary md-dense md-raised"
                        @click="logOut"
                        >Confirm</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>
        <!-- Approver Requests -->
        <div>
            <!-- Approver Requests -->
            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Approver Requests</h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-table md-card>
                                    <md-table-toolbar>
                                        <div class="md-toolbar-section-start">
                                            <!-- <h1 class="md-title">Regular Schedule</h1> -->
                                        </div>
                                        <form
                                            @submit.prevent="searchRequests()"
                                        >
                                            <md-field
                                                class="md-toolbar-section-end"
                                            >
                                                <md-input
                                                    placeholder="Search Requests"
                                                    v-model="
                                                        searchValueOnApprover
                                                    "
                                                />
                                                <md-button
                                                    type="submit"
                                                    class="md-primary md-dense"
                                                    style="
                                                        margin-bottom: 10px !important;
                                                    "
                                                    :disabled="
                                                        isSearchingRequests
                                                    "
                                                >
                                                    {{ btnSearchRequest }}
                                                </md-button>
                                            </md-field>
                                        </form>
                                    </md-table-toolbar>
                                    <md-table-empty-state
                                        md-label="No requests found"
                                        :md-description="`No request found in this record / user. Try searhing for a different term.`"
                                    >
                                        <!-- <md-button
                                            class="
                                                md-primary md-raised md-dense
                                            "
                                            @click="
                                                isAddManualRequest =
                                                    !isAddManualRequest
                                            "
                                            >Add Request</md-button
                                        > -->
                                    </md-table-empty-state>
                                    <md-table-row>
                                        <md-table-head></md-table-head>
                                        <md-table-head>Date Filled</md-table-head>
                                        <md-table-head>Request Type</md-table-head>
                                        <md-table-head>Category</md-table-head>
                                        <md-table-head>Employee Name</md-table-head>
                                        <md-table-head>From</md-table-head>
                                        <md-table-head>To</md-table-head>
                                        <md-table-head>Credit</md-table-head>
                                        <md-table-head>Status</md-table-head>
                                        <md-table-head>Remarks</md-table-head>
                                        <md-table-head>Actions</md-table-head>
                                    </md-table-row>
                                    <template v-for="(item, i) in approverRequests">
                                        <md-table-row :key="i + 'a'">
                                            <md-table-cell>
                                            <md-button
                                                class="
                                                    md-icon-button
                                                    md-primary
                                                "
                                                @click="toggleTableRow(item.id)"
                                            >
                                                <md-icon>{{
                                                    expandedTableId ==
                                                    item.id
                                                        ? "expand_more"
                                                        : "chevron_right"
                                                }}</md-icon>
                                            </md-button>
                                        </md-table-cell>
                                        <md-table-cell md-numeric>{{ item.dateFiled }}</md-table-cell>
                                        <md-table-cell>{{ item.requestType }}</md-table-cell>
                                        <md-table-cell>{{ item.category }}</md-table-cell>
                                        <md-table-cell>{{ item.name }}</md-table-cell>
                                        <md-table-cell>{{ item.from }}</md-table-cell>
                                        <md-table-cell>{{ item.to }}</md-table-cell>
                                        <md-table-cell>{{ item.credit }}</md-table-cell>
                                        <md-table-cell>
                                            <span
                                                :class="{
                                                    requested: item.status == 1,
                                                    approved: item.status == 2,
                                                    disapproved:
                                                        item.status == 3,
                                                    cancelled: item.status == 4,
                                                    automatic: item.status == 5,
                                                    manual: item.status == 6,
                                                    systemGenerated:
                                                        item.status == 7,
                                                }">
                                                {{statusValue(item.status)}}
                                            </span>
                                        </md-table-cell>
                                        <md-table-cell>{{ item.remarks }}</md-table-cell>
                                        <md-table-cell>
                                             <md-button
                                                v-if="
                                                    item.status != 3 &&
                                                    item.status != 2
                                                "
                                                class="
                                                    md-raised
                                                    md-dense
                                                    md-success
                                                "
                                                @click="approveRequest(item.id)"
                                                :disabled="
                                                    item.status == 3 ||
                                                    item.status == 2
                                                        ? true
                                                        : false
                                                "
                                            >
                                                ✓ Approve
                                                <!-- Cancel -->
                                                <md-tooltip md-direction="top"
                                                    >Approve this
                                                    record.</md-tooltip
                                                >
                                            </md-button>
                                            <md-button
                                                v-if="
                                                    item.status != 3 &&
                                                    item.status != 2
                                                "
                                                class="
                                                    md-raised md-dense md-danger
                                                "
                                                @click="rejectRequest(item.id)"
                                                :disabled="
                                                    item.status == 3 ||
                                                    item.status == 2
                                                        ? true
                                                        : false
                                                "
                                            >
                                                x Reject
                                                <!-- Cancel -->
                                                <md-tooltip md-direction="top"
                                                    >Reject this
                                                    record.</md-tooltip
                                                >
                                            </md-button>
                                        </md-table-cell>
                                        </md-table-row>
                                        <md-table-row :key="i + 'b'" v-if="expandedTableId == item.id">
                                            <md-table-cell colspan="11" style="background-color: #eeeeee;">
                                                <div style="text-align: left">
                                                    <div style="padding: 5px">
                                                        <strong>REASON: </strong> {{item.reason}}
                                                    </div>
                                                    <div style="padding: 5px" v-if="item.ob_venue && item.ob_venue != 'null'">
                                                        <strong>VENUE: </strong> {{ item.ob_venue }}
                                                    </div>
                                                    <div style="padding: 5px">
                                                        <strong>FIRST APPROVER: </strong>
                                                        <span
                                                            v-if="item.approverStatus.firstApprover"
                                                            :class="{
                                                                requested: item.approverStatus.firstApprover == 1,
                                                                approved: item.approverStatus.firstApprover == 2,
                                                                disapproved:
                                                                    item.approverStatus.firstApprover == 3,
                                                                cancelled: item.approverStatus.firstApprover == 4,
                                                                automatic: item.approverStatus.firstApprover == 5,
                                                                manual: item.approverStatus.firstApprover == 6,
                                                                systemGenerated:
                                                                    item.approverStatus.firstApprover == 7,
                                                            }">
                                                            {{statusValue(item.approverStatus.firstApprover)}}
                                                        </span>
                                                    </div>
                                                    <div style="padding: 5px">
                                                        <strong>SECOND APPROVER: </strong>
                                                        <span
                                                            v-if="item.approverStatus.secondApprover"
                                                            :class="{
                                                                requested: item.approverStatus.secondApprover == 1,
                                                                approved: item.approverStatus.secondApprover == 2,
                                                                disapproved:
                                                                    item.approverStatus.secondApprover == 3,
                                                                cancelled: item.approverStatus.secondApprover == 4,
                                                                automatic: item.approverStatus.secondApprover == 5,
                                                                manual: item.approverStatus.secondApprover == 6,
                                                                systemGenerated:
                                                                    item.approverStatus.secondApprover == 7,
                                                            }">
                                                            {{statusValue(item.approverStatus.secondApprover)}}
                                                        </span>
                                                    </div>
                                                    <div style="padding: 5px">
                                                        <strong>FINAL APPROVER: </strong>
                                                        <span
                                                            v-if="item.approverStatus.finalApprover"
                                                            :class="{
                                                                requested: item.approverStatus.finalApprover == 1,
                                                                approved: item.approverStatus.finalApprover == 2,
                                                                disapproved:
                                                                    item.approverStatus.finalApprover == 3,
                                                                cancelled: item.approverStatus.finalApprover == 4,
                                                                automatic: item.approverStatus.finalApprover == 5,
                                                                manual: item.approverStatus.finalApprover == 6,
                                                                systemGenerated:
                                                                    item.approverStatus.finalApprover == 7,
                                                            }">
                                                            {{statusValue(item.approverStatus.finalApprover)}}
                                                        </span>
                                                    </div>
                                                    <div style="padding: 5px">
                                                        <strong>PROOF: </strong> 
                                                        <md-button
                                                            style="margin: 0 !important;"
                                                            v-if="item.proof"
                                                            class="md-dense md-primary text-button"
                                                            @click="viewImage(item.proof)"

                                                            >View Attachment</md-button
                                                        >
                                                    </div>
                                                    
                                                </div>
                                            </md-table-cell>
                                        </md-table-row>
                                    </template>
                                </md-table>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        </div>

        <!-- Dialog Cards Here -->
        <!-- Add Manual Request -->
        <DialogCard v-if="isAddManualRequest || isUpdateRequest">
            <section slot="header">REQUEST</section>
            <section slot="body" class="dCardBody">
                <form
                    method="post"
                    @submit.prevent="
                        isUpdateRequest ? updateRequest() : addManualRequest()
                    "
                >
                    <md-field>
                        <label for="requestTypes">Request Type</label>
                        <md-select
                            v-model="requestTypeId"
                            name="Request Types"
                            id="requestTypes"
                            @md-selected="selectRequestType()"
                        >
                            <md-option
                                v-for="(requestType, index) in requestTypes"
                                :key="index"
                                :value="requestType.id"
                                >{{ requestType.code }} -
                                {{ requestType.description }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-field v-if="requestTypeId === 15">
                        <label for="obVenue">OB Venue</label>
                        <md-select
                            v-model="obVenue"
                            name="OB Venue"
                            id="obVenue"
                        >
                            <md-option
                                v-for="(val, index) in ob"
                                :key="index"
                                :value="val.name"
                                >{{ val.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-content>
                        <span class="md-body-2">Current Balance: </span>
                        {{ currentBalance }}
                        days
                    </md-content>
                    <span style="margin-top: 25px">
                        <md-checkbox v-model="isStart">Is Start?</md-checkbox>
                    </span>

                    <md-datepicker
                        md-placeholder="Enter date"
                        :md-immediately="true"
                        :md-model-type="String"
                        v-model="fromDate"
                        @md-closed="selectFromDate()"
                        @md-opened="selectFromDate()"
                        ><label>From:</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        :md-immediately="true"
                        md-placeholder="Enter date"
                        v-model="toDate"
                        @md-closed="selectToDate()"
                        @md-opened="selectToDate()"
                        ><label>To:</label></md-datepicker
                    >
                    <div
                        v-if="computeCreditError"
                        style="color: red; text-align: right"
                    >
                        {{ computeCreditError }}
                    </div>
                    <!-- <md-field>
                        <label for="selectHalfDay">Half Day? Leave blank if not.</label>
                        <md-select v-model="halfDay" name="Half Day" id="halfDay">
                            <md-option
                                :value="'na'">
                                NA
                            </md-option>
                            <md-option
                                v-for="(day, index) in halfDays"
                                :key="index"
                                :value="day"
                                >{{ day }}
                            </md-option>
                        </md-select>
                    </md-field> -->
                    <md-field>
                        <label>Credit</label>
                        <md-input v-model="credit"></md-input>
                    </md-field>
                    <md-field>
                        <label>Reason</label>
                        <md-textarea v-model="reason"></md-textarea>
                    </md-field>
                    <!-- <md-field v-if="isUpdateRequest">
                        <label>Status</label>
                        <md-select v-model="statusId">
                            <md-option
                                v-for="s in status"
                                :key="s.id"
                                :value="s.id"
                                >{{ s.value }}</md-option
                            >
                        </md-select>
                    </md-field> -->
                    <md-field>
                        <label>Attach Proof</label>
                        <md-file
                            @change="(e) => (proof = e.target.files[0])"
                            accept="image/*"
                        />
                    </md-field>
                    <md-field>
                        <label>Proof Type</label>
                        <md-input v-model="proofType"></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            :disabled="isAddingRequest"
                        >
                            {{ addBtn }}</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="
                                isUpdateRequest
                                    ? (isUpdateRequest = false)
                                    : (isAddManualRequest = false)
                            "
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <DialogCard v-if="isRejectRequest">
            <section slot="header">Confirm Request Rejection?</section>
            <section slot="body" class="remarksCardBody">
                <md-field>
                    <label>Remarks</label>
                    <md-textarea v-model="remarks" md-autogrow></md-textarea>
                </md-field>
                <md-dialog-actions>
                    <md-button
                        class="md-primary md-dense md-raised"
                        @click="validateRejectRequest"
                        >{{ rejectButton }}</md-button
                    >
                    <md-button
                        class="md-dense md-raised md-danger"
                        @click="isRejectRequest = false"
                    >
                        <!-- <md-icon>close</md-icon> -->
                        ✕ Cancel</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- Cancel Request -->
        <DialogCard v-if="isCancelRequest">
            <section slot="header">Confirm Request Cancellation?</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateCancelRequest">
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            :disabled="isCancelling"
                        >
                            {{ cnclButton }}
                        </md-button>
                        <md-button
                            class="md-dense md-raised md-warning"
                            style="color: black !important"
                            @click="isCancelRequest = false"
                        >
                            No, I changed my mind</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Approve Request -->
        <DialogCard v-if="isApproveRequest">
            <section slot="header">Confirm Request Approval?</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateApproveRequest">
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            :disabled="isApproving"
                        >
                            {{ approveButton }}
                        </md-button>
                        <md-button
                            class="md-dense md-raised md-warning"
                            style="color: black !important"
                            @click="isApproveRequest = false"
                        >
                            No, I changed my mind</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

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
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";

let baseUrl = localStorage.getItem("base_url");
let token = localStorage.getItem("token");

export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    name: "RequestApproves",
    props: [
        // {
        //     dataBackgroundColor: {
        //         type: String,
        //         default: "",
        //     },

        // },
        "vemployee",
        "vapprover",
    ],
    data: () => ({
        // UI Model
        addBtn: "Add Request",
        isAddingRequest: false,

        //Snackkbar
        fireSnackbar: false,
        messageSnackbar: "Sample",

        timeSheetHistoryMonth: 0,
        perPage: 31,
        type: null,
        isAuthenticated: true,
        dateFrom: null,
        dateTo: null,
        status: null,
        vacationLeave: 0,
        sickLeave: 0,
        forcedLeave: 0,
        specialPrivelegedLeave: 0,
        ctoLeaveBalance: 0,
        employeeRequests: [],
        approverRequests: [],

        isAddManualRequest: false,

        // Data
        dataParams: [],
        requestTypes: [],
        halfDays: [],
        categories: [],
        status: [],
        ob: [],
        requestTypeId: "",
        fromDate: null,
        toDate: null,
        refDate: null,
        halfDay: null,
        reason: "",
        proofType: "",
        proof: null,
        obVenue: null,
        remarks: "",
        requestEmployee: null,
        // Converted Date
        from: null,
        to: null,

        requestId: null,
        //Request Cancellation
        isCancelRequest: false,
        cnclButton: "Confirm Cancel Request",
        isCancelling: false,
        cancelId: null,

        // Reject Request
        isRejectRequest: false,
        rejectButton: "Confirm Reject Request",
        isRejecting: false,

        // Approve Request
        isApproveRequest: false,
        approveButton: "Confirm Approve Request",
        isApproving: false,

        // Compute Credit
        computeCreditError: "",
        credit: null,

        // Update
        isUpdateRequest: false,
        updateRequestData: {},

        // Balance
        balance: {},
        currentBalance: 0,

        //Status
        // statusId: 0,
        isStart: false,

        //Update Credit
        updatingCredit: 0,

        //Search
        searchValueOnApprover: null,
        btnSearchRequest: "Search",
        isSearchingRequests: false,

        expandedTableId: null
    }),
    methods: {
        //Add Manual Request
        async addManualRequest() {
            this.addBtn = "Adding...";
            this.isAddingRequest = true;

            const data = {
                request_type_id: this.requestTypeId,
                from: this.from,
                to: this.to,
                useSchedule: true,
                reason: this.reason,
                credit: this.credit,
                proof_type: this.proofType,
                ob_venue: this.obVenue,
                is_start: this.isStart,
            };

            var formData = new FormData();

            for (var key in data) {
                formData.append(key, data[key]);
            }

            if (this.proof) {
                formData.append("proof", this.proof);
            }

            const options = {
                method: "POST",
                url: baseUrl + "/api/request/create/" + this.empSelectionID,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                    "Content-Type": "multipart/form-data",
                },
                data: formData,
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Request submitted!";
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.addBtn = "Add Request";
            this.isAddingRequest = false;
            this.isAddManualRequest = false;
            this.getBalance();
            this.getEmployeeRequests();
            this.getApproverRequests();
        },
        computeCredit() {
            console.log(this.from);
            console.log(this.to);
            this.computeCreditError = "";
            this.credit = "";
            if (this.from && this.to) {
                const options = {
                    method: "POST",
                    url:
                        baseUrl + "/api/request/compute/" + this.empSelectionID,
                    params: {
                        // Add params
                    },
                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + token,
                    },
                    data: {
                        request_type_id: this.requestTypeId,
                        from: this.from,
                        to: this.to,
                    },
                };
                axios
                    .request(options)
                    .then((res) => {
                        this.credit = res.data.credit;
                        this.computeCreditError = "";
                    })
                    .catch((err) => {
                        if (
                            err.response.data.message ==
                            'Attempt to read property "workMinutes" on null'
                        ) {
                            this.computeCreditError =
                                "Assign schedule to employee first";
                        } else {
                            this.computeCreditError = err.response.data.message;
                        }
                    });
            }

            // if(this.isUpdateRequest){
            //     this.credit = this.updatingCredit
            //     console.log('Editing'+this.credit)
            // }
            // this.credit = 10
            // console.log(this.credit)
        },
        approveRequest(id) {
            this.requestId = id;
            this.isApproveRequest = true;
        },
        rejectRequest(id) {
            this.requestId = id;
            this.isRejectRequest = true;
        },
        cancelRequest(id) {
            this.requestId = id;
            this.isCancelRequest = true;
        },

        async validateApproveRequest() {
            this.approveButton = "Approving...";
            this.isApproving = true;

            const options = {
                method: "POST",
                url:
                    baseUrl + "/api/request/approver/approve/" + this.requestId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then(() => {
                    this.approveButton = "Confirm Approve Request";
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Request approved!";
                })
                .catch((error) => {
                    this.approveButton = "Confirm Approve Request";
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "An error occured. Please try again.";
                });
            this.getApproverRequests();
            this.approveButton = "";
            this.isApproving = false;
            this.isApproveRequest = false;
        },

        async validateRejectRequest() {
            this.rejectButton = "Rejecting...";
            this.isRejecting = true;

            const options = {
                method: "POST",
                url:
                    baseUrl +
                    "/api/request/approver/disapprove/" +
                    this.requestId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    remarks: this.remarks,
                },
            };

            await axios
                .request(options)
                .then(() => {
                    this.rejectButton = "Confirm Reject Request";
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Request rejected!";
                })
                .catch((error) => {
                    console.error(error);
                    this.rejectButton = "Confirm Reject Request";
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "An error occured. Please try again.";
                });
            await this.getApproverRequests();
            this.rejectButton = "Confirm Reject Request";
            this.isRejecting = false;
            this.isRejectRequest = false;
        },

        async validateCancelRequest() {
            this.cnclButton = "Cancelling...";
            this.isCancelling = true;
            const options = {
                method: "POST",
                url: baseUrl + "/api/request/portal/cancel/" + this.requestId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Request cancellation completed!";
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue cancelling the request. Please try again.";
                });
            await this.getEmployeeRequests();
            this.cnclButton = "Confirm Cancel Request";
            this.isCancelling = false;
            this.isCancelRequest = false;
        },
        resetFilters() {},
        firePerPage() {},
        fireRequestType() {},
        getRecordMonth() {},
        fireStatus() {},

        //Get Employee Request
        async getEmployeeRequests() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/search/" + this.empSelectionID,
                params: {
                    perPage: "20",
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            const response = await axios.request(options);
            const employeeRequests = response.data;

            this.employeeRequests = employeeRequests.data;
            await this.getBalance();
        },

        // //Get Balance
        // async getBalance(){
        //     let newUrl = baseUrl + '/api/request/balance/' + this.empSelectionID
        //     const options = {
        //     method: 'GET',
        //     url: newUrl,
        //     headers: {
        //         Accept: 'application/json',
        //         Authorization: 'Bearer '+token
        //         }
        //     };

        //     axios.request(options).then((response)=>{
        //         console.log(response.data);
        //     }).catch((error)=>{
        //         console.error(error);
        //     });
        // },

        //Get Approver Requests initial load
        async getApproverRequests() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/approver/search",
                params: {
                    perPage: "20",
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            const response = await axios.request(options);
            const approverRequests = response.data;

            this.approverRequests = approverRequests.data;
        },

        //Search Approver Request
        async searchRequests() {
            this.isSearchingRequests = true;
            this.btnSearchRequest = "Searching...";
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/approver/search/",
                params: {
                    searchValue: this.searchValueOnApprover,
                    perPage: "20",
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.approverRequests = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isSearchingRequests = false;
            this.btnSearchRequest = "Search";
        },

        //Get Data Params
        async getDataParams() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/portal/parameter",
                params: {
                    // Add params
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            const response = await axios.request(options);
            const data = response.data;
            // console.log('Data: ', response.data)
            // console.log('Req data: ', response.data.request_type_id)

            this.requestTypes = data.request_type_id;
            this.halfDays = data.halfDay;
            this.categories = data.category;
            this.status = data.status;
            this.ob = data.ob;
        },

        //Get Parameters for request type
        async getRequestType() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request-type/search/",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.requestTypes = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        async getBalance() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/balance/" + this.empSelectionID,
                params: {
                    // Add params
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            await axios
                .request(options)
                .then((res) => {
                    this.balance = res.data;
                })
                .catch((err) => {
                    console.error(err.response);
                });
        },

        convertDate(date) {
            let newDate = new Date(date);
            let month = ("0" + (newDate.getMonth() + 1)).slice(-2);
            let day = ("0" + newDate.getDate()).slice(-2);
            return [newDate.getFullYear(), month, day].join("-");
        },
        convertDateFromBE(date) {
            let newDate = date.split(" | ")[0];
            let month = new Date(newDate).getMonth() + 1;
            if (month.toString().length == 1) {
                month = "0" + month.toString();
            }
            let arr = newDate.split(" ");
            arr[1] = month;

            return arr.join("-");
        },
        statusValue(statusId) {
            switch (statusId) {
                case 1:
                    return "REQUESTED";
                    break;
                case 2:
                    return "APPROVED";
                    break;
                case 3:
                    return "DISAPPROVED";
                    break;
                case 4:
                    return "CANCELLED";
                    break;
                case 5:
                    return "AUTOMATIC";
                    break;
                case 6:
                    return "MANUAL";
                    break;
                case 7:
                    return "SYSTEM GENERATED";
                    break;
                default:
                    return "Undefined";
            }
        },
        viewImage(url) {
            // window.open(url);
            if (url.startsWith("http://localhost")) {
                window.open(url.replace("http://localhost", baseUrl));
            } else {
                window.open(url);
            }
        },

        async selectFromDate() {
            // this.fromDate = this.convertDate(this.fromDate);
            // console.log(this.fromDate)
            this.from = this.fromDate + " 01:00:00";
            this.computeCredit();
        },
        async selectToDate() {
            // this.toDate = this.convertDate(this.toDate);
            // console.log(this.toDate)
            this.to = this.toDate + " 23:59:59";
            this.computeCredit();
        },
        selectRequestType() {
            this.computeCredit();
        },

        //Update Request
        async updateRequest() {
            this.addBtn = "Updating...";
            this.isAddingRequest = true;
            console.log(this.from);
            const data = {
                request_type_id: this.requestTypeId,
                from: this.from,
                to: this.to,
                useSchedule: true,
                reason: this.reason,
                credit: this.credit,
                proof_type: this.proofType,
                ob_venue: this.obVenue,
                // status: this.statusId,
                is_start: this.isStart,
            };

            var formData = new FormData();

            for (var key in data) {
                formData.append(key, data[key]);
            }

            if (this.proof) {
                formData.append("proof", this.proof);
            }

            console.log(formData);

            const options = {
                method: "POST",
                url:
                    baseUrl +
                    "/api/request/update/" +
                    this.updateRequestData.id,
                params: {
                    // Add params
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                    "Content-Type": "multipart/form-data",
                },
                data: formData,
            };
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Request updated!";
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isUpdateRequest = false;
            this.isAddingRequest = false;
            this.getBalance();
            this.getEmployeeRequests();
            this.getApproverRequests();
        },

        //Print Request
        async printRequest(id) {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseUrl + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "portal request",
                    model_name: {
                        requestId: id,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseUrl +
                        "/generate/report/3/portal/leave-application-form/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        toggleTableRow(id) {
            if (this.expandedTableId == id) {
                this.expandedTableId = null
            } else {
                this.expandedTableId = id
            }
        }
    },
    async created() {
        if (this.empSelectionID === null) {
            this.$store.commit(
                "changecurrentSelectionUserId",
                localStorage.getItem("accountId")
            );
            this.$store.commit(
                "changeCurrentSelectionUserName",
                localStorage.getItem("full_name")
            );
        }

        // Get Balance
        this.getBalance();

        // Get Request Types
        this.getDataParams();
        // Get Employee Requests
        this.getEmployeeRequests();
        // Get Approver Requests
        this.getApproverRequests();

        //Get Request Type
        await this.getRequestType();
    },
    watch: {
        fromDate: function (date) {
            // this.fromDate = this.convertDate(date);
            this.from = this.fromDate + " 01:00:00";
            if (!this.isUpdateRequest) {
                this.computeCredit();
            }
        },
        toDate: function (date) {
            // this.toDate = this.convertDate(date);
            this.to = this.toDate + " 23:00:00";
            if (!this.isUpdateRequest) {
                this.computeCredit();
            }
        },
        requestTypeId: function (id) {
            // this.computeCredit()
            this.currentBalance =
                this.balance[
                    this.requestTypes[
                        this.requestTypes.findIndex((x) => x.id == id)
                    ].code
                ];
        },
        isUpdateRequest: function (bool) {
            if (bool) {
                this.addBtn = "Update Request";
                this.requestTypeId = this.updateRequestData.request_type_id;
                this.fromDate = this.convertDateFromBE(
                    this.updateRequestData.from
                );
                this.from = this.fromDate + " 00:00:01";
                this.toDate = this.convertDateFromBE(this.updateRequestData.to);
                this.to = this.toDate + " 23:59:59";
                this.credit = this.updateRequestData.credit;
                // this.updatingCredit = this.updateRequestData.credit
                this.proofType = this.updateRequestData.proof_type;
                this.proof = this.updateRequestData.proof;
                this.obVenue = this.updateRequestData.ob_venue;
            } else {
                this.addBtn = "Add Request";
                this.requestTypeId = null;
                // this.fromDate = null;
                // this.toDate = null;
                this.credit = null;
                this.proofType = null;
                this.proof = null;
                this.obVenue = null;
            }
        },
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
.vacation_leave {
    background-color: rgb(211, 47, 47) !important;
}
.sick_leave {
    background-color: rgb(194, 24, 91) !important;
}
.forced_leave {
    background-color: rgb(81, 45, 168) !important;
}
.special_leave {
    background-color: rgb(2, 136, 209) !important;
}
.cto_leave {
    background-color: rgb(224, 226, 117) !important;
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
.remarksCardBody {
    min-width: 640px !important;
}
.dCardBody {
    min-height: 500px !important;
    min-width: 640px !important;
}
.requested {
    color: #fff !important;
    padding: 5px !important;
    background: #0275d8 !important;
}
.approved {
    color: #fff !important;
    padding: 5px !important;
    background: #5cb85c !important;
}
.disapproved {
    color: #fff !important;
    padding: 5px !important;
    background: #d9534f !important;
}
.cancelled {
    color: #fff !important;
    padding: 5px !important;
    background: #f0ad4e !important;
}
.automatic {
    color: #000 !important;
    padding: 5px !important;
    background: #f7f7f7 !important;
}
.manual {
    color: #fff !important;
    padding: 5px !important;
    background: #292b2c !important;
}
.systemGenerated {
    color: #fff !important;
    padding: 5px !important;
    background: #5bc0de !important;
}
.md-menu-content {
    max-width: 500px !important;
    width: 500px !important;
}
</style>
