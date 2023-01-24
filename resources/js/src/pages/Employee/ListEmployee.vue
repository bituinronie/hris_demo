<template>
    <md-card>
        <!-- <DialogCard v-if="!isAuthenticated">
                <section slot="body">
                    Oops. Session expired. Please relogin.
                    <md-dialog-actions>
                        <md-button class="md-primary md-dense" @click="logOut">Confirm</md-button>
                    </md-dialog-actions>
                </section>
            </DialogCard> -->
        <!-- <md-card-header class="md-card-header">
                <h4 class="title">Lists of Employees</h4>
            </md-card-header> -->
        <md-card-content>
            <div class="md-layout">
                <div
                    class="md-layout-item md-large-size-100 md-size-100"
                    style="min-height: 100% !important"
                >
                    <md-table
                        v-model="users"
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
                                class="
                                    md-layout-item md-small-size-100 md-size-70
                                "
                            >
                                <md-field md-clearable>
                                    <form
                                        method="post"
                                        @submit.prevent="searchEmployee"
                                    >
                                        <md-input
                                            placeholder="Search by name..."
                                            v-model="searchValue"
                                        />
                                    </form>
                                </md-field>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-30
                                "
                            >
                                <md-button
                                    class="md-raised md-primary"
                                    @click="searchEmployee"
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
                            <md-table-cell md-label="Name" md-sort-by="name">{{
                                item.name
                            }}</md-table-cell>
                            <md-table-cell
                                md-label="Birth Date"
                                md-sort-by="birthdate"
                                >{{ item.birth_date }}</md-table-cell
                            >
                            <!-- <md-table-cell
                                md-label="Division"
                                md-sort-by="division"
                                >Division: {{ item.division }}</md-table-cell
                            > -->
                            <!-- <md-table-cell md-label="Deleted">{{ item.is_deleted }}</md-table-cell> -->
                            <!-- 
                            <md-table-cell md-label="Actions">

                                <md-button class="md-raised md-primary" @click="changeCurrentEmployeeSelection(item.id)" :disabled="item.is_deleted">
                                    Edit
                                    <md-tooltip md-direction="top">Edit information of this user</md-tooltip>
                                </md-button>                                        
                                <md-button class="md-raised md-danger" :disabled="item.is_deleted" @click="deleteEmployee(item.id, item.name)">
                                    Delete
                                    <md-tooltip md-direction="top">Soft delete this user</md-tooltip>
                                </md-button>
                                <md-button class="md-raised md-primary" :disabled="!item.is_deleted" @click="restoreEmployee(item.id, item.name)">
                                    Restore
                                    <md-tooltip md-direction="top">Restore this user</md-tooltip>
                                </md-button>
                                <md-button class="md-raised md-primary" :disabled="item.is_deleted" @click="generatePds(item.id)">
                                    Generate Report
                                    <md-tooltip md-direction="top">Generate 201 File</md-tooltip>
                                </md-button> -->

                            <!-- <md-button class="md-just-icon md-simple md-primary" @click="changeCurrentEmployeeSelection(item.id)" :disabled="item.is_deleted">
                                    <md-icon>edit</md-icon>
                                    <md-tooltip md-direction="top">Edit information of this user</md-tooltip>
                                </md-button>                                        
                                <md-button class="md-just-icon md-simple md-danger" :disabled="item.is_deleted" @click="deleteEmployee(item.id, item.name)">
                                    <md-icon>close</md-icon>
                                    <md-tooltip md-direction="top">Soft delete this user</md-tooltip>
                                </md-button>
                                <md-button class="md-just-icon md-simple md-primary" :disabled="!item.is_deleted" @click="restoreEmployee(item.id, item.name)">
                                    <md-icon>restore</md-icon>
                                    <md-tooltip md-direction="top">Restore this user</md-tooltip>
                                </md-button> -->
                            <!-- Generate Report -->
                            <!-- <md-button class="md-just-icon md-simple md-primary" :disabled="item.is_deleted" @click="generatePds(item.id)">
                                    <md-icon>print</md-icon>
                                    <md-tooltip md-direction="top">Generate 201 File</md-tooltip>
                                </md-button> 
                            </md-table-cell>-->
                        </md-table-row>

                        <md-table-empty-state
                            md-label="No employee found"
                            :md-description="`Try a different search term or create a new employee.`"
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
                    <!-- <md-button class="md-simple md-primary" @click="generatePds()" v-if="isSelected">
                            Generate 201 File
                        </md-button> -->
                </div>
            </div>
        </md-card-content>

        <!-- Delete Dialog -->
        <DialogCard v-if="isDeleting">
            <section slot="header">
                {{ dialogMessage }} {{ nameDeletion }}
            </section>
            <section slot="body">
                <form method="post" @submit.prevent="validateUEmployeeDeletion">
                    <md-dialog-actions>
                        <md-button class="md-primary md-dense" type="submit"
                            ><md-icon>delete</md-icon>Confirm Delete</md-button
                        >
                        <md-button
                            class="md-dense"
                            @click="deleteEmployee(null, null)"
                            ><md-icon>close</md-icon>Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
        <!-- Delete Dialog -->

        <!-- Restore Dialog -->
        <DialogCard v-if="isRestoring">
            <section slot="header">
                {{ dialogMessage }} {{ nameResoration }}
            </section>
            <section slot="body">
                <form
                    method="post"
                    @submit.prevent="validateEmployeeRestoration"
                >
                    <md-dialog-actions>
                        <md-button class="md-primary md-dense" type="submit"
                            ><md-icon>restore</md-icon>Confirm
                            Restore</md-button
                        >
                        <md-button
                            class="md-dense"
                            @click="restoreEmployee(null, null)"
                            ><md-icon>close</md-icon>Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
        <!-- Restore Dialog -->
    </md-card>
