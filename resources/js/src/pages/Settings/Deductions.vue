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
        <h4 class="title">Deductions</h4>
      </md-card-header>
      <md-card-content>
        <div class="md-layout">
          <div
            class="md-layout-item md-small-size-100 md-size-100"
            style="margin-top: 20px"
          >
            <md-button
              class="md-raised md-dense md-primary"
              @click="
                deductionParentData = {};
                isAddDeductionParent = true;
              "
            >
              Add Deduction
            </md-button>
            <md-button
              class="md-raised md-dense md-primary"
              @click="isDeductionTypes = true"
            >
              Deduction Types
            </md-button>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-100">
            <table
              style="
                margin-top: 30px !important;
                margin-bottom: 30px !important;
              "
              class="zui-table"
            >
              <thead>
                <tr>
                  <th></th>
                  <th>Code</th>
                  <th>Description</th>
                  <th>Deduction Type</th>
                  <th>Deduction Frequency</th>
                  <th>Priority Level</th>
                  <th>Amount Type</th>
                  <th>Amount</th>
                  <th>Allow Slashes</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(e, i) in deductions">
                  <tr :key="i + 'a'">
                    <td>
                      <md-button v-if="e.employee_deductions && e.employee_deductions.length > 0"
                        class="md-simple md-icon-button md-primary"
                        @click="toggleTableRow(e.id)"
                      >
                        <md-icon>{{
                          expandedTableId == e.id
                            ? "expand_more"
                            : "chevron_right"
                        }}</md-icon>
                      </md-button>
                    </td>
                    <td>{{ e.code }}</td>
                    <td>{{ e.description }}</td>
                    <td>{{ e.deduction_type }}</td>
                    <td>{{ e.deduction_frequency }}</td>
                    <td>{{ e.priority_level }}</td>
                    <td>{{ e.amount_type }}</td>
                    <td>
                        {{ e.amount_type == 'FIXED' ? e.amount : getFormulaAmount(e.formula_amount) }}
                    </td>
                    <td>{{ e.is_slashes == 1 ? "YES" : "NO" }}</td>
                    <td>
                      <md-button
                        class="md-raised md-dense md-primary"
                        @click="
                          deductionChildData = {};
                          deductionParentId = e.id;
                          isAddDeductionChild = true;
                        "
                        >Add</md-button
                      >
                      <md-button
                        class="md-raised md-dense md-warning"
                        @click="
                          isEditDeductionParent = true;
                          deductionParentData = JSON.parse(JSON.stringify(e));
                        "
                        style="color: black !important"
                        >Edit</md-button
                      >
                      <md-button
                        class="md-raised md-dense md-danger"
                        @click="
                          isDeleteDeductionParent = true;
                          deductionParentData = JSON.parse(JSON.stringify(e));
                        "
                        >Delete</md-button
                      >
                    </td>
                  </tr>
                  <tr
                    :key="i + 'b'"
                    v-if="expandedTableId == e.id"
                    style="background-color: #fafafa"
                  >
                    <td colspan="10">
                      <div>
                        <table
                          style="
                            margin-top: 30px !important;
                            margin-bottom: 30px !important;
                          "
                          class="zui-table"
                        >
                          <thead>
                            <tr>
                              <th width="30%">Reference Date</th>
                              <th width="20%">Payroll Type</th>
                              <th width="20%">Amount</th>
                              <th width="30%">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(item, i) in e.employee_deductions"
                              :key="i"
                            >
                              <td>{{ item.ref_date }}</td>
                              <td>{{ item.payroll_type }}</td>
                              <td>{{ item.fixed_amount }}</td>
                              <td>
                                <md-button
                                  class="md-raised md-dense md-primary"
                                  @click="isAssignEmployee = true"
                                  >Assign</md-button
                                >
                                <md-button
                                  class="md-raised md-dense md-warning"
                                  @click="
                                    isEditDeductionChild = true;
                                    deductionParentId = e.id;
                                    deductionChildData = item;
                                  "
                                  style="color: black !important"
                                  >Edit</md-button
                                >
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>

          <div class="md-layout-item md-size-100 text-right">
            <label v-for="l in links" :key="l.label">
              <md-button
                class="button-paginate md-warning md-raised"
                @click="getRequestTypeUsingLink(l.url)"
                :disabled="l.active || l.url === null"
              >
                <label style="color: black !important" v-html="l.label"></label>
              </md-button>
            </label>
          </div>
        </div>
      </md-card-content>
    </md-card>

    <DialogCard v-if="isAddDeductionChild || isEditDeductionChild">
      <section slot="header">
        {{ isAddDeductionChild ? "Add" : "Edit" }} Deduction
      </section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="isAddDeductionChild ? addDeductionChild() : editDeductionChild()">
          <md-datepicker
            md-placeholder="Reference Date"
            :md-immediately="true"
            :md-model-type="String"
            v-model="deductionChildData.ref_date"
            ><label>From:</label></md-datepicker
          >
          <md-field>
            <label>Payroll Type</label>
            <md-select v-model="deductionChildData.payroll_type">
              <md-option value="REGULAR">REGULAR</md-option>
              <md-option value="OTHER BENEFITS">OTHER BENEFITS</md-option>
            </md-select>
          </md-field>
          <md-field>
              <label>Fixed Amount</label>
              <md-input v-model="deductionChildData.fixed_amount"></md-input>
          </md-field>
         
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{ isAddDeductionChild ? "Add" : "Update" }}</md-button>

            <md-button
              class="md-dense md-danger"
              @click="
                isAddDeductionChild
                  ? (isAddDeductionChild = false)
                  : (isEditDeductionChild = false)
              "
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isAddDeductionParent || isEditDeductionParent">
      <section slot="header">
        {{ isAddDeductionParent ? "Add" : "Edit" }} Deduction
      </section>
      <section slot="body" class="dCardBody">
        <form  method="post" @submit.prevent="isAddDeductionParent ? addDeductionParent() : editDeductionParent()">
          <md-field>
            <label>Code</label>
            <md-input v-model="deductionParentData.code"></md-input>
          </md-field>
          <md-checkbox>Use code for display</md-checkbox>
          <md-field>
            <label>Description</label>
            <md-input v-model="deductionParentData.description"></md-input>
          </md-field>
          <md-field>
            <label>Journal Entry</label>
            <md-input v-model="deductionParentData.journal_entry"></md-input>
          </md-field>
          <md-field>
            <label>Deduction Type</label>
            <md-select v-model="deductionParentData.deduction_type">
              <md-option
                v-for="(d, i) in deductionTypes"
                :key="i"
                :value="d.code"
                >{{ d.description }}</md-option
              >
            </md-select>
          </md-field>
          <md-field>
            <label>Deduction Frequency</label>
            <md-select v-model="deductionParentData.deduction_frequency">
              <md-option value="ONE TIME">ONE TIME</md-option>
              <md-option value="PERPETUAL">PERPETUAL</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label>Priority Level (1 being the highest priority)</label>
            <md-input v-model="deductionParentData.priority_level"></md-input>
          </md-field>
          <md-field>
            <label>Amount Type</label>
            <md-select v-model="deductionParentData.amount_type">
              <md-option value="FIXED">FIXED</md-option>
              <md-option value="FORMULA">FORMULA BASED</md-option>
              <md-option value="AMORTIZED">AMORTIZED</md-option>
            </md-select>
          </md-field>
          <template v-if="deductionParentData.amount_type == 'FIXED'">
              <md-field>
                <label>Fixed Amount</label>
                <md-input v-model="deductionParentData.fixed_amount"></md-input>
            </md-field>
          </template>
          <template v-if="deductionParentData.amount_type == 'FORMULA'">
              <md-field>
                <label>Formula Amount</label>
                <md-input :value="getFormulaAmount(deductionParentData.formula_amount)"></md-input>
            </md-field>
          </template>
          <template v-if="deductionParentData.amount_type == 'AMORTIZED'">
              <md-checkbox v-model="deductionParentData.is_slashes">Allow Shashes</md-checkbox>
          </template>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{
              isAddDeductionParent ? "Add" : "Update"
            }}</md-button>

            <md-button
              class="md-dense md-danger"
              @click="
                isAddDeductionParent
                  ? (isAddDeductionParent = false)
                  : (isEditDeductionParent = false)
              "
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeleteDeductionParent">
      <section slot="header">Delete Deduction?</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="deleteDeductionParent()">
          <md-dialog-actions>
            <md-button class="md-dense md-danger" type="submit">Delete</md-button>
            <md-button
              class="md-dense md-primary"
              @click="isDeleteDeductionParent = false"
              >No, I changed my mind</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isAssignEmployee">
      <section slot="header">Assign Employee</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="assignEmployee()">
          <md-card>
            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-size-100">
                  <md-table class="md-dense" v-model="filteredEmployees">
                    <md-table-toolbar>
                      <div class="md-toolbar-section-start"></div>
                      <md-field class="md-toolbar-section-end">
                        <md-input
                          placeholder="Search"
                          v-model="searchEmployeeValue"
                          @keyup="
                            (e) => {
                              if (e.target.value == '') {
                                getEmployees('/api/training/date/parameter/');
                              }
                            }
                          "
                        />
                        <md-button
                          class="md-primary md-dense"
                          style="margin-bottom: 10px !important"
                          @click="getEmployees('/api/training/date/parameter/')"
                        >
                          Search
                        </md-button>
                      </md-field>
                    </md-table-toolbar>
                    <!-- <md-table-toolbar>
                                        <md-field md-clearable class="md-toolbar-section-end">
                                        <md-input placeholder="Search" v-model="searchEmployeeValue" @input="searchEmployee" />
                                        </md-field>
                                    </md-table-toolbar> -->
                    <md-table-empty-state :md-description="`No Record`">
                    </md-table-empty-state>
                    <md-table-row>
                      <md-table-head>
                        <md-checkbox
                          style="margin: 5px 0px 0px 5px"
                          v-model="selectAll"
                          @change="selectAllEmployees"
                        ></md-checkbox>
                        <!-- <md-button class="md-dense md-primary md-simple" @click="selectAllEmployees()">
                                                {{ this.filteredEmployees.every(val => this.selectedEmployees.includes(val.id)) ? 'Deselect All' : 'Select All' }}
                                            </md-button> -->
                      </md-table-head>
                      <md-table-head>Employee Number</md-table-head>
                      <md-table-head>Name</md-table-head>
                      <md-table-head>Date of Birth</md-table-head>
                    </md-table-row>
                    <md-table-row
                      v-for="(item, i) in filteredEmployees"
                      :key="i"
                      md-auto-select
                    >
                      <md-table-cell>
                        <md-checkbox
                          v-model="selectedEmployees"
                          :value="item.id"
                        ></md-checkbox>
                      </md-table-cell>
                      <md-table-cell>
                        {{ item.employee_number }}
                      </md-table-cell>
                      <md-table-cell>
                        {{ item.name }}
                      </md-table-cell>
                      <md-table-cell>
                        {{ item.dateOfBirth }}
                      </md-table-cell>
                    </md-table-row>
                  </md-table>
                  <!-- <md-table class="md-dense" v-model="filteredEmployees" @md-selected="onSelect">
                                    <md-table-toolbar>
                                        <md-field md-clearable class="md-toolbar-section-end">
                                        <md-input placeholder="Search" v-model="searchEmployeeValue" @input="searchEmployee" />
                                        </md-field>
                                    </md-table-toolbar>
                                    <md-table-empty-state :md-description="`No Record`">
                                    </md-table-empty-state>
                                    <md-table-row slot="md-table-row" slot-scope="{ item }" md-selectable="multiple" md-auto-select :md-disabled="item.isTick">
                                            <md-table-cell md-label="">
                                               
                                            </md-table-cell>
                                            <md-table-cell md-label="Employee Number">
                                                {{ item.employee_number }}
                                            </md-table-cell>
                                            <md-table-cell md-label="Name">
                                                {{ item.name }}
                                            </md-table-cell>
                                            <md-table-cell md-label="Date of Birth">
                                                {{ item.dateOfBirth }}
                                            </md-table-cell>
                                    </md-table-row>
                                </md-table>    -->
                </div>
                <div class="md-layout-item md-size-100 text-right">
                  <label v-for="(link, i) in employeeLinks" :key="i">
                    <md-button
                      class="button-paginate md-warning"
                      @click="getEmployees(link.url)"
                      :disabled="link.active || link.url === null"
                    >
                      <label
                        style="color: black !important"
                        v-html="link.label"
                      ></label>
                    </md-button>
                  </label>
                </div>
              </div>
            </md-card-content>
          </md-card>
          <md-dialog-actions>
            <md-button class="md-dense md-raised md-success" type="submit">
              Save</md-button
            >
            <md-button
              class="md-dense md-raised md-danger"
              @click="
                isAssignEmployee = false;
                searchEmployeeValue = null;
              "
            >
              ✕ Cancel</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeductionTypes">
      <section slot="header">Deduction Types</section>
      <section slot="body" class="dCardBody" style="width: 1000px">
        <form method="post" @submit.prevent="assignEmployee()">
          <md-card>
            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-size-100">
                  <div
                    class="md-layout-item md-small-size-100 md-size-100"
                    style="margin-top: 20px"
                  >
                    <md-button
                      class="md-raised md-dense md-primary"
                      @click="
                        isAddDeductionType = true;
                        deductionType = {};
                      "
                    >
                      Add Deduction Type
                    </md-button>
                  </div>
                  <table
                    style="
                      margin-top: 30px !important;
                      margin-bottom: 30px !important;
                    "
                    class="zui-table"
                  >
                    <thead>
                      <tr>
                        <th width="20%">Code</th>
                        <th width="30%">Description</th>
                        <th width="20%">Deductions Before Tax</th>
                        <th width="30%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, i) in deductionTypes" :key="i">
                        <td>{{ item.code }}</td>
                        <td>{{ item.description }}</td>
                        <td>{{ item.is_mandatory == 1 ? 'YES' : 'NO' }}</td>
                        <td>
                          <md-button
                            class="md-raised md-dense md-primary"
                            @click="
                              deductionType = item;
                              isEditDeductionType = true;
                            "
                            >Edit</md-button
                          >
                          <md-button
                            class="md-raised md-dense md-danger"
                            @click="
                              deductionType = item;
                              isDeleteDeductionType = true;
                            "
                            >Delete</md-button
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="md-layout-item md-size-100 text-right">
                  <label v-for="(link, i) in employeeLinks" :key="i">
                    <md-button
                      class="button-paginate md-warning"
                      @click="getEmployees(link.url)"
                      :disabled="link.active || link.url === null"
                    >
                      <label
                        style="color: black !important"
                        v-html="link.label"
                      ></label>
                    </md-button>
                  </label>
                </div>
              </div>
            </md-card-content>
          </md-card>
          <md-dialog-actions>
            <md-button class="md-dense md-raised md-success" type="submit">
              Save</md-button
            >
            <md-button
              class="md-dense md-raised md-danger"
              @click="isDeductionTypes = false"
            >
              ✕ Cancel</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isAddDeductionType || isEditDeductionType">
      <section slot="header">
        {{ isAddDeductionType ? "Add" : "Edit" }} Deduction
      </section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="isAddDeductionType ? addDeductionType() : editDeductionType()">
          <md-field>
            <label>Code</label>
            <md-input v-model="deductionType.code"> ></md-input>
          </md-field>
          <md-field>
            <label>Description</label>
            <md-input v-model="deductionType.description"> ></md-input>
          </md-field>
          <md-checkbox v-model="deductionType.is_mandatory">Deductions before tax</md-checkbox>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{
              isAddDeductionType ? "Add" : "Update"
            }}</md-button>
            <md-button
              class="md-dense md-danger"
              @click="
                isAddDeductionType
                  ? (isAddDeductionType = false)
                  : (isEditDeductionType = false)
              "
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeleteDeductionType">
      <section slot="header">Delete Deduction Type?</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="deleteDeductionType()">
          <md-dialog-actions>
            <md-button class="md-dense md-danger" type="submit">Delete</md-button>
            <md-button
              class="md-dense md-primary"
              @click="isDeleteDeductionType = false"
              >No, I changed my mind</md-button
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
      <md-button class="md-warning md-dense" @click="fireSnackbar = false">
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

