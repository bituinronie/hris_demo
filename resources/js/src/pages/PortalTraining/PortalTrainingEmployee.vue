<template>
    <div>
        <div class="md-layout">
            <!--  Calendar -->
            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Training Calendar</h4>
                    </md-card-header>
                    <md-card-content>
                        <div class="md-layout">
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-75
                                "
                            >
                                <v-calendar
                                    class="custom-calendar max-w-full"
                                    :masks="masks"
                                    :attributes="trainings"
                                    disable-page-swipe
                                    is-expanded
                                >
                                    <template
                                        v-slot:day-content="{ day, attributes }"
                                    >
                                        <div
                                            class="
                                                flex flex-col
                                                h-full
                                                z-10
                                                overflow-hidden
                                            "
                                        >
                                            <span
                                                class="
                                                    day-label
                                                    text-sm text-gray-900
                                                "
                                                >{{ day.day }}</span
                                            >
                                            <div class="flex-grow">
                                                <div
                                                    v-for="attr in attributes"
                                                    :key="
                                                        attr.customData
                                                            .trainingId
                                                    "
                                                    class="
                                                        text-xs
                                                        leading-tight
                                                        rounded-sm
                                                        p-1
                                                        mt-0
                                                        mb-1
                                                        custom-chip
                                                    "
                                                    @click="
                                                        showTrainingFromCalendar(
                                                            attr.customData
                                                                .employeeTrainingId
                                                        )
                                                    "
                                                >
                                                    {{ attr.customData.title }}
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </v-calendar>
                            </div>
                            <div
                                class="
                                    md-layout-item md-small-size-100 md-size-25
                                "
                            >
                                <br />
                                <span style="font-size: 20px"
                                    >EVENT SELECTED</span
                                >
                                <br /><br />
                                <b>Program:</b> {{ selectedTraining.program }}
                                <br />
                                <b>Date From:</b> {{ selectedTraining.date_from
                                }}<br />
                                <b>Date To:</b> {{ selectedTraining.date_to }}
                                <br />
                                <b>Number of Hours:</b>
                                {{ selectedTraining.number_of_hours }} <br />
                                <b>Type of LD:</b>
                                {{ selectedTraining.type_of_ld }} <br />
                                <b>Sponsored by:</b>
                                {{ selectedTraining.sponsored_by }} <br />
                                <b>Conducted by:</b>
                                {{ selectedTraining.conducted_by }} <br />
                                <b>Location:</b>
                                {{ selectedTraining.location }} <br />
                                <b>Description and Requirements:</b>
                                <p
                                    style="margin-top: 10px"
                                    v-html="selectedTraining.description"
                                ></p>
                                <br />
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
            <!--  My Trainings -->
            <div class="md-layout-item md-small-size-100 md-size-100">
                <md-card>
                    <md-card-header
                        class="md-card-header"
                        style="margin-bottom: 20px"
                    >
                        <h4 class="title">Trainings for {{ fullName }}</h4>
                    </md-card-header>
                    <!-- <md-card-content v-if="userAction === 'emp_selected' "> -->
                    <md-card-content>
                        <div class="md-layout">
                            <div class="md-layout-item md-size-100">
                                <md-table v-model="myTrainings" md-card>
                                    <md-table-empty-state
                                        :md-description="`No Record`"
                                    >
                                    </md-table-empty-state>

                                    <md-table-row
                                        slot="md-table-row"
                                        slot-scope="{ item }"
                                    >
                                        <md-table-cell
                                            md-label="Program"
                                            md-sort-by="trainingId"
                                            >{{ item.program }}</md-table-cell
                                        >
                                        <md-table-cell md-label="Date From">{{
                                            item.date_from
                                        }}</md-table-cell>
                                        <md-table-cell md-label="Date To">{{
                                            item.date_to
                                        }}</md-table-cell>
                                        <md-table-cell
                                            md-label="Number of Hours"
                                            >{{
                                                item.number_of_hours
                                            }}</md-table-cell
                                        >
                                        <md-table-cell md-label="Type of LD">{{
                                            item.type_of_ld
                                        }}</md-table-cell>
                                        <md-table-cell
                                            md-label="Sponsored By"
                                            >{{
                                                item.sponsored_by
                                            }}</md-table-cell
                                        >
                                        <md-table-cell
                                            md-label="Conducted By"
                                            >{{
                                                item.conducted_by
                                            }}</md-table-cell
                                        >
                                        <md-table-cell md-label="Location">{{
                                            item.location
                                        }}</md-table-cell>
                                        <md-table-cell
                                            md-label="Certificate of Training"
                                        >
                                            <md-button
                                                v-if="
                                                    item.certificateOfAppearance
                                                "
                                                class="md-dense md-primary"
                                                @click="
                                                    viewImage(
                                                        item.certificateOfAppearance
                                                    )
                                                "
                                                >View</md-button
                                            >
                                            <div
                                                v-else
                                                style="text-align: center"
                                            >
                                                No attachment provided
                                            </div>
                                        </md-table-cell>
                                        <md-table-cell
                                            md-label="Post Training Report"
                                        >
                                            <md-button
                                                v-if="item.postTrainingReport"
                                                class="md-dense md-primary"
                                                @click="
                                                    viewImage(
                                                        item.postTrainingReport
                                                    )
                                                "
                                                >View</md-button
                                            >
                                            <div
                                                v-else
                                                style="text-align: center"
                                            >
                                                No attachment provided
                                            </div>
                                        </md-table-cell>
                                        <md-table-cell
                                            md-label="Actions"
                                            md-sort-by="title"
                                        >
                                            <md-button
                                                v-if="item.isToAttachProof"
                                                class="md-dense md-primary"
                                                @click="
                                                    isAttachProof = true;
                                                    hasProof = item.certificateOfAppearance ? true : false
                                                    employeeTrainingId =
                                                        item.employeeTrainingId;
                                                "
                                                >Attach Proof</md-button
                                            >
                                            <!-- <md-button
                                                
                                                class="md-accent md-raised md-dense" style="background-color: #ff5252 !important"
                                                
                                            >
                                                Delete
                                            </md-button> -->
                                        </md-table-cell>
                                    </md-table-row>
                                </md-table>
                            </div>
                            <div
                                class="md-layout-item md-size-100 text-right"
                                v-if="links"
                            >
                                <label v-for="(link, i) in links" :key="i">
                                    <md-button
                                        class="button-paginate md-warning"
                                        @click="getTrainings(link.url)"
                                        :disabled="
                                            link.active || link.url === null
                                        "
                                    >
                                        <label
                                            style="color: black !important"
                                            v-html="link.label"
                                        ></label>
                                    </md-button>
                                </label>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        </div>
        <!-- Attachment Update -->
        <DialogCard v-if="isAttachProof">
            <section slot="header">Update Proof Attachment</section>
            <section slot="body" class="dCardBody">
                <form method="post" @submit.prevent="attachProof()">
                    <md-field>
                        <label>Certificate of Training *</label>
                        <md-file
                            @change="
                                (e) =>
                                    (certificateOfAppearance =
                                        e.target.files[0])
                            "
                            accept="image/*"
                        />
                    </md-field>
                    <md-field>
                        <label>Post Training Report</label>
                        <md-file
                            @change="
                                (e) => (postTrainingReport = e.target.files[0])
                            "
                            accept="image/*"
                        />
                    </md-field>
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                            @click="attachProof()"
                            :disabled="certificateOfAppearance ? false : true"
                        >
                            Save</md-button
                        >
                        <md-button
                            class="md-dense md-raised md-danger"
                            @click="isAttachProof = false"
                        >
                            <!-- <md-icon>close</md-icon> -->
                            ✕ Cancel</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Delete Training -->
        <DialogCard v-if="isDeleteTraining">
            <section slot="header">Delete Training?</section>
            <section slot="body">
                <form method="post" @submit.prevent="deleteTraining()">
                    <md-dialog-actions>
                        <md-button
                            class="md-dense md-raised md-success"
                            type="submit"
                        >
                            Delete
                        </md-button>
                        <md-button
                            class="md-dense md-raised md-warning"
                            style="color: black !important"
                            @click="isDeleteTraining = false"
                        >
                            No, I changed my mind</md-button
                        >
                    </md-dialog-actions>
                </form>
            </section>
        </DialogCard>

        <!-- Dialog Cards Here -->

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
</template>

