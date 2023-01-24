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
                            fullName
                        }}</label>
                    </h5>
                </label> -->
            </div>
            <div class="md-layout-item md-small-size-100 md-size-75 text-right">
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="approveRequest = true"
                    v-if="!approveRequest"
                    :disabled="!hasApproverList"
                    >Approver Request</md-button
                >
                <md-button
                    class="md-primary md-dense md-raised"
                    @click="approveRequest = false"
                    v-else
                    >My Request</md-button
                >
            </div>
        </div>
        <PortalRequestEmployee v-if="!approveRequest"></PortalRequestEmployee>
        <RequestApproves v-else></RequestApproves>
    </div>
</template>

<script>
import UserAction from "../../mixins/userAction.js";
import axios from "axios";
// const UserAction = () =>
//     import(
//         /* webpackChunkName: "UserAction" */ "../mixins/userAction.js"
//     );

const PortalRequestEmployee = () =>
    import(
        /* webpackChunkName: "ScheduleEmployee" */ "./PortalRequestEmployee.vue"
    );
const RequestApproves = () =>
    import(
        /* webpackChunkName: "RequestApproves" */ "../Request/RequestApproves.vue"
    );
// const DialogCard = () =>
//     import(
//         /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
//     );
export default {
    name: "Request",
    mixins: [UserAction],
    components: {
        PortalRequestEmployee,
        RequestApproves,
        // DialogCard,
    },
    data() {
        return {
            fullName: localStorage.getItem("full_name"),
            empSearch: false,

            //Check Approvers
            approveRequest: false,

            //Setting
            hasApproverList: false,
        };
    },

    methods: {
        getMyRequest() {
            const empID = localStorage.getItem("accountId");
            this.$store.commit("changecurrentSelectionUserId", empID);
            this.$router.go();
        },

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

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.hasApproverList =
                        response.data.settings.hasApproverList;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },

    async created() {
        await this.hasApproverListMethod();
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
