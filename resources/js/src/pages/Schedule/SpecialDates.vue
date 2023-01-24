<template>
    <md-card>
        <DialogCard v-if="!isAuthenticated">
            <section slot="body">
                Oops. Session expired. Please relogin.
                <md-dialog-actions>
                    <md-button
                        class="md-primary md-dense md-raised"
                        @click="logOut"
                        >Confirm</md-button
                    >
                </md-dialog-actions>
            </section>
        </DialogCard>
        <md-card-header class="md-card-header">
            <h4 class="title">Holidays / Special Dates</h4>
            <!-- <p class="category">Complete the employee's profile</p> -->
        </md-card-header>
        <md-card-content>
            <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-button
                        @click="addSpecialDate"
                        class="md-dense md-raised"
                        v-if="$permissions.includes('write special date')"
                    >
                        Add Holiday / Special Date</md-button
                    >
                </div>

                <div class="md-layout-item md-size-100">
                    <md-table
                        v-model="specialDates"
                        md-sort="reference_date"
                        md-sort-order="asc"
                    >
                        <md-table-toolbar>
                            <!-- <h1 class="md-title">Add Holiday / Special Date</h1> -->
                        </md-table-toolbar>
                        <md-table-row slot="md-table-row" slot-scope="{ item }">
                            <md-table-cell
                                md-label="Reference Date"
                                md-sort-by="reference_date"
                                >{{ item.reference_date }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Reference Time"
                                md-sort-by="reference_time"
                                >{{ item.reference_time }}</md-table-cell
                            >
                            <md-table-cell md-label="Type" md-sort-by="type">{{
                                item.type
                            }}</md-table-cell>
                            <md-table-cell
                                md-label="Description"
                                md-sort-by="description"
                                >{{ item.description }}</md-table-cell
                            >
                            <md-table-cell
                                v-if="item.employee_group != null"
                                md-label="Employee Group"
                                md-sort-by="employee_group.name"
                                >{{ item.employee_group.name }}</md-table-cell
                            >
                            <md-table-cell
                                v-else
                                md-label="Employee Group"
                                md-sort-by="employee_group"
                                >{{ item.employee_group }}</md-table-cell
                            >
                            <md-table-cell
                                md-label="Fixed"
                                md-sort-by="is_fixed"
                            >
                                <label v-if="item.is_fixed">Yes</label>
                                <label v-else>No</label>
                            </md-table-cell>
                            <md-table-cell
                                md-label="Required"
                                md-sort-by="is_required"
                            >
                                <label v-if="item.is_required">Yes</label>
                                <label v-else>No</label>
                            </md-table-cell>

                            <md-table-cell
                                md-label="Actions"
                                md-sort-by="actions"
                            >
                                <md-button
                                    class="md-raised md-dense md-primary"
                                    @click="editHolidayAndSpecialDate(item.id)"
                                    :disabled="item.isDeleted"
                                    v-if="
                                        $permissions.includes(
                                            'write special date'
                                        )
                                    "
                                >
                                    ✎
                                    <md-tooltip md-direction="top"
                                        >Edit this record.</md-tooltip
                                    >
                                </md-button>
                                <md-button
                                    class="md-raised md-dense md-danger"
                                    @click="
                                        deleteHolidayAndSpecialDate(item.id)
                                    "
                                    :disabled="item.isDeleted"
                                    v-if="
                                        $permissions.includes(
                                            'delete special date'
                                        )
                                    "
                                >
                                    ⌫
                                    <md-tooltip md-direction="top"
                                        >Delete this record.</md-tooltip
                                    >
                                </md-button>
                                <md-button
                                    class="md-dense md-warning"
                                    :disabled="!item.isDeleted"
                                    @click="
                                        restoreHolidayAndSpecialDate(item.id)
                                    "
                                    v-if="
                                        $permissions.includes(
                                            'restore special date'
                                        )
                                    "
                                >
                                    <label style="color: black !important"
                                        >⟳</label
                                    >
                                    <!-- Restore -->
                                    <md-tooltip md-direction="top"
                                        >Restore this record</md-tooltip
                                    >
                                </md-button>
                            </md-table-cell>
                        </md-table-row>
                    </md-table>
                </div>

                <DialogCard v-if="isAddSpecialDate">
                    <section slot="header">Add Holiday / Special Date</section>
                    <section slot="body">
                        <form
                            method="post"
                            @submit.prevent="validateAddSpecialDate"
                        >
                            <i>Time Format: Military Time (ex. 17:00:00)</i>
                            <md-field style="margin-top: 20px !important">
                                <label>Type</label>
                                <md-select v-model="type" required>
                                    <md-option value="SPECIAL"
                                        >Special
                                    </md-option>
                                    <md-option value="LEGAL">Legal </md-option>
                                    <md-option value="SUSPENSION"
                                        >Suspension</md-option
                                    >
                                    <md-option value="FLAG_CEREMONY"
                                        >Flag Ceremony
                                    </md-option>
                                </md-select>
                            </md-field>

                            <md-datepicker
                                :md-model-type="String"
                                label="To"
                                v-model="reference_date"
                                md-immediately
                            >
                                <label>Reference Date</label>
                            </md-datepicker>

                            <md-field>
                                <label>Reference Time</label>
                                <md-input
                                    v-model="reference_time"
                                    required
                                    maxlength="8"
                                    minlength="8"
                                ></md-input>
                            </md-field>
                            <md-field>
                                <label>Group</label>
                                <md-select v-model="employee_group_id" required>
                                    <md-option
                                        v-for="g in groups"
                                        :key="g.id"
                                        :value="g.id"
                                        >{{ g.code }}</md-option
                                    >
                                </md-select>
                            </md-field>
                            <!-- <md-autocomplete
                                v-model="employee_group_id"
                                :md-options="groups"
                                required
                            >
                                <label>Group</label>
                            </md-autocomplete> -->
                            <md-field>
                                <label>Description</label>
                                <md-input
                                    v-model="description"
                                    required
                                ></md-input>
                            </md-field>
                            <md-checkbox v-model="is_fixed">Fixed </md-checkbox>
                            <md-checkbox v-model="is_required"
                                >Required
                            </md-checkbox>
                            <md-checkbox v-model="use_description"
                                >Use Description
                            </md-checkbox>
                            <md-dialog-actions>
                                <md-button
                                    v-if="!isEdit"
                                    class="md-dense md-primary"
                                    type="submit"
                                    :disabled="isAdding"
                                >
                                    {{ msgButton }}
                                </md-button>

                                <md-button
                                    v-else
                                    class="md-dense md-primary"
                                    @click="updateHolidayOrSpecialDate"
                                    :disabled="isAdding"
                                >
                                    {{ msgButton }}
                                </md-button>
                                <md-button
                                    class="md-dense"
                                    @click="addSpecialDate"
                                >
                                    <!-- <md-icon>close</md-icon> -->
                                    ✕ Close</md-button
                                >
                            </md-dialog-actions>
                        </form>
                    </section>
                </DialogCard>
            </div>
        </md-card-content>
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
    </md-card>
</template>
<script>
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );
// import DialogCard from "../../components/Cards/DialogCard.vue";
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";
export default {
    components: {
        DialogCard,
    },
    mixins: [LogOut, userAction],
    name: "SpecialDate",
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data: () => ({
        //Snackkbar
        fireSnackbar: false,
        messageSnackbar: "Sample",

        msgButton: "Add Holiday / Special date",
        isAdding: false,
        isEdit: false,
        updateID: null,
        specialDates: [],
        isAuthenticated: true,
        isAddSpecialDate: false,
        type: "SPECIAL",
        reference_date: null,
        reference_time: null,
        groups: [],
        employee_group_id: null,
        description: null,
        is_fixed: true,
        is_required: true,
        use_description: true,
    }),
    methods: {
        //Add Special Date
        addSpecialDate() {
            this.resetData();
            this.isEdit = false;
            this.isAdding = false;
            this.msgButton = "Add Holiday / Special Date";
            this.isAddSpecialDate = !this.isAddSpecialDate;
        },
        async validateAddSpecialDate() {
            this.isAdding = true;
            this.msgButton = "Adding...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-date/create";

            const options = {
                method: "POST",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    reference_date: this.reference_date,
                    reference_time: this.reference_time,
                    type: this.type,
                    description: this.description,
                    employee_group_id: this.employee_group_id,
                    is_fixed: this.is_fixed,
                    is_required: this.is_required,
                    use_description: this.use_description,
                },
            };
            let resp = await this.getResp(options);
            await this.getSpecialDateAndHoliday();

            this.isAddSpecialDate = !this.isAddSpecialDate;
            this.isAdding = false;
            this.msgButton = "Add Holiday / Special date";
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been added";
            this.resetData();
        },

        //Edit Special Date
        async editHolidayAndSpecialDate(id) {
            this.addSpecialDate();
            this.isEdit = true;
            this.msgButton = "Update Holiday / Special Date";
            this.updateID = id;
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-date/search/" + this.updateID;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.getResp(options);
            this.type = resp.data.type;
            this.reference_date = resp.data.reference_date;
            this.reference_time = resp.data.reference_time;
            if (resp.data.employee_group === null) {
                //Do nothing
            } else {
                this.employee_group_id =
                    resp.data.employee_group.employee_group_id;
            }
            this.description = resp.data.description;
            this.is_fixed = resp.data.is_fixed;
            this.use_description = resp.data.use_description;
            this.is_required = resp.data.is_required;
        },

        //uUpdate Special Date
        async updateHolidayOrSpecialDate() {
            this.isAdding = true;
            this.msgButton = "Updating...";
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-date/update/" + this.updateID;
            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    reference_date: this.reference_date,
                    reference_time: this.reference_time,
                    type: this.type,
                    description: this.description,
                    employee_group_id: this.employee_group_id,
                    is_fixed: this.is_fixed,
                    is_required: this.is_required,
                    use_description: this.use_description,
                },
            };

            let resp = await this.getResp(options);
            await this.getResp();
            await this.getSpecialDateAndHoliday();
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been updated";
            this.addSpecialDate();
        },

        //Delete Special Date
        async deleteHolidayAndSpecialDate(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-date/delete/" + id;

            const options = {
                method: "DELETE",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.getResp(options);
            await this.getSpecialDateAndHoliday();
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been deleted";
        },

        //Restore Special Date
        async restoreHolidayAndSpecialDate(id) {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-date/restore/" + id;

            const options = {
                method: "POST",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.getResp(options);
            await this.getSpecialDateAndHoliday();
            this.fireSnackbar = true;
            this.messageSnackbar = "Record has been restored";
        },

        //Get Special Date and Holiday
        async getSpecialDateAndHoliday() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/special-date/search?perPage=50";

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let response = await this.getResp(options);
            console.log(response.data.data);
            this.specialDates = response.data.data;
        },

        //Get Group
        async getGroup() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/employee-group/search";

            const options = {
                method: "GET",
                params: {perPage: '1000'},
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.getResp(options);
            this.groups = resp.data.data;
        },

        async getResp(options) {
            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.log(error);
                    resp = error.response;
                });
            return resp;
        },

        resetData() {
            this.reference_date = null;
            this.reference_time = null;
            this.type = "SPECIAL";
            this.description = null;
            this.employee_group_id = null;
            this.is_fixed = true;
            this.is_required = true;
            this.use_description = true;
        },
    },

    async mounted() {
        await this.getSpecialDateAndHoliday();
        await this.getGroup();
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
