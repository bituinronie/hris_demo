<template>
    <div class="content">
        <!-- <PreLoader v-if="preloader"></PreLoader> -->
        <!-- <div v-else> -->
        <div>
            <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-75">
                    <!-- Personal Information -->
                    <md-card>
                        <span @click="expandThis('personalInformation')">
                            <md-card-actions md-alignment="space-between">
                                <div>Personal Information</div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ personalInformationTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="personalInformation">
                            <PortalPersonalInformation></PortalPersonalInformation>
                        </md-card-content>
                    </md-card>

                    <!-- Family Background -->
                    <md-card>
                        <span @click="expandThis('familyBackground')">
                            <md-card-actions md-alignment="space-between">
                                <div>Family Background</div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ familyBackgroundTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="familyBackground">
                            <PortalFamilyBackground></PortalFamilyBackground>
                        </md-card-content>
                    </md-card>

                    <!-- Educational Background -->
                    <md-card>
                        <span @click="expandThis('educationalBackground')">
                            <md-card-actions md-alignment="space-between">
                                <div>Educational Background</div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ educationalBackgroundTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="educationalBackground">
                            <PortalEducationalBackground></PortalEducationalBackground>
                        </md-card-content>
                    </md-card>

                    <!-- Civil Service Eligibility -->
                    <md-card>
                        <span @click="expandThis('civilServiceAndLicense')">
                            <md-card-actions md-alignment="space-between">
                                <div>Civil Service Eligibility</div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ civilServiceAndLicenseTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="civilServiceAndLicense">
                            <PortalCivilServiceAndLicense></PortalCivilServiceAndLicense>
                        </md-card-content>
                    </md-card>

                    <!-- Work Experiences -->
                    <md-card>
                        <span @click="expandThis('workExperience')">
                            <md-card-actions md-alignment="space-between">
                                <div>Work Experience</div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ workExperienceTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="workExperience">
                            <PortalWorkExperience></PortalWorkExperience>
                        </md-card-content>
                    </md-card>

                    <!-- Learning and Development Interventions/Training Programs Attended -->
                    <md-card>
                        <span @click="expandThis('voluntaryWork')">
                            <md-card-actions md-alignment="space-between">
                                <div>
                                    Voluntary Work or Involvement in
                                    Civic/Non-Governemnt/People/Voluntary
                                    Organizations
                                </div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ voluntaryWorkTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="voluntaryWork">
                            <PortalVoluntaryWork></PortalVoluntaryWork>
                        </md-card-content>
                    </md-card>

                    <!-- Learning and Development Interventions/Training Programs Attended -->
                    <md-card>
                        <span @click="expandThis('learningDevelopment')">
                            <md-card-actions md-alignment="space-between">
                                <div>
                                    Learning and Development
                                    Interventions/Training Programs Attended
                                </div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ learningDevelopmentTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="learningDevelopment">
                            <PortalLearningDevelopment></PortalLearningDevelopment>
                        </md-card-content>
                    </md-card>

                    <!-- Other Information -->
                    <md-card>
                        <span @click="expandThis('others')">
                            <md-card-actions md-alignment="space-between">
                                <div>Other Information and References</div>
                                <md-card-expand-trigger>
                                    <md-button class="md-simple md-primary">
                                        {{ othersTab }}
                                    </md-button>
                                </md-card-expand-trigger>
                            </md-card-actions>
                        </span>
                        <md-card-content v-if="others">
                            <PortalOthers></PortalOthers>
                        </md-card-content>
                    </md-card>

                    <!-- References -->
                    <!-- <md-card>
                    <md-card-expand>
                        <md-card-actions md-alignment="space-between">
                        <div>
                            References
                        </div>
                        <md-card-expand-trigger>
                            <md-button class="md-simple md-primary">
                                Expand
                            </md-button>
                        </md-card-expand-trigger>
                        </md-card-actions>

                        <md-card-expand-content>
                        <md-card-content>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque ea, nostrum odio. Dolores, sed accusantium quasi non, voluptas eius illo quas, saepe voluptate pariatur in deleniti minus sint. Excepturi.
                        </md-card-content>
                        </md-card-expand-content>
                    </md-card-expand>
                </md-card> -->
                </div>
                <div class="md-layout-item md-small-size-100 md-size-25">
                    <img
                        v-if="isUpdateEmployee === 'false'"
                        :src="displayPicture"
                        width="100%"
                        style="float: right"
                    />
                    <img
                        v-else
                        @click="isUploadPhotoMethod"
                        :src="displayPicture"
                        width="100%"
                        style="float: right"
                    />
                    <!-- Announcements -->
                    <!-- <md-card>
                        <md-card-expand>
                            <md-card-actions  md-alignment="space-between">
                            <div>
                                Announcements
                            </div>
                            <md-card-expand-trigger>
                                <md-button class="md-simple md-primary">
                                    Expand
                                </md-button>
                            </md-card-expand-trigger>
                            </md-card-actions>

                            <md-card-expand-content>
                            <md-card-content >
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque ea, nostrum odio. Dolores, sed accusantium quasi non, voluptas eius illo quas, saepe voluptate pariatur in deleniti minus sint. Excepturi.
                            </md-card-content>
                            </md-card-expand-content>
                        </md-card-expand>
                    </md-card> -->

                    <!-- Announcements -->
                    <md-card>
                        <md-card-expand>
                            <md-card-actions md-alignment="space-between">
                                <div>Quick Links</div>
                            </md-card-actions>
                            <md-card-content>
                                <md-list>
                                    <md-list-item @click="generatePds"
                                        >Print PDS</md-list-item
                                    >
                                    <md-list-item
                                        @click="isUpdatePasswordMethod"
                                        >Update Password</md-list-item
                                    >
                                </md-list>
                                <!-- <md-button
                                style=""
                                class="md-primary md-raised"
                                @click="generatePds"
                                >Print PDS</md-button
                            > -->
                            </md-card-content>
                        </md-card-expand>
                    </md-card>
                </div>
            </div>
            <DialogCard v-if="isPhotoUpload">
                <section slot="header">Upload Photo</section>
                <section slot="body">
                    <label
                        >File
                        <input
                            type="file"
                            id="file"
                            ref="file"
                            accept=".jpg,.png,.jpeg"
                        />
                    </label>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary emp-search"
                            @click="uploadPhoto"
                        >
                            Upload Display Picture
                        </md-button>
                        <md-button
                            class="md-dense"
                            @click="isUploadPhotoMethod"
                        >
                            Close
                        </md-button>
                    </md-dialog-actions>
                </section>
            </DialogCard>

            <DialogCard v-if="shouldChange === 'true' || isUpdatePassword">
                <section slot="header">Change Password</section>
                <section slot="body">
                    <md-field>
                        <label>Old Password</label>
                        <md-input
                            v-model="old_password"
                            type="password"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>New Password</label>
                        <md-input
                            v-model="new_password"
                            type="password"
                            required
                        ></md-input>
                    </md-field>
                    <md-field>
                        <label>Confirm Password</label>
                        <md-input
                            v-model="password_confirmation"
                            type="password"
                            required
                        ></md-input>
                    </md-field>
                    <label
                        class="text-danger"
                        v-for="e in passwordErrorLabel"
                        :key="e"
                        >{{ e }}</label
                    >
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-primary emp-search"
                            @click="updatePassword"
                            :disabled="
                                new_password != password_confirmation ||
                                password_confirmation === null
                            "
                        >
                            Change Password
                        </md-button>
                        <md-button
                            class="md-dense md-danger"
                            @click="isUpdatePasswordMethod"
                            :disabled="shouldChange === 'true'"
                        >
                            Close
                        </md-button>
                    </md-dialog-actions>
                </section>
            </DialogCard>
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
        </div>
    </div>
