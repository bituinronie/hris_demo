<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-25">
                <!-- <label
                    v-if="userAction === 'emp_selected'"
                > -->
                <!-- <label>
                    <h5>
                        Request for:
                        <label style="text-transform: uppercase !important">{{
                            empSelectionName
                        }}</label>
                    </h5>
                </label> -->
            </div>
            <div class="md-layout-item md-small-size-100 md-size-75 text-right">
                <!-- <md-button class="md-primary md-dense md-raised" @click="searchEmp" v-if="currentPage === 'schedule'">Attach Files</md-button> -->
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="searchEmp"
                    v-if="$permissions.includes('search request')"
                    >Search Employee Request</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="getApprovers()"
                    :disabled="showApproverRequests"
                    v-if="hasApproverList"
                    >Approver Request</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="getMyRequest()"
                    :disabled="showMyRequest"
                    v-if="
                        hasApproverList ||
                        $permissions.includes('search request')
                    "
                    >My Request</md-button
                >
            </div>
        </div>
        <RequestEmployee :key="empSelectionID" v-if="showEmployeeRequests">
        </RequestEmployee>
        <RequestApproves v-if="showApproverRequests">></RequestApproves>
        <!-- <RequestEmployee v-if="showEmployeeRequests">
        </RequestEmployee>         -->
        <PortalRequestEmployee v-if="showMyRequest"> </PortalRequestEmployee>
        <DialogCard v-if="empSearch">
            <section slot="header">Search Employee Request</section>
            <section slot="body">
                <ListEmployee
                    :module="
                        $permissions.includes('search request')
                            ? 'request'
                            : null
                    "
                    v-on:close-dialog="getNewlySelectedEmployee"
                ></ListEmployee>
                <form>
                    <md-dialog-actions>
                        <md-button class="md-dense md-danger" @click="searchEmp"
                            >Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </div>
</template>

<script>
import UserAction from "../mixins/userAction.js";
// const UserAction = () =>
//     import(
//         /* webpackChunkName: "UserAction" */ "../mixins/userAction.js"
//     );
const RequestEmployee = () =>
    import(
        /* webpackChunkName: "RequestEmployee" */ "../pages/Request/RequestEmployee.vue"
    );

const RequestApproves = () =>
    import(
        /* webpackChunkName: "RequestApproves" */ "../pages/Request/RequestApproves.vue"
    );

const PortalRequestEmployee = () =>
    import(
        /* webpackChunkName: "PortalRequestEmployee" */ "../pages/PortalRequest/PortalRequestEmployee.vue"
    );
const ListEmployee = () =>
    import(
        /* webpackChunkName: "ListEmployee" */ "../pages/Employee/ListEmployee.vue"
    );
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../components/Cards/DialogCard.vue";
import axios from "axios";
export default {
    name: "Request",
    mixins: [UserAction],
    components: {
        ListEmployee,
        RequestEmployee,
        PortalRequestEmployee,
        DialogCard,
        RequestApproves,
    },
    data() {
        return {
            empSearch: false,

            // Requests Table
            showEmployeeRequests: false,
            showApproverRequests: false,
            showMyRequest: true,

            //Setting
            hasApproverList: false,
            role: null,
        };
    },

    methods: {
        //Check if it has approver lists
        async hasApproverListMethod() {
            let baseUrl = localStorage.getItem("base_url");
            let getToken = localStorage.getItem("token");

            const options = {
                method: "GET",
                url: baseUrl + "/api/auth",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.hasApproverList =
                        response.data.settings.hasApproverList;
                    //Delete Later
                    // this.hasApproverList = true
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        //Get My Request
        getMyRequest() {
            // const empID = localStorage.getItem("accountId");
            // this.$store.commit("changecurrentSelectionUserId", empID);
            // this.$store.commit(
            //     "changeCurrentSelectionUserName",
            //     this.fullName
            // );
            // this.$router.go();
            localStorage.setItem("search_user_request", "0");
            this.showMyRequest = true;
            this.showEmployeeRequests = false;
            this.showApproverRequests = false;
        },
        getApprovers() {
            this.showApproverRequests = true;
            this.showMyRequest = false;
            this.showEmployeeRequests = false;
        },
        searchEmp() {
            this.empSearch = !this.empSearch;
        },
        getNewlySelectedEmployee() {
            // this.empSearch = !this.empSearch;
            // this.showMyRequest = false;
            // this.showEmployeeRequests = true;
            // this.showApproverRequests = false;
            localStorage.setItem("search_user_request", "1");
            this.$router.go()
        },
    },
    mounted: function () {
        // if (this.empSelectionID != localStorage.getItem("accountId")) {
        //     this.$router.go()
        // }
        
    },

    async created() {
        this.hasApproverListMethod();
        if (localStorage.getItem("search_user_request") === "1") {
            this.showMyRequest = false;
            this.showEmployeeRequests = true;
            this.showApproverRequests = false;
        }
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
