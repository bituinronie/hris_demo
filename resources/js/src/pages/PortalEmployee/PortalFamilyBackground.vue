<template>
    <form method="post" @submit.prevent="updateFamilyBackground">
        <md-dialog-alert
            :md-active.sync="updated"
            :md-content="notificationMessage"
            md-confirm-text="Okay"
        />
        <md-card>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        Spouse
                    </div>
                    <!-- Surname -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Surname</label>
                            <md-input
                                v-model="spouseSurName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- First Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>First Name</label>
                            <md-input
                                v-model="spouseFirstName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Middle Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Middle Name</label>
                            <md-input
                                v-model="spouseMiddleName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Name Extentions -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Name Extension (Jr, Sr)</label>
                            <md-input
                                v-model="spouseNameExtension"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Occupation -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Occupation</label>
                            <md-input
                                v-model="spouseOccupation"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Employer / Business Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Employer / Business Name</label>
                            <md-input
                                v-model="spouseEmployer"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Business Address -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Business Address</label>
                            <md-input
                                v-model="spouseBusinessAddress"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Telephone Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Telephone Number</label>
                            <md-input
                                v-model="spouseTel"
                                type="number"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        Father's Full Name
                    </div>

                    <!-- Father Surname -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Surname</label>
                            <md-input
                                v-model="fatherSurName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Father First Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>First Name</label>
                            <md-input
                                v-model="fatherFirstName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Father Middle Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Middle Name</label>
                            <md-input
                                v-model="fatherMiddleName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Father Name Extentions -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Name Extension (Jr, Sr)</label>
                            <md-input
                                v-model="fatherNameExtension"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Mother -->
                    <div class="md-layout-item md-small-size-100 md-size-100">
                        Mother's Maiden Name
                    </div>

                    <!-- Mother Surname -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Surname</label>
                            <md-input
                                v-model="motherSurName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Mother First Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>First Name</label>
                            <md-input
                                v-model="motherFirstName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Mother Middle Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Middle Name</label>
                            <md-input
                                v-model="motherMiddleName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <!-- Children -->
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        <!-- <label>Children </label><br> -->
                        <md-table
                            v-if="children.length"
                            v-model="children"
                            md-sort-order="asc"
                            md-card
                        >
                            <md-table-toolbar>
                                <h1 class="md-title">Children</h1>
                                <br />
                            </md-table-toolbar>
                            <md-table-row
                                slot="md-table-row"
                                slot-scope="{ item }"
                            >
                                <!-- <md-table-cell md-label="ID" md-sort-by="item.id">{{ item.id }}</md-table-cell> -->
                                <md-table-cell
                                    md-label="Name"
                                    md-sort-by="name"
                                    >{{ item.name }}</md-table-cell
                                >
                                <md-table-cell
                                    md-label="Birthdate"
                                    md-sort-by="birth_date"
                                    >{{ item.birth_date }}</md-table-cell
                                >
                                <md-table-cell md-label="Actions">
                                    <md-button
                                        class="md-raised md-simple md-danger"
                                        @click="
                                            deleteChild(
                                                item.id,
                                                item.birth_date
                                            )
                                        "
                                        :disabled="isUpdateEmployee === 'false'"
                                    >
                                        <!-- <md-icon>delete</md-icon> -->
                                        Delete
                                        <md-tooltip md-direction="top"
                                            >Delete this record</md-tooltip
                                        >
                                    </md-button>
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                        <md-button
                            @click="addChildren"
                            class="md-dense"
                            :disabled="isUpdateEmployee === 'false'"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            Add Child</md-button
                        >
                    </div>

                    <div class="md-layout-item md-size-100 text-right">
                        <span v-if="isUpdateEmployee === 'false'"
                            >Updating of record is disabled.</span
                        >
                        <md-button
                            v-else
                            class="md-raised md-success"
                            type="submit"
                            :disabled="
                                isUpdating || isUpdateEmployee === 'false'
                            "
                        >
                            <!-- <md-icon>arrow_circle_up</md-icon> -->
                            <!-- Update Famile Background -->
                            {{ btnMessage }}</md-button
                        >
                    </div>
                </div>
            </md-card-content>
        </md-card>

        <DialogCard v-if="isAddChildren">
            <section slot="header">Add Children</section>
            <section slot="body">
                <form method="post" @submit.prevent="validateAddChild">
                    <md-field>
                        <label>Name</label>
                        <md-input
                            v-model="form.childrenName"
                            type="text"
                            required
                        ></md-input>
                    </md-field>
                    <md-datepicker
                        :md-model-type="String"
                        label="Date To"
                        v-model="form.birthDate"
                        required
                    >
                        <label v-if="!isError">Birth Date</label>
                        <span class="isError" v-else>Invalid Date</span>
                    </md-datepicker>

                    <md-dialog-actions>
                        <md-button
                            class="md-primary md-dense"
                            type="submit"
                            :disabled="isUpdating"
                        >
                            <!-- <md-icon>plus_one</md-icon> -->
                            Add {{ AddBtnMessage }}</md-button
                        >
                        <md-button class="md-dense" @click="addChildren">
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Close</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>
    </form>