</template>

<script>
import defaultPhoto from "../assets/img/default_photo.png";
import axios from "axios";
// import DialogCard from "../components/Cards/DialogCard.vue";
const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../components/Cards/DialogCard.vue"
    );
//PDS Portal
// import PortalPersonalInformation from '../pages/PortalEmployee/PortalPersonalInformation.vue';
// import PortalFamilyBackground from '../pages/PortalEmployee/PortalFamilyBackground.vue';
// import PortalEducationalBackground from '../pages/PortalEmployee/PortalEducationalBackground.vue';
// import PortalCivilServiceAndLicense from '../pages/PortalEmployee/PortalCivilServiceAndLicense.vue';
// import PortalWorkExperience from '../pages/PortalEmployee/PortalWorkExperience.vue';
// import PortalVoluntaryWork from '../pages/PortalEmployee/PortalVoluntaryWork.vue';
// import PortalLearningDevelopment from '../pages/PortalEmployee/PortalLearningDevelopment.vue';

const PortalPersonalInformation = () =>
    import(
        /* webpackChunkName: "PortalPersonalInformation" */ "../pages/PortalEmployee/PortalPersonalInformation.vue"
    );
const PortalFamilyBackground = () =>
    import(
        /* webpackChunkName: "PortalFamilyBackground" */ "../pages/PortalEmployee/PortalFamilyBackground.vue"
    );
