<template>
    <form method="post" @submit.prevent="savePersonalInformation">
        <md-dialog-alert
            :md-active.sync="saved"
            :md-content="notificationMessage"
            md-confirm-text="Okay"
        />
        <md-card>
            <!-- <md-card-header :data-background-color="dataBackgroundColor"> -->
            <md-card-content>
                <div class="md-layout">
                    <!-- Employee Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Agency Employee ID</label>
                            <md-input
                                v-model="empNumber"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                                required
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Employee Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Email Address</label>
                            <md-input
                                v-model="email"
                                type="email"
                                :disabled="isUpdateEmployee === 'false'"
                                required
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Surname -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Surname</label>
                            <md-input
                                v-model="surName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                                required
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Firt Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>First Name</label>
                            <md-input
                                v-model="firstName"
                                type="text"
                                required
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Middle Name -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Middle Name</label>
                            <md-input
                                v-model="middleName"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Name Extentions -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Name Extension (Jr, Sr)</label>
                            <md-select
                                v-model="nameExtension"
                                :disabled="isUpdateEmployee === 'false'"
                            >
                                <md-option value=""> N/A </md-option>
                                <md-option
                                    v-for="ne in getParam.data.name_extension"
                                    :key="ne"
                                    :value="ne"
                                >
                                    {{ ne }}
                                </md-option>
                            </md-select>
                            <!-- <md-input
                                v-model="nameExtension"
                                type="text"
                            ></md-input> -->
                        </md-field>
                    </div>

                    <!-- Telephone Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Telephone Number</label>
                            <md-input
                                v-model="telNum"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Mobile Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Mobile Number</label>
                            <md-input
                                v-model="mobNum"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Group -->
                    <!-- <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Group</label>
                            <md-select v-model="group" :disabled="isUpdateEmployee === 'false'">
                                <md-option value="group-1">Group 1</md-option>
                            </md-select>
                        </md-field>
                    </div> -->

                    <!-- Agency Employee ID -->
                    <!-- <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Agency Employee ID</label>
                            <md-input v-model="agencyId" type="text" :disabled="isUpdateEmployee === 'false'"></md-input>
                        </md-field>
                    </div> -->

                    <!-- Date of Birth -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-datepicker
                            :md-model-type="String"
                            label="Date of Birth"
                            v-model="dob"
                            :disabled="isUpdateEmployee === 'false'"
                            ><label>Date of Birth</label></md-datepicker
                        >
                        <!-- <md-field>
                            <label class="dob">Date of Birth</label>
                            <md-input v-model="dob" type="date" required></md-input>
                        </md-field> -->
                    </div>

                    <!-- Place of Birth -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Place of Birth</label>
                            <md-input
                                v-model="pob"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Citizenship -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Citizenship</label>
                            <md-select
                                v-model="citizenship"
                                :disabled="isUpdateEmployee === 'false'"
                            >
                                <md-option
                                    v-for="c in getParam.data.citizenship"
                                    :key="c"
                                    :value="c"
                                >
                                    {{ c }}
                                </md-option>
                            </md-select>
                            <!-- <md-select v-model="citizenship" required>
                                <md-option value="filipino">Filipino</md-option>
                            </md-select> -->
                        </md-field>
                    </div>

                    <!-- Country of Citizenship -->
                    <div
                        class="md-layout-item md-small-size-100 md-size-50"
                        v-if="citizenship === 'DUAL_CITIZEN'"
                    >
                        <md-field>
                            <label>Country of Citizenship</label>
                            <md-input
                                v-model="citizenship_by_country"
                            ></md-input>
                        </md-field>
                    </div>
                    <!-- Citizenship by -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Citizenship by</label>
                            <md-select
                                v-model="citizenshipBy"
                                :disabled="isUpdateEmployee === 'false'"
                            >
                                <md-option
                                    v-for="c in getParam.data.citizenship_by"
                                    :key="c"
                                    :value="c"
                                >
                                    {{ c }}
                                </md-option>
                            </md-select>
                            <!-- <md-select v-model="citizenshipBy" required>
                                <md-option value="naturalBorn"
                                    >Natural Born</md-option
                                >
                            </md-select> -->
                        </md-field>
                    </div>

                    <!-- Gender -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Gender</label>
                            <md-select
                                v-model="gender"
                                :disabled="isUpdateEmployee === 'false'"
                            >
                                <md-option
                                    v-for="g in getParam.data.gender"
                                    :key="g"
                                    :value="g"
                                >
                                    {{ g }}
                                </md-option>
                            </md-select>
                            <!-- <md-select v-model="gender" required>
                                <md-option value="male">Male</md-option>
                                <md-option value="female">Female</md-option>
                                <md-option value="na"
                                    >Prefer not to say</md-option
                                >
                            </md-select> -->
                        </md-field>
                    </div>

                    <!-- Civil Status -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Civil Status</label>
                            <md-select
                                v-model="civilStatus"
                                :disabled="isUpdateEmployee === 'false'"
                            >
                                <md-option
                                    v-for="cv in getParam.data.civil_status"
                                    :key="cv"
                                    :value="cv"
                                >
                                    {{ cv }}
                                </md-option>
                            </md-select>
                            <!-- <md-select v-model="civilStatus" required>
                                <md-option value="single">Single</md-option>
                                <md-option value="married">Married</md-option>
                                <md-option value="widowed">Widowed</md-option>
                                <md-option value="widower">Widower</md-option>
                            </md-select> -->
                        </md-field>
                    </div>

                    <!-- Civil Status Others -->
                    <div
                        class="md-layout-item md-small-size-100 md-size-50"
                        v-if="civilStatus === 'OTHERS'"
                    >
                        <md-field>
                            <label>Civil Status: Others</label>
                            <md-input v-model="civil_status_others"></md-input>
                        </md-field>
                    </div>

                    <!-- Height in meters -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Height meters (m)</label>
                            <md-input
                                v-model="heightInM"
                                @input="computeUnitHeight"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>
                    <!-- Height in foot and inches -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Height feet (ft)</label>
                            <md-input
                                v-model="heightInFeet"
                                type="number"
                                disabled
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Height in foot and inches -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Height inches (inch)</label>
                            <md-input
                                v-model="heightInInches"
                                type="number"
                                disabled
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Blood Type -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Blood Type</label>
                            <md-select
                                v-model="bloodType"
                                :disabled="isUpdateEmployee === 'false'"
                            >
                                <md-option
                                    v-for="bt in getParam.data.blood_type"
                                    :key="bt"
                                    :value="bt"
                                >
                                    {{ bt }}
                                </md-option>
                            </md-select>
                            <!-- <md-select v-model="bloodType" required>
                                <md-option value="o+">O+</md-option>
                                <md-option value="o-">O-</md-option>
                            </md-select> -->
                        </md-field>
                    </div>

                    <!-- Weight in kilograms -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Weight in kilograms (kg)</label>
                            <md-input
                                v-model="weightKg"
                                @input="computeWeight"
                                type="number"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Weight in Pounds -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Weight in pounds (lbs)</label>
                            <md-input
                                v-model="weightLbs"
                                type="number"
                                disabled
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- GSID ID Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>GSID ID Number</label>
                            <md-input
                                v-model="gsis"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- PHILHEALTH Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>PHILHEALTH Number</label>
                            <md-input
                                v-model="philHealth"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- TIN Number -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>TIN Number</label>
                            <md-input
                                v-model="tinNumber"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- PAGIBIG -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>PAGIBIG</label>
                            <md-input
                                v-model="pagibig"
                                type="text"
                                :disabled="isUpdateEmployee === 'false'"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- SSS -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>SSS</label>
                            <md-input
                                v-model="sss"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        Residential Address
                    </div>

                    <!-- Province -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Province</label>
                            <md-input
                                v-model="residential_province"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- City -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>City</label>
                            <md-input
                                v-model="residential_city"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Barangay -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Barangay</label>
                            <md-input
                                v-model="residential_barangay"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Subdivision -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Subdivision</label>
                            <md-input
                                v-model="residential_subdivision"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Street -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Street</label>
                            <md-input
                                v-model="residential_street"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- House No. -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>House No.</label>
                            <md-input
                                v-model="residential_housenum"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Zip Code -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Zip Code</label>
                            <md-input
                                v-model="residential_zipcode"
                                type="number"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-100">
                        Permanent Address<br />
                        <md-button @click="sameAsResidential" class="md-dense"
                            >Same as Residential Address</md-button
                        >
                    </div>

                    <!-- Province -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Province</label>
                            <md-input
                                v-model="permanent_province"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- City -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>City</label>
                            <md-input
                                v-model="permanent_city"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Barangay -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Barangay</label>
                            <md-input
                                v-model="permanent_barangay"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Subdivision -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Subdivision</label>
                            <md-input
                                v-model="permanent_subdivision"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Street -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Street</label>
                            <md-input
                                v-model="permanent_street"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- House No. -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>House No.</label>
                            <md-input
                                v-model="permanent_housenum"
                                type="text"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <!-- Zip Code -->
                    <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-field>
                            <label>Zip Code</label>
                            <md-input
                                v-model="permanent_zipcode"
                                type="number"
                                :disabled="empSelected"
                            ></md-input>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-size-100 text-right">
                        <span v-if="isUpdateEmployee === 'false'"
                            >Updating of record is disabled.</span
                        >
                        <md-button
                            v-else
                            @click="updatePersonalInformation"
                            class="md-raised md-success md-dense"
                            :disabled="isSaving || isUpdateEmployee === 'false'"
                        >
                            {{ btnMessage }}
                        </md-button>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </form>
