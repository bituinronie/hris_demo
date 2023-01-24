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
                        v-model="positions"
                        md-sort="id"
                        md-sort-order="asc"
                        md-card
                        @md-selected="onSelect"
                    >
                        <md-table-toolbar>
                            <div class="md-toolbar-section-start">
                                <md-field
                                    md-clearable
                                    class="md-toolbar-section-end"
                                >
                                    <md-input
                                        placeholder="Search by position name..."
                                        v-model="searchValue"
                                    />
                                </md-field>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-30
                                "
                            >
                                <md-button
                                    class="md-raised md-primary"
                                    @click="searchPosition"
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
                            <md-table-cell md-label="Title" md-sort-by="name">{{
                                item.name
                            }}</md-table-cell>
                            <md-table-cell
                                md-label="Item Number"
                                md-sort-by="description"
                                >{{ item.item_number }}</md-table-cell
                            >
                        </md-table-row>
                    </md-table>
                    <md-button
                        class="md-raised md-primary"
                        @click="changeCurrentPositionSelection"
                        v-if="isSelected"
                    >
                        Confirm
                    </md-button>
                    <div class="md-layout-item md-size-100 text-right">
                        <label v-for="l in links" :key="l.label">
                            <md-button
                                class="button-paginate md-warning"
                                @click="getPositionUsingLink(l.url)"
                                :disabled="l.active || l.url === null"
                            >
                                <label
                                    style="color: black !important"
                                    v-html="l.label"
                                ></label>
                            </md-button>
                        </label>
                    </div>
                </div>
            </div>
        </md-card-content>
    </md-card>
</template>

<script>
import axios from "axios";
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
    name: "ListPosition",
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
            selectedPosId: null,
            searchValue: null,
            searched: {},
            positions: {},
            isSearching: false,
            searchBtnName: "Search",
            links: null,
            perPage: 20,
        };
    },
    methods: {
        changeCurrentPositionSelection() {
            const posID = this.selectedPosId;
            this.$emit("close-dialog");
            //this.$store.commit('changecurrentSelectionPositionId', posID);
        },

        searchOnTable() {
            this.searched = searchByName(this.positions.data.data, this.search);
        },

        // call axios
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

        // get positions
        async getPositions() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/position/search/";

            this.positions = await axios
                .get(this.baseUrl, {
                    params: {
                        searchValue: this.searchValue,
                        perPage: this.perPage,
                    },
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
            this.searched = this.positions.data.data;
            this.links = this.positions.data.links;
            this.positions = this.positions.data.data;
            console.log(this.searched);
        },

        async getPositionUsingLink(url) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = url;

            let newPosition = await axios
                .get(this.baseUrl, {
                    params: {
                        searchValue: this.searchValue,
                        perPage: this.perPage,
                    },
                    headers: {
                        Authorization: "Bearer " + getToken,
                        Accept: "application/json",
                    },
                })
                .catch((e) => {
                    console.log(e);
                });
            console.log(url);
            this.links = newPosition.data.links;
            this.positions = newPosition.data.data;

            //Convert Object to Data
            this.positions = Object.keys(newPosition.data.data).map((key) => {
                return newPosition.data.data[key];
            });
        },

        async searchPosition() {
            this.searchBtnName = "Searching";
            await this.getPositions();
            this.searchBtnName = "Search";
        },

        // select position
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                this.selectedPosId = item.id;
                localStorage.setItem("position_name", item.name);
                localStorage.setItem("position_id", item.id);
                localStorage.setItem(
                    "immediateSupervisor",
                    item.immediateSupervisor
                );
                localStorage.setItem(
                    "nextSupervisorName",
                    item.nextSupervisorName
                );
                localStorage.setItem("positionName", item.positionName);
                localStorage.setItem(
                    "supervised_position_title",
                    item.supervised_position_title
                );

                this.isSelected = true;
            }
        },
    },
    async created() {
        await this.getPositions();
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
</style>
