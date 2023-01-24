<template>
    <div class="content">
        <PreLoader v-if="pushingRequest"></PreLoader>
        <div class="md-layout" v-if="!pushingRequest">
            <div class="md-layout-item md-medium-size-100"></div>
            <div class="md-layout-item md-medium-size-100 login-form">
                <center>
                    <!-- <h3>This website is for staging purpose only. All data encoded here are for test purposes and are not considered factual nor accurate. If you wish to use the live site, please <a href='https://hris.dotr.gov.ph'>click here</a></h3> -->
                    <img :src="logo" width="200px;" />
                </center>
                <md-card class="">
                    <md-card-header class="md-card-header">
                        <h4 class="title">Approval / Rejection of Request</h4>
                    </md-card-header>
                    <md-card-content>
                        <div
                            v-if="isError"
                            class="
                                md-layout-item md-small-size-100 md-size-100
                                error
                            "
                        >
                            <label class="error"
                                >There is an error processing the request or the
                                token might be expired. Please try again.</label
                            >
                        </div>
                        <div
                            v-else
                            class="md-layout-item md-small-size-100 md-size-100"
                            style="margin-top: 20px"
                        >
                            <label>{{ msgSuccess }}</label>
                        </div>
                        <form
                            v-if="isDisapprove"
                            method="post"
                            @submit.prevent="disapproveRequest()"
                        >
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                "
                            >
                                <md-field>
                                    <label>Remarks</label>
                                    <md-input
                                        v-model="remarks"
                                        type="text"
                                        :disabled="rejectedSuccess"
                                    ></md-input>
                                </md-field>
                            </div>

                            <div>
                                <md-button
                                    class="md-raised md-success md-dense"
                                    type="submit"
                                    style="float: right"
                                    :disabled="rejectedSuccess"
                                >
                                    Reject Request</md-button
                                >
                            </div>
                        </form>
                    </md-card-content>
                </md-card>
            </div>
            <div class="md-layout-item md-medium-size-100"></div>
        </div>
    </div>
</template>

<script>
const PreLoader = () =>
    import(
        /* webpackChunkName: "PreLoader" */ "../../components/Preloader.vue"
    );

import logo from "../../assets/img/logo.png";
import SetBaseURL from "../../mixins/setBaseURL.js";
import axios from "axios";

export default {
    data() {
        return {
            logo: logo,
            pushingRequest: false,
            isError: false,
            isSuccess: false,
            msgSuccess: null,
            baseUrl: null,
            options: null,

            isDisapprove: false,
            rejectedSuccess: false,
            remarks: null,
            token: null,
        };
    },
    name: "RequestApprovalURI",
    components: {
        PreLoader,
    },
    methods: {
        async pushRequest(type, token) {
            this.token = token;
            this.pushingRequest = true;
            if (type === "approve") {
                this.options = {
                    method: "POST",
                    url: "/api/request/token/approve/" + token,
                    headers: { Accept: "application/json" },
                };

                await axios
                    .request(this.options)
                    .then((response) => {
                        console.log(response.data);
                        this.isSuccess = true;
                        this.msgSuccess = "Request has been approved.";
                    })
                    .catch((error) => {
                        console.error(error);
                        this.isError = true;
                    });
            } else {
                this.isDisapprove = true;
            }
            this.pushingRequest = false;
        },

        async disapproveRequest() {
            this.pushingRequest = true;

            this.options = {
                method: "POST",
                url: "/api/request/token/disapprove/" + this.token,
                headers: { Accept: "application/json" },
                data: { remarks: this.remarks },
            };

            await axios
                .request(this.options)
                .then((response) => {
                    console.log(response.data);
                    this.isSuccess = true;
                    this.rejectedSuccess = true;
                    this.msgSuccess = "Request has been rejected.";
                })
                .catch((error) => {
                    console.error(error);
                    this.isError = true;
                });
            this.pushingRequest = false;
        },
    },
    beforeCreate() {
        this.pushingRequest = true;
    },
    async created() {
        this.pushingRequest = false;
        // console.log(this.$route.query.type)
        let type = this.$route.query.type;
        let token = this.$route.query.token;
        console.log(type);
        console.log(token);
        if (window.location.hostname === "localhost") {
            // this.baseUrl = window.location.hostname + ':8000'
            this.baseUrl = "http://127.0.0.1:8000";
        } else {
            this.baseUrl = window.location.hostname;
        }
        await this.pushRequest(type, token);
    },
};
</script>
<style scoped>
.login-form {
    margin: auto !important;
    margin-top: 5% !important;
    /* width: 40% !important; */
    padding: 10px;
}
.error {
    color: red;
    margin-top: 1rem !important;
}
html.md-theme-default.body {
    background-color: #272727 !important;
}
html.md-theme-default {
    background-color: #272727 !important;
}
.md-card-header {
    background-color: #042278 !important;
}
</style>