<script>
import axios from "axios";

let token = localStorage.getItem("token");
let baseUrl = localStorage.getItem("base_url");
let fullName = localStorage.getItem("full_name");

const DialogCard = () =>
    import(
        /* webpackChunkName: "DialogCard" */ "../../components/Cards/DialogCard.vue"
    );

export default {
    components: {
        DialogCard,
    },
    data() {
        const month = new Date().getMonth();
        const year = new Date().getFullYear();
        return {
            myTrainings: [],
            trainings: [],
            selectedTraining: {
                program: "",
                date_from: "",
                date_to: "",
                number_of_hours: "",
                type_of_ld: "",
                sponsored_by: "",
                conducted_by: "",
                location: "",
                description: "",
            },
            links: [],

            postTrainingReport: null,
            certificateOfAppearance: null,

            //Snackkbar
            fireSnackbar: false,
            messageSnackbar: "",

            employeeTrainingId: null,
            masks: {
                weekdays: "WWW",
            },

            isDeleteTraining: false,
            isAttachProof: false,

            hasProof: false,

            fullName: fullName,
        };
    },
    methods: {
        async getMyTrainings() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/training/portal/search/",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            const response = await axios.request(options);
            this.myTrainings = response.data.data;
            this.links = response.data.links;
        },
        async getAllTrainings() {
            const options = {
                method: "GET",
                url: baseUrl + "/api/training/portal/calendar/",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            const response = await axios.request(options);
            let data = [];
            response.data.forEach((val, key) => {
                let training = {};
                training.customData = val;
                training.dates = new Date(val.date_from);
                data.push(training);
            });
            this.trainings = data;
        },
        async deleteTraining() {
            const options = {
                method: "DELETE",
                url: baseUrl + "/api/training/delete/" + this.trainingId,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            await axios
                .request(options)
                .then(() => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Training deleted!";
                })
                .catch((error) => {
                    console.error(error);
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "There is an issue submitting the request. Please try again!";
                });
            this.isDeleteTraining = false;
            this.getAllTrainings();
        },
        async showTrainingFromCalendar(id) {
            const options = {
                method: "GET",
                url: baseUrl + "/api/training/portal/calendar/" + id,
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                },
            };
            const response = await axios.request(options);
            this.selectedTraining = response.data;
        },
        viewImage(url) {
            if (url.startsWith("http://localhost")) {
                window.open(url.replace("http://localhost", baseUrl));
            } else {
                window.open(url);
            }
        },
        async attachProof() {
            const data = new FormData();
            if (this.postTrainingReport) {
                data.append("post_training_report", this.postTrainingReport);
            }
            data.append(
                "certificate_of_appearance",
                this.certificateOfAppearance
            );
            const options = {
                method: "POST",
                url:
                    baseUrl +
                    "/api/training/portal/attach/" +
                    this.employeeTrainingId,
                params: {
                    // Add params
                },
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token,
                    "Content-Type": "multipart/form-data",
                },
                data: data,
            };
            await axios
                .request(options)
                .then((res) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar = "Attachment proof updated!";
                })
                .catch((err) => {
                    this.fireSnackbar = true;
                    this.messageSnackbar =
                        "An error occured. Please try again.";
                });
            this.isAttachProof = false;
            this.getMyTrainings();
        },
    },
    mounted() {
        this.getMyTrainings();
        this.getAllTrainings();
    },
};
</script>
<style>
.md-card-header {
    background-color: #042278 !important;
}
.dob {
    margin-top: -20px;
}
.dCardBody {
    min-width: 640px !important;
}
.addChild {
    background-color: #495057;
    border-color: #495057;
    color: white !important;
}
.md-table-sortable-icon {
    display: none !important;
}

