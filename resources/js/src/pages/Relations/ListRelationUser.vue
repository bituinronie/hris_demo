<template>
    <md-card>
        <md-card-content>
            <div class="md-layout">
                <div
                    class="md-layout-item md-large-size-100 md-size-100"
                    style="min-height: 100% !important"
                >
                    <md-table
                        v-model="users"
                        md-sort="username"
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
                                        @submit.prevent="searchUser"
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
                                    @click="searchUser"
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
                                md-label="Employee Number"
                                md-sort-by="employee_number"
                                >{{ item.employee_number }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Employee Name"
                                md-sort-by="employee_name"
                                >{{ item.name }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Birthdate"
                                md-sort-by="birthdate"
                                >{{ item.birth_date }}</md-table-cell
                            >
                            <!-- <md-table-cell
                                md-label="Email"
                                md-sort-by="email"
                                >{{ item.email }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Active"
                                md-sort-by="isActive"
                            >
                                <label v-if="item.isActive === true">Yes</label>
                                <label v-if="item.isActive === false">No</label>
                            </md-table-cell>
                            <md-table-cell md-label="Role" md-sort-by="role">{{
                                item.role
                            }}</md-table-cell> -->
                        </md-table-row>

                        <md-table-empty-state
                            md-label="No user found"
                            :md-description="`Try a different search term or create a new user.`"
                        >
                        </md-table-empty-state>
                    </md-table>
                    <md-button
                        class="md-raised md-primary"
                        @click="changeCurrentUserSelection"
                        v-if="isSelected"
                    >
                        Confirm
                    </md-button>
                </div>
            </div>
        </md-card-content>
    </md-card>
</template>
<script>
import axios from "axios";
import userAction from "../../mixins/userAction.js";

export default {
    emits: ["close-dialog"],
    name: "ListAppraisalUsers",
    mixins: [userAction],
    components: {
        // DialogCard
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
            selectedUserID: null,
            users: {},

            //Data for searching
            searchValue: null,
            searchBtnName: "Search",
            isSearching: false,
        };
    },
    methods: {
        changeCurrentUserSelection() {
            localStorage.setItem("user_id", this.selectedUserID);
            localStorage.setItem("search_user", "1");
            this.$emit("close-dialog");
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

        //Get Users
        async getUsers() {
            let searchValue = this.searchValue;
            if (searchValue === "") {
                searchValue = null;
            }
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/awards/search/?searchValue=" + searchValue;
            console.log(this.baseUrl);
            const options = {
                method: "GET",
                url: this.baseUrl,
                params: { perPage: "20" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    this.users = response.data.data;
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });

            // this.users = this.users.data.data
            // this.searched = this.users.data.data;
            console.log(this.users);
        },

        //Searching State
        async searchUser() {
            this.searchBtnName = "Searching";
            this.isSearching = true;
            await this.getUsers();
            this.searchBtnName = "Search";
            this.isSearching = false;
        },

        //Select Employee for Editing
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                this.selectedUserID = item.id;
                localStorage.setItem("employee_name", item.name);
                console.log(item.name);
                this.isSelected = true;
            }
        },
    },
    async created() {
        await this.getUsers();
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
</style>