</template>
<script>
import axios from "axios";
import userAction from "../../mixins/userAction.js";
import LogOut from "../../mixins/logOut.js";

export default {
    mixins: [userAction, LogOut],
    name: "PortalPersonalInformation",
    props: {
        dataBackgroundColor: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            isUpdateEmployee: false,
            empNumber: "",
            surName: "",
            firstName: "",
            middleName: "",
            nameExtension: "",
            group: "",
            agencyId: "",
            dob: null,
            pob: "",
            citizenshipBy: "BIRTH",
            gender: "MALE",
            civilStatus: "SINGLE",
            heightInM: "",
            heightInFeet: "",
            heightInInches: "",
            citizenship: "FILIPINO",
            bloodType: "O+",
            weightKg: "",
            weightLbs: "",
            gsis: "",
            philHealth: "",
            tinNumber: "",
            pagibig: "",
            sss: "",
            telNum: "",
            mobNum: "",
            citizenship_by_country: null,
            // resHouseBloclLotNo: "",
            // resVillage: "",
            // resCity: "",
            // resZipCode: "",
            // perHouseBloclLotNo: "",
            // perVillage: "",
            // perCity: "",
            // perZipCode: "",
            residential_housenum: "",
            residential_street: "",
            residential_subdivision: "",
            residential_barangay: "",
            residential_city: "",
            residential_province: "",
            residential_zipcode: "",
            permanent_housenum: "",
            permanent_street: "",
            permanent_subdivision: "",
            permanent_barangay: "",
            permanent_city: "",
            permanent_province: "",
            permanent_zipcode: "",

            email: "",
            civil_status_others: "Prefer not to say",

            baseUrl: null,
            getParam: { data: [] },
            getEmp: null,
            saved: false,
            notificationMessage: null,
            isSaving: false,
            btnMessage: "Update Personal Information",
        };
    },
    methods: {
        //Auto Compute
        computeUnitHeight() {
            let heightVal = this.heightInM;
            this.heightInFeet = heightVal * 3.2808;
            this.heightInInches = this.heightInFeet * 12;
        },

        //Compute Weight
        computeWeight() {
            let weightVal = this.weightKg;
            this.weightLbs = weightVal * 2.205;
            // this.heightInInches = (this.heightInFeet * 12);
        },
        sameAsResidential() {
            // this.perHouseBloclLotNo = this.resHouseBloclLotNo;
            // this.perVillage = this.resVillage;
            // this.perCity = this.resCity;
            // this.perZipCode = this.resZipCode;
            this.permanent_housenum = this.residential_housenum;
            this.permanent_street = this.residential_street;
            this.permanent_subdivision = this.residential_subdivision;
            this.permanent_barangay = this.residential_barangay;
            this.permanent_city = this.residential_city;
            this.permanent_province = this.residential_province;
            this.permanent_zipcode = this.residential_zipcode;
        },

        //Get Parameters
        async getParameters() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/parameter/";

            this.getParam = await axios
                .get(this.baseUrl, {
                    headers: {
                        Authorization: "Bearer " + getToken,
                        Accept: "application/json",
                    },
                })
                .catch((e) => {
                    console.log(e);
                    if (e.response.status === 401) {
                        this.isAuthenticated = false;
                    }
                });
        },

        //Get Record
        async getEmployeeInformation() {
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/search";
            //From Designer
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
                    console.log(response.data);
                    this.getEmp = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });

            this.empNumber = this.getEmp.employee_number;
            this.firstName = this.getEmp.first_name;
            this.surName = this.getEmp.last_name;
            this.email = this.getEmp.email;
            this.middleName = this.getEmp.middle_name;
            this.nameExtension = this.getEmp.name_extension;
            this.dob = this.getEmp.birth_date;
            this.pob = this.getEmp.birth_place;
            this.citizenshipBy = this.getEmp.citizenship_by;
            this.gender = this.getEmp.gender;
            this.civilStatus = this.getEmp.civil_status;
            this.heightInM = this.getEmp.height;
            this.citizenship = this.getEmp.citizenship;
            this.citizenship_by_country = this.getEmp.citizenship_by_country;
            this.bloodType = this.getEmp.blood_type;
            this.weightKg = this.getEmp.weight;
            this.gsis = this.getEmp.gsis;
            this.sss = this.getEmp.sss;
            this.philHealth = this.getEmp.philhealth;
            this.tinNumber = this.getEmp.tin;
            this.pagibig = this.getEmp.pagibig;
            // this.resHouseBloclLotNo= this.getEmp.residential_housenum;
            // this.resVillage = this.getEmp.residential_barangay;
            // this.resCity = this.getEmp.residential_city;
            // this.resZipCode = this.getEmp.residential_zipcode;
            // this.perHouseBloclLotNo = this.getEmp.permanent_housenum;
            // this.perVillage= this.getEmp.permanent_subdivision;
            // this.perCity= this.getEmp.permanent_city;
            // this.perZipCode= this.getEmp.permanent_zipcode;
            this.residential_housenum = this.getEmp.residential_housenum;
            this.residential_street = this.getEmp.residential_street;
            this.residential_subdivision = this.getEmp.residential_subdivision;
            this.residential_barangay = this.getEmp.residential_barangay;
            this.residential_city = this.getEmp.residential_city;
            this.residential_province = this.getEmp.residential_province;
            this.residential_zipcode = this.getEmp.residential_zipcode;
            this.permanent_housenum = this.getEmp.permanent_housenum;
            this.permanent_street = this.getEmp.permanent_street;
            this.permanent_subdivision = this.getEmp.permanent_subdivision;
            this.permanent_barangay = this.getEmp.permanent_barangay;
            this.permanent_city = this.getEmp.permanent_city;
            this.permanent_province = this.getEmp.permanent_province;
            this.permanent_zipcode = this.getEmp.permanent_zipcode;
            this.telNum = this.getEmp.telephone;
            this.mobNum = this.getEmp.mobile;
            this.civil_status_others = this.getEmp.civil_status_others;
        },

        //Update Employee Information
        async updatePersonalInformation() {
            this.btnMessage = "Updating...";
            this.isSaving = true;
            const getToken = localStorage.getItem("token");
            this.baseUrl = localStorage.getItem("base_url");
            this.baseUrl = this.baseUrl + "/api/employee/portal/update/";

            const response = await axios
                .put(
                    this.baseUrl,
                    {
                        email: this.email,
                        employee_number: this.empNumber,
                        last_name: this.surName,
                        first_name: this.firstName,
                        birth_date: this.dob,
                        gender: this.gender,
                        civil_status: this.civilStatus,
                        //Optional
                        middle_name: this.middleName,
                        name_extension: this.nameExtension,
                        birth_place: this.pob,
                        height: this.heightInM,
                        weight: this.weightKg,
                        blood_type: this.bloodType,
                        gsis: this.gsis,
                        pagibig: this.pagibig,
                        philhealth: this.philHealth,
                        sss: this.sss,
                        tin: this.tinNumber,
                        citizenship: this.citizenship,
                        citizenship_by_country: this.citizenship_by_country,
                        citizenship_by: this.citizenshipBy,
                        residential_housenum: this.residential_housenum,
                        residential_street: this.residential_street,
                        residential_subdivision: this.residential_subdivision,
                        residential_barangay: this.residential_barangay,
                        residential_city: this.residential_city,
                        residential_province: this.residential_province,
                        residential_zipcode: this.residential_zipcode,
                        permanent_housenum: this.permanent_housenum,
                        permanent_street: this.permanent_street,
                        permanent_subdivision: this.permanent_subdivision,
                        permanent_barangay: this.permanent_barangay,
                        permanent_city: this.permanent_city,
                        permanent_province: this.permanent_province,
                        permanent_zipcode: this.permanent_zipcode,
                        mobile: this.mobNum,
                        telephone: this.telNum,
                        civil_status_others: this.civil_status_others,
                        isResetPassword: false,
                    },
                    {
                        headers: {
                            Authorization: "Bearer " + getToken,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    }
                )
                .then((response) => {
                    //Do Nothing
                    this.saved = true;
                    this.notificationMessage =
                        "The new information has been saved!";
                    this.getEmployeeInformation();
                })
                .catch((error) => {
                    console.log("ERRRR: ", error.response.data);
                    alert(error.response.data.message);
                });
            this.btnMessage = "Update Personal Information";
            this.isSaving = false;
        },
        //End Update Personal Information
    },
    async mounted() {
        await this.getParameters();
        await this.getEmployeeInformation();
        this.isUpdateEmployee = localStorage.getItem("isUpdateEmployee");
        console.log(this.isUpdateEmployee);
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
</style>
