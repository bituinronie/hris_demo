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

        <!-- Time Sheet History -->
        <div class="md-layout">
            <!-- Requests -->
            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">
                            Request Summary for
                            <label
                                style="text-transform: uppercase !important"
                                >{{ $store.state.userInfo.fullName }}</label
                            >
                        </h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-button
                                    class="md-raised md-dense md-primary"
                                    v-if="isOkToRequest"
                                    @click="
                                        isAddManualRequest = !isAddManualRequest
                                    "
                                >
                                    Add Request
                                </md-button>

                                <md-button
                                    class="raised md-dense md-primary"
                                    @click="resetFilters"
                                >
                                    Reset Filters
                                </md-button>

                                <!-- <md-button
                                    class="md-raised md-dense md-warning"
                                    style="color: black !important"
                                >
                                    Print Summary
                                </md-button> -->
                            </div>
                        </div>
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-field>
                                    <label>Per Page</label>
                                    <md-select
                                        v-model="perPage"
                                        @md-selected="firePerPage"
                                    >
                                        <md-option value="5">5</md-option>
                                        <md-option value="10">10</md-option>
                                        <md-option value="15">15</md-option>
                                        <md-option value="20">20</md-option>
                                        <md-option value="31">31</md-option>
                                    </md-select>
                                </md-field>
                            </div>
                            <!-- <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-field>
                                    <label>Request Type</label>
                                    <md-select
                                        v-model="type"
                                        @md-selected="fireRequestType"
                                    >
                                        <md-option value="type">Type</md-option>
                                    </md-select>
                                </md-field>
                            </div> -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-field>
                                    <label>Select Month</label>
                                    <md-select
                                        v-model="month"
                                        @md-selected="getRecordMonth"
                                    >
                                        <md-option value="1">January</md-option>
                                        <md-option value="2"
                                            >February</md-option
                                        >
                                        <md-option value="3">March</md-option>
                                        <md-option value="4">April</md-option>
                                        <md-option value="5">May</md-option>
                                        <md-option value="6">June</md-option>
                                        <md-option value="7">July</md-option>
                                        <md-option value="8">August</md-option>
                                        <md-option value="9"
                                            >September</md-option
                                        >
                                        <md-option value="10"
                                            >October</md-option
                                        >
                                        <md-option value="11"
                                            >November</md-option
                                        >
                                        <md-option value="12"
                                            >December</md-option
                                        >
                                    </md-select>
                                </md-field>
                            </div>
                            <!-- <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-datepicker
                                    :md-model-type="String"
                                    label="Date From"
                                    v-model="dateFrom"
                                >
                                    <label>Date From</label>
                                </md-datepicker>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-datepicker
                                    :md-model-type="String"
                                    label="Date To"
                                    v-model="dateTo"
                                >
                                    <label>Date To</label>
                                </md-datepicker>
                            </div> -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-field>
                                    <label>Status</label>
                                    <md-select
                                        v-model="statusId"
                                        @md-selected="fireStatus"
                                    >
                                        <md-option
                                            :value="s.id"
                                            v-for="s in status"
                                            :key="s.id"
                                            >{{ s.value }}</md-option
                                        >
                                    </md-select>
                                </md-field>
                            </div>
                        </div>

                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <strong>BALANCE</strong>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-20
                                "
                            >
                                <md-card class="vacation_leave">
                                    <md-card-content>
                                        <h4>
                                            <strong style="color: white"
                                                >Vacation Leave</strong
                                            >
                                        </h4>
                                        <h1 style="color: white">
                                            {{ balance["VL"] }}
                                        </h1>
                                    </md-card-content>
                                </md-card>
                            </div>

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-20
                                "
                            >
                                <md-card class="sick_leave">
                                    <md-card-content>
                                        <h4>
                                            <strong style="color: white"
                                                >Sick Leave</strong
                                            >
                                        </h4>
                                        <h1 style="color: white">
                                            {{ balance["SL"] }}
                                        </h1>
                                    </md-card-content>
                                </md-card>
                            </div>

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-20
                                "
                            >
                                <md-card class="forced_leave">
                                    <md-card-content>
                                        <h4>
                                            <strong style="color: white"
                                                >Mandatory Leave</strong
                                            >
                                        </h4>
                                        <h1 style="color: white">
                                            {{ balance["ML"] }}
                                        </h1>
                                    </md-card-content>
                                </md-card>
                            </div>

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-20
                                "
                            >
                                <md-card class="special_leave">
                                    <md-card-content>
                                        <h4>
                                            <strong style="color: white"
                                                >Special Privilege Leave</strong
                                            >
                                        </h4>
                                        <h1 style="color: white">
                                            {{ balance["SPL"] }}
                                        </h1>
                                    </md-card-content>
                                </md-card>
                            </div>

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-20
                                "
                            >
                                <md-card class="cto_leave">
                                    <md-card-content>
                                        <h4>
                                            <strong style="color: black"
                                                >CTO Leave Balance</strong
                                            >
                                        </h4>
                                        <h1 style="color: black">
                                            {{ balance["CTO"] }}
                                        </h1>
                                    </md-card-content>
                                </md-card>
                            </div>
                            <!-- Requests Table -->
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                                style="max-width: 500px"
                            >
                                <md-table md-card>
                                    <md-table-toolbar>
                                        <h1 class="md-title">
                                            Employee Requests
                                        </h1>
                                    </md-table-toolbar>
                                    <md-table-empty-state
                                        md-label="No requests found"
                                        :md-description="`No request found in this record / user. Try creating a new request or changing the filters.`"
                                    >
                                        <!-- <md-button
                                            class="
                                                md-primary md-raised md-dense
                                            "
                                            @click="
                                                isAddManualRequest =
                                                    !isAddManualRequest
                                            "
                                        >
                                            Add Request</md-button
                                        > -->
                                    </md-table-empty-state>
                                    <md-table-row>
                                        <md-table-head></md-table-head>
                                        <md-table-head>Date Filled</md-table-head>
                                        <md-table-head>Request Type</md-table-head>
                                        <md-table-head>From</md-table-head>
                                        <md-table-head>To</md-table-head>
                                        <md-table-head>Credit</md-table-head>
                                        <md-table-head>Status</md-table-head>
                                        <md-table-head>Remarks</md-table-head>
                                        <md-table-head>Actions</md-table-head>
                                    </md-table-row>
                                    <template v-for="(item, i) in employeeRequests">
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
                                                class="
                                                    md-raised
                                                    md-dense
                                                    md-primary
                                                "
                                                @click="
                                                    isUpdateAttachment = true;
                                                    updateId = item.id;
                                                "
                                                v-if="item.canUpdate"
                                            >
                                                🖉
                                                <!-- Update -->
                                                <md-tooltip md-direction="top"
                                                    >Update this
                                                    record</md-tooltip
                                                >
                                            </md-button>
                                            <!-- <md-button
                                                class="
                                                    md-raised md-dense md-danger
                                                "
                                                @click="cancelRequest(item.id)"
                                                v-if="item.isToCancel"
                                            >
                                                ⌫
                                                <md-tooltip md-direction="top"
                                                    >Cancel this
                                                    record</md-tooltip
                                                >                                               
                                            </md-button> -->
                                            <md-button
                                                class="
                                                    md-raised md-dense md-danger
                                                "
                                                @click="cancelRequest(item.id)"
                                                v-if="item.isToCancel"
                                            >
                                                ⌫ Cancel
                                                <!-- Cancel -->
                                                <md-tooltip md-direction="top"
                                                    >Cancel this
                                                    record</md-tooltip
                                                >
                                            </md-button>
                                            <md-button
                                                class="
                                                    md-raised
                                                    md-dense
                                                    md-primary
                                                "
                                                @click="printRequest(item.id)"
                                            >
                                                <strong
                                                    style="
                                                        font-size: 20px !important;
                                                        margin-right: 5px;
                                                    "
                                                    >⎘</strong
                                                >
                                                Print
                                                <md-tooltip md-direction="top"
                                                    >Print Request</md-tooltip
                                                ></md-button
                                            >
                                        </md-table-cell>
                                        </md-table-row>
                                        <md-table-row :key="i + 'b'" v-if="expandedTableId == item.id">
                                            <md-table-cell colspan="10" style="background-color: #eeeeee;">
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
                    <div class="md-layout-item md-size-100 text-right">
                        <label v-for="l in linksOnRequest" :key="l.label">
                            <md-button
                                class="button-paginate md-warning"
                                @click="getEmployeeRequestsLinks(l.url)"
                                :disabled="l.active || l.url === null"
                            >
                                <label
                                    style="color: black !important"
                                    v-html="l.label"
                                ></label>
                            </md-button>
                        </label>
                    </div>
                </md-card>
            </div>
        </div>

        <!-- Dialog Cards Here -->
        <!-- Add Manual Request -->
        <DialogCard v-if="isAddManualRequest">
            <section slot="header">Employee Request</section>
            <section slot="body" class="dCardBody">
                <form method="post" @submit.prevent="addManualRequest()">
                    <md-field>
                        <label for="requestTypes">Request Type</label>
                        <md-select
                            v-model="requestTypeId"
                            name="Request Types"
                            id="requestTypes"
                        >
                            <md-option
                                v-for="(requestType, index) in requestTypes"
                                :key="index"
                                :value="requestType.id"
                                >{{ requestType.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-field v-if="requestTypeId === 29">
                        <label>Other Request Description</label>
                        <md-input
                            v-model="othersDescription"
                            type="text"
                            required
                        ></md-input>
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
                    <md-field v-if="obVenue === 'Others'">
                        <label>Others (Please Specify)</label>
                        <md-input
                            v-model="obVenueOthers"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-content>
                        <span class="md-body-2">Current Balance: </span>
                        {{ currentBalance }}
                        days
                    </md-content>
                    <span style="margin-top: 25px"></span>
                    <md-datepicker
                        v-model="fromDate"
                        md-placeholder="Enter date"
                        ><label>Date From:</label></md-datepicker
                    >
                    <md-field v-if="requestTypeId === 15">
                        <label>Time - 24 hour format(09:00:00)</label>
                        <md-input
                            v-model="obDateFrom"
                            value="09:00:00"
                            maxlength="8"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-datepicker v-model="toDate" md-placeholder="Enter date"
                        ><label>Date To:</label></md-datepicker
                    >
                    <md-field v-if="requestTypeId === 15">
                        <label>Time - 24 hour format(17:00:00)</label>
                        <md-input
                            v-model="obDateTo"
                            value="17:00:00"
                            maxlength="8"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
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
                        <md-input v-model="credit" disabled></md-input>
                    </md-field>
                    <md-field>
                        <label>Reason</label>
                        <md-textarea v-model="reason"></md-textarea>
                    </md-field>
                    <!-- <md-field>
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
                            :disabled="isAddingRequest || computeCreditError"
                        >
                            {{ addBtn }}</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="isAddManualRequest = false"
                        >
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
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

        <!-- Attachment Update -->
        <DialogCard v-if="isUpdateAttachment">
            <section slot="header">Update Proof Attachment</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateApproveRequest">
                    <md-field>
                        <label>Attach Proof *</label>
                        <md-file
                            @change="(e) => (updateProof = e.target.files[0])"
                            accept="image/*"
                        />
                    </md-field>
                    <md-field>
                        <label>Proof Type *</label>
                        <md-input v-model="updateProofType"></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            @click="updateProofAttachment()"
                            :disabled="
                                updateProof && updateProofType ? false : true
                            "
                        >
                            Save</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="isUpdateAttachment = false"
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Dialog Cards Here -->

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
let d = new Date();
let currentMonth = d.getMonth() + 1;

export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    name: "ScheduleEmployee",
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        //UI Model
        addBtn: "Add Request",
        isAddingRequest: false,
        //Snackkbar
        fireSnackbar: false,
        messageSnackbar: "",

        timeSheetHistoryMonth: 0,
        type: null,
        isAuthenticated: true,
        dateFrom: null,
        dateTo: null,
        vacationLeave: 0,
        sickLeave: 0,
        forcedLeave: 0,
        specialPrivelegedLeave: 0,
        ctoLeaveBalance: 0,
        employeeRequests: [],

        isAddManualRequest: false,

        // Data
        dataParams: [],
        requestTypes: [],
        halfDays: [],
        categories: [],
        status: [],
        ob: [],
        requestTypeId: "",
        othersDescription: "",
        fromDate: null,
        toDate: null,
        refDate: null,
        halfDay: null,
        reason: "",
        proofType: "",
        proof: null,
        obVenue: null,
        // Converted Date
        from: null,
        to: null,

        //Request Cancellation
        requestId: null,
        isCancelRequest: false,
        cnclButton: "Yes, Confirm Cancel Request",
        isCancelling: false,

        // Compute Credit
        computeCreditError: null,
        credit: 0,

        // Update Attachment
        isUpdateAttachment: false,
        updateProofType: "",
        updateProof: null,
        updateId: "",

        // Balance
        balance: {},
        currentBalance: 0,

        // Fullname
        fullName: "",

        //Settings
        isOkToRequest: false,

        //OB Others
        obVenueOthers: null,
        obDateFrom: null,
        obDateTo: null,

        //UI
        linksOnRequest: [],
        perPage: 10,
        month: currentMonth,
        statusId: null,

        expandedTableId: null,
    }),
    methods: {
        async isOkToRequestMethod() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/auth",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.isOkToRequest = response.data.settings.isOkToRequest;
                    //Delete Later
                    // this.isOkToRequest = true;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Add Manuwal Request
        async addManualRequest() {
            if (this.obVenue === "Others") {
                this.obVenue = this.obVenueOthers;
            }

            //If type is OB
            if (this.requestTypeId === 15) {
                //From Date
                this.fromDate = this.convertDate(this.from);
                this.from = this.fromDate + " " + this.obDateFrom;
                //To Date
                this.toDate = this.convertDate(this.to);
                this.to = this.toDate + " " + this.obDateTo;
                console.log(this.from);
                console.log(this.to);
            }

            if (this.halfDay === "na") {
                this.halfDay = null;
            }

            this.addBtn = "Adding...";
            this.isAddingRequest = true;

            const data = {
                request_type_id: this.requestTypeId,
                from: this.from,
                to: this.to,
                reason: this.reason,
                proof_type: this.proofType,
                ob_venue: this.obVenue,
                others_description: this.othersDescription
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
                url: baseUrl + "/api/request/portal/create",
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
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Request submitted!";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.getBalance();
            this.getEmployeeRequests();
            this.addBtn = "Add Request";
            this.isAddingRequest = false;
            this.isAddManualRequest = false;
        },

        //Compute Credit
        computeCredit() {
            this.computeCreditError = null;
            this.credit = "";
            if (this.from && this.to) {
                const options = {
                    method: "POST",
                    url: baseUrl + "/api/request/portal/compute",
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
                        refDate: null,
                        others_description: this.othersDescription
                    },
                };
                axios
                    .request(options)
                    .then((res) => {
                        this.credit = res.data.credit;
                        this.computeCreditError = null;
                    })
                    .catch((err) => {
                        this.computeCreditError = err.response.data.message;
                    });
            }
        },

        //Cancel Request
        cancelRequest(id) {
            this.requestId = id;
            this.isCancelRequest = true;
        },
        async validateCancelRequest() {
            this.cnclButton = "Cancelling your request...";
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
            this.cnclButton = "Yes, Confirm Cancel Request";
            this.isCancelling = false;
            this.isCancelRequest = false;
        },

        //Reser Filters
        async resetFilters() {
            this.month = null;
            this.perPage = 10;
            this.perPage = null;
            await this.getEmployeeRequests();
        },

        fireRequestType() {},

        async getEmployeeRequests() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/portal/search",
                params: {
                    perPage: this.perPage,
                    // month: this.month,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.employeeRequests = response.data.data;
                    this.linksOnRequest = response.data.links;
                    console.log(this.linksOnRequest);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Get employee using links
        async getEmployeeRequestsLinks(url) {
            const options = {
                method: "GET",
                url: url,
                params: {
                    perPage: this.perPage,
                    month: this.month,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.employeeRequests = response.data.data;
                    this.linksOnRequest = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Fire Per Page
        async firePerPage() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/portal/search",
                params: {
                    perPage: this.perPage,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.employeeRequests = response.data.data;
                    this.linksOnRequest = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        async fireStatus() {
            console.log("");
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/portal/search",
                params: {
                    perPage: 1000,
                    status: this.statusId,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.employeeRequests = response.data.data;
                    this.linksOnRequest = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Select Status

        //Select Month
        async getRecordMonth() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/portal/search",
                params: {
                    perPage: this.perPage,
                    month: this.month,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.employeeRequests = response.data.data;
                    this.linksOnRequest = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

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

        async getBalance() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/request/portal/balance/",
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
            if (url.startsWith("http://localhost")) {
                window.open(url.replace("http://localhost", baseUrl));
            } else {
                window.open(url);
            }
        },

        //Update Proof of Attachment
        updateProofAttachment() {
            const data = new FormData();
            data.append("proof_type", this.updateProofType);
            data.append("proof", this.updateProof);
            console.log(this.updateProof);
            console.log(data);
            const options = {
                method: "POST",
                url: baseUrl + "/api/request/portal/proof/" + this.updateId,
                params: {
                    // Add params
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                    "Content-Type": "multipart/form-data",
                },
                data: data,
            };
            axios
                .request(options)
                .then((res) => {
                    console.log(res);
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Attachment proof updated!";
                })
                .catch((err) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "An error occured. Please try again.";
                });
            this.isUpdateAttachment = false;
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
        // Get Balance
        await this.getBalance();
        if (this.empSelectionID === null) {
            // Do Nothing
            this.$store.state.currentSelectionUserId =
                localStorage.getItem("accountId");
            //await this.getTheScheduleInformation();
        } else {
            //await this.getTheScheduleInformation();
        }

        this.fullName = localStorage.getItem("full_name");
    },
    async beforeMount() {
        // Get Request Types
        this.getDataParams();

        // Get Employee Requests
        this.getEmployeeRequests();

        //Check if isOkToRequest
        this.isOkToRequestMethod();
    },
    watch: {
        fromDate: function (date) {
            this.fromDate = this.convertDate(date);
            this.from = this.fromDate + " 00:00:01";
            this.computeCredit();
        },
        toDate: function (date) {
            this.toDate = this.convertDate(date);
            this.to = this.toDate + " 23:59:59";
            this.computeCredit();
        },
        requestTypeId: function (id) {
            this.computeCredit();
            this.currentBalance =
                this.balance[
                    this.requestTypes[
                        this.requestTypes.findIndex((x) => x.id == id)
                    ].code
                ];
        },
    },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css?family=Material+Icons");

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
.dCardBody {
    min-width: 640px !important;
    min-height: 500px !important;
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
.button-paginate {
    border: 0px !important;
    margin-left: 2px !important;
    margin-right: 2px !important;
    padding: 5px !important;
    max-width: 90px !important;
    min-width: 90px !important;
}
</style>
