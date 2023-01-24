<template>
    <form>
        <md-card>
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
            <md-dialog-alert
                :md-active.sync="isDeleted"
                :md-content="notificationMessage"
                md-confirm-text="Okay"
            />
            <md-card-header class="md-card-header">
                <h4 class="title">Employee Group</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-button
                            @click="addDivision"
                            class="md-dense md-warning"
                            style="color: black !important"
                            v-if="$permissions.includes('write employee group')"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            Add Group
                        </md-button>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-table
                            v-model="searched"
                            md-sort="name"
                            md-sort-order="asc"
                            md-card
                            md-fixed-header
                        >
                            <md-table-toolbar>
                                <div class="md-toolbar-section-start">
                                    <h1 class="md-title">Group</h1>
                                </div>

                                <md-field class="md-toolbar-section-end">
                                    <md-input
                                        placeholder="Search by Group Name..."
                                        v-model="search"
                                    />
                                    <md-button
                                        class="md-primary md-dense"
                                        style="margin-bottom: 10px !important"
                                        @click="searchOnTable"
                                        :disabled="isSearching"
                                    >
                                        {{ btnSearch }}
                                    </md-button>
                                </md-field>
                            </md-table-toolbar>

                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <md-table-cell
                                    md-label="Code"
                                    md-sort-by="code"
                                    >{{ item.code }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Description"
                                    md-sort-by="description"
                                    >{{ item.description }}</md-table-cell
                                >

                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-raised md-dense md-primary"
                                        @click="editDivision(item.id)"
                                        :disabled="item.deleted_at"
                                        v-if="
                                            $permissions.includes(
                                                'write employee group'
                                            )
                                        "
                                    >
                                        ✎
                                        <!-- Edit -->
                                        <md-tooltip md-direction="top"
                                            >Edit this record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-raised md-dense md-danger"
                                        @click="deleteDivision(item.id)"
                                        :disabled="item.deleted_at"
                                        v-if="
                                            $permissions.includes(
                                                'delete employee group'
                                            )
                                        "
                                    >
                                        ⌫
                                        <!-- Delete -->
                                        <md-tooltip md-direction="top"
                                            >Delete this record.</md-tooltip
                                        >
                                    </md-button>
                                    <md-button
                                        class="md-dense md-warning"
                                        :disabled="!item.deleted_at"
                                        @click="restoreDivision(item.id)"
                                        v-if="
                                            $permissions.includes(
                                                'restore employee group'
                                            )
                                        "
                                    >
                                        <label style="color: black !important"
                                            >⟳</label
                                        >
                                        <!-- Restore -->
                                        <md-tooltip md-direction="top"
                                            >Restore this record</md-tooltip
                                        >
                                    </md-button>
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </div>
                    <div class="md-layout-item md-size-100 text-right">
                        <label v-for="l in links" :key="l.label">
                            <md-button
                                class="button-paginate md-warning"
                                @click="getGroupsUsingLink(l.url)"
                                :disabled="l.active || l.url === null"
                            >
                                <label
                                    style="color: black !important"
                                    v-html="l.label"
                                ></label>
                            </md-button>
                        </label>
                        <!-- <md-button class="md-raised md-dense md-success">
                                <md-icon>save</md-icon> Save Learning and Development
                            </md-button> -->
                    </div>
                </div>
            </md-card-content>
        </md-card>

        <!-- <DialogCard v-if="isAddDivision"> -->
        <DialogCard v-if="isAddGroup">
            <section slot="header">Add Group</section>
            <section slot="body">
                <!-- <form
                    method="post"
                    @submit.prevent="validateLearningDevelopment"
                > -->
                <form method="post" @submit.prevent="validateDivision">
                    <md-field>
                        <label>Code</label>
                        <md-input
                            v-model="code"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Description</label>
                        <md-input v-model="description" type="text"></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            v-if="!isEdit"
                            class="md-primary md-dense"
                            type="submit"
                            :disabled="isUpdating"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            {{ btnMessage }}
                        </md-button>
                        <md-button
                            v-else
                            class="md-primary md-dense"
                            :disabled="isUpdating"
                            @click="updateDivision"
                        >
                            <!-- <md-icon>arrow_circle_up</md-icon> -->
                            {{ btnMessage }}
                        </md-button>
                        <md-button
                            v-if="!isEdit"
                            class="md-dense md-danger"
                            @click="addDivision"
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Close
                        </md-button>
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
            <md-button
                class="md-warning md-dense"
                @click="fireSnackbar = false"
            >
                <label style="color: black">Dismiss</label>
            </md-button>
        </md-snackbar>
    </form>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../../components/Cards/DialogCard.vue";
import LogOut from "../../mixins/logOut.js";
import axios from "axios";
const toLower = (text) => {
    return text.toString().toLowerCase();
};

const searchByName = (items, term) => {
    if (term) {
        return items.filter((item) =>
            toLower(item.name).includes(toLower(term))
        );
    }

    return items;
};

export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut],
    name: "EmployeeGroup",
    props: {
        dataBackgroundColor: {
            type: String,
        },
    },
    data: () => ({
        search: null,
        searched: [],

        groups: [],
        code: null,
        description: null,
        office_group: null,
        links: null,
        perPage: 20,
        currentPage: null,
        isAddGroup: false,
        default: "",
        isDeleted: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,
        isAuthenticated: true,
        isUpdating: false,
        btnMessage: "Add Group",
        btnSearch: "Search",
        isSearching: false,

        fireSnackbar: false,
        messageSnackbar: "",
    }),
    methods: {
        //Get Group
        async getDivision() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee-group/search/";

            const options = {
                method: "GET",
                params: {
                    perPage: this.perPage,
                },
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            // return response;
            let getResponse = await this.axiosRequest(options);

            this.groups = getResponse.data.data;
            this.links = getResponse.data.links;
            this.currentPage = getResponse.data.currentPage;
            this.searched = this.groups;
        },

        //Get Groups using Link
        async getGroupsUsingLink(url) {
            const getToken = localStorage.getItem("token");

            const options = {
                method: "GET",
                params: {
                    perPage: this.perPage,
                },
                url: url,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            // return response;
            let getResponse = await this.axiosRequest(options);
            this.groups = getResponse.data.data;
            this.links = getResponse.data.links;
            this.currentPage = getResponse.data.currentPage;
            this.searched = this.groups;
        },
        //Update Group
        async updateDivision() {
            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee-group/update/" + this.updateId;

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    code: this.code,
                    description: this.description,
                    office_group: null,
                },
            };

            await this.axiosRequest(options);
            await this.getDivision();
            this.addDivision();
        },

        //Add Group
        async validateDivision() {
            this.isUpdating = true;
            this.btnMessage = "Adding...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee-group/create/";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    code: this.code,
                    description: this.description,
                },
            };

            // return response;
            await this.axiosRequest(options);
            await this.getDivision();
            this.resetData();
            this.addDivision();
        },

        //Delete Group
        async deleteDivision(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee-group/delete/" + id;
            const options = {
                method: "DELETE",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.axiosRequest(options);
            console.log(resp.status);
            if (resp.status === 400) {
                this.notificationMessage =
                    resp.data.message + " Cannot be deleted.";
                this.isDeleted = true;
            } else {
                this.notificationMessage = "Employee Group has been deleted.";
                this.isDeleted = true;
            }
            await this.getDivision();
        },

        //Resore Group
        async restoreDivision(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee-group/restore/" + id;

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.axiosRequest(options);
            await this.getDivision();
            this.notificationMessage = "The record has been restored.";
            this.isDeleted = true;
        },

        //Edit Group
        async editDivision(id) {
            this.updateId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee-group/search/" + id;

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let getResponse = await this.axiosRequest(options);

            this.code = getResponse.data.code;
            this.name = getResponse.data.name;
            this.description = getResponse.data.description;
            this.office_group = null;

            this.addDivision();
            this.isEdit = true;
            this.btnMessage = "Update Group";
        },

        //Call Axios
        async axiosRequest(options) {
            let getResp;
            await axios
                .request(options)
                .then((response) => {
                    getResp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    getResp = error.response;

                    if (error.response.status === 422) {
                        this.fireSnackbar = true;
                        this.messageSnackbar = JSON.stringify(
                            error.response.data.errors.code[0]
                        );
                    }

                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
            return getResp;
        },

        //Add a Division
        addDivision() {
            this.isAddGroup = !this.isAddGroup;
            this.isUpdating = false;
            this.isEdit = false;
            this.btnMessage = "Add Group";
        },

        //reset Data()
        resetData() {
            this.code = null;
            this.name = null;
            this.description = null;
            this.office_group = null;
        },

        //Search on Table
        async searchOnTable() {
            this.isSearching = true;
            this.btnSearch = "Searching...";

            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee-group/search/";

            const options = {
                method: "GET",
                url: this.baseUrl,
                params: {
                    searchValue: this.search,
                    perPage: this.perPage,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            // return response;
            let getResponse = await this.axiosRequest(options);
            console.log(getResponse);
            this.btnSearch = "Search";
            this.isSearching = false;

            this.groups = getResponse.data.data;
            this.searched = this.groups;
            this.links = null;
        },
    },
    //Created
    created() {
        this.getDivision();
    },
};
</script>
<style scoped>
.button-paginate {
    border: 0px !important;
    margin-left: 2px !important;
    margin-right: 2px !important;
    padding: 5px !important;
    max-width: 90px !important;
    min-width: 90px !important;
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
.md-table-sortable-icon {
    display: none !important;
}
</style>
