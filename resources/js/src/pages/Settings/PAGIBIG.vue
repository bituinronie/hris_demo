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
        <h4 class="title">PAG-IBIG</h4>
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
                  <th width="35%">Employee Share</th>
                  <th width="35%">Employer Share</th>
                  <th width="30%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(p, i) in displayedPagIbig" :key="i">
                  <td>{{ p.employee_share }}</td>
                  <td>{{ p.employer_share }}</td>
                  <td>
                    <md-button
                      class="md-raised md-dense md-warning"
                      @click="
                        pagibigData = JSON.parse(JSON.stringify(p));
                        isEditPagIbig = true;
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

    <DialogCard v-if="isEditPagIbig">
      <section slot="header">Edit PagIbig</section>
      <section slot="body" class="dCardBody">
        <form
          method="post"
          @submit.prevent="editPagIbig()"
        >
          <md-field>
            <label>Employee Share</label>
            <md-input v-model="pagibigData.employee_share"> ></md-input>
          </md-field>
          <md-field>
            <label>Employer Share</label>
            <md-input v-model="pagibigData.employer_share"> ></md-input>
          </md-field>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">Update</md-button>
            <md-button
              class="md-dense md-danger"
              @click="isEditPagIbig = false"
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

        pagibig: [
            {"effective_date":"2020-01-01","array":[{"id":1,"employee_share":"100.00","employer_share":"100.00"}]}
        ],
        displayedPagIbig: [],
        pagibigData: {},
        date: "2020-01-01",
        period: "daily",

        isEditPagIbig: false,
        isDeleteTable: false,
    }),
    methods: {
        getPagIbigToDisplay() {
            const index = this.pagibig.findIndex(
                (val) => val.effective_date == this.date
            );
            this.displayedPagIbig = this.pagibig[index].array;
            console.log(this.displayedPagIbig)
        },
        editPagIbig() {
            const index = this.pagibig.findIndex(
                (val) => val.effective_date == this.date
            );
            const pagibigIndex = this.pagibig[index].array.findIndex(
                (val) => val.id == this.pagibigData.id
            );
            this.pagibig[index].array[pagibigIndex] = this.pagibigData;
            this.isEditPagIbig = false;
        },
        deleteTable() {
            const index = this.pagibig.findIndex(
                (val) => val.effective_date == this.date
            );
            this.pagibig.splice(index, 1)
            this.displayedPagIbig = []
            this.isDeleteTable = false;
        },
    },

    //Created
    async created() {
        this.getPagIbigToDisplay()
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
