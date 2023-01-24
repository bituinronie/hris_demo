<template>
    <md-card>
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
                            <div class="md-toolbar-section-start"></div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-70
                                "
                            >
                                <md-field md-clearable>
                                    <form
                                        method="post"
                                        @submit.prevent="searchPosition"
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
                            <md-table-cell
                                md-label="Position Title"
                                md-sort-by="name"
                                >{{ item.name }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Item Number"
                                md-sort-by="item_number"
                                >{{ item.item_number }}</md-table-cell
                            >
                        </md-table-row>

                        <md-table-empty-state
                            md-label="No positions found"
                            :md-description="`Try a different search term or create a new employee.`"
                        >
                            <!-- <md-button class="md-primary md-raised">Create New Record</md-button> -->
                        </md-table-empty-state>
                    </md-table>
                    <md-button
                        class="md-raised md-primary"
                        @click="changeSearchPosition"
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
import userAction from "../../mixins/userAction.js";

export default {
    emits: ["close-dialog"],
    name: "SearchPositions",
    mixins: [userAction],
    data() {
        return {
            // table selection
            isSelected: false,
            selection: {},
            selectedPosId: null,
            positions: {},
            isSearching: false,
            searchBtnName: "Search",
            searchValue: null,
            selectedPositionID: null,

            links: null,
            perPage: 5,
        };
    },
    methods: {
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

        // get positions
        async getPositions() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/position/search";

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
                    console.log(e);
                });
            this.links = this.positions.data.links;
            this.positions = this.positions.data.data;
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
            this.isSearching = true;
            await this.getPositions();
            this.searchBtnName = "Search";
            this.isSearching = false;
        },

        //Change Search Position
        async changeSearchPosition() {
            this.$emit("close-dialog");
            localStorage.setItem("positionId", this.selectedPositionID);
            localStorage.setItem("currentPositionAction", "edit");
            this.$router.go();
        },

        //Select Employee for Editing
        onSelect(item) {
            this.selection = item;
            if (!item) {
                this.isSelected = false;
            } else {
                this.selectedPositionID = item.id;
                localStorage.setItem(
                    "selectedPositionID",
                    this.selectedPositionID
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