export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    name: "RequestType",
    props: {
        dataBackgroundColor: {
            type: String,
        },
    },
    data: () => ({
        isAuthenticated: true,
        perPage: 10,
        fireSnackbar: false,
        messageSnackbar: null,

        requesTypes: null,
        links: null,
        employeeLinks: null,
        filteredEmployees: [],
        deductions: [
            {
                amount: null,
                amount_type: "FIXED",
                code: "VLWOP",
                created_at: null,
                deduction_frequency: "ONE TIME",
                deduction_type: "MANDATORY DEDUCTION",
                deduction_type_id: 1,
                description: "Leave W/O Pay",
                employee_deductions: [],
                fixed_amount: null,
                formula_amount: null,
                id: 1,
                is_slashes: 0,
                journal_entry: null,
                priority_level: 0,
                updated_at: null,
                use_code: 0,
            },
            {
               amount: null,
                amount_type: "FIXED",
                code: "ABSENTS",
                created_at: null,
                deduction_frequency: "ONE TIME",
                deduction_type: "MANDATORY DEDUCTION",
                deduction_type_id: 1,
                description: "Unpaid Absence",
                employee_deductions: [],
                fixed_amount: null,
                formula_amount: null,
                id: 2,
                is_slashes: 0,
                journal_entry: null,
                priority_level: 0,
                updated_at: null,
                use_code: 0,
            },
            {
                amount: [{id: "(", code: "("}, {id: "PERA", code: "PERA"}, {id: "/", code: "/"}, {id: "22", code: "22"}],
                amount_type: "FORMULA",
                code: "LWOP (PERA)",
                created_at: null,
                deduction_frequency: "ONE TIME",
                deduction_type: "MANDATORY DEDUCTION",
                deduction_type_id: 1,
                description: "PERA Deducted due to LWOP",
                employee_deductions: [
                    {
                        amount: "90.91",
                        amount_type: "FIXED",
                        deduction_frequency: "ONE TIME",
                        deduction_id: 4,
                        employee_id: [193, 273, 296, 298, 459, 464, 485],
                        fixed_amount: "90.91",
                        formula_amount: null,
                        payroll_type: "REGULAR",
                        ref_date: "2021-06-01",
                    }
                ],
                fixed_amount: null,
                formula_amount: [
                        {id: "(", code: "("}, 
                        {id: "PERA", code: "PERA"}, 
                        {id: "/", code: "/"}, 
                        {id: "22", code: "22"},
                        {id: ")", code: ")"},
                        {id: "*", code: "*"},
                        {id: -2, code: "LWOP"},
                    ],
                id: 4,
                is_slashes: 0,
                journal_entry: null,
                priority_level: 0,
                updated_at: null,
                use_code: 1,
            }
        ],

        deductionTypes: [
            {
                id: 1,
                code: "MANDATORY DEDUCTION",
                description: "MANDATORY PERSONAL SHARE",
                is_mandatory: 1,
                created_at: "1970-01-01 08:00:00",
                updated_at: "2020-09-05 16:43:18",
            },
            {
                id: 2,
                code: "LOAN",
                description: "LOANS",
                is_mandatory: 0,
                created_at: "1970-01-01 08:00:00",
                updated_at: "1970-01-01 08:00:00",
            },
            {
                id: 3,
                code: "GSIS LOANS",
                description: "GSIS LOANS",
                is_mandatory: 0,
                created_at: "1970-01-01 08:00:00",
                updated_at: "1970-01-01 08:00:00",
            },
            {
                id: 4,
                code: "ADJMT",
                description: "ADJUSTMENTS",
                is_mandatory: 1,
                created_at: "2020-08-17 13:51:43",
                updated_at: "2020-08-17 13:51:43",
            },
            {
                id: 5,
                code: "OTHER INSURANCE",
                description: "LIFE, HEALTH OR MEMORIAL INSURANCE",
                is_mandatory: 1,
                created_at: "2020-09-05 15:44:38",
                updated_at: "2020-09-05 15:44:38",
            },
            {
                id: 6,
                code: "MANDATORY GOVT SHARE",
                description: "MANDATORY GOV'T SHARE",
                is_mandatory: 1,
                created_at: "2020-09-05 16:45:43",
                updated_at: "2020-09-05 16:45:43",
            },
            {
                id: 7,
                code: "GSIS OTHER DEDS.",
                description: "GSIS OTHER DEDUCTIONS",
                is_mandatory: 0,
                created_at: "2021-02-10 17:47:39",
                updated_at: "2021-02-10 17:47:39",
            },
            {
                id: 8,
                code: "DOTC EMPC GROUP",
                description: "LOANS & HMO",
                is_mandatory: 0,
                created_at: "2021-05-28 11:09:22",
                updated_at: "2021-05-28 11:09:22",
            },
            {
                id: 9,
                code: "PAGIBIG GROUP",
                description: "PAGIBIG GROUP",
                is_mandatory: 0,
                created_at: "2021-08-05 11:03:07",
                updated_at: "2021-08-05 11:03:07",
            },
        ],
        deductionType: {},
        deductionParentData: {},
        deductionChildData: {},

        updatingRequestType: false,
        btnMessage: "Update",
        expandedTableId: null,

        isAddDeductionParent: false,
        isEditDeductionParent: false,
        isDeleteDeductionParent: false,
        isAddDeductionChild: false,
        isEditDeductionChild: false,
        isAssignEmployee: false,
        isDeductionTypes: false,
        isAddDeductionType: false,
        isEditDeductionType: false,
        isDeleteDeductionType: false,

        selectAll: false,
        searchEmployeeValue: null,
        
        deductionParentId: null,
        deductionChildId: null,
    }),
    methods: {
        toggleTableRow(id) {
            if (this.expandedTableId == id) {
                this.expandedTableId = null;
            } else {
                this.expandedTableId = id;
            }
        },
        selectAllEmployees() {},
        getFormulaAmount(amount) {
            if (amount) {
                let text = ''
                amount.map(val => text = text + ' ' + val.code)
                return text
            } else {
                return ''
            }
            
        }, 
        addDeductionParent() {
            this.deductionParentData.id = this.deductions.length + 1
            this.deductions.push(JSON.parse(JSON.stringify(this.deductionParentData)))
            this.isAddDeductionParent = false
        },
        editDeductionParent() {
            const index = this.deductions.findIndex(val => val.id == this.deductionParentData.id)
            this.deductions[index] = JSON.parse(JSON.stringify(this.deductionParentData))
            this.isEditDeductionParent = false
        },
        deleteDeductionParent() {
            const index = this.deductions.findIndex(val => val.id == this.deductionParentData.id)
            this.deductions.splice(index, 1)
            this.isDeleteDeductionParent = false
        },
        addDeductionChild() {
            const index = this.deductions.findIndex(val => val.id == this.deductionParentId)
            console.log(index)
            if (!this.deductions[index].employee_deductions) {
              this.deductions[index].employee_deductions = []
            }
            console.log(this.deductions[index])
            this.deductionChildData.id = this.deductions[this.deductionParentId].employee_deductions.length + 1
            this.deductions[index].employee_deductions.push(JSON.parse(JSON.stringify(this.deductionChildData)))
            this.isAddDeductionChild = false
        },
        editDeductionChild() {
            const parentIndex = this.deductions.findIndex(val => val.id == this.deductionParentId)
            const childIndex = this.deductions[parentIndex].employee_deductions.findIndex(val => val.id == this.deductionChildId)
            this.deductions[parentIndex].employee_deductions[childIndex] = JSON.parse(JSON.stringify(this.deductionChildData))
            this.isEditDeductionChild = false
        },
        addDeductionType() {
            this.deductionType.id = this.deductionTypes.length + 1
            this.deductionTypes.push(JSON.parse(JSON.stringify(this.deductionType)))
            this.isAddDeductionType = false
        },
        editDeductionType() {
            const index = this.deductionTypes.findIndex(val => val.id == this.deductionType.id)
            this.deductionTypes[index] = JSON.parse(JSON.stringify(this.deductionType))
            this.isEditDeductionType = false
        },
        deleteDeductionType() {
            const index = this.deductionTypes.findIndex(val => val.id == this.deductionType.id)
            this.deductionTypes.splice(index, 1)
            this.isDeleteDeductionType = false
        }
    },

    //Created
    async created() {
        // await this.getRequestType();
    },
    watch: {
        isAddDeductionType(bool) {
            this.isDeductionTypes = !bool
        },
        isEditDeductionType(bool) {
            this.isDeductionTypes = !bool
        },
        isDeleteDeductionType(bool) {
            this.isDeductionTypes = !bool
        }
    }
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css?family=Material+Icons");

.button-paginate {
  border: 0px !important;
  margin-left: 2px !important;
  margin-right: 2px !important;
  padding: 5px !important;
  max-width: 80px !important;
  min-width: 80px !important;
  font-size: 12px !important;
}
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

.zui-table {
  border: solid 1px #ddeeee;
  border-collapse: collapse;
  border-spacing: 0;
  font: normal 13px;
  width: 100% !important;
}
.zui-table thead th {
  border: solid 1px #ddeeee;
  color: rgb(0, 0, 0) !important;
  padding: 10px;
  text-align: left;
}
.zui-table tfoot th {
  border: solid 1px white;
  color: white !important;
  padding: 10px;
  text-align: left;
}
.zui-table tbody td {
  border: solid 1px #ddeeee;
  color: #333;
  padding: 10px;
}
.dCardBody {
  /* min-height: 500px !important; */
  min-width: 640px !important;
}
</style>
