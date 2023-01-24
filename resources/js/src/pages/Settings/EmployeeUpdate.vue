<template>
    <form>
        <md-card>
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
            <md-dialog-alert
                :md-active.sync="isUpdated"
                :md-content="notificationMessage"
                md-confirm-text="Okay"
            />
            <md-card-header class="md-card-header">
                <h4 class="title">Employee Update</h4>
            </md-card-header>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-button
                            @click="editUpdateRange"
                            class="md-dense"
                            v-if="$permissions.includes('write setting')"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            ✎ Edit Update Range
                        </md-button>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <h5>Allow Editing of Employee Information</h5>
                        <h4><b>From:</b> {{ from }}</h4>
                        <h4><b>To:</b> {{ to }}</h4>
                    </div>
                </div>
            </md-card-content>
        </md-card>

        <!-- <DialogCard v-if="isAddDivision"> -->
        <DialogCard v-if="isEditUpdateRange">
            <section slot="header">Add Division</section>
            <section slot="body">
                <!-- <form
                    method="post"
                    @submit.prevent="validateLearningDevelopment"
                > -->
                <form method="post" @submit.prevent="validateDivision">
                    <md-datepicker
                        :md-model-type="String"
                        v-model="from"
                        label="Date of Birth"
                        ><label>Allow Update From</label>
                    </md-datepicker>
                    <md-datepicker
                        :md-model-type="String"
                        v-model="to"
                        label="Date of Birth"
                        ><label>Allow Update To</label>
                    </md-datepicker>

                    <md-dialog-actions>
                        <md-button
                            class="md-primary md-dense"
                            type="submit"
                            :disabled="isUpdating"
                            @click="updateRange"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            {{ btnMessage }}
                        </md-button>
                        <md-button
                            v-if="!isEdit"
                            class="md-dense"
                            @click="editUpdateRange"
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Close
                        </md-button>
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </form>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../../components/Cards/DialogCard.vue";
import LogOut from "../../mixins/logOut.js";
import axios from "axios";
export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut],
    name: "EmployeeUpdate",
    data: () => ({
        from: null,
        to: null,

        isEditUpdateRange: false,
        default: "",
        isUpdated: false,
        notificationMessage: null,
        isEdit: false,
        updateId: null,
        isAuthenticated: true,
        isUpdating: false,
        btnMessage: "Update Range",
    }),
    methods: {
        editUpdateRange() {
            this.isEditUpdateRange = !this.isEditUpdateRange;
            this.btnMessage = "Update Range";
            this.isUpdating = false;
        },

        async updateRange() {
            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/setting/UPDATE_EMPLOYEE";

            const options = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    value: {
                        from: this.from,
                        to: this.to,
                    },
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.editUpdateRange();
                    this.isUpdated = true;
                    this.notificationMessage = "Range has been updated!";
                })
                .catch((error) => {
                    console.error(error);
                    this.editUpdateRange();
                    this.notificationMessage =
                        "There is an error during updating of the date range.";
                });
        },

        async getCurrentRange() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/setting/UPDATE_EMPLOYEE";

            const options = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data.message);
                    this.from = response.data.message.from;
                    this.to = response.data.message.to;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
    },
    //Created
    async created() {
        await this.getCurrentRange();
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
