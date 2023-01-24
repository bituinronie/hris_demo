<template>
    <div>
        <md-card>
            <md-card-content>
                <div class="md-layout">
                    <div
                        class="md-layout-item md-small-size-100 md-size-100"
                    ></div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <h5>User Information</h5>
                        <md-field>
                            <label>Username</label>
                            <md-input
                                :disabled="!isEdit"
                                v-model="username"
                                type="text"
                            ></md-input>
                        </md-field>

                        <md-field>
                            <label>Email</label>
                            <md-input
                                :disabled="!isEdit"
                                v-model="email"
                                type="email"
                            ></md-input>
                        </md-field>
                        <md-field>
                            <label>Password</label>
                            <md-input
                                :disabled="!isEdit"
                                v-model="password"
                                type="password"
                            ></md-input>
                        </md-field>

                        <md-field>
                            <label>Role</label>
                            <md-select
                                :disabled="!isEdit"
                                @md-selected="changeRole"
                                v-model="role"
                                :required="true"
                            >
                                <md-option
                                    v-for="r in paramRole"
                                    :key="r.id"
                                    :value="r.name"
                                >
                                    {{ r.name }}
                                </md-option>
                            </md-select>
                        </md-field>

                        <label>Active</label><br />
                        <md-radio
                            :disabled="!isEdit"
                            v-model="isActive"
                            :value="true"
                            >Yes</md-radio
                        >
                        <md-radio
                            :disabled="!isEdit"
                            v-model="isActive"
                            :value="false"
                            >No</md-radio
                        >
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <h5>Permissions</h5>
                        <md-field>
                            <label>Select</label>
                            <md-select
                                :disabled="!isEdit"
                                v-model="tempPermission"
                            >
                                <md-option
                                    v-for="p in paramPermission"
                                    :key="p"
                                    :value="p"
                                >
                                    {{ p }}
                                </md-option>
                            </md-select>
                            <md-button
                                @click="addPermission"
                                class="md-raised md-warning md-dense"
                                style="color: black !important"
                                :disabled="!isEdit"
                                >Add Permission</md-button
                            >
                        </md-field>
                        <br />
                        <md-chips
                            :disabled="!isEdit"
                            :md-check-duplicated="true"
                            v-model="permissions"
                            class="md-primary"
                        >
                            <template
                                class="md-primary"
                                slot="md-chip"
                                slot-scope="{ chip }"
                            >
                                {{ chip }}
                            </template>
                        </md-chips>
                        <!-- <md-chip class="md-primary" md-deletable>Deletable</md-chip> -->
                    </div>
                    <div class="md-layout-item md-size-100 text-right">
                        <md-button
                            v-if="
                                !isEdit && $permissions.includes('write user')
                            "
                            class="md-raised md-warning md-dense"
                            style="color: black !important"
                            @click="isEdit = true"
                            :disabled="username === null"
                        >
                            Edit
                        </md-button>
                        <md-button
                            class="md-raised md-primary md-dense"
                            @click="validateUpdateUser"
                            :disabled="!isEdit"
                            v-if="$permissions.includes('write user')"
                        >
                            Update User
                        </md-button>
                    </div>
                </div>
            </md-card-content>
            <md-snackbar
                :md-position="'center'"
                :md-duration="2000"
                :md-active.sync="fireSnackBar"
                md-persistent
            >
                <span>{{ snackBarMessage }}</span>
                <md-button
                    class="md-warning md-dense"
                    @click="fireSnackBar = false"
                >
                    <label style="color: black">Dismiss</label>
                </md-button>
            </md-snackbar>
        </md-card>
    </div>
</template>
<script>
import axios from "axios";
import userAction from "../../mixins/userAction.js";

export default {
    emits: ["close-dialog"],
    name: "EditUser",
    mixins: [userAction],
    components: {
        // DialogCard
    },
    data() {
        return {
            username: null,
            email: null,
            password: null,
            isActive: true,
            role: null,
            permissions: [],
            paramRole: [],
            paramPermission: null,
            tempPermission: null,
            fireSnackBar: false,
            snackBarMessage: "",

            userID: localStorage.getItem("user_id"),
            isEdit: false,
        };
    },
    methods: {
        async validateUpdateUser() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/user/update/" + this.userID;

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    isActive: this.isActive,
                    role: this.role,
                    permissions: this.permissions,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log("update success!");
                    this.fireSnackbar = true;
                    this.snackBarMessage = "Updating of user success!";
                    console.log((this.fireSnackBar = true));
                })
                .catch((error) => {
                    this.fireSnackbar = true;
                    console.log((this.fireSnackBar = true));
                    this.snackBarMessage =
                        "There is an error updating the approvers. Please try again!";
                });
        },

        //Add Permission
        async addPermission() {
            if (this.permissions === null) {
                this.permissions = [this.tempPermission];
            } else {
                var checkExist = this.permissions.includes(this.tempPermission);
                if (!checkExist) {
                    this.permissions.push(this.tempPermission);
                } else {
                    this.fireSnackBar = true;
                    this.snackBarMessage = "Permission already exist!";
                }
            }
        },

        //Change User Role
        async changeRole() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/role/search/?searchValue=" + this.role;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer  " + getToken,
                },
            };

            let getResp = await this.callAxios(options);
            // console.log(getResp.data.data[0].permissions);
            this.permissions = getResp.data.data[0].permissions;
        },

        async getUserInformation() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/user/search/" + this.userID;

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.callAxios(options);
            console.log(resp);
            this.role = resp.data.role;
            this.username = resp.data.username;
            this.email = resp.data.email;
            this.isActive = resp.data.isActive;
            setTimeout(() => {
                this.permissions = resp.data.permissions;
                console.log("Set Permission");
            }, 1000);
        },

        //Get Param Roles
        async getParamRoles() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/role/search/";

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let getResp = await this.callAxios(options);
            this.paramRole = getResp.data.data;
        },

        //Get Param Permission
        async getParamPermissions() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/role/parameter/";

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let getResp = await this.callAxios(options);
            this.paramPermission = getResp.data.permissions;
            console.log(this.paramPermission);
        },

        //Call Axios
        async callAxios(options) {
            let resp;
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    resp = response;
                })
                .catch((error) => {
                    console.log(error.response);
                    resp = error;
                });
            return resp;
        },
    },
    async created() {
        await this.getParamRoles();
        await this.getParamPermissions();
        await this.getUserInformation();
    },
};
</script>
<style scoped>
.md-card-header {
    background-color: #042278 !important;
}
</style>
