<template>
    <div>
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Statistical Summary</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-medium-size-100 md-size-100">
                        <form
                            method="post"
                            @submit.prevent="printprintStatisticalSummary"
                        >
                            <div class="md-layout-item md-small-size-50"></div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-field>
                                    <label>Prepared</label>
                                    <md-input
                                        v-model="prepared"
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
                                    <label>Prepared Position</label>
                                    <md-input
                                        v-model="preparedPosition"
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
                                    <label>Supervisor</label>
                                    <md-input
                                        v-model="supervisor"
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
                                    <label>Supervisor Position</label>
                                    <md-input
                                        v-model="supervisorPosition"
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
                                    <label>Supervisor Division</label>
                                    <md-input
                                        v-model="supervisorDivision"
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
    </div>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
import LogOut from "../../mixins/logOut.js";
import axios from "axios";

export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut],
    name: "StatisticalSummary",
    data() {
        return {
            isAuthenticated: true,
            prepared: null,
            preparedPosition: null,
            preparedDivision: null,
            supervisor: null,
            supervisorPosition: null,
            supervisorDivision: null,
        };
    },
    methods: {
        printprintStatisticalSummary() {
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
                    permission: "print service record",
                    model_name: {
                        prepared: this.prepared,
                        preparedPosition: this.prepared,
                        preparedDivision: this.preparedDivision,
                        supervisor: this.supervisor,
                        supervisorPosition: this.supervisorPosition,
                        supervisorDivision: this.supervisorDivision,
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
                        "/generate/report/1/single/ss/" +
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
