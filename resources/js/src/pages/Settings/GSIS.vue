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
        <h4 class="title">GSIS</h4>
      </md-card-header>
      <md-card-content>
        <div class="md-layout" style="margin-top: 20px">
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Select Date</label>
              <md-select v-model="date">
                <md-option value="2020-01-01">2020-01-01</md-option>
              </md-select>
            </md-field>
          </div>
          <div
            class="md-layout-item md-small-size-100 md-size-25"
            style="margin-top: 20px"
          >
            <md-button class="md-raised md-dense md-primary" disabled>
              Add Date
            </md-button>
          </div>
        </div>
        <div class="md-layout" style="margin-top: 20px">
          <div class="md-layout-item md-small-size-100 md-size-100">
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
                  <th width="30%">Employee Contribution</th>
                  <th width="30%">Employer Contribution</th>
                  <th width="30%">Employer Compensation Commision</th>
                  <th width="10%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(g, i) in displayedGSIS" :key="i">
                  <td>{{ g.employee_contribution }}</td>
                  <td>{{ g.employer_contribution }}</td>
                  <td>{{ g.employer_compensation_commission }}</td>
                  <td>
                    <md-button
                      class="md-raised md-dense md-warning"
                      @click="
                        gsisData = JSON.parse(JSON.stringify(g));
                        isEditGSIS = true;
                      "
                      style="color: black !important"
                      >Edit</md-button
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

    <DialogCard v-if="isEditGSIS">
      <section slot="header">Edit GSIS</section>
      <section slot="body" class="dCardBody">
        <form
          method="post"
          @submit.prevent="editGSIS()"
        >
          <md-field>
            <label>Employee Contribution</label>
            <md-input v-model="gsisData.employee_contribution"> ></md-input>
          </md-field>
          <md-field>
            <label>Employer Contribution</label>
            <md-input v-model="gsisData.employer_contribution"> ></md-input>
          </md-field>
          <md-field>
            <label>Employer Compensation Commission</label>
            <md-input v-model="gsisData.employer_compensation_commission"> ></md-input>
          </md-field>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">Update</md-button>
            <md-button
              class="md-dense md-danger"
              @click="isEditGSIS = false"
              >Close</md-button
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
            <md-button class="md-dense md-danger" type="submit"
              >Delete</md-button
            >
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

        gsis: [
            {
                effective_date: "2020-01-01",
                array: [
                    {
                        id: 1,
                        employee_contribution: "9.00",
                        employer_contribution: "12.00",
                        employer_compensation_commission: "1.00",
                    },
                ],
            },
        ],
        displayedGSIS: [],
        gsisData: {},
        date: "2020-01-01",
        period: "daily",

        isEditGSIS: false,
        isDeleteTable: false,
    }),
    methods: {
        getGSISToDisplay() {
            const index = this.gsis.findIndex(
                (val) => val.effective_date == this.date
            );
            this.displayedGSIS = this.gsis[index].array;
            console.log(this.displayedGSIS)
        },
        editGSIS() {
            const index = this.gsis.findIndex(
                (val) => val.effective_date == this.date
            );
            const gsisIndex = this.gsis[index].array.findIndex(
                (val) => val.id == this.gsisData.id
            );
            this.gsis[index].array[gsisIndex] = this.gsisData;
            this.isEditGSIS = false;
        },
        deleteTable() {
            const index = this.gsis.findIndex(
                (val) => val.effective_date == this.date
            );
            this.gsis.splice(index, 1)
            this.displayedGSIS = []
            this.isDeleteTable = false;
        },
    },

    //Created
    async created() {
        this.getGSISToDisplay()
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
