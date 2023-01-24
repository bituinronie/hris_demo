<template>
    <div class="content">
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
        <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-25">
                <label v-if="isAddUser">
                    <h5>Add User</h5>
                </label>
                <label v-if="!isAddUser">
                    <h5>
                        <b>APPRAISALS: </b>
                        <label style="text-transform: uppercase !important">{{
                            fullName
                        }}</label>
                    </h5>
                </label>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-75 text-right">
                <!-- <md-button class="md-primary md-dense md-raised" @click="searchEmp" v-if="currentPage === 'schedule'">Attach Files</md-button> -->
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="searchUser"
                    >Search employee</md-button
                >
                <!-- <md-button
                    class="md-primary md-dense md-raised"
                    @click="isAddUser = !isAddUser"
                    v-if="!isAddUser"
                    >Add User</md-button
                > -->
            </div>
        </div>
        <AppraisalUser></AppraisalUser>
        <DialogCard v-if="userSearch">
            <section slot="header">Search Employee</section>
            <section slot="body">
                <ListAppraisalUsers
                    v-on:close-dialog="getNewlySelectedUser"
                ></ListAppraisalUsers>
                <form>
                    <md-dialog-actions>
                        <!-- <md-button
                            class="md-dense md-danger"
                            @click="searchUser"
                            >Close</md-button
                        > -->

                        <md-button
                            v-if="userSearch"
                            class="md-dense md-danger"
                            @click="goBack"
                            >Cancel</md-button
                        >
                        <md-button
                            v-else
                            class="md-dense md-danger"
                            @click="searchUser"
                            ><!-- ✕ -->Close</md-button
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
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
const ListAppraisalUsers = () =>
    import(
        /* webpackChunkName: "ListAppraisalUsers" */ "../pages/Appraisal/ListAppraisalUsers.vue"
    );

const AppraisalUser = () =>
    import(
        /* webpackChunkName: "AppraisalUser" */ "../pages/Appraisal/AppraisalUser.vue"
    );

import axios from "axios";
import UserAction from "../mixins/userAction.js";

import logOut from "../mixins/logOut.js";

export default {
    name: "Appraisal",
    mixins: [UserAction, logOut],
    components: {
        AppraisalUser,
        ListAppraisalUsers,
        DialogCard,
    },
    data() {
        return {
            fullName: localStorage.getItem("employee_name"),
            userSearch: false,
            isAddUser: false,
            isAuthenticated: true,
        };
    },

    methods: {
        goBack() {
            this.$router.push({ name: "Dashboard" });
        },
        searchUser() {
            this.userSearch = !this.userSearch;
            this.isAddUser = false;
        },

        async getNewlySelectedUser() {
            this.searchUser();
            this.fullName = localStorage.getItem("full_name");
            console.log(localStorage.getItem("full_name"));
            const userID = localStorage.getItem("user_id");
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/user/search/" + userID;

            const options = {
                method: "GET",
                url: baseUrl,
                params: { searchValue: "string" },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.getResp(options);
            this.$router.go();
        },

        //Axios Request
        async getResp(options) {
            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                    resp = error.response;
                });
            return resp;
        },
    },

    created() {
        let searchUser = localStorage.getItem("search_user");
        if (searchUser === "0") {
            this.userSearch = true;
        } else {
            this.userSearch = false;
        }
        // console.log(searchUser)
    },
};
</script>

<style scoped>
.emp-search {
    float: right;
}
.md-card-header {
    background-color: #042278 !important;
}
</style>
<style lang="scss" scoped>
.md-checkbox {
    display: flex;
}
</style>
