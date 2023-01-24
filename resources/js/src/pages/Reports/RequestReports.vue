<template>
    <form>
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Request Reports</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-medium-size-100 md-size-100">
                        <md-table md-card>
                            <md-table-toolbar>
                                <!-- <h1 class="md-title"></h1> -->
                            </md-table-toolbar>

                            <md-table-row>
                                <md-table-head>Description</md-table-head>
                                <md-table-head>Actions</md-table-head>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell>Leave Ledger</md-table-cell>
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printLeaveLedger = !printLeaveLedger
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Leave Balances Report</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printLeaveBalancesReport =
                                                !printLeaveBalancesReport
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Certification of Leave
                                    Credits</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printCertificationOfLeaveCredits =
                                                !printCertificationOfLeaveCredits
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Certification of Without Pay</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printCertificationWithoutPay =
                                                !printCertificationWithoutPay
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Report of Salary Deduction/Cancellation
                                    from Restoration to Payroll</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSalaryDeductionPayroll =
                                                !printSalaryDeductionPayroll
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell>Monetization</md-table-cell>
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printMonetization =
                                                !printMonetization
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Summary of Approved/Disapproved/Cancelled
                                    leave and CTO requests</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryRequest =
                                                !printSummaryRequest
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Summary of Employees with Approved Request
                                    to Render Overtime</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryRenderOT =
                                                !printSummaryRenderOT
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Summary of Employees With Approved Request
                                    for Night Differential Pay</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryNightDifferential =
                                                !printSummaryNightDifferential
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Monthly Summary of employees with negative
                                    VL and SL credits</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printSummaryEmployeesNegativeLeave =
                                                !printSummaryEmployeesNegativeLeave
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>

                            <md-table-row>
                                <md-table-cell
                                    >Year-end list of employees unused VL and SL
                                    for commutation</md-table-cell
                                >
                                <md-table-cell>
                                    <md-button
                                        class="md-primary md-dense"
                                        @click="
                                            printAnnualEmployeeLeave =
                                                !printAnnualEmployeeLeave
                                        "
                                        >Print</md-button
                                    >
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </div>
                </div>
            </md-card-content>
        </md-card>

        <!-- Leave Ledger Report -->
        <DialogCard v-if="printLeaveLedger">
            <section slot="header">Leave Ledger Report</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validateLeaveLedgerReport()"
                >
                    <md-field>
                        <label>Select Employee</label>
                        <md-input v-model="employeeName" disabled> </md-input>
                        <md-button
                            class="md-raised md-dense md-primary"
                            @click="isSelectEmployee = true"
                            >☰</md-button
                        >
                    </md-field>

                    <!-- <md-field>
                        <label>Employee</label>
                        <md-input
                            v-model="employeeName"
                            type="text"
                            disabled
                        ></md-input>
                    </md-field> -->

                    <md-field>
                        <label>Employee Position</label>
                        <md-input
                            v-model="employeePosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-field>
                        <label>Employee Division</label>
                        <md-input
                            v-model="employeeDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionEmployee"
                        @md-selected="getPositionEmployee()"
                        required
                    >
                        <label>Prepared</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="printLeaveLedger = !printLeaveLedger"
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Leave Balances Report -->
        <DialogCard v-if="printLeaveBalancesReport">
            <section slot="header">Leave Balances Report</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintLeaveBalanceReport()"
                >
                    <md-field>
                        <label>Select Division</label>
                        <md-select v-model="divisionId">
                            <md-option
                                v-for="d in divisions"
                                :key="d.id"
                                :value="d.id"
                                >{{ d.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Reference Date"
                        v-model="refDate"
                        ><label>Reference Date</label></md-datepicker
                    >
                    <md-field>
                        <label>From</label>
                        <md-input v-model="from"></md-input>
                    </md-field>
                    <md-field>
                        <label>Select Employee</label>
                        <md-input v-model="employeeName" disabled> </md-input>
                        <md-button
                            class="md-raised md-dense md-primary"
                            @click="isSelectEmployee = true"
                            >☰</md-button
                        >
                    </md-field>
                    <md-field>
                        <label>Employee Position</label>
                        <md-input
                            v-model="employeePosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-field>
                        <label>Employee Division</label>
                        <md-input
                            v-model="employeeDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorDivision()"
                        required
                    >
                        <label>Super Visor</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <md-field>
                        <label>Supervisor Division</label>
                        <md-input
                            v-model="supervisorDivision"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printLeaveBalancesReport = !printLeaveBalancesReport
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Certification of Leave Credits -->
        <DialogCard v-if="printCertificationOfLeaveCredits">
            <section slot="header">Certification of Leave Credits</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintCertificationOfLeaveCredits()"
                >
                    <md-chips v-model="selectionOfEmployees">
                        <md-button
                            class="md-raised md-dense md-primary"
                            @click="isSelectMultipleEmployee = true"
                            style="width: 100% !important"
                            >Search Employees</md-button
                        >
                        <template slot="md-chip" slot-scope="{ chip }">
                            ID: {{ chip.id }} Employee No:
                            {{ chip.employee_number }} Name:
                            {{ chip.first_name }} {{ chip.middle_name }}
                            {{ chip.last_name }}
                        </template>
                    </md-chips>
                    <md-datepicker
                        :md-model-type="String"
                        label="Reference Date"
                        v-model="refDate"
                        ><label>Reference Date</label></md-datepicker
                    >
                    <md-autocomplete
                        v-model="prepared"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorPositionDivision()"
                        required
                    >
                        <label>Prepared</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>
                    <md-field>
                        <label>Prepared Position</label>
                        <md-input
                            v-model="preparedPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Prepared Division</label>
                        <md-input
                            v-model="preparedDivision"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-autocomplete
                        v-model="verified"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorPositionDivision()"
                        required
                    >
                        <label>Verified</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>
                    <md-field>
                        <label>Verified Position</label>
                        <md-input
                            v-model="verifiedPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Verified Division</label>
                        <md-input
                            v-model="verifiedDivision"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printCertificationOfLeaveCredits =
                                !printCertificationOfLeaveCredits
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Report of Salary Deduction/Cancellation from Restoration to Payroll -->
        <DialogCard v-if="printSalaryDeductionPayroll">
            <section slot="header">
                Report of Salary Deduction/Cancellation from Restoration to
                Payroll
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validateSalaryDeductionPayroll()"
                >
                    <md-field>
                        <label>Select Month</label>
                        <md-select v-model="month">
                            <md-option value="01">January</md-option>
                            <md-option value="02">February</md-option>
                            <md-option value="03">March</md-option>
                            <md-option value="04">April</md-option>
                            <md-option value="05">May</md-option>
                            <md-option value="06">June</md-option>
                            <md-option value="07">July</md-option>
                            <md-option value="8">August</md-option>
                            <md-option value="9">September</md-option>
                            <md-option value="10">October</md-option>
                            <md-option value="11">November</md-option>
                            <md-option value="12">December</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Year</label>
                        <md-input
                            v-model="year"
                            type="number"
                            required
                            maxlength="4"
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>From</label>
                        <md-input v-model="from"></md-input>
                    </md-field>
                    <md-field>
                        <label>For</label>
                        <md-input v-model="employeeName" disabled> </md-input>
                        <md-button
                            class="md-raised md-dense md-primary"
                            @click="isSelectEmployee = true"
                            >☰</md-button
                        >
                    </md-field>
                    <md-field>
                        <label>For Position</label>
                        <md-input
                            v-model="employeePosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-field>
                        <label>For Division</label>
                        <md-input
                            v-model="employeeDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorDivision()"
                        required
                    >
                        <label>Signed</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <md-field>
                        <label>Signed Division</label>
                        <md-input
                            v-model="supervisorDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printSalaryDeductionPayroll =
                                !printSalaryDeductionPayroll
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Monetization -->
        <DialogCard v-if="printMonetization">
            <section slot="header">Monetization</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintMonetization()"
                >
                    <md-field>
                        <label>Print Type</label>
                        <md-select v-model="printType">
                            <md-option value="FOR_APPROVAL"
                                >FOR APPROVAL</md-option
                            >
                            <md-option value="FOR_APPROPRIATE_ACTION"
                                >FOR APPROPRIATE ACTION</md-option
                            >
                        </md-select>
                    </md-field>

                    <md-field>
                        <label>Select Month</label>
                        <md-select v-model="month">
                            <md-option value="01">January</md-option>
                            <md-option value="02">February</md-option>
                            <md-option value="03">March</md-option>
                            <md-option value="04">April</md-option>
                            <md-option value="05">May</md-option>
                            <md-option value="06">June</md-option>
                            <md-option value="07">July</md-option>
                            <md-option value="8">August</md-option>
                            <md-option value="9">September</md-option>
                            <md-option value="10">October</md-option>
                            <md-option value="11">November</md-option>
                            <md-option value="12">December</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Year</label>
                        <md-input
                            v-model="year"
                            type="number"
                            required
                            maxlength="4"
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>For Employee</label>
                        <md-input v-model="employeeName" disabled> </md-input>
                        <md-button
                            class="md-raised md-dense md-primary"
                            @click="isSelectEmployee = true"
                            >☰</md-button
                        >
                    </md-field>
                    <md-field>
                        <label>For Position</label>
                        <md-input
                            v-model="employeePosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-field>
                        <label>For Division</label>
                        <md-input
                            v-model="employeeDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="through"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getThroughDivisionPosition()"
                        required
                    >
                        <label>Through</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <md-field>
                        <label>Through Position</label>
                        <md-input
                            v-model="throughPosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-field>
                        <label>Through Division</label>
                        <md-input
                            v-model="throughDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="signed"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSignedPositionDivision()"
                        required
                    >
                        <label>Signed</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <md-field>
                        <label>Signed Position</label>
                        <md-input
                            v-model="signedPosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-field>
                        <label>Signed Division</label>
                        <md-input
                            v-model="signedDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="printMonetization = !printMonetization"
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Certification of Without Pay -->
        <DialogCard v-if="printCertificationWithoutPay">
            <section slot="header">Certification of Without Pay</section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validateCertificationWithoutPay()"
                >
                    <md-chips v-model="selectionOfEmployees">
                        <md-button
                            class="md-raised md-dense md-primary"
                            @click="isSelectMultipleEmployee = true"
                            style="width: 100% !important"
                            >Select Employees</md-button
                        >
                        <template slot="md-chip" slot-scope="{ chip }">
                            ID: {{ chip.id }} Employee No:
                            {{ chip.employee_number }} Name:
                            {{ chip.first_name }} {{ chip.middle_name }}
                            {{ chip.last_name }}
                        </template>
                    </md-chips>
                    <md-datepicker
                        :md-model-type="String"
                        label="Reference Date"
                        v-model="dateFrom"
                        ><label>Date From:</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        label="Reference Date"
                        v-model="dateTo"
                        ><label>Date To:</label></md-datepicker
                    >
                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorPositionDivision()"
                        required
                    >
                        <label>Super Visor</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>
                    <md-field>
                        <label>Supervisor Potision</label>
                        <md-input
                            v-model="supervisorPosition"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Supervisor Division</label>
                        <md-input
                            v-model="supervisorDivision"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printCertificationWithoutPay =
                                !printCertificationWithoutPay
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Select Multiple Employee -->
        <DialogCard v-if="isSelectMultipleEmployee">
            <section slot="header">Select Employee</section>
            <section slot="body">
                <md-table
                    v-model="employees"
                    md-sort="name"
                    md-sort-order="asc"
                    md-card
                    @md-selected="onSelectMultipleEmployee"
                >
                    <md-table-toolbar>
                        <div class="md-toolbar-section-start">
                            <!-- <h2 class="md-title">Employees Information</h2> -->
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-70"
                        >
                            <md-field md-clearable>
                                <form
                                    method="post"
                                    @submit.prevent="searchEmployee()"
                                >
                                    <md-input
                                        placeholder="Search employee..."
                                        v-model="searchValue"
                                    />
                                </form>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-30"
                        >
                            <md-button
                                class="md-raised md-primary"
                                @click="searchEmployee()"
                                :disabled="isSearching"
                                >{{ searchBtnName }}</md-button
                            >
                        </div>
                    </md-table-toolbar>
                    <md-table-row
                        slot="md-table-row"
                        slot-scope="{ item }"
                        md-selectable="multiple"
                    >
                        <md-table-cell
                            md-label="ID"
                            md-sort-by="id"
                            md-numeric
                            >{{ item.id }}</md-table-cell
                        >
                        <!-- <md-table-cell
                                md-label="Username"
                                md-sort-by="username"
                                md-numeric
                                >{{ item.username }}</md-table-cell
                            >                             -->
                        <md-table-cell
                            md-label="Employee Number"
                            md-sort-by="employee_number"
                            >{{ item.employee_number }}</md-table-cell
                        >
                        <!-- <md-table-cell md-label="Birth Date" md-sort-by="birth_date">{{ item.birth_date }}</md-table-cell> -->
                        <md-table-cell md-label="Name" md-sort-by="name"
                            >{{ item.first_name }} {{ item.middle_name }}
                            {{ item.last_name }}
                            {{ item.name_extension }}</md-table-cell
                        >
                        <md-table-cell
                            md-label="Birth Date"
                            md-sort-by="birthdate"
                            >{{ item.birth_date }}</md-table-cell
                        >
                    </md-table-row>

                    <md-table-empty-state
                        md-label="No employee found"
                        :md-description="`Try a different search term`"
                    >
                        <!-- <md-button class="md-primary md-raised">Create New Record</md-button> -->
                    </md-table-empty-state>
                </md-table>
                <md-chips
                    v-model="selectionOfEmployees"
                    md-placeholder="Selected Employees:"
                >
                    <template slot="md-chip" slot-scope="{ chip }">
                        ID: {{ chip.id }} Employee No:
                        {{ chip.employee_number }} Name: {{ chip.first_name }}
                        {{ chip.middle_name }} {{ chip.last_name }}
                    </template>
                </md-chips>
                <md-button
                    class="md-raised md-primary"
                    @click="changeCurrentEmployeeSelections()"
                    v-if="isSelected"
                >
                    Confirm
                </md-button>
                <md-dialog-actions>
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            isSelectMultipleEmployee = !isSelectMultipleEmployee
                        "
                        >✕ Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- Select Single Employee -->
        <DialogCard v-if="isSelectEmployee">
            <section slot="header">Select Employee</section>
            <section slot="body">
                <md-table
                    v-model="employees"
                    md-sort="name"
                    md-sort-order="asc"
                    md-card
                    @md-selected="onSelect"
                >
                    <md-table-toolbar>
                        <div class="md-toolbar-section-start">
                            <!-- <h2 class="md-title">Employees Information</h2> -->
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-70"
                        >
                            <md-field md-clearable>
                                <form
                                    method="post"
                                    @submit.prevent="searchEmployee()"
                                >
                                    <md-input
                                        placeholder="Search employee..."
                                        v-model="searchValue"
                                    />
                                </form>
                            </md-field>
                        </div>
                        <div
                            class="md-layout-item md-small-size-100 md-size-30"
                        >
                            <md-button
                                class="md-raised md-primary"
                                @click="searchEmployee()"
                                :disabled="isSearching"
                                >{{ searchBtnName }}</md-button
                            >
                        </div>
                    </md-table-toolbar>
                    <md-table-row
                        slot="md-table-row"
                        slot-scope="{ item }"
                        md-selectable="single"
                    >
                        <md-table-cell
                            md-label="ID"
                            md-sort-by="id"
                            md-numeric
                            >{{ item.id }}</md-table-cell
                        >
                        <!-- <md-table-cell
                                md-label="Username"
                                md-sort-by="username"
                                md-numeric
                                >{{ item.username }}</md-table-cell
                            >                             -->
                        <md-table-cell
                            md-label="Employee Number"
                            md-sort-by="employee_number"
                            >{{ item.employee_number }}</md-table-cell
                        >
                        <!-- <md-table-cell md-label="Birth Date" md-sort-by="birth_date">{{ item.birth_date }}</md-table-cell> -->
                        <md-table-cell md-label="Name" md-sort-by="name"
                            >{{ item.first_name }} {{ item.middle_name }}
                            {{ item.last_name }}
                            {{ item.name_extension }}</md-table-cell
                        >
                        <md-table-cell
                            md-label="Birth Date"
                            md-sort-by="birthdate"
                            >{{ item.birth_date }}</md-table-cell
                        >
                    </md-table-row>

                    <md-table-empty-state
                        md-label="No employee found"
                        :md-description="`Try a different search term`"
                    >
                        <!-- <md-button class="md-primary md-raised">Create New Record</md-button> -->
                    </md-table-empty-state>
                </md-table>
                <md-button
                    class="md-raised md-primary"
                    @click="changeCurrentEmployeeSelection()"
                    v-if="isSelected"
                >
                    Confirm
                </md-button>
                <md-dialog-actions>
                    <md-button
                        class="md-dense md-danger"
                        @click="isSelectEmployee = !isSelectEmployee"
                        >✕ Close</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>

        <!-- Summary of Approved/Disapproved/Cancelled leave and CTO requests -->
        <DialogCard v-if="printSummaryRequest">
            <section slot="header">
                Summary of Approved/Disapproved/Cancelled leave and CTO requests
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintSummaryRequest()"
                >
                    <md-field>
                        <label>Status</label>
                        <md-select v-model="status">
                            <md-option value="ALL">ALL</md-option>
                            <md-option value="APPROVED">APPROVED</md-option>
                            <md-option value="DISAPPROVED"
                                >DISAPPROVED</md-option
                            >
                            <md-option value="CANCELLED">CANCELLED</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Select Division</label>
                        <md-select v-model="divisionId">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="d in divisions"
                                :key="d.id"
                                :value="d.id"
                                >{{ d.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date From"
                        v-model="dateFrom"
                        ><label>Date From</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        label="Date To"
                        v-model="dateTo"
                        ><label>Date To</label></md-datepicker
                    >
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="printSummaryRequest = !printSummaryRequest"
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Summary of Employees with Approved Request to Render Overtime -->
        <DialogCard v-if="printSummaryRenderOT">
            <section slot="header">
                Summary of Employees with Approved Request to Render Overtime
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintSummaryRenderOT()"
                >
                    <md-field>
                        <label>Select Division</label>
                        <md-select v-model="divisionId">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="d in divisions"
                                :key="d.id"
                                :value="d.id"
                                >{{ d.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date From"
                        v-model="dateFrom"
                        ><label>Date From</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        label="Date To"
                        v-model="dateTo"
                        ><label>Date To</label></md-datepicker
                    >
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="printSummaryRenderOT = !printSummaryRenderOT"
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Summary of Employees With Approved Request for Night Differential Pay -->
        <DialogCard v-if="printSummaryNightDifferential">
            <section slot="header">
                Summary of Employees With Approved Request for Night
                Differential Pay
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintSummaryNightDifferential()"
                >
                    <md-field>
                        <label>Select Division</label>
                        <md-select v-model="divisionId">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="d in divisions"
                                :key="d.id"
                                :value="d.id"
                                >{{ d.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date From"
                        v-model="dateFrom"
                        ><label>Date From</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        label="Date To"
                        v-model="dateTo"
                        ><label>Date To</label></md-datepicker
                    >
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printSummaryNightDifferential =
                                !printSummaryNightDifferential
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Monthly Summary of employees with negative VL and SL credits -->
        <DialogCard v-if="printSummaryEmployeesNegativeLeave">
            <section slot="header">
                Monthly Summary of employees with negative VL and SL credits
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="
                        validatePrintSummaryEmployeesNegativeLeave()
                    "
                >
                    <md-field>
                        <label>Select Division</label>
                        <md-select v-model="divisionId">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="d in divisions"
                                :key="d.id"
                                :value="d.id"
                                >{{ d.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date From"
                        v-model="dateFrom"
                        ><label>Date From</label></md-datepicker
                    >
                    <md-datepicker
                        :md-model-type="String"
                        label="Date To"
                        v-model="dateTo"
                        ><label>Date To</label></md-datepicker
                    >
                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printSummaryEmployeesNegativeLeave =
                                !printSummaryEmployeesNegativeLeave
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Year-end list of employees unused VL and SL for commutation -->
        <DialogCard v-if="printAnnualEmployeeLeave">
            <section slot="header">
                Year-end list of employees unused VL and SL for commutation
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validatePrintAnnualEmployeeLeave()"
                >
                    <md-field>
                        <label>Select Division</label>
                        <md-select v-model="divisionId">
                            <md-option value="na">N/A</md-option>
                            <md-option
                                v-for="d in divisions"
                                :key="d.id"
                                :value="d.id"
                                >{{ d.name }}</md-option
                            >
                        </md-select>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Reference Date"
                        v-model="refDate"
                        ><label>Reference Date</label></md-datepicker
                    >
                    <md-field>
                        <label>For Employee</label>
                        <md-input v-model="employeeName" disabled> </md-input>
                        <md-button
                            class="md-raised md-dense md-primary"
                            @click="isSelectEmployee = true"
                            >☰</md-button
                        >
                    </md-field>
                    <md-field>
                        <label>For Position</label>
                        <md-input
                            v-model="employeePosition"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-field>
                        <label>For Division</label>
                        <md-input
                            v-model="employeeDivision"
                            type="text"
                        ></md-input>
                    </md-field>

                    <md-autocomplete
                        v-model="supervisor"
                        :md-options="getSanitizedSuggestionSupervisor"
                        @md-selected="getSuperVisorDivision()"
                        required
                    >
                        <label>Signed</label>
                        <template
                            slot="md-autocomplete-item"
                            slot-scope="{ item }"
                        >
                            {{ item.name }}
                        </template>
                    </md-autocomplete>

                    <md-field>
                        <label>Signed Division</label>
                        <md-input
                            v-model="supervisorDivision"
                            type="text"
                            required
                        ></md-input>
                    </md-field>

                    <md-button type="submit" class="md-primary md-dense"
                        >Print</md-button
                    >
                    <md-button
                        class="md-dense md-danger"
                        @click="
                            printAnnualEmployeeLeave = !printAnnualEmployeeLeave
                        "
                        >✕ Close</md-button
                    >
                </form>
            </section>
        </DialogCard>

        <!-- Division -->
        <!-- <DialogCard v-if="divSearch">
            <section slot="header">Select Division</section>
            <section slot="body">
                <ListDivision
                    v-on:close-dialog="getDivNameAndId"
                ></ListDivision>
                <form>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-danger"
                            @click="divSearch = !divSearch"
                            >✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard> -->

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

        <!-- -->
        <DialogCard v-if="!isParamLoaded">
            <section slot="header">Getting Requied Parameters...</section>
            <section slot="body">
                Please do not refresh or close this window
            </section>
        </DialogCard>
        <!-- -->
    </form>
</template>
<script>
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
// const ListDivision = () =>
//     import(
//         /* webpackChunkName: "ListDivision" */ "../../pages/Positions/ListDivision.vue"
//     );
document.getElementsByClassName("md-input").disabled = true;

import LogOut from "../../mixins/logOut.js";
import axios from "axios";
let baseURL = localStorage.getItem("base_url");
let token = localStorage.getItem("token");
export default {
    components: {
        DialogCard,
        // ListDivision,
    },
    mixins: [LogOut],
    name: "RequestReports",
    data() {
        return {
            isAuthenticated: true,

            //Report
            printLeaveLedger: false,
            isSelectEmployee: false,
            employees: [],
            employeeName: null,
            employeeId: null,
            employeePosition: null,
            employeeDivision: null,
            isSelected: false,
            searchValue: null,
            isSearching: false,
            searchBtnName: "Search",
            selection: null,
            from: '',

            printLeaveBalancesReport: false,
            divisions: [],
            divisionName: null,
            divisionId: null,
            refDate: null,

            printCertificationOfLeaveCredits: false,
            isSelectMultipleEmployee: false,
            selectionOfEmployees: [],
            employeeIds: [],

            printCertificationWithoutPay: false,
            dateFrom: null,
            dateTo: null,

            printSalaryDeductionPayroll: false,
            month: 1,
            year: 2020,

            printMonetization: false,
            through: null,
            throughPosition: null,
            throughDivision: null,
            signed: null,
            signedPosition: null,
            signedDivision: null,
            printType: "FOR_APPROVAL",

            printSummaryRequest: false,
            status: "ALL",

            printSummaryRenderOT: false,

            printSummaryNightDifferential: false,

            printSummaryEmployeesNegativeLeave: false,

            printAnnualEmployeeLeave: false,

            prepared: null,
            preparedPosition: null,
            preparedDivision: null,
            verified: null,
            verifiedPosition: null,
            verifiedDivision: null,
            supervisor: null,
            supervisorPosition: null,
            supervisorDivision: null,
            printEmployeeTardiness: false,
            placeOfWork: null,

            //Suggestion
            suggestions: [],
            suggestionsEmployee: [],
            suggestionsEmployeePosition: [],
            suggestionsSuperVisor: [],
            suggestionHigherSuperVisor: [],
            suggestionPlaceOfWork: null,

            //UI
            isParamLoaded: false,
        };
    },
    computed: {
        getSanitizedSuggestionEmployee() {
            return this.suggestionsEmployee.map((suggestionsEmployees) => ({
                name: suggestionsEmployees.name,
                position: suggestionsEmployees.position,
                toLowerCase: () => suggestionsEmployees.name.toLowerCase(),
                toString: () => suggestionsEmployees.name,
            }));
        },
        getSanitizedSuggestionSupervisor() {
            return this.suggestionsSuperVisor.map((suggestionsSuperVisors) => ({
                name: suggestionsSuperVisors.name,
                position: suggestionsSuperVisors.position,
                division: suggestionsSuperVisors.division,
                toLowerCase: () => suggestionsSuperVisors.name.toLowerCase(),
                toString: () => suggestionsSuperVisors.name,
            }));
        },
    },
    methods: {
        //Get Suggestions
        async getSuggestions() {
            let newURL = baseURL + "/api/token/report/parameter";
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
                    this.suggestions = response.data;
                    this.divisions = response.data.divisionId;
                    this.suggestionPlaceOfWork = this.suggestions.placeOfWork;
                    //Get Employee
                    for (const [key, employeeValue1] of Object.entries(
                        this.suggestions
                    )) {
                        if (key === "suggestions") {
                            for (const [key, employeeValue2] of Object.entries(
                                employeeValue1
                            )) {
                                this.suggestionsEmployee.push(
                                    employeeValue2.employee
                                );
                            }
                        }
                    }

                    //Get Super visor
                    for (const [key, superVisorValue1] of Object.entries(
                        this.suggestions
                    )) {
                        if (key === "suggestions") {
                            for (const [
                                key,
                                superVisorValue2,
                            ] of Object.entries(superVisorValue1)) {
                                this.suggestionsSuperVisor.push(
                                    superVisorValue2.supervisor
                                );
                            }
                        }
                    }

                    //Get Higher Supervisor
                    for (const [key, higherSuperVisor1] of Object.entries(
                        this.suggestions
                    )) {
                        if (key === "suggestions") {
                            for (const [
                                key,
                                higherSuperVisor2,
                            ] of Object.entries(higherSuperVisor1)) {
                                this.suggestionHigherSuperVisor.push(
                                    higherSuperVisor2.higherSupervisor
                                );
                            }
                        }
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        //Get Position Employee
        getPositionEmployee() {
            this.prepared = this.prepared.name;
        },

        //Get Position Super Visor
        getSuperVisorPosition() {
            this.supervisorPosition = this.supervisor.position;
            this.supervisor = this.supervisor.name;
        },

        //Get Division Super Visor
        getSuperVisorDivision() {
            this.supervisorDivision = this.supervisor.division;
            this.supervisor = this.supervisor.name;
        },

        //Print Leave Ledger Report
        async validateLeaveLedgerReport() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        employeeId: this.employeeId,
                        certified: this.employeeName,
                        certifiedPosition: this.employeePosition,
                        certifiedDivision: this.employeeDivision,
                        prepared: this.prepared,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/leave-ledger/" +
                        printToken;
                    console.log(parentURL);
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Print Leave Balance Report
        async validatePrintLeaveBalanceReport() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        divisionId: this.divisionId,
                        refDate: this.refDate,
                        from: this.from,
                        employee: this.employeeName,
                        employeePosition: this.employeePosition,
                        employeeDivision: this.employeeDivision,
                        supervisor: this.supervisor,
                        supervisorDivision: this.supervisorDivision,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/leave-balance/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Print Certification of Leave Credits
        async validatePrintCertificationOfLeaveCredits() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        employeeId: this.employeeIds,
                        refDate: this.refDate,
                        prepared: this.prepared,
                        preparedPosition: this.preparedPosition,
                        preparedDivision: this.preparedDivision,
                        verified: this.verified,
                        verifiedPosition: this.verifiedPosition,
                        verifiedDivision: this.verifiedDivision,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/certification-leave-credits/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Print Monetization
        async validatePrintMonetization() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        printType: this.printType,
                        month: this.month,
                        year: this.year,
                        for: this.employeeName,
                        forPosition: this.employeePosition,
                        forDivision: this.employeeDivision,
                        through: this.through,
                        throughPosition: this.throughPosition,
                        throughDivision: this.throughDivision,
                        signed: this.signed,
                        signedPosition: this.signedPosition,
                        signedDivision: this.signedDivision,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/monetization/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Print Certification of Without Pay
        async validateCertificationWithoutPay() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        employeeId: this.employeeIds,
                        dateFrom: this.dateFrom,
                        dateTo: this.dateTo,
                        supervisor: this.supervisor,
                        supervisorPosition: this.supervisorPosition,
                        supervisorDivision: this.supervisorDivision,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/certification-without-pay/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Print Report of Salary Deduction/Cancellation from Restoration to Payroll
        async validateSalaryDeductionPayroll() {
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        month: this.month,
                        year: this.year,
                        from: this.from,
                        for: this.employeeName,
                        forPosition: this.employeePosition,
                        forDivision: this.employeeDivision,
                        signed: this.supervisor,
                        signedDivision: this.supervisorDivision,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/salary-deduction-payroll/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async validatePrintSummaryRequest() {
            if (this.divisionId === "na") {
                this.divisionId = null;
            }
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        status: this.status,
                        divisionId: this.divisionId,
                        dateFrom: this.dateFrom,
                        dateTo: this.dateTo,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/summary-request/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Summary of Employees With Approved Request for Night Differential Pay
        async validatePrintSummaryNightDifferential() {
            if (this.divisionId === "na") {
                this.divisionId = null;
            }
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        divisionId: this.divisionId,
                        dateFrom: this.dateFrom,
                        dateTo: this.dateTo,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/summary-employees-night-differential/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        // Monthly Summary of employees with negative VL and SL credits
        async validatePrintSummaryEmployeesNegativeLeave() {
            if (this.divisionId === "na") {
                this.divisionId = null;
            }
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        divisionId: this.divisionId,
                        dateFrom: this.dateFrom,
                        dateTo: this.dateTo,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/summary-employees-negative-leave-credits/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async validatePrintSummaryRenderOT() {
            if (this.divisionId === "na") {
                this.divisionId = null;
            }
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        divisionId: this.divisionId,
                        dateFrom: this.dateFrom,
                        dateTo: this.dateTo,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/summary-employees-render-ot/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        //Year-end list of employees unused VL and SL for commutation
        async validatePrintAnnualEmployeeLeave() {
            if (this.divisionId === "na") {
                this.divisionId = null;
            }
            let printToken = null;
            const options = {
                method: "POST",
                url: baseURL + "/api/token/generate",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + token,
                },
                data: {
                    permission: "print request",
                    model_name: {
                        divisionId: this.divisionId,
                        refDate: this.refDate,
                        for: this.employeeName,
                        forPosition: this.employeePosition,
                        forDivision: this.employeeDivision,
                        signed: this.supervisor,
                        signedDivision: this.supervisorDivision,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    //New Tab to generate the report
                    let parentURL =
                        baseURL +
                        "/generate/report/3/single/annual-employees-unused-leave/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        //Get Supervisor Position and Division
        getSuperVisorPositionDivision() {
            this.supervisorPosition = this.supervisor.position;
            this.supervisorDivision = this.supervisor.division;
            this.supervisor = this.supervisor.name;
        },
        getThroughDivisionPosition() {
            this.throughPosition = this.through.position;
            this.throughDivision = this.through.division;
            this.through = this.through.name;
        },
        getSignedPositionDivision() {
            this.signedDivision = this.signed.position;
            this.signedPosition = this.signed.division;
            this.signed = this.signed.name;
        },

        //Search Employee
        async searchEmployee() {
            this.isSearching = true;
            this.searchBtnName = "Searching";
            const options = {
                method: "GET",
                url: baseURL + "/api/token/employees/parameter",
                params: { searchValue: this.searchValue, perPage: "10" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.employees = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isSearching = false;
            this.searchBtnName = "Search";
        },

        //Select Employee
        async changeCurrentEmployeeSelection() {
            this.isSelectEmployee = false;
            this.isParamLoaded = false;
            const options = {
                method: "GET",
                url: baseURL + "/api/token/report/parameter/" + this.employeeId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.employeeName = response.data.self.employee.name;
                    this.employeePosition =
                        response.data.self.employee.position;
                    this.employeeDivision =
                        response.data.self.employee.division;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.isParamLoaded = true;
        },

        //Change Multiple Employee Selection
        changeCurrentEmployeeSelections() {
            this.isSelectMultipleEmployee = false;
            this.employeeIds = [];
            for (const [key, value] of Object.entries(
                this.selectionOfEmployees
            )) {
                this.employeeIds.push(value.id);
            }
        },

        //event on selection of employee
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                this.employeeId = item.id;
                this.isSelected = true;
            }
        },

        //event on selection of multiple employee
        onSelectMultipleEmployee(item) {
            if (item.length <= 0) {
                this.isSelected = false;
                //this.selectionOfEmployees = []
            } else {
                //Iterate the item
                for (var i = 0; i < item.length; i++) {
                    if (
                        this.selectionOfEmployees.some(
                            (e) => e.id === item[i].id
                        )
                    ) {
                        console.log("exist!");
                    } else {
                        this.selectionOfEmployees.push(item[i]);
                    }
                }
                this.isSelected = true;
                console.log(this.selectionOfEmployees);
            }
        },
        getDivNameAndId() {
            this.divisionName = localStorage.getItem("division_name");
            this.divisionId = localStorage.getItem("division_id");
            this.divSearch = !this.divSearch;
        },
    },
    async created() {
        this.isParamLoaded = false;
        await this.getSuggestions();
        this.isParamLoaded = true;
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