</template>
<script>
import DialogCard from "../../components/Cards/DialogCard.vue";
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";
//import { v4 as uuidv4 } from 'uuid';
export default {
    components: {
        DialogCard,
    },
    name: "PortalFamilyBackground",
    mixins: [LogOut, userAction],
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            isError: false,
            isAddChildren: false,
            children: [],
            form: {
                childrenName: null,
                birthDate: null, //,
            },
            updated: false,
            notificationMessage: null,
            spouseSurName: "",
            spouseFirstName: "",
            spouseMiddleName: "",
            spouseNameExtension: "",
            spouseOccupation: "",
            spouseEmployer: "",
            spouseBusinessAddress: "",
            spouseTel: "",
            fatherSurName: "",
            fatherFirstName: "",
            fatherMiddleName: "",
            fatherNameExtension: "",
            motherSurName: "",
            motherFirstName: "",
            motherMiddleName: "",
            personalInformation: {},

            //Updating State
            isAuthenticated: true,
            isUpdating: false,
            btnMessage: "Update Family Background",
            AddBtnMessage: "Child",

            isUpdateEmployee: false,
        };
    },
    methods: {
        //Toggle Dialog Card
        async addChildren() {
            this.isAddChildren = !this.isAddChildren;
            this.AddBtnMessage = "Child";
            this.isUpdating = false;
        },
        //Add Children
        async validateAddChild() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/children/portal/create/";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    name: this.form.childrenName,
                    birth_date: this.form.birthDate,
                },
            };
            this.isUpdating = true;
            this.AddBtnMessage = "Adding...";
            await this.axiosRequest(options);

            // await this.getFamilyBackground();
            this.form.childrenName = null;
            this.form.birthDate = null;
            await this.addChildren();
            await this.getChildren();
        },

        //Get Family Background
        async getFamilyBackground() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/search/";
            //Start get family information
            const familyInformation = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(familyInformation)
                .then((response) => {
                    this.spouseSurName = response.data.spouse_last_name;
                    this.spouseFirstName = response.data.spouse_first_name;
                    this.spouseMiddleName = response.data.spouse_middle_name;
                    this.spouseNameExtension =
                        response.data.spouse_name_extension;
                    this.spouseOccupation = response.data.spouse_occupation;
                    this.spouseEmployer =
                        response.data.spouse_employer_business;
                    this.spouseBusinessAddress =
                        response.data.spouse_business_address;
                    this.spouseTel = response.data.spouse_telephone;
                    this.fatherSurName = response.data.father_last_name;
                    this.fatherFirstName = response.data.father_first_name;
                    this.fatherMiddleName = response.data.father_middle_name;
                    this.fatherNameExtension =
                        response.data.father_name_extension;
                    this.motherSurName = response.data.mother_last_name;
                    this.motherFirstName = response.data.mother_first_name;
                    this.motherMiddleName = response.data.mother_middle_name;
                    this.personalInformation = response.data;
                })
                .catch((error) => {
                    console.log("ERRRR: ", error.response.data);
                    if (error.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
            //End get family information
        },

        async getChildren() {
            //Try getting the children
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/children/portal/search/";
            const child = {
                method: "GET",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            let resp = await this.axiosRequest(child);
            this.children = resp;

            //End getting the children
        },

        //Start update family information
        async updateFamilyBackground() {
            this.isUpdating = true;
            this.btnMessage = "Updating...";
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update";
            //Start update family information
            const familyInformation = {
                method: "PUT",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    spouse_last_name: this.spouseSurName,
                    spouse_first_name: this.spouseFirstName,
                    spouse_middle_name: this.spouseMiddleName,
                    spouse_name_extension: this.spouseNameExtension,
                    spouse_occupation: this.spouseOccupation,
                    spouse_employer_business: this.spouseEmployer,
                    spouse_business_address: this.spouseBusinessAddress,
                    spouse_telephone: this.spouseTel,
                    father_last_name: this.fatherSurName,
                    father_first_name: this.fatherFirstName,
                    father_middle_name: this.fatherMiddleName,
                    father_name_extension: this.fatherNameExtension,
                    mother_last_name: this.motherSurName,
                    mother_first_name: this.motherFirstName,
                    mother_middle_name: this.motherMiddleName,
                    birth_date: this.personalInformation.birth_date,
                    gender: this.personalInformation.gender,
                    civil_status: this.personalInformation.civil_status,
                    email: this.personalInformation.email,
                    employee_number: this.personalInformation.employee_number,
                    first_name: this.personalInformation.first_name,
                    last_name: this.personalInformation.last_name,
                    isResetPassword: false,
                },
            };
            let resp = await this.axiosRequest(familyInformation);
            this.notificationMessage =
                resp === 422
                    ? "One or more errors in the fields."
                    : "Family Background has been updated.";
            await this.getFamilyBackground();
            this.updated = true;

            this.btnMessage = "Update Family Background";
            this.isUpdating = false;
            //End update family information
        },

        //Deleted Child
        async deleteChild(id, birthdate) {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl =
                this.baseUrl + "/api/employee/children/portal/delete/" + id;

            const options = {
                method: "DELETE",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await this.axiosRequest(options);
            await this.getChildren();
        },

        //Axios Request
        async axiosRequest(options) {
            let getResp;
            await axios
                .request(options)
                .then((response) => {
                    getResp = response.data.data;
                })
                .catch((error) => {
                    getResp = error.response.status;
                });
            return getResp;
        },
    },
    async mounted() {
        console.log(this.empSelectionID);
        await this.getFamilyBackground();
        await this.getChildren();
        this.isUpdateEmployee = localStorage.getItem("isUpdateEmployee");
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
.isError {
    color: red;
}
</style>
