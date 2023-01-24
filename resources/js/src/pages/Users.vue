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
                        Username:
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
                    v-if="$permissions.includes('search user')"
                    >Users</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="isAddUser = !isAddUser"
                    v-if="!isAddUser && $permissions.includes('write user')"
                    >Add User</md-button
                >
            </div>
        </div>
        <AddUser v-if="isAddUser"></AddUser>
        <EditUser v-if="!isAddUser"></EditUser>
        <DialogCard v-if="userSearch">
            <section slot="header">Search Users</section>
            <section slot="body">
                <ListUser v-on:close-dialog="getNewlySelectedUser"></ListUser>
                <form>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-danger"
                            @click="searchUser"
                            >Close</md-button
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
const ListUser = () =>
    import(/* webpackChunkName: "ListUser" */ "../pages/Users/ListUser.vue");
const AddUser = () =>
    import(/* webpackChunkName: "AddUser" */ "../pages/Users/AddUser.vue");
const EditUser = () =>
    import(/* webpackChunkName: "EditUser" */ "../pages/Users/EditUser.vue");
import axios from "axios";
import UserAction from "../mixins/userAction.js";
// import ListUser from "../pages/Users/ListUser.vue";
// import AddUser from "../pages/Users/AddUser.vue";
// import EditUser from "../pages/Users/EditUser.vue";
// import DialogCard from "../components/Cards/DialogCard.vue";
import logOut from "../mixins/logOut.js";

export default {
    name: "Users",
    mixins: [UserAction, logOut],
    components: {
        ListUser,
        AddUser,
        EditUser,
        DialogCard,
    },
    data() {
        return {
            fullName: localStorage.getItem("selection_name_users"),
            userSearch: false,
            isAddUser: false,
            isAuthenticated: true,
        };
    },

    methods: {
        searchUser() {
            this.userSearch = !this.userSearch;
            this.isAddUser = false;
        },

        async getNewlySelectedUser() {
            this.searchUser();
            this.fullName = localStorage.getItem("selection_name_users");
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
        let searhUser = localStorage.getItem("search_user");
        if (searhUser === "0") {
            this.userSearch = true;
        } else {
            this.userSearch = false;
        }
        console.log(this.userSearch);
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
