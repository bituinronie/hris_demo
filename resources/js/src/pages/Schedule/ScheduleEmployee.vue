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
        <!-- Schedule Today and Weekly Timesheet -->
        <div class="md-layout">
            <!-- Schedule -->
            <div
                class="md-layout-item md-small-size-100 md-size-25"
                v-if="
                    $permissions.includes('search employee schedule') ||
                    $permissions.includes('portal employee schedule')
                "
            >
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Schedule Today</h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <b>Code:</b> {{ scheduleToday.code }} <br />
                        <b>Description:</b> {{ scheduleToday.description }}
                        <br /><br />
                        <b>Time In:</b> {{ scheduleToday.time_in }} <br />
                        <b>Lunch Out:</b> {{ scheduleToday.lunch_out }} <br />
                        <b>Lunch In:</b> {{ scheduleToday.lunch_in }} <br />
                        <b>Time Out:</b> {{ scheduleToday.time_out }} <br />
                    </md-card-content>
                </md-card>
            </div>
            <!-- Weekly Timesheet -->
            <div
                class="md-layout-item md-small-size-100 md-size-75"
                v-if="$permissions.includes('search dtr')"
            >
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Weekly Timesheet</h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <md-table
                            v-model="weeklyTimesheet"
                            md-sort="reference_date"
                            md-sort-order="asc"
                        >
                            <md-table-toolbar>
                                <!-- <h1 class="md-title">Add Holiday / Special Date</h1> -->
                            </md-table-toolbar>
                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell
                                    md-label="Date"
                                    md-sort-by="date"
                                    >{{ item.date }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Time In"
                                    md-sort-by="time_in"
                                    >{{ item.time_in }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Lunch Out"
                                    md-sort-by="lunch_out"
                                    >{{ item.lunch_out }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Lunch In"
                                    md-sort-by="lunch_in"
                                    >{{ item.lunch_in }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Time Out"
                                    md-sort-by="time_out"
                                    >{{ item.time_out }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Actions"
                                    md-sort-by="actions"
                                >
                                    <md-button
                                        class="md-raised md-dense md-primary"
                                        @click="editWeeklyTimeSheet(item.id)"
                                        v-if="
                                            $permissions.includes('write dtr')
                                        "
                                    >
                                        Edit
                                        <md-tooltip md-direction="top"
                                            >Edit this record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-raised md-dense md-warning"
                                        style="color: black !important"
                                        @click="
                                            viewLog(item.id, item.hasTimeLog)
                                        "
                                    >
                                        Log
                                        <md-tooltip md-direction="top"
                                            >View Log.</md-tooltip
                                        >
                                    </md-button>
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </md-card-content>
                </md-card>
                <!-- Change Schedule -->
                <DialogCard v-if="isEditTimeSheet">
                    <section slot="header">Edit MF</section>
                    <section slot="body">
                        <form method="post" @submit.prevent="updateTimeSheet">
                            <b>Time In</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_time_in"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Time in</label>
                                        <md-input
                                            v-model="timeSheet.time_in"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <b>Lunch Out</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_lunch_out"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Lunch Out</label>
                                        <md-input
                                            v-model="timeSheet.lunch_out"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <b>Lunch In</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_lunch_in"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Lunch in</label>
                                        <md-input
                                            v-model="timeSheet.lunch_in"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <b>Time Out</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_time_out"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Time Out</label>
                                        <md-input
                                            v-model="timeSheet.time_out"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <md-field>
                                <label>Reason</label>
                                <md-textarea
                                    v-model="timeSheet.reason"
                                    required
                                ></md-textarea>
                            </md-field>
                            <md-dialog-actions>
                                <md-button
                                    class="md-dense md-primary"
                                    type="submit"
                                    :disabled="isChanging"
                                >
                                    {{ msgButton }}
                                </md-button>
                                <md-button
                                    class="md-dense md-danger"
                                    @click="editWeeklyTimeSheet(updateID)"
                                >
                                    <!-- <md-icon>close</md-icon> -->
                                    ✕ Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>
            </div>
        </div>

        <!-- Time Sheet History -->
        <div class="md-layout" v-if="$permissions.includes('search dtr')">
            <!-- Schedule -->
            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Timesheet History</h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-button
                                    class="md-raised md-dense md-warning"
                                    style="
                                        color: black !important;
                                        float: right !important;
                                    "
                                    @click="printDTR = !printDTR"
                                >
                                    Print DTR
                                </md-button>
                            </div>
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
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-15
                                "
                            >
                                <md-field>
                                    <label>Select Month</label>
                                    <md-select
                                        v-model="timeSheetHistoryMonth"
                                        @md-selected="getTimeSheetHistoryMonth"
                                    >
                                        <md-option value="01">January</md-option>
                                        <md-option value="02"
                                            >February</md-option
                                        >
                                        <md-option value="03">March</md-option>
                                        <md-option value="04">April</md-option>
                                        <md-option value="05">May</md-option>
                                        <md-option value="06">June</md-option>
                                        <md-option value="07">July</md-option>
                                        <md-option value="08">August</md-option>
                                        <md-option value="09"
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

                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <md-datepicker
                                    :md-model-type="String"
                                    label="Date From"
                                    v-model="timeSheetHistoryDateFrom"
                                >
                                    <label>Date From</label>
                                </md-datepicker>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <md-datepicker
                                    :md-model-type="String"
                                    label="Date To"
                                    v-model="timeSheetHistoryDateTo"
                                    @md-closed="getTimeSheetHistoryRange"
                                >
                                    <label>Date To</label>
                                </md-datepicker>
                            </div>
                        </div>

                        <md-table v-model="timeSheetHistory" md-card>
                            <!-- <md-table-toolbar>
                        <div class="md-toolbar-section-start">
                        <h1 class="md-title">Users</h1>
                        </div>
                    </md-table-toolbar> -->

                            <md-table-empty-state :md-description="`No Record`">
                            </md-table-empty-state>

                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell
                                    md-label="Date"
                                    md-sort-by="id"
                                    >{{ item.date }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="AM In"
                                    md-sort-by="name"
                                    >{{ item.am_in }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="AM Out"
                                    md-sort-by="name"
                                    >{{ item.am_out }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="PM In"
                                    md-sort-by="email"
                                    >{{ item.pm_in }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="PM Out"
                                    md-sort-by="gender"
                                    >{{ item.pm_out }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Late/UT/HD"
                                    md-sort-by="title"
                                    >{{ item.diff }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="OT"
                                    md-sort-by="title"
                                    >{{ item.ot }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Remarks"
                                    md-sort-by="title"
                                    >{{ item.remark }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Actions"
                                    md-sort-by="title"
                                >
                                    <md-button
                                        class="md-primary md-raised md-dense"
                                        @click="editHistoryTimeSheet(item.id)"
                                        v-if="
                                            $permissions.includes('write dtr')
                                        "
                                    >
                                        Edit
                                    </md-button>
                                    <md-button
                                        class="md-raised md-dense md-warning"
                                        style="color: black !important"
                                        @click="
                                            viewLog(item.id, item.hasTimeLog)
                                        "
                                    >
                                        Log
                                        <md-tooltip md-direction="top"
                                            >View Log.</md-tooltip
                                        >
                                    </md-button>
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                        <hr />
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-50
                                "
                            >
                                <h4>Total</h4>
                                <b>Difference:</b> {{ stats.data.total.diff }}
                                <br />
                                <b>Overtime:</b> {{ stats.data.total.ot }}
                                <br />
                                <b>Total Work Hours:</b>
                                {{ stats.data.total.workHours }} <br />
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-50
                                "
                            >
                                <h4>Summary</h4>
                                <b>Unfiled Leave:</b>
                                {{ stats.data.summary.unfilledLeave }} <br />
                                <b>Late:</b> {{ stats.data.summary.late }}<br />
                                <b>Undertime:</b> {{ stats.data.summary.ut }}
                                <br />
                                <b>Total Late/UT/HD in Days:</b>
                                {{ stats.data.summary.diff_in_days }}<br />
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
                <!-- Change Schedule - History Time Sheet -->
                <DialogCard v-if="isEditHistoryTimeSheet">
                    <section slot="header">Edit MF</section>
                    <section slot="body">
                        <form
                            method="post"
                            @submit.prevent="updateHistoryTimeSheet"
                        >
                            <b>Time In</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_time_in"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Time in</label>
                                        <md-input
                                            v-model="timeSheet.time_in"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <b>Lunch Out</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_lunch_out"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Lunch Out</label>
                                        <md-input
                                            v-model="timeSheet.lunch_out"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <b>Lunch In</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_lunch_in"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Lunch in</label>
                                        <md-input
                                            v-model="timeSheet.lunch_in"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <b>Time Out</b>
                            <div class="md-layout">
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-datepicker
                                        :md-model-type="String"
                                        label="To"
                                        v-model="timeSheet.date_time_out"
                                        md-immediately
                                    >
                                        <label>Date</label>
                                    </md-datepicker>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-50
                                    "
                                >
                                    <md-field>
                                        <label>Time Out</label>
                                        <md-input
                                            v-model="timeSheet.time_out"
                                        ></md-input>
                                    </md-field>
                                </div>
                            </div>

                            <md-field>
                                <label>Reason</label>
                                <md-textarea
                                    v-model="timeSheet.reason"
                                    required
                                ></md-textarea>
                            </md-field>
                            <md-dialog-actions>
                                <md-button
                                    class="md-dense md-primary"
                                    type="submit"
                                    :disabled="isChanging"
                                >
                                    {{ msgButton }}
                                </md-button>
                                <md-button
                                    class="md-dense md-danger"
                                    @click="editHistoryTimeSheet(updateID)"
                                >
                                    <!-- <md-icon>close</md-icon> -->
                                    ✕ Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>
            </div>
            <!-- Weekly Timesheet -->
        </div>
        <!-- Schedule History -->
        <div class="md-layout">
            <!-- <div class="md-layout-item md-small-size-100 md-size-100" v-if="userAction === 'emp_selected' "> -->
            <div
                class="md-layout-item md-small-size-100 md-size-100"
                v-if="
                    $permissions.includes('search employee schedule') ||
                    $permissions.includes('portal employee schedule')
                "
            >
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Schedule History</h4>
                    </md-card-header>
                    <md-card-content>
                        <div class="md-layout">
                            <md-button
                                class="md-dense md-primary md-raised"
                                @click="changeSchedule"
                                v-if="
                                    $permissions.includes(
                                        'write employee schedule'
                                    )
                                "
                            >
                                Change Schedule
                            </md-button>
                        </div>

                        <div class="md-layout-item md-size-100">
                            <md-table
                                v-model="schedule"
                                md-sort="reference_date"
                                md-sort-order="asc"
                            >
                                <md-table-toolbar>
                                    <!-- <h1 class="md-title">Add Holiday / Special Date</h1> -->
                                </md-table-toolbar>
                                <md-table-row
                                    slot="md-table-row"
                                    slot-scope="{ item }"
                                >
                                    <md-table-cell
                                        md-label="Date"
                                        md-sort-by="date"
                                        >{{ item.date }}</md-table-cell
                                    >
                                    <md-table-cell
                                        md-label="Code"
                                        md-sort-by="code"
                                        >{{
                                            item.code ? item.code : "SPECIAL"
                                        }}</md-table-cell
                                    >
                                    <md-table-cell
                                        md-label="Description"
                                        md-sort-by="description"
                                        >{{
                                            item.description
                                                ? item.description
                                                : "SPECIAL"
                                        }}</md-table-cell
                                    >
                                    <md-table-cell
                                        md-label="Actions"
                                        md-sort-by="actions"
                                    >
                                        <!-- Edit Special Schedule button -->
                                        <!-- <md-button
                                            v-if="item.description === null"
                                            class="md-raised md-dense md-primary"
                                            @click="
                                                editSpecialSchedule(
                                                    item,
                                                    item.id
                                                )
                                            "
                                        >
                                            Edit Special Schedule
                                            <md-tooltip md-direction="top"
                                                >Edit Special
                                                Schedule.</md-tooltip
                                            >
                                        </md-button> -->
                                        <md-button
                                            class="
                                                md-raised md-dense md-primary
                                            "
                                            @click="
                                                viewScheduleInformation(item)
                                            "
                                        >
                                            View Info
                                            <md-tooltip md-direction="top"
                                                >View this record.</md-tooltip
                                            >
                                        </md-button>
                                        <md-button
                                            class="md-raised md-dense md-danger"
                                            @click="deleteSchedule(item.id)"
                                            v-if="
                                                $permissions.includes(
                                                    'delete employee schedule'
                                                )
                                            "
                                        >
                                            Del
                                            <md-tooltip md-direction="top"
                                                >View this record.</md-tooltip
                                            >
                                        </md-button>
                                    </md-table-cell>
                                </md-table-row>
                            </md-table>
                        </div>

                        <!-- Delete Schedule -->
                        <DialogCard v-if="isDelete">
                            <section slot="header">
                                Delete this schedule?
                            </section>
                            <section slot="body">
                                You cannot undo the changes
                                <md-dialog-actions>
                                    <md-button
                                        class="md-dense md-danger"
                                        type="submit"
                                        @click="validateDeleteSchedule"
                                    >
                                        Confirm Deletion
                                    </md-button>
                                    <md-button
                                        class="md-dense"
                                        @click="deleteSchedule"
                                    >
                                        <!-- <md-icon>close</md-icon> -->
                                        ✕ Cancel</md-button
                                    >
                                </md-dialog-actions>
                            </section>
                        </DialogCard>

                        <!-- View Information -->
                        <DialogCard v-if="isViewScheduleInformation">
                            <section slot="header">
                                Schedule Information
                            </section>
                            <section
                                slot="body"
                                v-if="
                                    sheduleInformation.schedule_type ===
                                    'SPECIAL'
                                "
                            >
                                <label
                                    v-for="(
                                        value, day
                                    ) in sheduleInformation.info"
                                    :key="day"
                                >
                                    <br />
                                    <span
                                        ><b
                                            ><i>{{ day }}</i></b
                                        ></span
                                    >
                                    <br />
                                    Time In:
                                    {{ value.time_in ? value.time_in : "NA" }}
                                    <br />
                                    Lunch Out:
                                    {{
                                        value.lunch_out ? value.lunch_out : "NA"
                                    }}
                                    <br />
                                    Lunch In:
                                    {{ value.lunch_in ? value.lunch_in : "NA" }}
                                    <br />
                                    Time Out:
                                    {{ value.time_out ? value.time_out : "NA" }}
                                    <br />
                                </label>
                                <md-dialog-actions>
                                    <md-button
                                        class="md-dense md-raised md-danger"
                                        @click="viewScheduleInformation"
                                    >
                                        <!-- <md-icon>close</md-icon> -->
                                        ✕ Close</md-button
                                    >
                                </md-dialog-actions>
                            </section>
                            <section slot="body" v-else>
                                <b>Effective Date:</b>
                                {{ sheduleInformation.date }} <br />
                                <b>Code:</b> {{ sheduleInformation.code }}
                                <br />
                                <b>Description:</b>
                                {{ sheduleInformation.description }}
                                <br /><br />

                                <br />
                                <b>Monday:</b>
                                <br />
                                {{
                                    sheduleInformation.info.mon_time_in
                                        ? sheduleInformation.info.mon_time_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.mon_lunch_out
                                        ? sheduleInformation.info.mon_lunch_out
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.mon_lunch_in
                                        ? sheduleInformation.info.mon_lunch_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.mon_time_out
                                        ? sheduleInformation.info.mon_time_out
                                        : "NA"
                                }}
                                <br />

                                <br />
                                <b>Tuesday:</b>
                                <br />
                                {{
                                    sheduleInformation.info.tue_time_in
                                        ? sheduleInformation.info.tue_time_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.tue_lunch_out
                                        ? sheduleInformation.info.tue_lunch_out
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.tue_lunch_in
                                        ? sheduleInformation.info.tue_lunch_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.tue_time_out
                                        ? sheduleInformation.info.tue_time_out
                                        : "NA"
                                }}
                                <br />

                                <br />
                                <b>Wednesday:</b>
                                <br />
                                {{
                                    sheduleInformation.info.wed_time_in
                                        ? sheduleInformation.info.wed_time_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.wed_lunch_out
                                        ? sheduleInformation.info.wed_lunch_out
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.wed_lunch_in
                                        ? sheduleInformation.info.wed_lunch_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.wed_time_out
                                        ? sheduleInformation.info.wed_time_out
                                        : "NA"
                                }}
                                <br />

                                <br />
                                <b>Thursday:</b>
                                <br />
                                {{
                                    sheduleInformation.info.thu_time_in
                                        ? sheduleInformation.info.thu_time_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.thu_lunch_out
                                        ? sheduleInformation.info.thu_lunch_out
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.thu_lunch_in
                                        ? sheduleInformation.info.thu_lunch_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.thu_time_out
                                        ? sheduleInformation.info.thu_time_out
                                        : "NA"
                                }}
                                <br />

                                <br />
                                <b>Friday:</b>
                                <br />
                                {{
                                    sheduleInformation.info.fri_time_in
                                        ? sheduleInformation.info.fri_time_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.fri_lunch_out
                                        ? sheduleInformation.info.fri_lunch_out
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.fri_lunch_in
                                        ? sheduleInformation.info.fri_lunch_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.fri_time_out
                                        ? sheduleInformation.info.fri_time_out
                                        : "NA"
                                }}
                                <br />

                                <br />
                                <b>Saturday:</b>
                                <br />
                                {{
                                    sheduleInformation.info.sat_time_in
                                        ? sheduleInformation.info.sat_time_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.sat_lunch_out
                                        ? sheduleInformation.info.sat_lunch_out
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.sat_lunch_in
                                        ? sheduleInformation.info.sat_lunch_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.sat_time_out
                                        ? sheduleInformation.info.sat_time_out
                                        : "NA"
                                }}
                                <br />

                                <br />
                                <b>Sunday:</b>
                                <br />
                                {{
                                    sheduleInformation.info.sun_time_in
                                        ? sheduleInformation.info.sun_time_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.sun_lunch_out
                                        ? sheduleInformation.info.sun_lunch_out
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.sun_lunch_in
                                        ? sheduleInformation.info.sun_lunch_in
                                        : "NA"
                                }}
                                <br />
                                {{
                                    sheduleInformation.info.sun_time_out
                                        ? sheduleInformation.info.sun_time_out
                                        : "NA"
                                }}
                                <br />

                                <md-dialog-actions>
                                    <md-button
                                        class="md-dense md-raised md-danger"
                                        @click="viewScheduleInformation"
                                    >
                                        <!-- <md-icon>close</md-icon> -->
                                        ✕ Close</md-button
                                    >
                                </md-dialog-actions>
                            </section>
                        </DialogCard>

                        <!-- Print DTR -->
                        <DialogCard v-if="printDTR">
                            <section slot="header">Print DTR</section>
                            <section slot="body">
                                <form
                                    method="post"
                                    @submit.prevent="generateDTR"
                                >
                                    <md-field>
                                        <label>Supervisor</label>
                                        <md-input
                                            v-model="supervisor"
                                            type="text"
                                            required
                                        ></md-input>
                                    </md-field>
                                    <md-button
                                        type="submit"
                                        class="md-primary md-dense"
                                        >Print</md-button
                                    >
                                    <md-button
                                        class="md-dense md-danger"
                                        @click="printDTR = !printDTR"
                                        >✕ Close</md-button
                                    >
                                </form>
                            </section>
                        </DialogCard>

                        <!-- Change Schedule -->
                        <DialogCard v-if="isChangeSchedule">
                            <section slot="header">Change Schedule</section>
                            <section slot="body">
                                <form
                                    method="post"
                                    @submit.prevent="validateChangeSchedule"
                                >
                                    <md-field>
                                        <label>Schedule Type</label>
                                        <md-select
                                            v-model="schedule_type"
                                            @md-selected="getSpecialCode"
                                            required
                                        >
                                            <md-option value="REGULAR"
                                                >REGULAR</md-option
                                            >
                                            <md-option value="SPECIAL"
                                                >SPECIAL</md-option
                                            >
                                        </md-select>
                                    </md-field>
                                    <div v-if="schedule_type != 'SPECIAL'">
                                        <md-field>
                                            <label>Code</label>
                                            <md-select
                                                v-model="schedule_id"
                                                required
                                            >
                                                <md-option
                                                    v-for="s in paramSchedule"
                                                    :key="s.id"
                                                    :value="s.id"
                                                    >{{ s.code }}</md-option
                                                >
                                            </md-select>
                                        </md-field>
                                        <md-field>
                                            <label>Type</label>
                                            <md-select v-model="type" required>
                                                <md-option value="PERMANENT"
                                                    >PERMANENT</md-option
                                                >
                                                <md-option value="ONE_TIME"
                                                    >ONE TIME</md-option
                                                >
                                            </md-select>
                                        </md-field>
                                        <md-datepicker
                                            disable
                                            :md-model-type="String"
                                            v-model="effective_date"
                                            @md-closed="getMonthAndYear"
                                        >
                                            <label>Effective Date</label>
                                        </md-datepicker>
                                    </div>
                                    <!-- If special-->
                                    <div v-else>
                                        <!-- <md-field
                                            v-if="schedule_type === 'SPECIAL'"
                                        >
                                            <label>Use Template?</label>
                                            <md-select
                                                v-model="isUseCode"
                                                @md-selected="getSpecialCode"
                                            >
                                                <md-option :value="'yes'"
                                                    >Yes</md-option
                                                >
                                                <md-option :value="'no'"
                                                    >No</md-option
                                                >
                                            </md-select>
                                        </md-field> -->
                                        <div v-if="isUseCode === 'no'">
                                            <md-field>
                                                <label>Effective Year</label>
                                                <md-input
                                                    v-model="effective_year"
                                                    maxlength="4"
                                                ></md-input>
                                            </md-field>
                                            <md-field>
                                                <label>Effective Month</label>
                                                <md-select
                                                    v-model="effecttive_month"
                                                    @md-selected="
                                                        getMonthAndYear
                                                    "
                                                >
                                                    <md-option value="01"
                                                        >January</md-option
                                                    >
                                                    <md-option value="02"
                                                        >February</md-option
                                                    >
                                                    <md-option value="03"
                                                        >March</md-option
                                                    >
                                                    <md-option value="04"
                                                        >April</md-option
                                                    >
                                                    <md-option value="05"
                                                        >May</md-option
                                                    >
                                                    <md-option value="06"
                                                        >June</md-option
                                                    >
                                                    <md-option value="07"
                                                        >July</md-option
                                                    >
                                                    <md-option value="08"
                                                        >August</md-option
                                                    >
                                                    <md-option value="09"
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
                                            <span
                                                v-for="(
                                                    day, index
                                                ) in special_schedule_data"
                                                :key="index"
                                            >
                                                <br />
                                                <label
                                                    ><i
                                                        ><b>{{ index }}</b></i
                                                    ></label
                                                >
                                                <md-field>
                                                    <label>Time in</label>
                                                    <md-input
                                                        v-model="day.time_in"
                                                    ></md-input>
                                                </md-field>
                                                <md-field>
                                                    <label>Lunch Out</label>
                                                    <md-input
                                                        v-model="day.lunch_out"
                                                    ></md-input>
                                                </md-field>
                                                <md-field>
                                                    <label>Lunch In</label>
                                                    <md-input
                                                        v-model="day.lunch_in"
                                                    ></md-input>
                                                </md-field>
                                                <md-field>
                                                    <label>Time Out</label>
                                                    <md-input
                                                        v-model="day.time_out"
                                                    ></md-input>
                                                </md-field>
                                            </span>
                                        </div>
                                        <div v-else>
                                            <md-field>
                                                <label
                                                    >Special Schedule
                                                    Code</label
                                                >
                                                <md-select
                                                    v-model="specialSchedule"
                                                >
                                                    <md-option
                                                        v-for="ssi in specialScheduleInformation"
                                                        :key="ssi.id"
                                                        :value="ssi.id"
                                                        >{{
                                                            ssi.code
                                                        }}</md-option
                                                    >
                                                </md-select>
                                            </md-field>
                                        </div>
                                    </div>
                                    <md-dialog-actions>
                                        <md-button
                                            class="md-dense md-primary"
                                            type="submit"
                                            :disabled="isChanging"
                                        >
                                            {{ msgButton }}
                                        </md-button>
                                        <md-button
                                            class="md-dense md-danger"
                                            @click="changeSchedule"
                                        >
                                            <!-- <md-icon>close</md-icon> -->
                                            ✕ Close</md-button
                                        >
                                    </md-dialog-actions>
                                </form>
                            </section>
                        </DialogCard>

                        <!-- Edit Special Schedule Information -->
                        <DialogCard v-if="isEditSpecialSchedule">
                            <section slot="header">
                                Edit / View Special Schedule
                            </section>
                            <section slot="body">
                                <span
                                    v-for="(
                                        day, index
                                    ) in special_schedule_data"
                                    :key="index"
                                >
                                    <br />
                                    <label
                                        ><i
                                            ><b>{{ index }}</b></i
                                        ></label
                                    >
                                    <md-field>
                                        <label>Time in</label>
                                        <md-input
                                            v-model="day.time_in"
                                        ></md-input>
                                    </md-field>
                                    <md-field>
                                        <label>Lunch Out</label>
                                        <md-input
                                            v-model="day.lunch_out"
                                        ></md-input>
                                    </md-field>
                                    <md-field>
                                        <label>Lunch In</label>
                                        <md-input
                                            v-model="day.lunch_in"
                                        ></md-input>
                                    </md-field>
                                    <md-field>
                                        <label>Time Out</label>
                                        <md-input
                                            v-model="day.time_out"
                                        ></md-input>
                                    </md-field>
                                </span>
                                <md-dialog-actions>
                                    <md-button
                                        @click="updateSpecialSchedule"
                                        class="md-dense md-primary"
                                        type="submit"
                                        :disabled="isUpdatingSchedule"
                                    >
                                        {{ msgButtonUpdateSpecialSchedule }}
                                    </md-button>
                                    <md-button
                                        class="md-dense md-raised md-danger"
                                        @click="isEditSpecialSchedule = false"
                                    >
                                        <!-- <md-icon>close</md-icon> -->
                                        ✕ Close</md-button
                                    >
                                </md-dialog-actions>
                            </section>
                        </DialogCard>

                        <!-- View Log -->
                        <DialogCard v-if="viewTimeLog">
                            <section slot="header">Schedule</section>
                            <section slot="body">
                                <md-table v-model="timeLogs" md-card>
                                    <md-table-row
                                        slot="md-table-row"
                                        slot-scope="{ item }"
                                    >
                                        <md-table-cell
                                            md-label="ID"
                                            md-numeric
                                            >{{ item.id }}</md-table-cell
                                        >
                                        <md-table-cell md-label="Post Date">{{
                                            item.post_date
                                        }}</md-table-cell>
                                        <md-table-cell md-label="Post Time">{{
                                            item.post_time
                                        }}</md-table-cell>
                                        <md-table-cell md-label="Type">{{
                                            item.type
                                        }}</md-table-cell>
                                        <md-table-cell md-label="User">{{
                                            item.cause
                                        }}</md-table-cell>
                                        <md-table-cell md-label="Created">{{
                                            item.created_at
                                        }}</md-table-cell>
                                    </md-table-row>
                                </md-table>
                                <md-dialog-actions>
                                    <md-button
                                        class="md-dense md-raised md-danger"
                                        @click="viewTimeLog = false"
                                    >
                                        <!-- <md-icon>close</md-icon> -->
                                        ✕ Close</md-button
                                    >
                                </md-dialog-actions>
                            </section>
                        </DialogCard>
                    </md-card-content>
                    <md-snackbar
                        :md-position="'center'"
                        :md-duration="3000"
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
                </md-card>
            </div>
        </div>
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
        //Snackkbar
        fireSnackbar: false,
        messageSnackbar: "Sample",

        //Actions Specific
        isAuthenticated: true,
        msgButton: "",
        isChangeSchedule: false,
        updateID: null,
        isChanging: false,
        isViewScheduleInformation: false,
        isEditTimeSheet: false,
        isEditHistoryTimeSheet: false,
        sheduleInformation: [],
        schedule: [],
        paramSchedule: [],
        deleteID: null,
        isDelete: false,
        scheduleToday: [],
        weeklyTimesheet: [],
        timeSheet: {
            time_in: "",
            lunch_out: "",
            lunch_in: "",
            time_out: "",
        },
        timeSheetHistory: [],
        timeSheetHistoryDateFrom: null,
        timeSheetHistoryDateTo: null,
        timeSheetHistoryMonth: null,
        isMonthSelected: false,
        perPage: 15,
        stats: {
            data: {
                total: {},
                summary: {},
            },
        },
        //Weekly Time Sheet
        //Data needed for setting schedule
        schedule_id: null,
        effective_date: "2020-01-01",
        effecttive_month: 1,
        effective_year: 2021,
        no_of_days: null,
        type: "PERMANENT",
        schedule_type: "REGULAR",

        //For Printing DTR
        supervisor: null,
        printDTR: false,

        //Special Schedule Data
        special_schedule_data: {},
        temp_date: null,
        is_special_selected: false,
        editScheduleInformation: null,
        isEditSpecialSchedule: false,
        spScheduleID: null,
        isUpdatingSchedule: false,
        msgButtonUpdateSpecialSchedule: "Update",

        //Time log
        viewTimeLog: false,
        timeLogs: [],

        //use code in special sked
        isUseCode: "yes",
        specialScheduleInformation: null,
        specialSchedule: null,
    }),
    methods: {
        viewLog(id, hasTimeLog) {
            if (hasTimeLog) {
                this.viewTimeLog = true;
                const getToken = localStorage.getItem("token");
                let baseUrl = localStorage.getItem("base_url");
                baseUrl = baseUrl + "/api/dtr/time-log/" + id;

                const options = {
                    method: "GET",
                    url: baseUrl,
                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + getToken,
                    },
                };

                axios
                    .request(options)
                    .then((response) => {
                        console.log(response.data);
                        this.timeLogs = response.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                this.fireSnackbar = true;
                this.messageSnackbar = "No time logs available for this record";
            }
        },
        //Edit Special Schedule
        editSpecialSchedule(info, id) {
            this.editScheduleInformation = info;
            this.special_schedule_data = this.editScheduleInformation.info;
            this.isEditSpecialSchedule = !this.isEditSpecialSchedule;
            this.spScheduleID = id;
            console.log(this.spScheduleID);
            console.log(this.special_schedule_data);
        },

        //Update Special Schedule
        async updateSpecialSchedule() {
            this.isUpdatingSchedule = true;
            this.msgButtonUpdateSpecialSchedule = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl + "/api/employee/schedule/update/" + this.spScheduleID;

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    special_schedule: this.special_schedule_data,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Schedule template of this employee has been updated";
                    this.getSchedule();
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error updating the schedule template of this employee";
                    console.error(error);
                });

            await this.getSchedule();
            this.isUpdatingSchedule = false;
            this.msgButtonUpdateSpecialSchedule = "Update";
            this.isEditSpecialSchedule = !this.isEditSpecialSchedule;
        },

        //Per Page
        async firePerPage() {
            if (this.isMonthSelected) {
                await this.getTimeSheetHistoryMonth();
            } else {
                await this.getTimeSheetHistoryRange();
            }
        },

        //Open or Close Add Modal
        changeSchedule() {
            this.isEdit = false;
            this.isChanging = false;
            this.msgButton = "Change Schedule";
            this.isChangeSchedule = !this.isChangeSchedule;
        },

        //Prompt Delete Schedule
        deleteSchedule(delId) {
            this.deleteID = delId;
            this.isDelete = !this.isDelete;
        },

        //Validate Delete Schedule
        async validateDeleteSchedule() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl + "/api/employee/schedule/delete/" + this.deleteID;

            const options = {
                method: "DELETE",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.getResp(options);
            this.deleteID = null;
            this.fireSnackbar = true;
            this.messageSnackbar =
                "Schedule has been deleted that is associated with this employee";
            this.deleteID = null;
            await this.getSchedule();
            this.deleteSchedule();
        },

        // View Information
        viewScheduleInformation(info) {
            this.sheduleInformation = info;
            this.isViewScheduleInformation = !this.isViewScheduleInformation;
        },

        //Pad function to convert length of the number
        pad(d) {
            return d < 10 ? "0" + d.toString() : d.toString();
        },
        //Pass values on date select
        getMonthAndYear() {
            this.special_schedule_data = {};
            this.effective_date =
                this.effective_year + "-" + this.effecttive_month + "-01";
            console.log(this.effective_date);
            this.no_of_days = this.daysInMonth(
                this.effecttive_month,
                this.effective_year
            );
            console.log(this.no_of_days);
            let counter = 1;
            while (this.no_of_days >= 1) {
                counter = this.pad(counter);
                this.temp_date =
                    this.effective_year +
                    "-" +
                    this.effecttive_month +
                    "-" +
                    counter;
                var key = this.temp_date;
                this.special_schedule_data[key] = {
                    time_in: null,
                    lunch_out: null,
                    lunch_in: null,
                    time_out: null,
                };
                counter++;
                this.no_of_days -= 1;
            }
            this.is_special_selected = true;
            console.log(this.is_special_selected);
            console.log(this.special_schedule_data);
        },

        //Calculate days in a month
        daysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        },

        //Get Special Schedule
        async getSpecialCode() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-schedule/search";

            const options = {
                method: "GET",
                url: baseUrl,
                params: { perPage: 1000 },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.specialScheduleInformation = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Validate Change Schedule
        //Validate Change Schedule (Special)
        async validateChangeSchedule() {
            this.isChanging = true;
            this.msgButton = "Changing...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl +
                "/api/employee/schedule/create/" +
                this.empSelectionID;
            let options;

            if (this.schedule_type === "SPECIAL") {
                if (this.isUseCode === "yes") {
                    //Get Special Code Effective Date
                    let newURL = localStorage.getItem("base_url");
                    options = {
                        method: "GET",
                        url:
                            newURL +
                            "/api/special-schedule/search/" +
                            this.specialSchedule,
                        headers: {
                            Accept: "application/json",
                            Authorization: "Bearer " + getToken,
                        },
                    };

                    await axios
                        .request(options)
                        .then((response) => {
                            console.log(response.data);
                            this.effective_date = Object.keys(
                                response.data.template
                            )[0];
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                    console.log("isUseCodeYes");
                    options = {
                        method: "POST",
                        url: baseUrl,
                        headers: {
                            Accept: "application/json",
                            "Content-Type": "application/json",
                            Authorization: "Bearer " + getToken,
                        },
                        data: {
                            schedule_type: this.schedule_type,
                            special_schedule_id: this.specialSchedule,
                            effective_date: this.effective_date,
                            type: this.type,
                        },
                    };
                } else {
                    console.log("isUseCodeNo");
                    options = {
                        method: "POST",
                        url: baseUrl,
                        headers: {
                            Accept: "application/json",
                            "Content-Type": "application/json",
                            Authorization: "Bearer " + getToken,
                        },
                        data: {
                            effective_date: this.effective_date,
                            type: this.type,
                            schedule_type: this.schedule_type,
                            special_schedule: this.special_schedule_data,
                        },
                    };
                }
            } else {
                options = {
                    method: "POST",
                    url: baseUrl,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken,
                    },
                    data: {
                        schedule_id: this.schedule_id,
                        effective_date: this.effective_date,
                        type: this.type,
                        schedule_type: this.schedule_type,
                    },
                };
            }

            await axios
                .request(options)
                .then((response) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "Schedule of this employee has been updated";
                })
                .catch((error) => {
                    console.log(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error processing your request. Please try again.";
                });
            // await this.getResp(options);
            await this.getSchedule();
            this.changeSchedule();
        },

        //Get Parameters
        async getParam() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/employee/schedule/parameter";
            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.getResp(options);
            this.paramSchedule = resp.data.schedule;
        },

        //Get Schedule
        async getSchedule() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl +
                "/api/employee/schedule/search/" +
                this.empSelectionID;
            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let resp = await this.getResp(options);
            this.schedule = resp.data.data;
        },

        //Get Schedule Today
        async getScheduleToday() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl + "/api/employee/schedule/today/" + this.empSelectionID;
            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let resp = await this.getResp(options);
            this.scheduleToday = resp.data;
        },

        //Get Schedule Today
        async getWeeklyRecord() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/weekly/" + this.empSelectionID;
            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let resp = await this.getResp(options);
            this.weeklyTimesheet = resp.data;
            console.log(this.weeklyTimesheet);
        },

        //Prompt Edit Weekly TimeSheet
        async editWeeklyTimeSheet(id) {
            this.isEditTimeSheet = !this.isEditTimeSheet;
            this.isChanging = false;
            this.msgButton = "Save";
            this.updateID = id;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl +
                "/api/dtr/search/" +
                this.empSelectionID +
                "/" +
                this.updateID;
            const options = {
                method: "GET",
                url: baseUrl,
                params: { perPage: "31" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let resp = await this.getResp(options);
            this.timeSheet = resp.data;
            console.log(this.timeSheet);
            this.timeSheet.date_time_in = this.timeSheet.ref_date;
            this.timeSheet.date_time_out = this.timeSheet.ref_date;
            this.timeSheet.date_lunch_in = this.timeSheet.ref_date;
            this.timeSheet.date_lunch_out = this.timeSheet.ref_date;
            // if (this.timeSheet.time_in === null) {
            // } else {
            //     this.timeSheet.time_in = this.timeSheet.time_in.split(" ")[1];
            //     this.timeSheet.time_out = this.timeSheet.time_out.split(" ")[1];
            //     this.timeSheet.lunch_in = this.timeSheet.lunch_in.split(" ")[1];
            //     this.timeSheet.lunch_out =
            //         this.timeSheet.lunch_out.split(" ")[1];
            // }

            //Split if not null
            if(this.timeSheet.time_in != null){
                this.timeSheet.time_in = this.timeSheet.time_in.split(" ")[1];
            }

            if(this.timeSheet.time_out != null){
                this.timeSheet.time_out = this.timeSheet.time_out.split(" ")[1];
            }

            if(this.timeSheet.lunch_in != null){
                this.timeSheet.lunch_in = this.timeSheet.lunch_in.split(" ")[1];
            }

            if(this.timeSheet.lunch_out != null){
                this.timeSheet.lunch_out = this.timeSheet.lunch_out.split(" ")[1];
            }

        },

        //Update Time Sheet
        async updateTimeSheet() {
            this.isChanging = true;
            this.msgButton = "Saving...";

            //Time In
            if (this.timeSheet.time_in === '' || this.timeSheet.time_in === null) {
                this.timeSheet.time_in = null;
            } else {
                this.timeSheet.time_in =
                    this.timeSheet.date_time_in + " " + this.timeSheet.time_in;
            }

            //Lunch Out
            if (this.timeSheet.lunch_out === '' || this.timeSheet.lunch_out === null) {
                this.timeSheet.lunch_out = null;
            } else {
                this.timeSheet.lunch_out =
                    this.timeSheet.date_lunch_out +
                    " " +
                    this.timeSheet.lunch_out;
            }

            //Lunch In
            if (this.timeSheet.lunch_in === '' || this.timeSheet.lunch_in === null) {
                this.timeSheet.lunch_in = null;
            } else {
                this.timeSheet.lunch_in =
                    this.timeSheet.date_lunch_in +
                    " " +
                    this.timeSheet.lunch_in;
            }

            //Time Out
            if (this.timeSheet.time_out === '' || this.timeSheet.time_out === null) {
                this.timeSheet.time_out = null;
            } else {
                this.timeSheet.time_out =
                    this.timeSheet.date_time_out +
                    " " +
                    this.timeSheet.time_out;
            }

            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/update/" + this.updateID;

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    time_in: this.timeSheet.time_in,
                    lunch_out: this.timeSheet.lunch_out,
                    lunch_in: this.timeSheet.lunch_in,
                    time_out: this.timeSheet.time_out,
                    reason: this.timeSheet.reason,
                },
            };

            let resp = await this.getResp(options);
            if (this.isMonthSelected) {
                this.getTimeSheetHistoryMonth();
            } else {
                this.getTimeSheetHistoryRange();
            }

            await this.getStats();
            await this.getWeeklyRecord();
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been updated";
            this.isChanging = false;
            this.editWeeklyTimeSheet(1);
        },

        //Get Time Sheet History Range
        async getTimeSheetHistoryRange() {
            this.isMonthSelected = false;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/search/" + this.empSelectionID;

            const options = {
                method: "GET",
                url: baseUrl,
                params: {
                    perPage: this.perPage,
                    dateFrom: this.timeSheetHistoryDateFrom,
                    dateTo: this.timeSheetHistoryDateTo,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let resp = await this.getResp(options);
            this.timeSheetHistory = resp.data.data;
            // await this.getStats();

            //Get Stats
            baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/stats/" + this.empSelectionID;

            let getStats = {
                method: "GET",
                url: baseUrl,
                params: {
                    dateFrom: this.timeSheetHistoryDateFrom,
                    dateTo: this.timeSheetHistoryDateTo,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            resp = await this.getResp(getStats);
            this.stats = resp;
        },

        //Get Time Sheet History using Month
        async getTimeSheetHistoryMonth() {
            this.isMonthSelected = true;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/search/" + this.empSelectionID;

            const options = {
                method: "GET",
                url: baseUrl,
                params: {
                    perPage: this.perPage,
                    month: this.timeSheetHistoryMonth,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.getResp(options);
            this.timeSheetHistory = resp.data.data;

            //Get Stats
            baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/stats/" + this.empSelectionID;

            let getStats = {
                method: "GET",
                url: baseUrl,
                params: {
                    month: this.timeSheetHistoryMonth,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            resp = await this.getResp(getStats);
            this.stats = resp;
        },

        //Prompt Edit History TimeSheet
        async editHistoryTimeSheet(id) {
            this.isEditHistoryTimeSheet = !this.isEditHistoryTimeSheet;
            this.isChanging = false;
            this.msgButton = "Save";
            this.updateID = id;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl +
                "/api/dtr/search/" +
                this.empSelectionID +
                "/" +
                this.updateID;
            const options = {
                method: "GET",
                url: baseUrl,
                params: { perPage: "31" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let resp = await this.getResp(options);
            this.timeSheet = resp.data;
            console.log(this.timeSheet);
            this.timeSheet.date_time_in = this.timeSheet.ref_date;
            this.timeSheet.date_time_out = this.timeSheet.ref_date;
            this.timeSheet.date_lunch_in = this.timeSheet.ref_date;
            this.timeSheet.date_lunch_out = this.timeSheet.ref_date;
            // if (this.timeSheet.time_in === null || this.timeSheet.time_out === null || this.timeSheet.lunch_in === null || this.timeSheet.lunch_out === null) {
            // } else {

            // }

            //Split if not null
            if(this.timeSheet.time_in != null){
                this.timeSheet.time_in = this.timeSheet.time_in.split(" ")[1];
            }

            if(this.timeSheet.time_out != null){
                this.timeSheet.time_out = this.timeSheet.time_out.split(" ")[1];
            }

            if(this.timeSheet.lunch_in != null){
                this.timeSheet.lunch_in = this.timeSheet.lunch_in.split(" ")[1];
            }

            if(this.timeSheet.lunch_out != null){
                this.timeSheet.lunch_out = this.timeSheet.lunch_out.split(" ")[1];
            }


            
        },
        //Update History Time Sheet
        async updateHistoryTimeSheet() {
            //Check if null
            //Time in
            if(this.timeSheet.time_in === null || this.timeSheet.time_in === ''){
                this.timeSheet.time_in = null;
            }
            else{
            this.timeSheet.time_in =
                this.timeSheet.date_time_in + " " + this.timeSheet.time_in;
            }

            //Lunch Out
            if(this.timeSheet.lunch_out === null || this.timeSheet.lunch_out === ''){
                this.timeSheet.lunch_out = null;
            }
            else{
            this.timeSheet.lunch_out =
                this.timeSheet.date_lunch_out + " " + this.timeSheet.lunch_out;
            }

            //Lunch in
            if(this.timeSheet.lunch_in === null || this.timeSheet.lunch_in === ''){
                this.timeSheet.lunch_in = null;
            }
            else{
           this.timeSheet.lunch_in =
                this.timeSheet.date_lunch_in + " " + this.timeSheet.lunch_in;
            }
            
            //Time out
            if(this.timeSheet.time_out === null || this.timeSheet.time_out === ''){
                this.timeSheet.time_out = null;
            }
            else{
            this.timeSheet.time_out =
                this.timeSheet.date_time_out + " " + this.timeSheet.time_out;
            }
            
            //Check if null
            this.isChanging = true;
            this.msgButton = "Saving...";

            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/update/" + this.updateID;

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    time_in: this.timeSheet.time_in,
                    lunch_out: this.timeSheet.lunch_out,
                    lunch_in: this.timeSheet.lunch_in,
                    time_out: this.timeSheet.time_out,
                    reason: this.timeSheet.reason,
                },
            };

            let resp = await this.getResp(options);
            if (this.isMonthSelected) {
                this.getTimeSheetHistoryMonth();
            } else {
                this.getTimeSheetHistoryRange();
            }
            await this.getStats();
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been updated";
            this.isChanging = false;
            this.editHistoryTimeSheet(1);
        },

        //Get Stats
        async getStats() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/dtr/stats/" + this.empSelectionID;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            let resp = await this.getResp(options);
            this.stats = resp;
        },

        //Axios Request
        async getResp(options) {
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

        //Fire this function everytime it refreshes
        async getTheScheduleInformation() {
            await this.getStats();
            await this.getSchedule();
            await this.getScheduleToday();
            await this.getWeeklyRecord();

            //Get Today
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, "0");
            var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
            var yyyy = today.getFullYear();
            today = yyyy + "-" + mm + "-" + dd;
            this.timeSheetHistoryDateFrom = today;
            this.timeSheetHistoryDateTo = today;
            await this.getTimeSheetHistoryRange();
        },

        //Generate DTR
        async generateDTR() {
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";
            var newDate = new Date();
            var newYear = newDate.getFullYear();
            let options = null;
            options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    permission: "print dtr",
                    model_name: {
                        employeeId: this.empSelectionID,
                        // "dateFrom": this.timeSheetHistoryDateFrom,
                        // "dateTo": this.timeSheetHistoryDateTo,
                        month: this.timeSheetHistoryMonth,
                        // "year": newYear,
                        perPage: this.perPage,
                        supervisor: this.supervisor,
                    },
                },
            };

            if (this.isMonthSelected) {
                options = {
                    method: "POST",
                    url: this.baseUrl,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken,
                    },
                    data: {
                        permission: "print dtr",
                        model_name: {
                            employeeId: this.empSelectionID,
                            // "dateFrom": this.timeSheetHistoryDateFrom,
                            // "dateTo": this.timeSheetHistoryDateTo,
                            month: this.timeSheetHistoryMonth,
                            // "year": newYear,
                            perPage: this.perPage,
                            supervisor: this.supervisor,
                        },
                    },
                };
            } else {
                options = {
                    method: "POST",
                    url: this.baseUrl,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken,
                    },
                    data: {
                        permission: "print dtr",
                        model_name: {
                            employeeId: this.empSelectionID,
                            dateFrom: this.timeSheetHistoryDateFrom,
                            dateTo: this.timeSheetHistoryDateTo,
                            perPage: this.perPage,
                            supervisor: this.supervisor,
                        },
                    },
                };
            }

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    console.log(printToken);

                    //New Tab to generate the PDS
                    parentURL =
                        parentURL +
                        "/generate/report/2/single/dtr/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    async created() {
        await this.getParam();
        if (this.empSelectionID === null) {
            // Do Nothing
            this.$store.state.currentSelectionUserId =
                localStorage.getItem("accountId");
            // console.log(this.empSelectionID)
            await this.getTheScheduleInformation();
        } else {
            await this.getTheScheduleInformation();
        }

        //Get Today
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, "0");
        var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + "-" + mm + "-" + dd;

        this.effective_date = today;
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
