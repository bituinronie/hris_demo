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
        <h4 class="title">Philhealth</h4>
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
          <div
            class="md-layout-item md-small-size-100 md-size-75"
            style="margin-top: 10px"
          >
            <md-button
              class="md-raised md-dense md-primary"
              @click="
                philhealthData = {};
                isAddPhilhealth = true;
              "
            >
              Add Philhealth
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
                  <th width="10%">Salary Base</th>
                  <th width="20%">Monthly</th>
                  <th width="30%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(p, i) in displayedPhilhealth" :key="i">
                  <td>{{ p.minimum_salary }}</td>
                  <td>{{ p.maximum_salary }}</td>
                  <td>{{ p.salary_base }}</td>
                  <td>{{ p.monthly }}</td>
                  <td>
                    <md-button
                      class="md-raised md-dense md-warning"
                      @click="
                        philhealthData = JSON.parse(JSON.stringify(p));
                        isEditPhilhealth = true;
                      "
                      style="color: black !important"
                      >Edit</md-button
                    >
                    <md-button
                      class="md-raised md-dense md-danger"
                      @click="
                        philhealthData = JSON.parse(JSON.stringify(p));
                        isDeletePhilhealth = true;
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

    <DialogCard v-if="isAddPhilhealth || isEditPhilhealth">
      <section slot="header">
        {{ isAddPhilhealth ? "Add" : "Edit" }} Philhealth
      </section>
      <section slot="body" class="dCardBody">
        <form
          method="post"
          @submit.prevent="isAddPhilhealth ? addPhilhealth() : editPhilhealth()"
        >
          <md-field>
            <label>Minimum Salary</label>
            <md-input v-model="philhealthData.minimum_salary"> ></md-input>
          </md-field>
          <md-field>
            <label>Maximum Salary</label>
            <md-input v-model="philhealthData.maximum_salary"> ></md-input>
          </md-field>
          <md-field>
            <label>Salary Base</label>
            <md-input v-model="philhealthData.salary_base"> ></md-input>
          </md-field>
          <md-field>
            <label>Monthly</label>
            <md-input v-model="philhealthData.monthly"> ></md-input>
          </md-field>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{
              isAddPhilhealth ? "Add" : "Update"
            }}</md-button>
            <md-button
              class="md-dense md-danger"
              @click="
                isAddPhilhealth
                  ? (isAddPhilhealth = false)
                  : (isEditPhilhealth = false)
              "
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeletePhilhealth">
      <section slot="header">Delete Philhealth?</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="deletePhilhealth()">
          <md-dialog-actions>
            <md-button class="md-dense md-danger" type="submit"
              >Delete</md-button
            >
            <md-button
              class="md-dense md-primary"
              @click="isDeletePhilhealth = false"
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

        philhealth: [
            {
                effective_date: "2020-01-01",
                contribution_percentage: "3.00",
                array: [
                    {
                        id: 1,
                        minimum_salary: null,
                        maximum_salary: "10000.00",
                        salary_base: "10000.00",
                    },
                    {
                        id: 2,
                        minimum_salary: "10000.01",
                        maximum_salary: "59999.99",
                        salary_base: null,
                    },
                    {
                        id: 3,
                        minimum_salary: "60000.00",
                        maximum_salary: null,
                        salary_base: "60000.00",
                    },
                ],
            },
        ],
        displayedPhilhealth: [],
        philhealthData: {},
        date: "2020-01-01",
        period: "daily",

        isAddPhilhealth: false,
        isEditPhilhealth: false,
        isDeletePhilhealth: false,
        isDeleteTable: false,
    }),
    methods: {
        getPhilhealthToDisplay() {
            const index = this.philhealth.findIndex(
                (val) => val.effective_date == this.date
            );
            this.displayedPhilhealth = this.philhealth[index].array
        },
        addPhilhealth() {
            const index = this.philhealth.findIndex(
                (val) => val.effective_date == this.date
            );
            this.philhealthData.id = this.philhealth[index].array.length + 1
            this.philhealth[index].array.push(this.philhealthData);
            this.isAddPhilhealth = false;
        },
        editPhilhealth() {
            const index = this.philhealth.findIndex(
                (val) => val.effective_date == this.date
            );
            const philhealthIndex = this.philhealth[index].array.findIndex((val) => val.id == this.philhealthData.id);
            this.philhealth[index].array[
                philhealthIndex
            ] = this.philhealthData;
            this.isEditPhilhealth = false;
        },
        deletePhilhealth() {
            const index = this.philhealth.findIndex(
                (val) => val.effective_date == this.date
            );
            const philhealthIndex = this.philhealth[index].array.findIndex((val) => val.id == this.philhealthData.id);
            this.philhealth[index].array.splice(
                philhealthIndex,
                1
            );
            this.isDeletePhilhealth = false;
        },
        deleteTable() {
            const index = this.philhealth.findIndex(
                (val) => val.effective_date == this.date
            );
            delete this.philhealth[index].array;
            this.displayedPhilhealth = [];
            this.isDeleteTable = false;
        },
    },

    //Created
    async created() {
        this.getPhilhealthToDisplay();
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