</template>
<script>
import axios from "axios";
import userAction from "../../mixins/userAction.js";

export default {
    emits: ["close-dialog"],
    name: "ListEmployee",
    mixins: [userAction],
    components: {
        // DialogCard
    },
    props: {
        module: {
            type: String,
            default: null,
        },
    },
    data() {
        return {
            isAuthenticated: true,
            baseUrl: null,
            isDeleting: false,
            idDeletion: null,
            nameDeletion: null,
            //Restore
            isRestoring: false,
            idRestore: null,
            nameResoration: null,
            dialogMessage: null,

            //Table Selection
            isSelected: false,
            selection: {},
            selectedEmpId: null,
            users: {},

            //Data for searching
            searchValue: null,
            searchBtnName: "Search",
            isSearching: false,

            //Selection name
            selectionName: null,
        };
    },
    methods: {
        newUser() {
            window.alert("Noop");
        },

        changeCurrentEmployeeSelection() {
            const empID = this.selectedEmpId;
            // alert("You will be redirected to the other tabs for updating.");
            this.$emit("close-dialog");
            this.$store.commit("changecurrentSelectionUserId", empID);
            this.$store.commit("changeUserStatusAction", "emp_selected");
            this.$store.commit(
                "changeCurrentTabSelection",
                "personalInformation"
            );

            //Selection Name 
            if (this.$route.path == '/schedule') {
                    localStorage.setItem("selection_name_shedule", this.selectionName);
            } else if (this.$route.path == '/history') {
                localStorage.setItem("selection_name_history", this.selectionName);
            } else if (this.$route.path == '/employee') {
                localStorage.setItem("selection_name_employee", this.selectionName)
            } else if (this.$route.path == '/request') {
                localStorage.setItem("selection_name_request", this.selectionName)
            } 
           
        },

        deleteEmployee(id, name) {
            this.dialogMessage = "Confirm Deletion of";
            this.idDeletion = id;
            this.nameDeletion = name;
            this.isDeleting = !this.isDeleting;
        },

        restoreEmployee(id, name) {
            this.dialogMessage = "Confirm Restoration of";
            this.idRestore = id;
            this.nameResoration = name;
            this.isRestoring = !this.isRestoring;
        },

        //Call Axios
        async callAxios(options) {
            await axios
                .request(options)
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //Get Employee - Inititate in page load
        async getEmployees() {
            let searchValue = this.searchValue;
            if (searchValue === "") {
                searchValue = null;
            }

            var module = "";

            if (this.module) {
                module = this.module;
            } else {
                module = "employee";
            }

            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/" +
                module +
                "/search/?searchValue=" +
                searchValue;
            console.log(this.baseUrl);
            this.users = await axios
                .get(this.baseUrl, {
                    headers: {
                        Authorization: "Bearer " + getToken,
                        Accept: "application/json",
                    },
                })
                .catch((e) => {
                    if (e.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                    console.log(e);
                });
            this.users = this.users.data.data;
            // this.searched = this.users.data.data;
        },

        async searchEmployee() {
            this.searchBtnName = "Searching";
            this.isSearching = true;
            await this.getEmployees();
            this.searchBtnName = "Search";
            this.isSearching = false;
        },
        //Validate User Deletion
        validateUEmployeeDeletion() {
            this.dialogMessage =
                "Deleting " + this.nameDeletion + " please wait.";
            this.nameDeletion = null;
            const id = this.idDeletion;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/delete/" + id;

            const options = {
                method: "DELETE",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            this.callAxios(options);
            this.getEmployees();
            this.dialogMessage = null;
            this.isDeleting = !this.isDeleting;
        },
        //Validate User Restoration
        validateEmployeeRestoration() {
            this.dialogMessage =
                "Restoring " + this.nameRestoration + " please wait.";
            this.nameRestoration = null;
            const id = this.idRestore;
            const getToken = localStorage.getItem("token");
            console.log(getToken);

            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/restore/" + id;

            // Start From Designer
            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            this.callAxios(options);
            // End From Designer
            this.getEmployees();
            this.dialogMessage = null;
            this.isRestoring = !this.isRestoring;
        },

        //Select Employee for Editing
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                this.selectedEmpId = item.id;
                this.$store.commit("changeCurrentSelectionUserName", item.name);
                localStorage.setItem("full_name", item.name);
                this.isSelected = true;

                //On Employee selection
                this.selectionName = item.name;
            }
        },

        //Generate PDS
        generatePds(id) {
            const employeeID = this.selectedEmpId;
            //const empID = this.selectedEmpId;
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    permission: "print employee",
                    model_name: {
                        employeeId: employeeID,
                    },
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    console.log(printToken);

                    //New Tab to generate the PDS
                    parentURL =
                        parentURL +
                        "/generate/report/1/single/pds/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
    },
    async created() {
        await this.getEmployees();
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
</style>