.custom-calendar ::-webkit-scrollbar {
    width: 0px;
}
.custom-calendar ::-webkit-scrollbar-track {
    display: none;
}
.custom-calendar.vc-container {
    --day-border: 1px solid #b8c2cc !important;
    --day-border-highlight: 1px solid #b8c2cc !important;
    --day-width: 90px !important;
    --day-height: 90px !important;
    --weekday-bg: #f8fafc !important;
    --weekday-border: 1px solid #eaeaea !important;
    border-radius: 0 !important;
    width: 50% !important;
}
.vc-header {
    background-color: #f1f5f8 !important;
    padding: 10px 0 !important;
}
.vc-weeks {
    padding: 0 !important;
}
.vc-weekday {
    background-color: var(--weekday-bg) !important;
    border-bottom: var(--weekday-border) !important;
    border-top: var(--weekday-border) !important;
    padding: 5px 0 !important;
}
.vc-day {
    padding: 0 5px 3px 5px !important;
    text-align: left !important;
    height: 100px !important;
    min-width: 80px;
    background-color: white !important;
    border: 0.5px solid #b8c2cc;
    overflow-y: scroll;
}
.weekday-1,
.weekday-7 {
    background-color: #eff8ff !important;
}

.custom-calendar .vc-day-dots {
    margin-bottom: 5px !important;
}

.custom-chip {
    background: #042278;
    border-radius: 5px;
    color: white;
    white-space: nowrap;
    padding: 2px 5px;
    margin-bottom: 3px;
    cursor: pointer;
}
</style>
