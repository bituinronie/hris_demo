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
                        md-sort="name"
                        md-sort-order="asc"
                        md-card
                        @md-selected="onSelect"
                    >
                        <md-table-toolbar>
                            <div class="md-toolbar-section-start"></div>
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
                                            placeholder="Search..."
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
                            <md-table-cell
                                md-label="Employee Number"
                                md-sort-by="employee_number"
                                >{{ item.employee_number }}</md-table-cell
                            >
                            <md-table-cell md-label="Name" md-sort-by="name">{{
                                item.name
                            }}</md-table-cell>
                            <md-table-cell
                                md-label="Birth Date"
                                md-sort-by="birthdate"
                                >{{ item.birth_date }}</md-table-cell
                            >
                        </md-table-row>

                        <md-table-empty-state
                            md-label="No employee found"
                            :md-description="`Try a different search term or create a new employee.`"
                        >
                        </md-table-empty-state>
                    </md-table>
                    <md-button
                        class="md-raised md-primary"
                        @click="changeCurrentEmployeeSelection()"
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
    name: "ListApprover",
    mixins: [userAction],
    components: {
        // DialogCard
    },
    data() {
        return {
            isAuthenticated: true,
            baseUrl: null,

            //Table Selection
            isSelected: false,
            selection: {},
            selectedEmpId: null,
            users: {},

            //Data for searching
            searchValue: null,
            searchBtnName: "Search",
            isSearching: false,
        };
    },
    methods: {
        changeCurrentEmployeeSelection() {
            this.$emit("close-dialog");
        },

        //Call Axios
        async callAxios(options) {
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Get Employee - Inititate in page load
        async getEmployees() {
            let searchValue = this.searchValue;
            if (searchValue === "") {
                searchValue = null;
            }
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl +
                "/api/employee/search/?searchValue=" +
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

        //Select Employee for Editing
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                localStorage.setItem("approver_name", item.name);
                localStorage.setItem("approver_id", item.id);
                this.isSelected = true;
            }
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
