<template>
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
        <md-card-content>
            <div class="md-layout">
                <div
                    class="md-layout-item md-large-size-100 md-size-100"
                    style="min-height: 100% !important"
                >
                    <md-table
                        v-model="divisions"
                        md-sort="id"
                        md-sort-order="asc"
                        md-card
                        @md-selected="onSelect"
                    >
                        <!-- <md-table-toolbar>
                            <div class="md-toolbar-section-start"></div>
                            <md-field
                                md-clearable
                                class="md-toolbar-section-end"
                            >
                                <md-input
                                    placeholder="Search by division name..."
                                    v-model="search"
                                    @input="searchOnTable"
                                />
                            </md-field>
                        </md-table-toolbar> -->

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
                            md-selectable="single"
                        >
                            <!-- hide division id from table -->
                            <!-- <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell> -->
                            <md-table-cell md-label="CODE" md-sort-by="code">{{
                                item.code
                            }}</md-table-cell>
                            <md-table-cell md-label="NAME" md-sort-by="name">{{
                                item.name
                            }}</md-table-cell>
                            <md-table-cell
                                md-label="DESCRIPTION"
                                md-sort-by="description"
                                >{{ item.description }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="OFFICE GROUP"
                                md-sort-by="officeGroupData"
                                >{{
                                    item.officeGroupData
                                        ? item.officeGroupData.code
                                        : "None"
                                }}</md-table-cell
                            >
                        </md-table-row>
                    </md-table>
                    <md-button
                        class="md-raised md-primary"
                        @click="changeCurrentDivisionSelection()"
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
// import DialogCard from "../../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";
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
    emits: ["close-dialog"],
    name: "ListDivision",
    mixins: [userAction, LogOut],
    components: {
        DialogCard,
    },
    data() {
        return {
            isAuthenticated: true,
            search: null,
            baseUrl: null,

            // table selection
            isSelected: false,
            selection: {},
            selectedDivId: null,
            searched: {},
            divisions: {},

            //UI
            searchValue: null,
            isSearching: false,
            btnSearch: "Search",
        };
    },
    methods: {
        changeCurrentDivisionSelection() {
            const divID = this.selectedDivId;
            this.$emit("close-dialog");
            // this.$store.commit('changecurrentSelectionDivisionId', divID);
        },

        // searchOnTable() {
        //     this.searched = searchByName(this.divisions.data.data, this.search);
        // },

        // Call Axios
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

        // Get Division
        async getDivisions() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/division/search/";

            // this.divisions = await axios
            //     .get(this.baseUrl, {
            //         headers: {
            //             Authorization: "Bearer " + getToken,
            //             Accept: "application/json",

            //         },
            //     })
            //     .catch((e) => {
            //         if (e.response.status === 401) {
            //             this.isAuthenticated = false;
            //         }
            //         console.log(e);
            //     });
            const options = {
                method: "GET",
                url: this.baseUrl,
                params: {
                    perPage: "20",
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
                })
                .catch((error) => {
                    console.error(error);
                });

            this.searched = this.divisions;
            console.log(this.searched);
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
                params: { searchValue: this.searchValue, perPage: "20" },
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
                })
                .catch((error) => {
                    console.error(error);
                });
            this.btnSearch = "Search";
            this.isSearching = false;
        },

        // Select Division
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                this.selectedDivId = item.id;
                localStorage.setItem("division_name", item.name);
                localStorage.setItem("division_id", item.id);
                this.isSelected = true;
            }
        },
    },
    created() {
        this.getDivisions();
    },
};
</script>

<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
</style>
