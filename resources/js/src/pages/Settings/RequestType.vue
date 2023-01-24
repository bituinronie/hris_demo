<template>
    <div>
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
        <md-card>
            <md-card-header class="md-card-header">
                <h4 class="title">Request Type</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <table
                            style="
                                margin-top: 30px !important;
                                margin-bottom: 30px !important;
                            "
                            class="zui-table"
                        >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Filing Period Type</th>
                                    <th>Filing Period Month</th>
                                    <th>Filing Period Days</th>
                                    <th>Request Limit Minimum</th>
                                    <th>Request Limit Maximum</th>
                                    <th>Category</th>
                                    <th>Based On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="r in requesTypes" :key="r.id">
                                    <td>{{ r.id }}</td>
                                    <td>{{ r.code }}</td>
                                    <td>{{ r.description }}</td>
                                    <td>{{ r.filing_period_type }}</td>
                                    <td>{{ r.filing_period_month }}</td>
                                    <td>{{ r.filing_period_days }}</td>
                                    <td>{{ r.request_limit_min }}</td>
                                    <td>{{ r.request_limit_max }}</td>
                                    <td>{{ r.category }}</td>
                                    <td>{{ r.based_on }}</td>
                                    <td>
                                        <md-button
                                            class="
                                                md-raised md-dense md-warning
                                            "
                                            style="color: black !important"
                                            @click="editRequestType(r.id)"
                                            v-if="
                                                $permissions.includes(
                                                    'write request type'
                                                )
                                            "
                                            >Edit</md-button
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- 
                        <md-table v-model="requesTypes" md-card>
                            <md-table-toolbar>
                                <h1 class="md-title">Request Types</h1>
                            </md-table-toolbar>

                            <md-table-row slot="md-table-row" slot-scope="{ item }">
                                <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                                <md-table-cell md-label="Description" md-sort-by="code">{{ item.code }}</md-table-cell>
                                <md-table-cell md-label="Filing Period Type" md-sort-by="filing_period_type">{{ item.filing_period_type }}</md-table-cell>
                                <md-table-cell md-label="Filing Period Month" md-sort-by="filing_period_month">{{ item.filing_period_month }}</md-table-cell>
                                <md-table-cell md-label="Filing Period Days" md-sort-by="filing_period_days">{{ item.filing_period_days }}</md-table-cell>
                                <md-table-cell md-label="Request Limit Minimum" md-sort-by="request_limit_min">{{ item.request_limit_min }}</md-table-cell>
                                <md-table-cell md-label="Request Limit Maximum" md-sort-by="request_limit_max">{{ item.request_limit_max }}</md-table-cell>
                                <md-table-cell md-label="Category" md-sort-by="category">{{ item.category }}</md-table-cell>
                                <md-table-cell md-label="Based On" md-sort-by="based_on">{{ item.based_on }}</md-table-cell>
                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-raised md-dense md-warning"
                                        style="color: black !important"
                                        @click="editRequestType(item.id)"
                                        >Edit</md-button
                                    >                                    
                                </md-table-cell>
                            </md-table-row>
                        </md-table>                         -->
                    </div>

                    <div class="md-layout-item md-size-100 text-right">
                        <label v-for="l in links" :key="l.label">
                            <md-button
                                class="button-paginate md-warning md-raised"
                                @click="getRequestTypeUsingLink(l.url)"
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
            </md-card-content>
        </md-card>
        <DialogCard v-if="isEditRequestType">
            <section slot="header">Edit Request Type</section>
            <section slot="body">
                <form>
                    <md-field>
                        <label>Code</label>
                        <md-input
                            v-model="requestType.code"
                            disabled
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Description</label>
                        <md-input v-model="requestType.description"></md-input>
                    </md-field>
                    <md-field>
                        <label>Filing Period Type</label>
                        <md-select v-model="requestType.filing_period_type">
                            <md-option value="BEFORE">BEFORE</md-option>
                            <md-option value="AFTER">AFTER</md-option>
                            <md-option value="EITHER">EITHER</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Filing Period Days</label>
                        <md-input
                            v-model="requestType.filing_period_days"
                            type="number"
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Request Limit Minimum</label>
                        <md-input
                            v-model="requestType.request_limit_min"
                            type="number"
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Request Limit Maximum</label>
                        <md-input
                            v-model="requestType.request_limit_max"
                            type="number"
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Category</label>
                        <md-select v-model="requestType.category">
                            <md-option value="LEAVES">LEAVES</md-option>
                            <md-option value="OB">OB</md-option>
                            <md-option value="OVERTIME">OVERTIME</md-option>
                        </md-select>
                    </md-field>
                    <md-field>
                        <label>Based On</label>
                        <md-select v-model="requestType.based_on">
                            <md-option value="SCHEDULE">SCHEDULE</md-option>
                            <md-option value="CALENDAR">CALENDAR</md-option>
                        </md-select>
                    </md-field>

                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary"
                            @click="updateRequestType"
                            :disabled="updatingRequestType"
                            >{{ btnMessage }}</md-button
                        >

                        <md-button
                            class="md-dense md-danger"
                            @click="isEditRequestType = false"
                            >Close</md-button
                        >
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
    </div>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );

import LogOut from "../../mixins/logOut.js";
import userAction from "../../mixins/userAction.js";

import axios from "axios";

export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    name: "RequestType",
    props: {
        dataBackgroundColor: {
            type: String,
        },
    },
    data: () => ({
        isAuthenticated: true,
        perPage: 10,
        fireSnackbar: false,
        messageSnackbar: null,

        requesTypes: null,
        links: null,
        isEditRequestType: false,
        requestType: {},

        updatingRequestType: false,
        btnMessage: "Update",
    }),
    methods: {
        //Get Request Type
        async getRequestType() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/request-type/search";

            const options = {
                method: "GET",
                url: baseUrl,
                params: { perPage: this.perPage },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            await axios
                .request(options)
                .then((response) => {
                    this.requesTypes = response.data.data;
                    this.links = response.data.links;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Edit Request Type
        async editRequestType(id) {
            this.isEditRequestType = !this.isEditRequestType;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/request-type/search/" + id;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };
            await axios
                .request(options)
                .then((response) => {
                    this.requestType = response.data;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Update Request Type
        async updateRequestType() {
            this.updatingRequestType = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl =
                baseUrl + "/api/request-type/update/" + this.requestType.id;

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    code: this.requestType.code,
                    description: this.requestType.description,
                    filing_period_type: this.requestType.filing_period_type,
                    filing_period_month: this.requestType.filing_period_month,
                    filing_period_days: this.requestType.filing_period_days,
                    request_limit_min: this.requestType.request_limit_min,
                    request_limit_max: this.requestType.request_limit_max,
                    category: this.requestType.category,
                    based_on: this.requestType.based_on,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Request Type updated successfully!";
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error updating the request type. Please try again";
                });
            await this.getRequestType();
            this.updatingRequestType = false;
            this.btnMessage = "Update";
            this.isEditRequestType = !this.isEditRequestType;
        },

        async getRequestTypeUsingLink(url) {
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

            await axios
                .request(options)
                .then((response) => {
                    this.requesTypes = response.data.data;
                    this.links = response.data.links;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },

    //Created
    async created() {
        await this.getRequestType();
    },
};
</script>
<style scoped>
.button-paginate {
    border: 0px !important;
    margin-left: 2px !important;
    margin-right: 2px !important;
    padding: 5px !important;
    max-width: 80px !important;
    min-width: 80px !important;
    font-size: 12px !important;
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

.zui-table {
    border: solid 1px #ddeeee;
    border-collapse: collapse;
    border-spacing: 0;
    font: normal 13px;
    width: 100% !important;
}
.zui-table thead th {
    border: solid 1px #ddeeee;
    color: rgb(0, 0, 0) !important;
    padding: 10px;
    text-align: left;
}
.zui-table tfoot th {
    border: solid 1px white;
    color: white !important;
    padding: 10px;
    text-align: left;
}
.zui-table tbody td {
    border: solid 1px #ddeeee;
    color: #333;
    padding: 10px;
}
</style>
