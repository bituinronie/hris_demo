<template>
    <!-- <body> -->
    <div class="content">
        <PreLoader v-if="isAuthenticated"></PreLoader>
        <label v-if="!isAuthenticated">
            <div class="md-layout">
                <div class="md-layout-item md-medium-size-100"></div>
                <div class="md-layout-item md-medium-size-100 login-form">
                    <center>
                        <!-- <h3>This website is for staging purpose only. All data encoded here are for test purposes and are not considered factual nor accurate. If you wish to use the live site, please <a href='https://hris.dotr.gov.ph'>click here</a></h3> -->
                        <img :src="logo" width="200px;" />
                    </center>
                    <md-card class="">
                        <md-card-header class="md-card-header">
                            <h3 class="title">{{ appName }}</h3>
                            <h4 class="title">User Login</h4>
                        </md-card-header>
                        <md-card-content>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-100
                                    error
                                "
                            >
                                <label v-if="isError" class="error"
                                    >One or more fields are incorrect. Please
                                    try again.</label
                                >
                            </div>

                            <form
                                method="post"
                                @submit.prevent="authenticateUser"
                            >
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-100
                                    "
                                >
                                    <md-field>
                                        <label>Username</label>
                                        <md-input
                                            v-model="username"
                                            type="text"
                                        ></md-input>
                                    </md-field>
                                </div>
                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-100
                                    "
                                >
                                    <md-field>
                                        <label>Password</label>
                                        <md-input
                                            v-model="password"
                                            type="password"
                                        ></md-input>
                                    </md-field>
                                </div>
                                <div>
                                    <md-button
                                        class="md-raised md-success md-dense"
                                        type="submit"
                                        style="float: right"
                                        :disabled="isLoggingIn"
                                    >
                                        <!-- <md-icon>login</md-icon> -->
                                        {{ loginBtnMessage }}</md-button
                                    >
                                </div>

                                <div
                                    class="
                                        md-layout-item
                                        md-small-size-100
                                        md-size-100
                                    "
                                >
                                    <a
                                        @click="forgotPassword = true"
                                        style="float: left"
                                        >Forgot Password?</a
                                    >
                                </div>
                            </form>
                        </md-card-content>
                    </md-card>
                </div>
                <div class="md-layout-item md-medium-size-100"></div>
            </div>
            <div class="md-layout-item md-medium-size-100 privacy-policy">
                <center>
                    <p>
                        <a
                            target="_blank"
                            href="http://www.ots.gov.ph/images/notice/PrivacyNotice-12042020.pdf"
                            >PRIVACY POLICY</a
                        >
                    </p>
                </center>
            </div>
        </label>
        <DialogCard v-if="forgotPassword">
            <section slot="header">Request a new password</section>
            <section slot="body">
                <form @submit.prevent="sendForgotPassword">
                    <label class="text-danger">{{
                        forgotPasswordMessage
                    }}</label>
                    <md-field>
                        <label>Email Address</label>
                        <md-input
                            v-model="email"
                            type="email"
                            required
                        ></md-input>
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary"
                            type="submit"
                            :disabled="isSendingNewPass"
                        >
                            {{ sendNewPasswordBtn }}
                        </md-button>
                        <md-button
                            class="md-dense md-danger"
                            @click="forgotPassword = false"
                        >
                            Cancel
                        </md-button>
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </div>
    <!-- </body> -->
</template>

<script>
import axios from "axios";
// import DialogCard from "../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
//import {mapState} from 'vuex'
//import store from '../store.js';
const PreLoader = () =>
    import(/* webpackChunkName: "PreLoader" */ "../components/Preloader.vue");
// import PreLoader from "../components/Preloader.vue";
import SetBaseURL from "../mixins/setBaseURL.js";
import logo from "../assets/img/logo.png";
export default {
    // computed: mapState({
    //     label: state => state.userStatusAction
    // }),
    name: "Login",
    components: {
        PreLoader,
        DialogCard,
    },
    data() {
        return {
            logo: logo,
            username: "",
            password: "",
            isAuthenticated: false,
            isLoggingIn: false,
            isError: false,
            message: null,
            //The base URL storage can be found below before Mount
            baseUrl: null,
            loginBtnMessage: "Log in",
            email: null,
            forgotPassword: false,
            forgotPasswordMessage: null,
            sendNewPasswordBtn: "Send New Password",
            isSendingNewPass: false,
            appName: localStorage.getItem("app_name"),
        };
    },
    methods: {
        //Send new password using the email
        async sendForgotPassword() {
            this.isSendingNewPass = true;
            this.sendNewPasswordBtn = "Sending...";
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/forgot-password/send";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                data: {
                    email: this.email,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.forgotPasswordMessage = response.data.message;
                    // this.forgotPassword = false
                })
                .catch((error) => {
                    console.error(error.response);
                    this.forgotPasswordMessage = error.response.data.message;
                });

            this.sendNewPasswordBtn = "Send New Password";
            this.isSendingNewPass = false;
        },

        //Login user
        async authenticateUser() {
            this.isLoggingIn = true;
            this.loginBtnMessage = "Logging in";
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/auth/login/";
            const response = await axios
                .post(this.baseUrl, {
                    username: this.username,
                    password: this.password,
                })
                .then((response) => {
                    this.isAuthenticated = true;
                    localStorage.setItem("token", response.data.access_token);
                    this.isError = false;
                    this.username = "";
                    this.password = "";

                    //Set Search user to false initially
                    localStorage.setItem("search_user", "0");
                    setTimeout(() => {
                        localStorage.setItem("refreshCounter", "0");
                        this.$router.push({ name: "Dashboard" });
                    }, 200);

                    //Set initial search schedule
                    localStorage.setItem("search_user_schedule", "0");
                    localStorage.setItem("search_user_history", "0");
                    localStorage.setItem("search_user_employee", "0");
                    localStorage.setItem("search_user_request", "0");
                })
                .catch((error) => {
                    this.isError = true;
                    this.isLoggingIn = false;
                    this.loginBtnMessage = "Log in";
                    console.log(error);
                });
        },
    },
    mixins: [SetBaseURL],
};
</script>

<style scoped>
.login-form {
    margin: auto !important;
    margin-top: 5% !important;
    /* width: 40% !important; */
    padding: 10px;
}
.privacy-policy {
    margin-top: 10% !important;
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
.error {
    color: red;
    margin-top: 1rem !important;
}
</style>