const PortalEducationalBackground = () =>
    import(
        /* webpackChunkName: "PortalEducationalBackground" */ "../pages/PortalEmployee/PortalEducationalBackground.vue"
    );
const PortalCivilServiceAndLicense = () =>
    import(
        /* webpackChunkName: "PortalCivilServiceAndLicense" */ "../pages/PortalEmployee/PortalCivilServiceAndLicense.vue"
    );
const PortalWorkExperience = () =>
    import(
        /* webpackChunkName: "PortalWorkExperience" */ "../pages/PortalEmployee/PortalWorkExperience.vue"
    );
const PortalVoluntaryWork = () =>
    import(
        /* webpackChunkName: "PortalVoluntaryWork" */ "../pages/PortalEmployee/PortalVoluntaryWork.vue"
    );
const PortalLearningDevelopment = () =>
    import(
        /* webpackChunkName: "PortalLearningDevelopment" */ "../pages/PortalEmployee/PortalLearningDevelopment.vue"
    );
const PortalOthers = () =>
    import(
        /* webpackChunkName: "PortalOthers" */ "../pages/PortalEmployee/PortalOthers.vue"
    );

// const PreLoader = () =>
//     import(/* webpackChunkName: "PreLoader" */ "../components/Preloader.vue");

export default {
    components: {
        PortalPersonalInformation,
        PortalFamilyBackground,
        PortalEducationalBackground,
        PortalCivilServiceAndLicense,
        PortalWorkExperience,
        PortalVoluntaryWork,
        PortalLearningDevelopment,
        PortalOthers,
        DialogCard,
        // PreLoader
    },
    data() {
        return {
            defaultPhoto: defaultPhoto,
            isUpdateEmployee: false,
            file: null,
            isPhotoUpload: false,
            displayPicture: defaultPhoto,

            //Tabs for Expanding
            personalInformation: false,
            personalInformationTab: "+",
            familyBackground: false,
            familyBackgroundTab: "+",
            educationalBackground: false,
            educationalBackgroundTab: "+",
            civilServiceAndLicense: false,
            civilServiceAndLicenseTab: "+",
            workExperience: false,
            workExperienceTab: "+",
            voluntaryWork: false,
            voluntaryWorkTab: "+",
            learningDevelopment: false,
            learningDevelopmentTab: "+",
            others: false,
            othersTab: "+",
            isUpdatePassword: false,
            shouldChange: null,
            old_password: null,
            new_password: null,
            password_confirmation: null,
            passwordErrorLabel: null,
            messageSnackbar: null,
            fireSnackbar: false,

            //UI
            // preloader: false,
        };
    },
    methods: {
        //Open Dialog Card for Uploading
        isUploadPhotoMethod() {
            this.isPhotoUpload = !this.isPhotoUpload;
        },

        //Open Dialog Card for Changing password
        isUpdatePasswordMethod() {
            this.isUpdatePassword = !this.isUpdatePassword;
        },
        //Update Password
        async updatePassword() {
            const getToken = localStorage.getItem("token");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/auth/change-password";

            const options = {
                method: "PUT",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    old_password: this.old_password,
                    new_password: this.new_password,
                    new_password_confirmation: this.password_confirmation,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    this.shouldChange = false;
                    this.messageSnackbar = "Password updated successfully!";
                    localStorage.setItem("shouldChange", this.shouldChange);
                    this.fireSnackbar = true;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error.response);
                    (this.passwordErrorLabel =
                        error.response.data.errors.new_password),
                        (this.messageSnackbar =
                            "Error changing the password. Please try again.");
                    this.fireSnackbar = true;
                });
        },

        //Upload Photo
        async uploadPhoto() {
            const getToken = localStorage.getItem("token");
            const employeeID = localStorage.getItem("accountId");
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/employee/portal/dp/change/";

            var imagefile = document.querySelector("#file");

            let formData = new FormData();
            formData.append("picture", imagefile.files[0]);

            await axios
                .post(baseUrl, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Authorization: "Bearer " + getToken,
                    },
                })
                .then((response) => {
                    console.log(response.data);
                    this.isUploadPhotoMethod();
                    this.getDisplayPicture();
                    console.log("SUCCESS!!");
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Photo uploaded successfully!";
                })
                .catch((error) => {
                    console.log(error.response);
                    this.isUploadPhotoMethod();
                    console.log("FAILURE!!");
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an error in uploading the photo. Please try again.";
                });
        },

        //Get Display Picture
        async getDisplayPicture() {
            const getToken = localStorage.getItem("token");
            const employeeID = localStorage.getItem("accountId");
            console.log(employeeID);
            let baseUrl = localStorage.getItem("base_url");
            baseUrl = baseUrl + "/api/employee/portal/dp/search/";

            const options = {
                method: "GET",
                url: baseUrl,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + getToken,
                },
            };

            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    this.displayPicture = response.data.message;
                })
                .catch((error) => {
                    console.error(error);
                    this.displayPicture = this.defaultPhoto;
                });

            if (this.displayPicture === null) {
                this.displayPicture = this.defaultPhoto;
            }
        },

        //Generate PDS
        generatePds() {
            const employeeID = localStorage.getItem("accountId");
            // console.log(employeeID);
            //const empID = this.selectedEmpId;
            let printToken = null;
            this.baseUrl = localStorage.getItem("base_url");

            let parentURL = this.baseUrl;
            const getToken = localStorage.getItem("token");
            this.baseUrl = this.baseUrl + "/api/token/generate";

            const options = {
                method: "POST",
                url: this.baseUrl,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + getToken,
                },
                data: {
                    permission: "portal employee",
                    model_name: null,
                },
            };

            axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    printToken = response.data.message;
                    console.log(printToken);

                    //New Tab to generate the PDS
                    parentURL =
                        parentURL +
                        "/generate/report/1/portal/pds/" +
                        printToken;
                    window.open(parentURL, "_blank");
                })
                .catch(function (error) {
                    console.error(error);
                });
        },

        //axios request
        async axiosRequest(options) {
            await axios
                .request(options)
                .then((response) => {
                    console.log(response.data);
                    return response;
                })
                .catch((error) => {
                    return this.defaultPhoto;
                });
        },

        //Expand Cards
        expandThis(tab) {
            if (tab === "personalInformation") {
                this.personalInformation = !this.personalInformation;
                let label = this.personalInformation ? "-" : "+";
                this.personalInformationTab = label;
            }
            if (tab === "familyBackground") {
                this.familyBackground = !this.familyBackground;
                let label = this.familyBackground ? "-" : "+";
                this.familyBackgroundTab = label;
            }
            if (tab === "educationalBackground") {
                this.educationalBackground = !this.educationalBackground;
                let label = this.educationalBackground ? "-" : "+";
                this.educationalBackgroundTab = label;
            }
            if (tab === "civilServiceAndLicense") {
                this.civilServiceAndLicense = !this.civilServiceAndLicense;
                let label = this.civilServiceAndLicense ? "-" : "+";
                this.civilServiceAndLicenseTab = label;
            }
            if (tab === "workExperience") {
                this.workExperience = !this.workExperience;
                let label = this.workExperience ? "-" : "+";
                this.workExperienceTab = label;
            }
            if (tab === "voluntaryWork") {
                this.voluntaryWork = !this.voluntaryWork;
                let label = this.voluntaryWork ? "-" : "+";
                this.voluntaryWorkTab = label;
            }
            if (tab === "learningDevelopment") {
                this.learningDevelopment = !this.learningDevelopment;
                let label = this.learningDevelopment ? "-" : "+";
                this.learningDevelopmentTab = label;
            }
            if (tab === "others") {
                this.others = !this.others;
                let label = this.others ? "-" : "+";
                this.othersTab = label;
            }
        },
    },

    async mounted() {
        this.isUpdateEmployee = localStorage.getItem("isUpdateEmployee");
        await this.getDisplayPicture();
        this.shouldChange = localStorage.getItem("shouldChange");

        // console.log("Refresh Counter: "+localStorage.getItem("refreshCounter"));
        // if(localStorage.getItem("refreshCounter") === "0") {
        //     this.preloader = true;
        // setTimeout(() => {
        //     localStorage.setItem("refreshCounter", "1");
        //     this.$router.go();
        //     }, 10);
        // }
        // else{
        //     this.preloader = false;
        // }
    },
};
</script>
<style scoped>
.md-card-actions {
    margin: 0px !important;
    padding-left: 10px !important;
    padding-bottom: 10px !important;
    background-color: #fbcc2b !important;
}
</style>
