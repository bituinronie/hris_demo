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
                <h4 class="title">Division</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-button
                            @click="addDivision"
                            class="md-dense"
                            v-if="$permissions.includes('write division')"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            +1 Add Division
                        </md-button>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-table
                            v-model="divisions"
                            md-sort="name"
                            md-sort-order="asc"
                            md-card
                            md-fixed-header
                        >
                            <md-table-toolbar>
                                <div class="md-toolbar-section-start">
                                    <!-- <h1 class="md-title">Users</h1> -->
                                </div>

                                <md-field class="md-toolbar-section-end">
                                    <!-- <md-input placeholder="Search by name..." v-model="search" @input="searchOnTable" /> -->
                                    <md-input
                                        placeholder="Search..."
                                        v-model="searchValue"
                                    />
                                    <md-button
                                        class="md-primary md-dense"
                                        style="margin-bottom: 10px !important"
                                        @click="getDivisionSearch()"
                                        :disabled="isSearching"
                                    >
                                        {{ btnSearch }}
                                    </md-button>
                                </md-field>
                            </md-table-toolbar>
                            <md-table-empty-state
                                md-label="No Divisions found. Please try another search term."
                            >
                                <!-- <md-button
                                            class="md-primary md-raised"
                                            @click="isAddApplication = true"
                                            >Create new application</md-button
                                        > -->
                            </md-table-empty-state>
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
                                    md-label="Name"
                                    md-sort-by="name"
                                    >{{ item.name }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Description"
                                    md-sort-by="description"
                                    >{{ item.description }}</md-table-cell
                                >
                                <!-- <md-table-cell md-label="Office Group" md-sort-by="office_group">{{ item.office_group }}</md-table-cell> -->
                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-raised md-dense md-primary"
                                        @click="editDivision(item.id)"
                                        :disabled="item.is_deleted"
                                        v-if="
                                            $permissions.includes(
                                                'write division'
                                            )
                                        "
                                    >
                                        ✎
                                    </md-button>
                                    <md-button
                                        class="md-raised md-dense md-danger"
                                        @click="deleteDivision(item.id)"
                                        :disabled="item.is_deleted"
                                        v-if="
                                            $permissions.includes(
                                                'delete division'
                                            )
                                        "
                                    >
                                        ⌫
                                    </md-button>
                                    <md-button
                                        class="md-raised md-dense md-warning"
                                        :disabled="!item.is_deleted"
                                        @click="restoreDivision(item.id)"
                                        v-if="
                                            $permissions.includes(
                                                'restore division'
                                            )
                                        "
                                    >
                                        <label style="color: black">⟳</label>
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
                        <!-- <md-button class="md-raised md-dense md-success">
                                <md-icon>save</md-icon> Save Learning and Development
                            </md-button> -->
                    </div>
                </div>
            </md-card-content>
            <div class="md-layout-item md-size-100 text-right">
                <label v-for="l in linksOnDivision" :key="l.label">
                    <md-button
                        class="button-paginate md-warning"
                        @click="getDivisionUrl(l.url)"
                        :disabled="l.active || l.url === null"
                    >
                        <label
                            style="color: black !important"
                            v-html="l.label"
                        ></label>
                    </md-button>
                </label>
            </div>
        </md-card>

        <!-- <DialogCard v-if="isAddDivision"> -->
        <DialogCard v-if="isAddDivision">
            <section slot="header">{{ divisionHeader }}</section>
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
                        <label>Name</label>
                        <md-input
                            v-model="name"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Description</label>
                        <md-input v-model="description" type="text"></md-input>
                    </md-field>
                    <!-- Division -->
                    <DialogCard v-if="divSearch">
                        <section slot="header">Select Division</section>
                        <section slot="body">
                            <ListDivision
                                v-on:close-dialog="getDivNameAndId"
                            ></ListDivision>
                            <form>
                                <md-dialog-actions>
                                    <md-button
                                        class="md-dense"
                                        @click="searchDiv"
                                        >Close</md-button
                                    >
                                </md-dialog-actions>
                            </form>
                        </section>
                    </DialogCard>
                    <md-field>
                        <label>Parent Division (Optional)</label>
                        <md-input
                            v-model="office_group.division_name"
                            type="text"
                            disabled
                        ></md-input>
                        <md-button
                            class="md-raised md-primary"
                            @click="searchDiv"
                            >☰</md-button
                        >
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
    </form>
</template>
<script>
const ListDivision = () =>
    import(
        /* webpackChunkName: "ListDivision" */ "../../pages/Positions/ListDivision.vue"
    );
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
        ListDivision,
    },
    mixins: [LogOut],
    name: "Division",
    props: {
        dataBackgroundColor: {
            type: String,
        },
    },
    data: () => ({
        search: null,
        searched: [],

        divisions: [],
        code: null,
        name: null,
        description: null,

        isAddDivision: false,
        default: "",
        isDeleted: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,
        isAuthenticated: true,
        isUpdating: false,
        btnMessage: "Add Division",
        btnIcon: "plus_one",

        divisionHeader: "Add Division",
        divSearch: false,
        paramOfficeGroup: [],

        office_group: {
            division_name: null,
            division_id: null,
        },

        //UI
        searchValue: null,
        isSearching: false,
        btnSearch: "Search",
        linksOnDivision: null,
        perPage: 10,
    }),
    methods: {
        //Get Division List
        searchDiv() {
            this.divSearch = !this.divSearch;
        },

        // Get div name and id
        getDivNameAndId() {
            this.office_group.division_name =
                localStorage.getItem("division_name");
            this.office_group.division_id = localStorage.getItem("division_id");
            this.searchDiv();
        },

        //Get Record Division
        async getDivision() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/search/";

            const options = {
                method: "GET",
                url: this.baseUrl,
                params: {
                    searchValue: this.searchValue,
                    perPage: this.perPage,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            // return response;
            let getResponse = await this.axiosRequest(options);

            this.divisions = getResponse.data.data;
            this.linksOnDivision = getResponse.data.links;
            await this.getParameter();
        },

        //Get Division using url
        async getDivisionUrl(url) {
            const getToken = localStorage.getItem("token");

            const options = {
                method: "GET",
                url: url,
                params: {
                    searchValue: this.searchValue,
                    perPage: this.perPage,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.divisions = response.data.data;
                    this.linksOnDivision = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Search Division
        async getDivisionSearch() {
            this.btnSearch = "Searching...";
            this.isSearching = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/search/";

            const options = {
                method: "GET",
                url: this.baseUrl,
                params: {
                    searchValue: this.searchValue,
                    perPage: this.perPage,
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.divisions = response.data.data;
                    this.linksOnDivision = response.data.links;
                })
                .catch((error) => {
                    console.error(error);
                });
            this.btnSearch = "Search";
            this.isSearching = false;
        },

        //Get Office Group (Parameters)
        async getParameter() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/parameter";

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    this.paramOfficeGroup = response.data.office_group;
                    console.log(this.paramOfficeGroup);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Update Division
        async updateDivision() {
            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/division/update/" + this.updateId;

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
                    name: this.name,
                    description: this.description,
                    office_group: this.office_group.division_id,
                },
            };

            await this.axiosRequest(options);
            await this.getDivision();
            this.addDivision();
        },

        //Add Division
        async validateDivision() {
            this.isUpdating = true;
            this.btnMessage = "Adding...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/create/";

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
                    name: this.name,
                    description: this.description,
                    office_group: this.office_group.division_id,
                },
            };

            // return response;
            await this.axiosRequest(options);
            await this.getDivision();
            this.resetData();
            this.addDivision();
        },

        //Delete Division
        async deleteDivision(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/delete/" + id;
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

        //Resore Record
        async restoreDivision(id) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/restore/" + id;

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

        //Edit Division
        async editDivision(id) {
            this.updateId = id;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/search/" + id;

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
            // this.office_group = this.office_group.division_id;

            this.addDivision();
            this.divisionHeader = "Edit Division";
            this.isEdit = true;
            this.btnMessage = "Update Division";
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
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
            return getResp;
        },

        //Add a Division
        addDivision() {
            this.isAddDivision = !this.isAddDivision;
            this.isUpdating = false;
            this.isEdit = false;
            this.divisionHeader = "Add Division";
            this.btnMessage = "Add Division";
        },

        //reset Data()
        resetData() {
            this.code = null;
            this.name = null;
            this.description = null;
            this.office_group = null;
        },

        // //Search on Table
        // searchOnTable() {
        //     this.searched = searchByName(this.divisions, this.search);
        // },
    },
    //Created
    created() {
        this.getDivision();
    },
};
</script>
<style scoped>
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
.button-paginate {
    border: 0px !important;
    margin-left: 2px !important;
    margin-right: 2px !important;
    padding: 5px !important;
    max-width: 90px !important;
    min-width: 90px !important;
}
</style>
