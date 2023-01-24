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
        <h4 class="title">Taxes</h4>
      </md-card-header>
      <md-card-content>
        <div class="md-layout" style="margin-top: 20px">
            <div class="md-layout-item md-small-size-100 md-size-25">
                <md-field>
                    <label>Select Date</label>
                    <md-select v-model="date">
                        <md-option value="2018-01-01">2018-01-01</md-option>
                    </md-select>
                </md-field>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-25" style="margin-top: 20px">
                <md-button
                    class="md-raised md-dense md-primary"
                    disabled
                    >
                    Add Date
                </md-button>
            </div>
        </div>
        <div class="md-layout" style="margin-top: 20px">
            <div class="md-layout-item md-small-size-100 md-size-25">
                <md-field>
                <label>Select Period</label>
                <md-select v-model="period" @md-selected="getTaxesToDisplay()">
                    <md-option value="daily">Daily</md-option>
                    <md-option value="weekly">Weekly</md-option>
                    <md-option value="semi-monthly">Semi-Monthly</md-option>
                    <md-option value="monthly">Monthly</md-option>
                    <md-option value="annual">Annually</md-option>
                </md-select>
            </md-field>
            </div>
          <div class="md-layout-item md-small-size-100 md-size-75" style="margin-top: 10px">
            <md-button
              class="md-raised md-dense md-primary"
              @click="
                taxData = {};
                isAddTax = true;
              "
            >
              Add Tax
            </md-button>
            <md-button
              class="md-raised md-dense md-danger"
              @click="isDeleteTable = true"
            >
              Delete Table
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
                  <th width="20%">Minimum Salary</th>
                  <th width="20%">Maximum Salary</th>
                  <th width="10%">Tax Rate</th>
                  <th width="20%">Basic Amount</th>
                  <th width="30%">Actions</th>
                </tr>
              </thead>
              <tbody>
                  <tr  v-for="(tax, i) in displayedTaxes" :key="i">
                    <td>{{ tax.minimum_salary }}</td>
                    <td>{{ tax.maximum_salary }}</td>
                    <td>{{ tax.percentage_rate }}</td>
                    <td>{{ tax.basic_amount }}</td>
                    <td>
                      <md-button
                        class="md-raised md-dense md-warning"
                        @click="
                          taxData = JSON.parse(JSON.stringify(tax));
                          isEditTax = true;
                        "
                        style="color: black !important"
                        >Edit</md-button
                      >
                      <md-button
                        class="md-raised md-dense md-danger"
                        @click="
                          taxData = JSON.parse(JSON.stringify(tax));
                          isDeleteTax = true;
                        "
                        >Delete</md-button
                      >
                    </td>
                  </tr>
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

    <DialogCard v-if="isAddTax || isEditTax">
      <section slot="header">
        {{ isAddTax ? "Add" : "Edit" }} Tax
      </section>
      <section slot="body" class="dCardBody">
        <form  method="post" @submit.prevent="isAddTax ? addTax() : editTax()">
          <md-field>
            <label>Minimum Salary</label>
            <md-input v-model="taxData.minimum_salary"> ></md-input>
          </md-field>
          <md-field>
            <label>Maximum Salary</label>
            <md-input v-model="taxData.maximum_salary"> ></md-input>
          </md-field>
          <md-field>
            <label>Tax Rate(%)</label>
            <md-input v-model="taxData.percentage_rate"> ></md-input>
          </md-field>
          <md-field>
            <label>Basic Amount</label>
            <md-input v-model="taxData.basic_amount"> ></md-input>
          </md-field>
          Tax Type: {{ period.toUpperCase() }}
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{
              isAddTax ? "Add" : "Update"
            }}</md-button>
            <md-button
              class="md-dense md-danger"
              @click="isAddTax ? (isAddTax = false) : (isEditTax = false)"
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeleteTax">
      <section slot="header">Delete Tax?</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="deleteTax()">
          <md-dialog-actions>
            <md-button class="md-dense md-danger" type="submit">Delete</md-button>
            <md-button
              class="md-dense md-primary"
              @click="isDeleteTax = false"
              >No, I changed my mind</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeleteTable">
      <section slot="header">Delete Table?</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="deleteTable()">
          <md-dialog-actions>
            <md-button class="md-dense md-danger" type="submit">Delete</md-button>
            <md-button
              class="md-dense md-primary"
              @click="isDeleteTable = false"
              >No, I changed my mind</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>
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
        links: [],

        taxes: [
            {
                effective_date: "2018-01-01",
                array: {
                    daily: [
                        {
                            id: 1,
                            minimum_salary: null,
                            maximum_salary: "684.99",
                            basic_amount: "0.00",
                            percentage_rate: "0.00",
                        },
                        {
                            id: 2,
                            minimum_salary: "685.00",
                            maximum_salary: "1095.99",
                            basic_amount: "0.00",
                            percentage_rate: "20.00",
                        },
                        {
                            id: 3,
                            minimum_salary: "1096.00",
                            maximum_salary: "2191.99",
                            basic_amount: "82.19",
                            percentage_rate: "25.00",
                        },
                        {
                            id: 4,
                            minimum_salary: "2192.00",
                            maximum_salary: "5478.99",
                            basic_amount: "356.16",
                            percentage_rate: "30.00",
                        },
                        {
                            id: 5,
                            minimum_salary: "5479.00",
                            maximum_salary: "21917.99",
                            basic_amount: "1342.47",
                            percentage_rate: "32.00",
                        },
                        {
                            id: 6,
                            minimum_salary: "21918.00",
                            maximum_salary: null,
                            basic_amount: "6602.74",
                            percentage_rate: "35.00",
                        },
                    ],
                    weekly: [
                        {
                            id: 7,
                            minimum_salary: null,
                            maximum_salary: "4807.99",
                            basic_amount: "0.00",
                            percentage_rate: "0.00",
                        },
                        {
                            id: 8,
                            minimum_salary: "4808.00",
                            maximum_salary: "7691.99",
                            basic_amount: "0.00",
                            percentage_rate: "20.00",
                        },
                        {
                            id: 9,
                            minimum_salary: "7692.00",
                            maximum_salary: "15384.99",
                            basic_amount: "576.92",
                            percentage_rate: "25.00",
                        },
                        {
                            id: 10,
                            minimum_salary: "15385.00",
                            maximum_salary: "38461.99",
                            basic_amount: "2500.16",
                            percentage_rate: "30.00",
                        },
                        {
                            id: 11,
                            minimum_salary: "38462.00",
                            maximum_salary: "153845.99",
                            basic_amount: "9423.08",
                            percentage_rate: "32.00",
                        },
                        {
                            id: 12,
                            minimum_salary: "153846.00",
                            maximum_salary: null,
                            basic_amount: "46346.15",
                            percentage_rate: "35.00",
                        },
                    ],
                    "semi-monthly": [
                        {
                            id: 13,
                            minimum_salary: null,
                            maximum_salary: "10416.99",
                            basic_amount: "0.00",
                            percentage_rate: "0.00",
                        },
                        {
                            id: 14,
                            minimum_salary: "10417.00",
                            maximum_salary: "16666.99",
                            basic_amount: "0.00",
                            percentage_rate: "20.00",
                        },
                        {
                            id: 15,
                            minimum_salary: "16667.00",
                            maximum_salary: "33332.99",
                            basic_amount: "1250.00",
                            percentage_rate: "25.00",
                        },
                        {
                            id: 16,
                            minimum_salary: "33333.00",
                            maximum_salary: "83332.99",
                            basic_amount: "5416.67",
                            percentage_rate: "30.00",
                        },
                        {
                            id: 17,
                            minimum_salary: "83333.00",
                            maximum_salary: "333332.99",
                            basic_amount: "20416.67",
                            percentage_rate: "32.00",
                        },
                        {
                            id: 18,
                            minimum_salary: "333333.00",
                            maximum_salary: null,
                            basic_amount: "100416.67",
                            percentage_rate: "35.00",
                        },
                    ],
                    monthly: [
                        {
                            id: 19,
                            minimum_salary: null,
                            maximum_salary: "20832.99",
                            basic_amount: "0.00",
                            percentage_rate: "0.00",
                        },
                        {
                            id: 20,
                            minimum_salary: "20833.00",
                            maximum_salary: "33332.99",
                            basic_amount: "0.00",
                            percentage_rate: "20.00",
                        },
                        {
                            id: 21,
                            minimum_salary: "33333.00",
                            maximum_salary: "66666.99",
                            basic_amount: "2500.00",
                            percentage_rate: "25.00",
                        },
                        {
                            id: 22,
                            minimum_salary: "66667.00",
                            maximum_salary: "166666.99",
                            basic_amount: "10833.33",
                            percentage_rate: "30.00",
                        },
                        {
                            id: 23,
                            minimum_salary: "166667.00",
                            maximum_salary: "666666.99",
                            basic_amount: "40833.33",
                            percentage_rate: "32.00",
                        },
                        {
                            id: 24,
                            minimum_salary: "666667.00",
                            maximum_salary: null,
                            basic_amount: "200833.33",
                            percentage_rate: "35.00",
                        },
                    ],
                    annual: [
                        {
                            id: 25,
                            minimum_salary: null,
                            maximum_salary: "249999.99",
                            basic_amount: "0.00",
                            percentage_rate: "0.00",
                        },
                        {
                            id: 26,
                            minimum_salary: "250000.00",
                            maximum_salary: "399999.99",
                            basic_amount: "0.00",
                            percentage_rate: "20.00",
                        },
                        {
                            id: 27,
                            minimum_salary: "400000.00",
                            maximum_salary: "799999.99",
                            basic_amount: "30000.00",
                            percentage_rate: "25.00",
                        },
                        {
                            id: 28,
                            minimum_salary: "800000.00",
                            maximum_salary: "1999999.99",
                            basic_amount: "130000.00",
                            percentage_rate: "30.00",
                        },
                        {
                            id: 29,
                            minimum_salary: "2000000.00",
                            maximum_salary: "7999999.99",
                            basic_amount: "490000.00",
                            percentage_rate: "32.00",
                        },
                        {
                            id: 30,
                            minimum_salary: "8000000.00",
                            maximum_salary: null,
                            basic_amount: "2410000.00",
                            percentage_rate: "35.00",
                        },
                    ],
                },
            },
        ],
        displayedTaxes: [],
        taxData: {},
        date: "2018-01-01",
        period: "daily",

        isAddTax: false,
        isEditTax: false,
        isDeleteTax: false,
        isDeleteTable: false,
    }),
    methods: {
        getTaxesToDisplay() {
            const index = this.taxes.findIndex(val => val.effective_date == this.date) 
            this.displayedTaxes = this.taxes[index].array[this.period]
        },
        addTax() {
            const index = this.taxes.findIndex(val => val.effective_date == this.date) 
            this.taxData.id = this.taxes[index].array[this.period].length + 1
            this.taxes[index].array[this.period].push(this.taxData)
            this.isAddTax = false
        },
        editTax() {
            const index = this.taxes.findIndex(val => val.effective_date == this.date) 
            const taxIndex = this.taxes[index].array[this.period].findIndex(val => val.id == this.taxData.id)
            this.taxes[index].array[this.period][taxIndex] = this.taxData
            this.isEditTax = false
        },
        deleteTax() {
            const index = this.taxes.findIndex(val => val.effective_date == this.date) 
            const taxIndex = this.taxes[index].array[this.period].findIndex(val => val.id == this.taxData.id)
            this.taxes[index].array[this.period].splice(taxIndex, 1)
            this.isDeleteTax = false
        },
        deleteTable() {
            const index = this.taxes.findIndex(val => val.effective_date == this.date) 
            delete this.taxes[index].array[this.period]
            this.displayedTaxes = []
            this.isDeleteTable = false
        }
    },

    //Created
    async created() {
        this.getTaxesToDisplay()
    },
    watch: {},
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
