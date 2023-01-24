<template>
    <div>
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Position Description Form</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-medium-size-100 md-size-100">
                        <form
                            method="post"
                            @submit.prevent="printPositionDescriptionForm"
                        >
                            <div class="md-layout-item md-small-size-50">
                                <md-field>
                                    <label>Select Potision</label>
                                    <md-input
                                        v-model="positionName"
                                        required
                                        disabled
                                    >
                                    </md-input>
                                    <md-button
                                        class="md-raised md-primary"
                                        @click="searchPos"
                                        >☰</md-button
                                    >
                                </md-field>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-field>
                                    <label>Employee Name</label>
                                    <md-input
                                        v-model="employeeName"
                                        type="text"
                                        required
                                    ></md-input>
                                </md-field>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-field>
                                    <label>Supervisor Name</label>
                                    <md-input
                                        v-model="supervisorName"
                                        type="text"
                                        required
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-100 text-right">
                                <md-button
                                    type="submit"
                                    class="md-primary md-dense"
                                    >Print</md-button
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </md-card-content>
        </md-card>
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
        <!-- Position Title of Immediate Supervisor -->
        <DialogCard v-if="posSearch">
            <section slot="header">Select Position</section>
            <section slot="body">
                <ListPosition
                    v-on:close-dialog="getPosNameAndId"
                ></ListPosition>
                <form>
                    <md-dialog-actions>
                        <md-button class="md-dense md-danger" @click="searchPos"
                            >✕ Close</md-button
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
const ListPosition = () =>
    import(
        /* webpackChunkName: "ListPosition" */ "../Positions/ListPosition.vue"
    );
import LogOut from "../../mixins/logOut.js";
import axios from "axios";

export default {
    components: {
        DialogCard,
        ListPosition,
    },
    mixins: [LogOut],
    name: "PositionDescriptionForm",
    data() {
        return {
            isAuthenticated: true,

            //PositionDescriptionForm
            positionId: null,
            positionName: null,
            employeeName: null,
            supervisorName: null,
            posSearch: false,
        };
    },
    methods: {
        //PositionDescriptionForm
        searchPos() {
            this.posSearch = !this.posSearch;
        },
        getPosNameAndId() {
            this.positionId = localStorage.getItem("position_id");
            this.positionName = localStorage.getItem("position_name");
            this.searchPos();
            console.log(this.positionId);
        },

        printPositionDescriptionForm() {
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
                    permission: "print position",
                    model_name: {
                        positionId: this.positionId,
                        employeeName: this.employeeName,
                        supervisorName: this.supervisorName,
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
                        "/generate/report/1/single/pdf/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
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
</style>
