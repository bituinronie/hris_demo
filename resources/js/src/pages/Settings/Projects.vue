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
        <h4 class="title">Projects</h4>
      </md-card-header>
      <md-card-content>
        <div class="md-layout" style="margin-top: 20px">
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-button
              class="md-raised md-dense md-primary"
              @click="
                projectData = {};
                isAddProject = true;
              "
            >
              Add Project
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
                  <th width="20%">Code</th>
                  <th width="50%">Description</th>
                  <th width="30%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(project, i) in projects" :key="i">
                  <td>{{ project.code }}</td>
                  <td>{{ project.description }}</td>
                  <td>
                    <md-button
                      class="md-raised md-dense md-warning"
                      @click="
                        projectData = JSON.parse(JSON.stringify(project));
                        isEditProject = true;
                      "
                      style="color: black !important"
                      >Edit</md-button
                    >
                    <md-button
                      class="md-raised md-dense md-danger"
                      @click="
                        projectData = JSON.parse(JSON.stringify(project));
                        isDeleteProject = true;
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

    <DialogCard v-if="isAddProject || isEditProject">
      <section slot="header">
        {{ isAddProject ? "Add" : "Edit" }} Project
      </section>
      <section slot="body" class="dCardBody">
        <form
          method="post"
          @submit.prevent="isAddProject ? addProject() : editProject()"
        >
          <md-field>
            <label>Code</label>
            <md-input v-model="projectData.code"> ></md-input>
          </md-field>
          <md-field>
            <label>Description</label>
            <md-input v-model="projectData.description"> ></md-input>
          </md-field>
          <md-dialog-actions>
            <md-button class="md-dense md-primary" type="submit">{{
              isAddProject ? "Add" : "Update"
            }}</md-button>
            <md-button
              class="md-dense md-danger"
              @click="
                isAddProject ? (isAddProject = false) : (isEditProject = false)
              "
              >Close</md-button
            >
          </md-dialog-actions>
        </form>
      </section>
    </DialogCard>

    <DialogCard v-if="isDeleteProject">
      <section slot="header">Delete Project?</section>
      <section slot="body" class="dCardBody">
        <form method="post" @submit.prevent="deleteProject()">
          <md-dialog-actions>
            <md-button class="md-dense md-danger" type="submit"
              >Delete</md-button
            >
            <md-button
              class="md-dense md-primary"
              @click="isDeleteProject = false"
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

        projects: [
            
                {
                    id: 1,
                    code: "ACTION",
                    description: "ACTION CENTER",
                    created_at: "2021-05-01 12:41:38",
                    updated_at: "2021-05-01 12:41:38",
                },
                {
                    id: 2,
                    code: "ADMIN",
                    description: "ADMINISTRATIVE SERVICE",
                    created_at: "2020-06-24 10:45:51",
                    updated_at: "2020-06-24 10:45:51",
                },
                {
                    id: 3,
                    code: "AFCS",
                    description: "automatic fare collection system",
                    created_at: "2020-06-23 14:13:17",
                    updated_at: "2020-06-24 07:48:28",
                },
                {
                    id: 4,
                    code: "AFCS-Ongoing Proj",
                    description:
                        "Automatic Fare Collection System -On Going Proj",
                    created_at: "2021-05-04 09:33:08",
                    updated_at: "2021-05-04 09:33:08",
                },
                {
                    id: 5,
                    code: "apdu",
                    description: "Aviation project development unit",
                    created_at: "2020-06-24 07:48:02",
                    updated_at: "2020-06-24 07:48:02",
                },
            
        ],
        projectData: {},

        isAddProject: false,
        isEditProject: false,
        isDeleteProject: false,
    }),
    methods: {
        addProject() {
            this.projectData.id = this.projects.length + 1;
            this.projects.push(this.projectData);
            this.isAddProject = false;
        },
        editProject() {
            const index = this.projects.findIndex(
                (val) => val.id == this.projectData.id
            );
            this.projects[index] = this.projectData;
            this.isEditProject = false;
        },
        deleteProject() {
            const index = this.projects.findIndex(
                (val) => val.id == this.projectData.id
            );
            this.projects.splice(index, 1);
            this.isDeleteProject = false;
        },
    },
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
