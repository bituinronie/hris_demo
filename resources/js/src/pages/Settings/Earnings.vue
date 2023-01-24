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
        <h4 class="title">Earnings</h4>
      </md-card-header>
      <md-card-content style="overflow: scroll">
        <div class="md-layout">
          <div
            class="md-layout-item md-small-size-100 md-size-100"
            style="margin-top: 20px"
          >
            <md-button
              class="md-raised md-dense md-primary"
              @click="
                earningParentData = {};
                isAddEarningParent = true;
              "
            >
              Add Earning
            </md-button>
            <md-button
              class="md-raised md-dense md-primary"
              @click="isEarningTypes = true"
            >
              Earning Types
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
                  <th>Earning Type</th>
                  <th>Earning Frequency</th>
                  <th>Earning Classification</th>
                  <th>Amount Type</th>
                  <th>Amount</th>
                  <th>Amount Taxable</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(e, i) in earnings">
                  <tr :key="i + 'a'">
                    <td>
                      <md-button
                        v-if="e.employee_earnings && e.employee_earnings.length > 0"
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
                    <td>{{ e.earning_type }}</td>
                    <td>{{ e.earning_frequency }}</td>
                    <td>{{ e.earning_classification }}</td>
                    <td>{{ e.amount_type }}</td>
                    <td>{{ e.amount_type == 'FIXED' ? e.fixed_amount : e.formula_amount }}</td>
                    <td>{{ e.amount_taxable }}</td>
                    <td>
                      <md-button
                        class="md-raised md-dense md-primary"
                        @click="
                          earningChildData = {};
                          earningParentId = e.id
                          isAddEarningChild = true;
                        "
                        >Add</md-button
                      >
                      <md-button
                        class="md-raised md-dense md-warning"
                        @click="
                          isEditEarningParent = true;
                          earningParentData = JSON.parse(JSON.stringify(e));
                        "
                        style="color: black !important"
                        >Edit</md-button
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
                              <th width="20%">Reference Date</th>
                              <th width="20%">Payroll Type</th>
                              <th width="15%">Amount</th>
                              <th width="15%">Amount Taxable</th>
                              <th width="30%">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(item, i) in e.employee_earnings"
                              :key="i"
                            >
                              <td>{{ item.ref_date }}</td>
                              <td>{{ item.payroll_type }}</td>
                              <td>{{ item.fixed_amount }}</td>
                              <td>{{ item.amount_taxable }}</td>
                              <td>
                                <md-button
                                  class="md-raised md-dense md-primary"
                                  @click="isAssignEmployee = true"
                                  >Assign</md-button
                                >
                                <md-button
                                  class="md-raised md-dense md-warning"
                                  @click="
                                    isEditEarningChild = true;
                                    earningParentId = e.id
                                    earningChildData = item;
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

    <DialogCard v-if="isAddEarningChild || isEditEarningChild">
      <section slot="header">
        {{ isAddEarningChild ? "Add" : "Edit" }} Earning
      </section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="isAddEarningChild ? addEarningChild() : editEarningChild()">
          <md-datepicker
            md-placeholder="Reference Date"
            :md-immediately="true"
            :md-model-type="String"
            v-model="earningChildData.ref_date"
            ><label>From:</label></md-datepicker
          >
          <md-field>
            <label>Payroll Type</label>
            <md-select v-model="earningChildData.payroll_type">
              <md-option value="REGULAR">REGULAR</md-option>
              <md-option value="OTHER BENEFITS">OTHER BENEFITS</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label>Fixed Amount</label>
            <md-input v-model="earningChildData.fixed_amount"> ></md-input>
          </md-field>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{ isAddEarningChild ? "Add" : "Update" }}</md-button>

            <md-button
              class="md-dense md-danger"
              @click="
                isAddEarningChild
                  ? (isAddEarningChild = false)
                  : (isEditEarningChild = false)
              "
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isAddEarningParent || isEditEarningParent">
      <section slot="header">
        {{ isAddEarningParent ? "Add" : "Edit" }} Earning
      </section>
      <section slot="body" class="dCardBody">
        <form  method="post" @submit.prevent="isAddEarningParent ? addEarningParent() : editEarningParent()">
          <md-field>
            <label>Code</label>
            <md-input v-model="earningParentData.code"></md-input>
          </md-field>
          <md-checkbox>Use code for display</md-checkbox>
          <md-field>
            <label>Description</label>
            <md-input v-model="earningParentData.description"></md-input>
          </md-field>
          <md-field>
            <label>Journal Entry</label>
            <md-input v-model="earningParentData.journal_entry"></md-input>
          </md-field>
          <md-field>
            <label>Earning Type</label>
            <md-select v-model="earningParentData.earning_type">
              <md-option
                v-for="(e, i) in earningTypes"
                :key="i"
                :value="e.code"
                >{{ e.description }}</md-option
              >
            </md-select>
          </md-field>
          <md-field>
            <label>Earning Frequency</label>
            <md-select v-model="earningParentData.earning_frequency">
              <md-option value="ONE TIME">ONE TIME</md-option>
              <md-option value="PERPETUAL">PERPETUAL</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label>Payroll Type</label>
            <md-select v-model="earningParentData.payroll_type">
              <md-option value="REGULAR">REGULAR</md-option>
              <md-option value="OTHER BENEFITS">OTHER BENEFITS</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label>Earning Classification</label>
            <md-select v-model="earningParentData.earning_classification">
              <md-option value="TAXABLE">TAXABLE</md-option>
              <md-option value="NON-TAXABLE">NON-TAXABLE</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label>Amount Type</label>
            <md-select v-model="earningParentData.amount_type">
              <md-option value="FIXED">FIXED</md-option>
              <md-option value="FORMULA">FORMULA BASED</md-option>
            </md-select>
          </md-field>
          <template v-if="earningParentData.amount_type == 'FIXED'">
              <md-field>
                <label>Fixed Amount</label>
                <md-input v-model="earningParentData.fixed_amount"> ></md-input>
            </md-field>
          </template>
        <template v-if="earningParentData.amount_type == 'FORMULA'">
              <md-field>
                <label>Formula Amount</label>
                <md-input :value="getFormulaAmount(earningParentData.formula_amount)"></md-input>
            </md-field>
          </template>
          <md-dialog-actions>
            <md-button 
              class="md-dense md-primary"
              type="submit"
            >
              {{ isAddEarningParent ? "Add" : "Update" }}
            </md-button>

            <md-button
              class="md-dense md-danger"
              @click="
                isAddEarningParent
                  ? (isAddEarningParent = false)
                  : (isEditEarningParent = false)
              "
              >Close</md-button
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

    <DialogCard v-if="isEarningTypes">
      <section slot="header">Earning Types</section>
      <section slot="body" class="dCardBody" style="width: 800px">
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
                        isAddEarningType = true;
                        earningType = {};
                      "
                    >
                      Add Earning Type
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
                        <th width="30%">Code</th>
                        <th width="30%">Description</th>
                        <th width="40%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, i) in earningTypes" :key="i">
                        <td>{{ item.code }}</td>
                        <td>{{ item.description }}</td>
                        <td>
                          <md-button
                            class="md-raised md-dense md-primary"
                            @click="
                              earningType = item;
                              isEditEarningType = true;
                            "
                            >Edit</md-button
                          >
                          <md-button
                            class="md-raised md-dense md-danger"
                            @click="
                              earningType = item;
                              isDeleteEarningType = true;
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
            <md-button
              class="md-dense md-raised md-danger"
              @click="isEarningTypes = false"
            >
              ✕ Cancel</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isAddEarningType || isEditEarningType">
      <section slot="header">
        {{ isAddEarningType ? "Add" : "Edit" }} Earning
      </section>
      <section slot="body" class="dCardBody">
        <form  method="post" @submit.prevent="isAddEarningType ? addEarningType() : editEarningType()">
          <md-field>
            <label>Code</label>
            <md-input v-model="earningType.code"> ></md-input>
          </md-field>
          <md-field>
            <label>Description</label>
            <md-input v-model="earningType.description"> ></md-input>
          </md-field>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{
              isAddEarningType ? "Add" : "Update"
            }}</md-button>
            <md-button
              class="md-dense md-danger"
              @click="
                isAddEarningType
                  ? (isAddEarningType = false)
                  : (isEditEarningType = false)
              "
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeleteEarningType">
      <section slot="header">Delete Earning?</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="deleteEarningType()">
          <md-dialog-actions>
            <md-button class="md-dense md-danger" type="submit">Delete</md-button>
            <md-button
              class="md-dense md-primary"
              @click="isDeleteEarningType = false"
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
        earnings: [
            {
                amount_taxable: "0.00",
                amount_type: "FIXED",
                code: "DIFFERENTIAL",
                created_at: null,
                description: "Salary Differential",
                earning_classification: "TAXABLE",
                earning_frequency: "ONE TIME",
                earning_type: "NON-ALLOWANCE",
                earning_type_id: 1,
                employee_earnings: [
                    {
                        amount: "0.00",
                        amount_taxable: "0.00",
                        amount_type: "FIXED",
                        earning_frequency: "ONE TIME",
                        earning_id: 1,
                        employee_id: [606, 645, 1250],
                        fixed_amount: "0.00",
                        fixed_amount_taxable: "0.00",
                        formula_amount: null,
                        formula_amount_taxable: null,
                        payroll_type: "REGULAR",
                        ref_date: "2020-10-01",
                    },
                ],
                fixed_amount: null,
                fixed_amount_taxable: "0.00",
                formula_amount: null,
                formula_amount_taxable: null,
                has_special_tax: false,
                id: 1,
                journal_entry: null,
                payroll_type: "REGULAR",
                updated_at: null,
                use_code: 0,
            },
            {
                amount: null,
                amount_taxable: "0.00",
                amount_type: "FIXED",
                code: "Mid-Year Bonus",
                created_at: null,
                description: "13th Month Pay",
                earning_classification: "TAXABLE",
                earning_frequency: "ONE TIME",
                earning_type: "ALLOWANCE",
                earning_type_id: 2,
                employee_earnings: [
                    {
                        amount: "12034.00",
                        amount_taxable: "12034.00",
                        amount_type: "FIXED",
                        earning_frequency: "ONE TIME",
                        earning_id: 3,
                        employee_id: [
                            157,
                            230,
                            409,
                            438,
                            459,
                            464,
                            477,
                            491,
                            497,
                            554,
                            717,
                        ],
                        fixed_amount: "12034.00",
                        fixed_amount_taxable: "12034.00",
                        formula_amount: null,
                        formula_amount_taxable: null,
                        payroll_type: "SPECIAL",
                        ref_date: "2021-05-01",
                    },
                    {
                        amount: "12651.00",
                        amount_taxable: "12651.00",
                        amount_type: "FIXED",
                        earning_frequency: "ONE TIME",
                        earning_id: 3,
                        employee_id: [96],
                        fixed_amount: "12651.00",
                        fixed_amount_taxable: "12651.00",
                        formula_amount: null,
                        formula_amount_taxable: null,
                        payroll_type: "SPECIAL",
                        ref_date: "2021-05-01",
                    },
                ],
                fixed_amount: null,
                fixed_amount_taxable: "0.00",
                formula_amount: null,
                formula_amount_taxable: null,
                has_special_tax: false,
                id: 2,
                journal_entry: null,
                payroll_type: "SPECIAL",
                updated_at: null,
                use_code: 0,
            },
        ],

        earningTypes: [
            {
                id: 1,
                code: "NON-ALLOWANCE",
                description: "NON ALLOWANCE",
                created_at: "1970-01-01 08:00:00",
                updated_at: "1970-01-01 08:00:00",
            },
            {
                id: 2,
                code: "ALLOWANCE",
                description: "ALLOWANCE(90,000 MARGIN)",
                created_at: "1970-01-01 08:00:00",
                updated_at: "1970-01-01 08:00:00",
            },
        ],
        earningType: {},
        earningParentData: {},
        earningChildData: {},

        updatingRequestType: false,
        btnMessage: "Update",
        expandedTableId: null,

        isAddEarningParent: false,
        isEditEarningParent: false,
        isAddEarningChild: false,
        isEditEarningChild: false,
        isAssignEmployee: false,
        isEarningTypes: false,
        isAddEarningType: false,
        isEditEarningType: false,
        isDeleteEarningType: false,

        selectAll: false,
        searchEmployeeValue: null,

        earningParentId: null,
        earningChildId: null,
    }),
    methods: {
        toggleTableRow(id) {
            if (this.expandedTableId == id) {
                this.expandedTableId = null;
            } else {
                this.expandedTableId = id;
            }
        },
        getFormulaAmount(amount) {
            if (amount) {
                let text = ''
                amount.map(val => text = text + ' ' + val.code)
                return text
            } else {
                return ''
            }
            
        }, 
        selectAllEmployees() {},
        addEarningParent() {
            this.earningParentData.id = this.earnings.length + 1
            this.earnings.push(JSON.parse(JSON.stringify(this.earningParentData)))
            this.isAddEarningParent = false
        },
        editEarningParent() {
            const index = this.earnings.findIndex(val => val.id == this.earningParentData.id)
            this.earnings[index] = JSON.parse(JSON.stringify(this.earningParentData))
            this.isEditEarningParent = false
        },
        addEarningChild() {
            const index = this.earnings.findIndex(val => val.id == this.earningParentId)
            if (!this.earnings[index].employee_earnings) {
              this.earnings[index].employee_earnings = []
            }
            this.earningChildData.id = this.earnings[this.earningParentId].employee_earnings.length + 1
            this.earnings[index].employee_earnings.push(JSON.parse(JSON.stringify(this.earningChildData)))
            this.isAddEarningChild = false
        },
        editEarningChild() {
            const parentIndex = this.earnings.findIndex(val => val.id == this.earningParentId)
            const childIndex = this.earnings[parentIndex].employee_earnings.findIndex(val => val.id == this.earningChildId)
            this.earnings[parentIndex].employee_earnings[childIndex] = JSON.parse(JSON.stringify(this.earningChildData))
            this.isEditEarningChild = false
        },
        addEarningType() {
            this.earningType.id = this.earningTypes.length + 1
            this.earningTypes.push(JSON.parse(JSON.stringify(this.earningType)))
            this.isAddEarningType = false
        },
        editEarningType() {
            const index = this.earningTypes.findIndex(val => val.id == this.earningType.id)
            this.earningTypes[index] = JSON.parse(JSON.stringify(this.earningType))
            this.isEditEarningType = false
        },
        deleteEarningType() {
            const index = this.earningTypes.findIndex(val => val.id == this.earningType.id)
            this.earningTypes.splice(index, 1)
            this.isDeleteEarningType = false
        }

    },

    //Created
    async created() {
        // await this.getRequestType();
    },
     watch: {
        isAddEarningType(bool) {
            this.isEarningTypes = !bool
        },
        isEditEarningType(bool) {
            this.isEarningTypes = !bool
        },
        isDeleteEarningType(bool) {
            this.isEarningTypes = !bool
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
